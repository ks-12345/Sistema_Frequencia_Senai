<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\HistoricoSolicitacaoSaida;
use App\Models\SaidaAntecipada;
use App\Models\SolicitacaoSaida;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaidaAntecipadaController extends Controller
{
    public function index()
    {
        $turmasIds = Turma::where('professor_id', Auth::id())->pluck('id');

        $saidas = SolicitacaoSaida::with(['aluno.turma', 'analisadoPor'])
            ->whereIn('turma_id', $turmasIds)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('professor.saidas.index', compact('saidas'));
    }

    public function create()
    {
        $turmasIds = Turma::where('professor_id', Auth::id())->pluck('id');
        $alunos = Aluno::whereIn('turma_id', $turmasIds)->orderBy('nome')->get();

        return view('professor.saidas.create', compact('alunos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'horario_saida' => 'required|date',
            'motivo' => 'required|string|max:1000',
        ]);

        $aluno = Aluno::with('turma')->findOrFail($request->aluno_id);
        $horarioSaida = \Carbon\Carbon::parse($request->horario_saida);

        // Mantem compatibilidade com o historico antigo do sistema.
        SaidaAntecipada::create([
            'aluno_id' => $aluno->id,
            'solicitado_por_id' => Auth::id(),
            'horario_saida' => $horarioSaida,
            'motivo' => $request->motivo,
            'status' => 'pendente',
        ]);

        $solicitacao = SolicitacaoSaida::updateOrCreate(
            [
                'aluno_id' => $aluno->id,
                'data' => $horarioSaida->toDateString(),
            ],
            [
                'professor_id' => Auth::id(),
                'turma_id' => $aluno->turma_id,
                'horario_saida' => $horarioSaida->format('H:i:s'),
                'motivo' => $request->motivo,
                'observacoes' => 'Solicitacao registrada pela tela de saidas antecipadas do professor.',
                'apresentou_justificativa' => false,
                'autorizado_saida' => false,
                'status' => 'pendente',
                'analisado_por' => null,
                'data_analise' => null,
            ]
        );

        HistoricoSolicitacaoSaida::create([
            'solicitacao_saida_id' => $solicitacao->id,
            'user_id' => Auth::id(),
            'acao' => 'solicitacao_criada',
            'descricao' => 'Professor registrou saida antecipada pela tela dedicada.',
        ]);

        return redirect()->route('professor.saidas.index')
            ->with('success', 'Saida antecipada registrada! O aluno ja pode enviar justificativa.');
    }
}
