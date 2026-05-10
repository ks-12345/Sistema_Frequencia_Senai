<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SubstitutoController extends Controller
{
    public function index()
    {
        $substitutos = User::where('is_substituto', true)
                          ->with('turmas')
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('admin.substitutos.index', compact('substitutos'));
    }

    public function create()
    {
        $turmas = Turma::with('professor')->orderBy('nome')->get();
        return view('admin.substitutos.create', compact('turmas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'turma_id'   => 'required|exists:turmas,id',
            'nome'       => 'required|string|max:255',
            'expira_em'  => 'required|date|after:now',
        ]);

        $senha = Str::random(10);
        $email = 'sub_' . Str::random(6) . '@senai.temp';

        $substituto = User::create([
            'name'            => $request->nome,
            'email'           => $email,
            'password'        => Hash::make($senha),
            'role'            => 'professor',
            'is_substituto'   => true,
            'acesso_expira_em'=> $request->expira_em,
        ]);

        // Vincula à turma específica
        $substituto->turmas()->attach($request->turma_id);

        return redirect()->route('admin.substitutos.index')
                         ->with('credenciais', [
                             'nome'  => $request->nome,
                             'email' => $email,
                             'senha' => $senha,
                         ]);
    }

    public function destroy(User $substituto)
    {
        $substituto->turmas()->detach();
        $substituto->delete();

        return redirect()->route('admin.substitutos.index')
                         ->with('success', 'Acesso removido!');
    }
}