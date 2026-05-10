<?php

namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Models\SaidaAntecipada;
use App\Models\Frequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaidaAntecipadaController extends Controller
{
    public function index()
    {
        $pendentes = SaidaAntecipada::with(['aluno.turma', 'solicitadoPor'])
            ->where('status', 'pendente')
            ->orderBy('created_at', 'desc')
            ->get();

        $historico = SaidaAntecipada::with(['aluno.turma', 'solicitadoPor', 'validadoPor'])
            ->whereIn('status', ['autorizada', 'nao_autorizada'])
            ->orderBy('validado_em', 'desc')
            ->paginate(10);

        return view('secretaria.saidas.index', compact('pendentes', 'historico'));
    }

    public function autorizar(Request $request, SaidaAntecipada $saida)
    {
        $request->validate([
            'observacao_secretaria' => 'nullable|string|max:500',
        ]);

        $saida->update([
            'status'                => 'autorizada',
            'validado_por_id'       => Auth::id(),
            'observacao_secretaria' => $request->observacao_secretaria,
            'validado_em'           => now(),
        ]);

        // Atualiza frequência do aluno para atraso
        Frequencia::where('aluno_id', $saida->aluno_id)
            ->whereDate('data', $saida->horario_saida->toDateString())
            ->where('status_aprovacao', 'aprovado')
            ->update(['status_presenca' => 'atraso', 'observacao' => 'Saída antecipada autorizada']);

        return back()->with('success', 'Saída autorizada e frequência atualizada!');
    }

    public function naoAutorizar(Request $request, SaidaAntecipada $saida)
    {
        $request->validate([
            'observacao_secretaria' => 'nullable|string|max:500',
        ]);

        $saida->update([
            'status'                => 'nao_autorizada',
            'validado_por_id'       => Auth::id(),
            'observacao_secretaria' => $request->observacao_secretaria,
            'validado_em'           => now(),
        ]);

        return back()->with('success', 'Saída não autorizada registrada.');
    }
}