<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\User;
use App\Models\Frequencia;
use App\Models\Empresa;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAlunos      = Aluno::count();
        $totalTurmas      = Turma::count();
        $totalProfessores = User::where('role', 'professor')
                               ->where('is_substituto', false)
                               ->count();
        $totalEmpresas    = Empresa::count();

        $totalFrequencias = Frequencia::count();
        $totalPresencas   = Frequencia::where('status_presenca', 'presente')->count();
        $percentualGeral  = $totalFrequencias > 0
            ? round(($totalPresencas / $totalFrequencias) * 100, 1)
            : 0;

        $pendentes = Frequencia::where('status_aprovacao', 'pendente')->count();

        return view('admin.dashboard', compact(
            'totalAlunos',
            'totalTurmas',
            'totalProfessores',
            'totalEmpresas',
            'percentualGeral',
            'pendentes'
        ));
    }
}