<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
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
        ]);

        Empresa::create($request->only('nome', 'cnpj', 'responsavel'));

        return redirect()->route('admin.empresas.index')
                         ->with('success', 'Empresa cadastrada com sucesso!');
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