<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiarioAula;
use App\Models\Turma;

class DiarioAulaController extends Controller
{
    public function index()
    {
        $turmas = Turma::withCount('diarioAulas')->orderBy('nome')->get();
        return view('admin.diario.index', compact('turmas'));
    }

    public function turma(Turma $turma)
    {
        $aulas = DiarioAula::with('professor')
            ->where('turma_id', $turma->id)
            ->orderBy('data', 'desc')
            ->paginate(15);

        return view('admin.diario.turma', compact('turma', 'aulas'));
    }
}