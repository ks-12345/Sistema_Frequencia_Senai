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
                ->where(function ($query) {
                    $query->whereDoesntHave('frequencia')
                        ->orWhereHas('frequencia', fn ($frequencia) => $frequencia->where('status_presenca', 'saida_antecipada'));
                })
                ->latest()
                ->first();

            $motivoBloqueio = null;

            if ($aluno->isMenorDeIdade()) {
                $motivoBloqueio = 'Saida nao permitida para aluno menor de idade sem procedimento presencial da secretaria.';
            } elseif (!$solicitacao) {
                $motivoBloqueio = 'Saida nao permitida. Nao existe autorizacao registrada para hoje.';
            } elseif ($solicitacao->autorizado_saida !== true) {
                $motivoBloqueio = 'Saida nao permitida. A autorizacao da secretaria ainda esta pendente ou foi recusada.';
            }

            if ($motivoBloqueio) {
                TentativaSaida::create([
                    'aluno_id' => $aluno->id,
                    'data_hora' => now(),
                    'resultado' => 'bloqueado',
                    'motivo_bloqueio' => $motivoBloqueio,
                ]);

                return back()->withErrors([
                    'saida' => $motivoBloqueio,
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
