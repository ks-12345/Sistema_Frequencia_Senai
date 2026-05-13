<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::orderBy('nome')->paginate(10);
        return view('admin.empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('admin.empresas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'        => 'required|string|max:255',
            'cnpj'        => 'required|string|size:18|unique:empresas',
            'responsavel' => 'required|string|max:255',
            'email'       => 'required|email|unique:users',
            'password'    => 'required|string|min:8|confirmed',
        ]);

        // Cria a empresa
        $empresa = Empresa::create($request->only('nome', 'cnpj', 'responsavel'));

        // Cria o usuário de acesso para a empresa
        User::create([
            'name'        => $empresa->nome,
            'email'       => $request->email,
            'password'    => bcrypt($request->password),
            'role'        => 'empresa',
            'empresa_id'  => $empresa->id,
        ]);

        return redirect()->route('admin.empresas.index')
                         ->with('success', 'Empresa cadastrada com sucesso! Login: ' . $request->email);
    }

    public function edit(Empresa $empresa)
    {
        return view('admin.empresas.edit', compact('empresa'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'nome'        => 'required|string|max:255',
            'cnpj'        => 'required|string|size:18|unique:empresas,cnpj,' . $empresa->id,
            'responsavel' => 'required|string|max:255',
        ]);

        $empresa->update($request->only('nome', 'cnpj', 'responsavel'));

        return redirect()->route('admin.empresas.index')
                         ->with('success', 'Empresa atualizada!');
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('admin.empresas.index')
                         ->with('success', 'Empresa removida!');
    }
}