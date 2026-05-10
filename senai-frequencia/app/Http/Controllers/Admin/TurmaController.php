<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index()
    {
        $turmas = Turma::with('professor')->orderBy('nome')->paginate(10);
        return view('admin.turmas.index', compact('turmas'));
    }

    public function create()
    {
        $professores = User::where('role', 'professor')
                          ->where('is_substituto', false)
                          ->orderBy('name')
                          ->get();
        return view('admin.turmas.create', compact('professores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'         => 'required|string|max:255',
            'curso'        => 'required|string|max:255',
            'periodo'      => 'required|string|max:255',
            'professor_id' => 'required|exists:users,id',
        ]);

        Turma::create($request->only('nome', 'curso', 'periodo', 'professor_id'));

        return redirect()->route('admin.turmas.index')
                         ->with('success', 'Turma cadastrada com sucesso!');
    }

    public function edit(Turma $turma)
    {
        $professores = User::where('role', 'professor')
                          ->where('is_substituto', false)
                          ->orderBy('name')
                          ->get();
        return view('admin.turmas.edit', compact('turma', 'professores'));
    }

    public function update(Request $request, Turma $turma)
    {
        $request->validate([
            'nome'         => 'required|string|max:255',
            'curso'        => 'required|string|max:255',
            'periodo'      => 'required|string|max:255',
            'professor_id' => 'required|exists:users,id',
        ]);

        $turma->update($request->only('nome', 'curso', 'periodo', 'professor_id'));

        return redirect()->route('admin.turmas.index')
                         ->with('success', 'Turma atualizada!');
    }

    public function destroy(Turma $turma)
    {
        $turma->delete();
        return redirect()->route('admin.turmas.index')
                         ->with('success', 'Turma removida!');
    }

    public function finalizar(Turma $turma)
{
    if ($turma->isFinalizada()) {
        return back()->with('error', 'Turma já está finalizada.');
    }

    $turma->update([
        'status'        => 'finalizada',
        'finalizada_em' => now(),
    ]);

    return back()->with('success', "Turma {$turma->nome} finalizada com sucesso!");
}

public function reativar(Turma $turma)
{
    $turma->update([
        'status'        => 'ativa',
        'finalizada_em' => null,
    ]);

    return back()->with('success', "Turma {$turma->nome} reativada!");
}
}