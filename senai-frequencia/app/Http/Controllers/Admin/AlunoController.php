<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            'nome'            => 'required|string|max:255',
            'matricula'       => ['required','string',Rule::unique('alunos')],
            'cpf'             => ['required','string','max:20',Rule::unique('alunos')],
            'email'           => ['required','email',Rule::unique('alunos'), Rule::unique('users')],
            'password'        => 'required|string|min:8|confirmed',
            'data_nascimento' => 'required|date',
            'endereco'        => 'required|string|max:1000',
            'turma_id'        => 'required|exists:turmas,id',
            'empresa_id'      => 'nullable|exists:empresas,id',
        ]);

        $aluno = Aluno::create($request->only([
            'nome',
            'matricula',
            'cpf',
            'email',
            'data_nascimento',
            'endereco',
            'turma_id',
            'empresa_id',
        ]));

        $user = User::create([
            'name'       => $aluno->nome,
            'email'      => $aluno->email,
            'password'   => Hash::make($request->password),
            'role'       => 'aluno',
            'empresa_id' => $aluno->empresa_id,
        ]);

        $aluno->update(['user_id' => $user->id]);

        return redirect()->route('admin.alunos.index')
                         ->with('success', 'Aluno cadastrado com sucesso! Login criado com email: ' . $request->email);
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
            'nome'            => 'required|string|max:255',
            'matricula'       => ['required','string',Rule::unique('alunos')->ignore($aluno->id)],
            'cpf'             => ['required','string','max:20',Rule::unique('alunos')->ignore($aluno->id)],
            'email'           => ['required','email',Rule::unique('alunos')->ignore($aluno->id), Rule::unique('users')->ignore($aluno->user_id)],
            'password'        => 'nullable|string|min:8|confirmed',
            'data_nascimento' => 'required|date',
            'endereco'        => 'required|string|max:1000',
            'turma_id'        => 'required|exists:turmas,id',
            'empresa_id'      => 'nullable|exists:empresas,id',
        ]);

        $aluno->update($request->only([
            'nome',
            'matricula',
            'cpf',
            'email',
            'data_nascimento',
            'endereco',
            'turma_id',
            'empresa_id',
        ]));

        if ($aluno->user) {
            $aluno->user->update([
                'name'       => $aluno->nome,
                'email'      => $aluno->email,
                'empresa_id' => $aluno->empresa_id,
                'password'   => $request->filled('password') ? Hash::make($request->password) : $aluno->user->password,
            ]);
        } elseif ($request->filled('password')) {
            $user = User::create([
                'name'       => $aluno->nome,
                'email'      => $aluno->email,
                'password'   => Hash::make($request->password),
                'role'       => 'aluno',
                'empresa_id' => $aluno->empresa_id,
            ]);
            $aluno->update(['user_id' => $user->id]);
        }

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