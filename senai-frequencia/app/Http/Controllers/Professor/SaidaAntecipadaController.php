<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\SaidaAntecipada;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaidaAntecipadaController extends Controller
{
    public function index()
    {
        $turmasIds = Turma::where('professor_id', Auth::id())->pluck('id');

        $saidas = SaidaAntecipada::with(['aluno.turma', 'validadoPor'])
            ->whereHas('aluno', fn($q) => $q->whereIn('turma_id', $turmasIds))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('professor.saidas.index', compact('saidas'));
    }

    public function create()
    {
        $turmasIds = Turma::where('professor_id', Auth::id())->pluck('id');
        $alunos    = Aluno::whereIn('turma_id', $turmasIds)->orderBy('nome')->get();

        return view('professor.saidas.create', compact('alunos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aluno_id'     => 'required|exists:alunos,id',
            'horario_saida'=> 'required|date',
            'motivo'       => 'nullable|string|max:500',
        ]);

        SaidaAntecipada::create([
            'aluno_id'         => $request->aluno_id,
            'solicitado_por_id'=> Auth::id(),
            'horario_saida'    => $request->horario_saida,
            'motivo'           => $request->motivo,
            'status'           => 'pendente',
        ]);

        return redirect()->route('professor.saidas.index')
                         ->with('success', 'Saída antecipada registrada! Aguardando validação da secretaria.');
    }
}