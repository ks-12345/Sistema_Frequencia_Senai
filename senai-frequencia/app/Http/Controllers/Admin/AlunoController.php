<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Empresa;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::with(['turma', 'empresa'])->orderBy('nome')->paginate(10);
        return view('admin.alunos.index', compact('alunos'));
    }

    public function create()
    {
        $turmas   = Turma::orderBy('nome')->get();
        $empresas = Empresa::orderBy('nome')->get();
        return view('admin.alunos.create', compact('turmas', 'empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'       => 'required|string|max:255',
            'matricula'  => 'required|string|unique:alunos',
            'turma_id'   => 'required|exists:turmas,id',
            'empresa_id' => 'nullable|exists:empresas,id',
        ]);

        Aluno::create($request->only('nome', 'matricula', 'turma_id', 'empresa_id'));

        return redirect()->route('admin.alunos.index')
                         ->with('success', 'Aluno cadastrado com sucesso!');
    }

    public function edit(Aluno $aluno)
    {
        $turmas   = Turma::orderBy('nome')->get();
        $empresas = Empresa::orderBy('nome')->get();
        return view('admin.alunos.edit', compact('aluno', 'turmas', 'empresas'));
    }

    public function update(Request $request, Aluno $aluno)
    {
        $request->validate([
            'nome'       => 'required|string|max:255',
            'matricula'  => 'required|string|unique:alunos,matricula,' . $aluno->id,
            'turma_id'   => 'required|exists:turmas,id',
            'empresa_id' => 'nullable|exists:empresas,id',
        ]);

        $aluno->update($request->only('nome', 'matricula', 'turma_id', 'empresa_id'));

        return redirect()->route('admin.alunos.index')
                         ->with('success', 'Aluno atualizado!');
    }

    public function destroy(Aluno $aluno)
    {
        $aluno->delete();
        return redirect()->route('admin.alunos.index')
                         ->with('success', 'Aluno removido!');
    }
}