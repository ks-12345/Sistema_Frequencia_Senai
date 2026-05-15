<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\RegistroAcesso;

class AcessoController extends Controller
{
    public function index()
    {
        $registros = RegistroAcesso::with('aluno.turma')
            ->whereDate('registrado_em', today())
            ->orderBy('registrado_em', 'desc')
            ->paginate(20);

        return view('admin.acesso.index', compact('registros'));
    }

    public function historico(Aluno $aluno)
    {
        $registros = RegistroAcesso::where('aluno_id', $aluno->id)
            ->orderBy('registrado_em', 'desc')
            ->paginate(20);

        return view('admin.acesso.historico', compact('aluno', 'registros'));
    }
}
