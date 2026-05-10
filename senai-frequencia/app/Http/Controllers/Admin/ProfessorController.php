<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfessorController extends Controller
{
    public function index()
    {
        $professores = User::where('role', 'professor')
                          ->where('is_substituto', false)
                          ->orderBy('name')
                          ->paginate(10);
        return view('admin.professores.index', compact('professores'));
    }

    public function create()
    {
        return view('admin.professores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'professor',
        ]);

        return redirect()->route('admin.professores.index')
                         ->with('success', 'Professor cadastrado com sucesso!');
    }

    public function edit(User $professore)
    {
        return view('admin.professores.edit', compact('professore'));
    }

    public function update(Request $request, User $professore)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $professore->id,
        ]);

        $data = $request->only('name', 'email');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $professore->update($data);

        return redirect()->route('admin.professores.index')
                         ->with('success', 'Professor atualizado!');
    }

    public function destroy(User $professore)
    {
        $professore->delete();
        return redirect()->route('admin.professores.index')
                         ->with('success', 'Professor removido!');
    }
}