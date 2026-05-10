<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Frequencia;
use Illuminate\Support\Facades\Auth;

class FrequenciaController extends Controller
{
    public function index()
    {
        $alunos = Aluno::with(['turma', 'frequencias'])
            ->where('empresa_id', Auth::user()->empresa_id)
            ->orderBy('nome')
            ->get();

        return view('empresa.frequencia.index', compact('alunos'));
    }

    public function show(Aluno $aluno)
    {
        // Garante que a empresa só vê seus próprios alunos
        if ($aluno->empresa_id !== Auth::user()->empresa_id) {
            abort(403);
        }

        $frequencias = Frequencia::with('lancadoPor')
            ->where('aluno_id', $aluno->id)
            ->orderBy('data', 'desc')
            ->paginate(20);

        $total     = $frequencias->total();
        $presencas = Frequencia::where('aluno_id', $aluno->id)
                               ->where('status_presenca', 'presente')
                               ->count();
        $percentual = $total > 0 ? round(($presencas / $total) * 100, 1) : 0;

        return view('empresa.frequencia.show', compact('aluno', 'frequencias', 'percentual'));
    }
}