<?php

namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnalisarJustificativaRequest;
use App\Models\Frequencia;
use App\Models\HistoricoSolicitacaoSaida;
use App\Models\SolicitacaoSaida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaidaAntecipadaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $query = SolicitacaoSaida::with(['aluno.turma', 'professor', 'justificativas', 'analisadoPor'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByRaw("FIELD(status, 'pendente', 'em_analise', 'recusado', 'falta_mantida', 'justificado', 'aprovado')")
            ->orderBy('created_at', 'desc');

        $solicitacoes = $query->paginate(12)->withQueryString();

        $resumo = [
            'pendente' => SolicitacaoSaida::where('status', 'pendente')->count(),
            'em_analise' => SolicitacaoSaida::where('status', 'em_analise')->count(),
            'justificado' => SolicitacaoSaida::whereIn('status', ['justificado', 'aprovado'])->count(),
            'falta_mantida' => SolicitacaoSaida::whereIn('status', ['recusado', 'falta_mantida'])->count(),
        ];

        return view('secretaria.saidas.index', compact('solicitacoes', 'resumo', 'status'));
    }

    public function autorizar(AnalisarJustificativaRequest $request, SolicitacaoSaida $saida)
    {
        $this->aprovarSolicitacao($saida, $request->observacao);

        return back()->with('success', 'Justificativa aprovada, saida liberada e frequencia atualizada.');
    }

    public function naoAutorizar(AnalisarJustificativaRequest $request, SolicitacaoSaida $saida)
    {
        $this->recusarSolicitacao($saida, $request->observacao);

        return back()->with('success', 'Justificativa recusada e falta mantida.');
    }

    private function aprovarSolicitacao(SolicitacaoSaida $saida, ?string $observacao): void
    {
        $saida->update([
            'status' => 'justificado',
            'autorizado_saida' => true,
            'analisado_por' => Auth::id(),
            'data_analise' => now(),
        ]);

        $saida->justificativas()->latest()->first()?->update([
            'status' => 'aprovado',
            'analisado_por' => Auth::id(),
            'data_analise' => now(),
        ]);

        Frequencia::whereKey($saida->frequencia_id)
            ->orWhere(fn ($q) => $q->where('aluno_id', $saida->aluno_id)->whereDate('data', $saida->data))
            ->update([
                'status_presenca' => 'saida_antecipada',
                'observacao' => trim('Saida antecipada justificada. '.$observacao),
            ]);

        HistoricoSolicitacaoSaida::create([
            'solicitacao_saida_id' => $saida->id,
            'user_id' => Auth::id(),
            'acao' => 'justificativa_aprovada',
            'descricao' => $observacao,
        ]);
    }

    private function recusarSolicitacao(SolicitacaoSaida $saida, ?string $observacao): void
    {
        $saida->update([
            'status' => 'falta_mantida',
            'autorizado_saida' => false,
            'analisado_por' => Auth::id(),
            'data_analise' => now(),
        ]);

        $saida->justificativas()->latest()->first()?->update([
            'status' => 'recusado',
            'analisado_por' => Auth::id(),
            'data_analise' => now(),
        ]);

        Frequencia::whereKey($saida->frequencia_id)
            ->orWhere(fn ($q) => $q->where('aluno_id', $saida->aluno_id)->whereDate('data', $saida->data))
            ->update([
                'status_presenca' => 'falta',
                'observacao' => trim('Saida antecipada recusada. '.$observacao),
            ]);

        HistoricoSolicitacaoSaida::create([
            'solicitacao_saida_id' => $saida->id,
            'user_id' => Auth::id(),
            'acao' => 'justificativa_recusada',
            'descricao' => $observacao,
        ]);
    }
}
