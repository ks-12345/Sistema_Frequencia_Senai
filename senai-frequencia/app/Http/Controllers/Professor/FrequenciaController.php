<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrarSaidaAntecipadaRequest;
use App\Models\Frequencia;
use App\Models\HistoricoSolicitacaoSaida;
use App\Models\SolicitacaoSaida;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrequenciaController extends Controller
{
    private function getTurmasDoUsuario()
    {
        $user = Auth::user();

        if ($user->is_substituto) {
            // Substituto: busca turmas vinculadas pela tabela pivot
            return $user->turmas;
        }

        // Professor titular: busca turmas pelo professor_id
        return Turma::where('professor_id', $user->id)->get();
    }

    public function index()
    {
        $turmas = $this->getTurmasDoUsuario();
        return view('professor.frequencia.index', compact('turmas'));
    }

    private function autorizarTurma(Turma $turma): void
    {
        $turmas = $this->getTurmasDoUsuario();

        if (!$turmas->contains('id', $turma->id)) {
            abort(403);
        }
    }
    public function store(RegistrarSaidaAntecipadaRequest $request)
    {
        $user      = Auth::user();
        $enviar    = $request->input('acao') === 'enviar';
        $turma     = Turma::with('alunos')->findOrFail($request->turma_id);

        $alunosIds = $turma->alunos->pluck('id')->all();

        foreach ($request->frequencias as $alunoId => $status) {
            if (!in_array((int) $alunoId, $alunosIds, true)) {
                continue;
            }

            if ($status === 'saida_antecipada' && (!$request->filled("saida_horario.$alunoId") || !$request->filled("saida_motivo.$alunoId"))) {
                return back()
                    ->withInput()
                    ->withErrors(['saida_antecipada' => 'Informe horario e motivo para todas as saidas antecipadas.']);
            }

            $frequenciaExistente = Frequencia::where('aluno_id', $alunoId)
                ->whereDate('data', $request->data)
                ->first();

            if ($frequenciaExistente && $frequenciaExistente->status === 'pendente_aprovacao') {
                continue;
            }

            $statusFluxo = $enviar ? 'pendente_aprovacao' : 'rascunho';

            Frequencia::updateOrCreate(
                [
                    'aluno_id' => $alunoId,
                    'data'     => $request->data,
                ],
                [
                    'lancado_por_id'       => $user->id,
                    'status_presenca'      => $status,
                    'status'               => $statusFluxo,
                    'status_aprovacao'     => 'pendente',
                    'enviado_secretaria_em' => $enviar ? now() : null,
                    'observacao'           => $request->observacoes[$alunoId] ?? null,
                ]
            );

            if ($status === 'saida_antecipada') {
                $solicitacao = SolicitacaoSaida::updateOrCreate(
                    [
                        'aluno_id' => $alunoId,
                        'data' => $request->data,
                    ],
                    [
                        'professor_id' => $user->id,
                        'turma_id' => $turma->id,
                        'frequencia_id' => Frequencia::where('aluno_id', $alunoId)
                            ->whereDate('data', $request->data)
                            ->value('id'),
                        'horario_saida' => $request->saida_horario[$alunoId],
                        'motivo' => $request->saida_motivo[$alunoId],
                        'observacoes' => $request->saida_observacoes[$alunoId] ?? null,
                        'apresentou_justificativa' => (bool) ($request->saida_apresentou_justificativa[$alunoId] ?? false),
                        'autorizado_saida' => false,
                        'status' => 'pendente',
                        'analisado_por' => null,
                        'data_analise' => null,
                    ]
                );

                HistoricoSolicitacaoSaida::create([
                    'solicitacao_saida_id' => $solicitacao->id,
                    'user_id' => $user->id,
                    'acao' => 'solicitacao_criada',
                    'descricao' => 'Professor registrou saida antecipada durante a chamada.',
                ]);
            }
        }

        $mensagem = $enviar
            ? 'Frequência enviada para a Secretaria com sucesso!'
            : 'Frequência salva como rascunho. Envie para a Secretaria quando estiver pronta.';

        return redirect()->route('professor.frequencia.index')
                         ->with('success', $mensagem);
    }

    public function pendentes()
    {
        $turmasIds = Turma::where('professor_id', Auth::id())->pluck('id');

        $frequencias = Frequencia::with(['aluno.turma', 'lancadoPor'])
            ->where('status', 'pendente_aprovacao')
            ->whereHas('aluno', function ($q) use ($turmasIds) {
                $q->whereIn('turma_id', $turmasIds);
            })
            ->orderBy('data', 'desc')
            ->get();

        return view('professor.frequencia.pendentes', compact('frequencias'));
    }


    public function historico(Turma $turma)
    {
        $this->autorizarTurma($turma);

        $registros = Frequencia::whereHas('aluno', fn ($query) => $query->where('turma_id', $turma->id))
            ->selectRaw("
                data,
                COUNT(*) as total,
                SUM(CASE WHEN status_presenca = 'presente' THEN 1 ELSE 0 END) as presentes,
                SUM(CASE WHEN status_presenca = 'falta' THEN 1 ELSE 0 END) as faltas,
                SUM(CASE WHEN status_presenca = 'atraso' THEN 1 ELSE 0 END) as atrasos,
                SUM(CASE WHEN status_presenca = 'saida_antecipada' THEN 1 ELSE 0 END) as saidas
            ")
            ->groupBy('data')
            ->orderBy('data', 'desc')
            ->paginate(12);

        return view('professor.frequencia.historico', compact('turma', 'registros'));
    }

    public function editar(Turma $turma, string $data)
    {
        $this->autorizarTurma($turma);

        abort_unless(\DateTime::createFromFormat('Y-m-d', $data), 404);

        $alunos = $turma->alunos()->orderBy('nome')->get();
        $frequencias = Frequencia::whereDate('data', $data)
            ->whereHas('aluno', fn ($query) => $query->where('turma_id', $turma->id))
            ->get()
            ->keyBy('aluno_id');

        return view('professor.frequencia.editar', compact('turma', 'data', 'alunos', 'frequencias'));
    }

    public function atualizar(Request $request, Turma $turma, string $data)
    {
        $this->autorizarTurma($turma);

        // Bloqueia edição quando a secretaria já recebeu (pendente de aprovação)
        // Observação: por requisito, após envio o professor não deve editar.
        $jaEnviado = Frequencia::whereHas('aluno', fn($q) => $q->where('turma_id', $turma->id))
            ->whereDate('data', $data)
            ->where('status', 'pendente_aprovacao')
            ->exists();

        if ($jaEnviado) {
            return back()->withErrors([
                'frequencia_bloqueada' => 'Esta frequência foi enviada para a Secretaria e está aguardando aprovação. Edição bloqueada.'
            ]);
        }


        $request->validate([
            'frequencias' => ['required', 'array'],
            'frequencias.*' => ['required', 'in:presente,falta,atraso,saida_antecipada'],
            'observacoes' => ['nullable', 'array'],
            'observacoes.*' => ['nullable', 'string', 'max:500'],
        ]);

        $alunosIds = $turma->alunos()->pluck('id')->all();
        $user = Auth::user();

        $enviar = $request->input('acao') === 'enviar';

        foreach ($request->frequencias as $alunoId => $status) {
            if (!in_array((int) $alunoId, $alunosIds, true)) {
                continue;
            }

            $frequencia = Frequencia::where('aluno_id', $alunoId)
                ->whereDate('data', $data)
                ->first();

            Frequencia::updateOrCreate(
                [
                    'aluno_id' => $alunoId,
                    'data' => $data,
                ],
                [
                    'lancado_por_id' => $user->id,
                    'status_presenca' => $status,
                    'status_aprovacao' => $frequencia?->status_aprovacao ?? ($user->is_substituto ? 'pendente' : 'aprovado'),
                    'aprovado_por' => $frequencia?->aprovado_por,
                    'observacao' => $request->observacoes[$alunoId] ?? null,
                ]
            );
        }

        if ($enviar) {
            Frequencia::whereHas('aluno', fn ($query) => $query->where('turma_id', $turma->id))
                ->whereDate('data', $data)
                ->whereIn('status', ['rascunho', 'devolvido_correcao'])
                ->update([
                    'status' => 'pendente_aprovacao',
                    'status_aprovacao' => 'pendente',
                    'enviado_secretaria_em' => now(),
                ]);
        }

        return redirect()
            ->route('professor.frequencia.historico', $turma)
            ->with('success', $enviar ? 'Frequência enviada para a Secretaria!' : 'Frequência atualizada com sucesso!');
    }

    public function aprovar(Frequencia $frequencia)
    {
        $frequencia->update([
            'status_aprovacao' => 'aprovado',
            'aprovado_por'  => Auth::id(),
        ]);

        return back()->with('success', 'Frequência aprovada!');
    }

    public function rejeitar(Frequencia $frequencia)
    {
        $frequencia->update([
            'status_aprovacao' => 'rejeitado',
            'aprovado_por'  => Auth::id(),
        ]);

        return back()->with('success', 'Frequência rejeitada!');
    }

    public function lancar(Turma $turma)
{
    $this->autorizarTurma($turma);

    if ($turma->isFinalizada()) {
        return redirect()->route('professor.frequencia.index')
                         ->with('error', 'Esta turma está finalizada.');
    }

    $alunos = $turma->alunos;
    $data   = today()->toDateString();

    return view('professor.frequencia.lancar', compact('turma', 'alunos', 'data'));
}
}
