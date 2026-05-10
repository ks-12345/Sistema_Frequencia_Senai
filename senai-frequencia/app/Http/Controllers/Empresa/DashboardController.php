<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Frequencia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $empresa_id = Auth::user()->empresa_id;

        $totalAlunos = Aluno::where('empresa_id', $empresa_id)->count();

        $totalFrequencias = Frequencia::whereHas('aluno', function ($q) use ($empresa_id) {
            $q->where('empresa_id', $empresa_id);
        })->count();

        $totalPresencas = Frequencia::whereHas('aluno', function ($q) use ($empresa_id) {
            $q->where('empresa_id', $empresa_id);
        })->where('status_presenca', 'presente')->count();

        $percentual = $totalFrequencias > 0
            ? round(($totalPresencas / $totalFrequencias) * 100, 1)
            : 0;

        return view('empresa.dashboard', compact('totalAlunos', 'percentual'));
    }
}