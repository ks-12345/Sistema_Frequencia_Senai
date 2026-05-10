<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    // Exibe o crachá com QR Code do aluno
    public function cracha(Aluno $aluno)
    {
        return view('admin.qrcode.cracha', compact('aluno'));
    }

    // Retorna a imagem do QR Code
    public function imagem(Aluno $aluno)
    {
        $qrcode = QrCode::format('png')
                        ->size(300)
                        ->errorCorrection('H')
                        ->generate($aluno->qrcode_token);

        return response($qrcode, 200)->header('Content-Type', 'image/png');
    }

    // Simula leitura do QR Code
    public function lerQrCode(string $token)
    {
        $aluno = Aluno::where('qrcode_token', $token)
                      ->with(['turma', 'empresa'])
                      ->firstOrFail();

        return view('admin.qrcode.leitura', compact('aluno'));
    }
}