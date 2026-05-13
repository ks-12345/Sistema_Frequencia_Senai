<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlunosController extends Controller
{
    public function index()
    {
        $empresa_id = Auth::user()->empresa_id;

        $alunos = Aluno::where('empresa_id', $empresa_id)
                      ->orderBy('nome')
                      ->paginate(10);

        return view('empresa.alunos.index', compact('alunos'));
    }
}