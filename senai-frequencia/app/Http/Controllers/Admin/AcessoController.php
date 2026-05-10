<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\RegistroAcesso;
use Illuminate\Http\Request;

class AcessoController extends Controller
{
    // Tela principal da portaria
    public function index()
    {
        $registros = RegistroAcesso::with('aluno.turma')
            ->whereDate('registrado_em', today())
            ->orderBy('registrado_em', 'desc')
            ->paginate(20);

        return view('admin.acesso.index', compact('registros'));
    }

    // Tela de leitura por QR Code
    public function leitura()
    {
        return view('admin.acesso.leitura');
    }

    // Processa a leitura do QR Code
    public function registrar(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'tipo'  => 'required|in:entrada_portaria,entrada_bloco,saida',
            'local' => 'nullable|string|max:100',
        ]);

        $aluno = Aluno::where('qrcode_token', $request->token)
                      ->with('turma')
                      ->first();

        if (!$aluno) {
            return back()->with('error', 'QR Code não reconhecido.');
        }

        // Detecta se aluno está no bloco errado
        $status = 'ok';
        $observacao = null;

        if ($request->tipo === 'entrada_bloco' && $request->local && $aluno->turma) {
            $blocoEsperado = $aluno->turma->bloco;
            if ($blocoEsperado && $blocoEsperado !== $request->local) {
                $status     = 'bloco_errado';
                $observacao = "Esperado: {$blocoEsperado}, Registrado: {$request->local}";
            }
        }

        $registro = RegistroAcesso::create([
            'aluno_id'      => $aluno->id,
            'tipo'          => $request->tipo,
            'local'         => $request->local,
            'registrado_em' => now(),
            'status'        => $status,
            'observacao'    => $observacao,
        ]);

        return redirect()->route('admin.acesso.resultado', $registro)
                         ->with('aluno', $aluno);
    }

    // Resultado da leitura
    public function resultado(RegistroAcesso $registro)
    {
        $registro->load('aluno.turma');
        return view('admin.acesso.resultado', compact('registro'));
    }

    // Histórico de acesso de um aluno
    public function historico(Aluno $aluno)
    {
        $registros = RegistroAcesso::where('aluno_id', $aluno->id)
            ->orderBy('registrado_em', 'desc')
            ->paginate(20);

        return view('admin.acesso.historico', compact('aluno', 'registros'));
    }
}