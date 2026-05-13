<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
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
}
