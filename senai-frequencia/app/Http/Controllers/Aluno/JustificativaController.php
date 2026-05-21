<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJustificativaRequest;
use App\Models\HistoricoSolicitacaoSaida;
use App\Models\Justificativa;
use App\Models\SolicitacaoSaida;
use Illuminate\Support\Facades\Auth;

class JustificativaController extends Controller
{
    public function index()
    {
        $aluno = Auth::user()->aluno;
        abort_if(!$aluno, 404);

        $status = request('status');

        $solicitacoes = SolicitacaoSaida::with(['turma', 'professor', 'frequencia', 'justificativas.analisadoPor'])
            ->where('aluno_id', $aluno->id)
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderBy('data', 'desc')
            ->orderBy('horario_saida', 'desc')
            ->paginate(10)
            ->withQueryString();

        $pendentes = SolicitacaoSaida::where('aluno_id', $aluno->id)
            ->whereIn('status', ['pendente', 'em_analise'])
            ->count();

        return view('aluno.justificativas.index', compact('solicitacoes', 'pendentes', 'status'));
    }

    public function store(StoreJustificativaRequest $request)
    {
        $aluno = Auth::user()->aluno;
        abort_if(!$aluno, 404);

        $solicitacao = SolicitacaoSaida::where('id', $request->solicitacao_saida_id)
            ->where('aluno_id', $aluno->id)
            ->firstOrFail();

        $arquivo = $request->file('arquivo')?->store('justificativas', 'public');

        $justificativa = Justificativa::create([
            'solicitacao_saida_id' => $solicitacao->id,
            'descricao' => $request->descricao,
            'arquivo' => $arquivo,
            'status' => 'em_analise',
        ]);

        $solicitacao->update(['status' => 'em_analise']);

        HistoricoSolicitacaoSaida::create([
            'solicitacao_saida_id' => $solicitacao->id,
            'user_id' => Auth::id(),
            'acao' => 'justificativa_enviada',
            'descricao' => "Aluno enviou justificativa #{$justificativa->id}.",
        ]);

        return back()->with('success', 'Justificativa enviada para analise da secretaria.');
    }
}
