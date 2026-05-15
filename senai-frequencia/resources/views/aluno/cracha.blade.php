<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Crachá – SENAI</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f3f4f6; margin: 0; }
        .cracha { width: 320px; padding: 26px; border-radius: 24px; background: #fff; border: 1px solid #e2e8f0; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08); text-align: center; }
        .cracha h2 { margin: 0; color: #2563eb; font-size: 13px; letter-spacing: .15em; text-transform: uppercase; }
        .cracha h1 { margin: 16px 0 8px; font-size: 22px; color: #0f172a; }
        .cracha p { margin: 8px 0; color: #475569; font-size: 14px; }
        .cracha img { margin: 18px auto; display: block; }
        .btn { display: inline-block; margin-top: 18px; padding: 10px 18px; background: #2563eb; color: #fff; border-radius: 999px; text-decoration: none; font-size: 13px; }
        .btn-secondary { background: #64748b; }
    </style>
</head>
<body>
    <div class="cracha">
        <h2>SENAI – Aluno</h2>
        <h1>{{ $aluno->nome }}</h1>
        <p><strong>Matrícula:</strong> {{ $aluno->matricula }}</p>
        <p><strong>Turma:</strong> {{ $aluno->turma->nome ?? '—' }}</p>
        <p><strong>Curso:</strong> {{ $aluno->turma->curso ?? '—' }}</p>
        <img src="{{ route('aluno.imagem') }}" width="200" height="200" alt="QR Code">
        <p style="font-size:12px;color:#64748b;margin-top:12px;">Token: {{ $aluno->qrcode_token }}</p>
        <a href="{{ route('aluno.leitura') }}" class="btn">Simular Leitura</a>
        <br>
        <a href="{{ route('aluno.dashboard') }}" class="btn-secondary btn">Voltar ao Painel</a>
    </div>
</body>
</html>
