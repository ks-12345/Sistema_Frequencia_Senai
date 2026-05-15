<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\RegistroAcesso;
use App\Models\SolicitacaoSaida;
use App\Models\TentativaSaida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function cracha()
    {
        $aluno = Auth::user()->aluno;
        abort_if(!$aluno, 404);

        return view('aluno.cracha', compact('aluno'));
    }

    public function imagem()
    {
        $aluno = Auth::user()->aluno;
        abort_if(!$aluno, 404);

        $qrcode = QrCode::format('svg')
                        ->size(300)
                        ->errorCorrection('H')
                        ->generate($aluno->qrcode_token);

        return response($qrcode, 200)->header('Content-Type', 'image/svg+xml');
    }

    public function leitura()
    {
        $aluno = Auth::user()->aluno()->with(['turma', 'empresa'])->first();
        abort_if(!$aluno, 404);

        return view('aluno.leitura', compact('aluno'));
    }

    public function registrarAcesso(Request $request)
    {
        $request->validate([
            'tipo'  => 'required|in:entrada_portaria,entrada_bloco,saida',
            'local' => 'nullable|string|max:100',
        ]);

        $aluno = Auth::user()->aluno()->with('turma')->first();
        abort_if(!$aluno, 404);

        if ($request->tipo === 'saida') {
            $solicitacao = SolicitacaoSaida::where('aluno_id', $aluno->id)
                ->whereDate('data', today())
                ->latest()
                ->first();

            $saidaAutorizada = $solicitacao?->autorizado_saida === true;
            $deveBloquear = ($solicitacao && !$saidaAutorizada) || ($aluno->isMenorDeIdade() && !$saidaAutorizada);

            if ($deveBloquear) {
                TentativaSaida::create([
                    'aluno_id' => $aluno->id,
                    'data_hora' => now(),
                    'resultado' => 'bloqueado',
                    'motivo_bloqueio' => 'Saida nao autorizada. Necessaria autorizacao da secretaria.',
                ]);

                return back()->withErrors([
                    'saida' => 'Saída não autorizada. Necessária autorização da secretaria.',
                ])->withInput();
            }

            TentativaSaida::create([
                'aluno_id' => $aluno->id,
                'data_hora' => now(),
                'resultado' => 'liberado',
            ]);
        }

        $status = 'ok';
        $observacao = null;

        if ($request->tipo === 'entrada_bloco' && $request->local && $aluno->turma) {
            $blocoEsperado = $aluno->turma->bloco;

            if ($blocoEsperado && $blocoEsperado !== $request->local) {
                $status = 'bloco_errado';
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

        return redirect()->route('aluno.resultado', $registro);
    }

    public function resultado(RegistroAcesso $registro)
    {
        $aluno = Auth::user()->aluno;
        abort_if(!$aluno || $registro->aluno_id !== $aluno->id, 403);

        $registro->load('aluno.turma');

        return view('aluno.resultado', compact('registro'));
    }
}
