<!DOCTYPE html>
<html>
<head>
<title>Crachá – {{ $aluno->nome }}</title>
<style>
    body { font-family: Arial, sans-serif; display: flex; justify-content: center; padding: 40px; }
    .cracha {
        border: 2px solid #1a56db;
        border-radius: 12px;
        padding: 24px;
        width: 280px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .cracha h2 { color: #1a56db; margin: 0 0 4px; font-size: 14px; }
    .cracha h1 { margin: 8px 0; font-size: 18px; }
    .cracha p  { margin: 4px 0; font-size: 13px; color: #555; }
    .cracha img { margin: 16px 0; }
    .btn { display: inline-block; margin-top: 16px; padding: 8px 16px;
           background: #1a56db; color: #fff; border-radius: 6px;
           text-decoration: none; font-size: 13px; }
</style>
</head>
<body>
    <div class="cracha">
        <h2>SENAI – Sistema de Frequência</h2>
        <h1>{{ $aluno->nome }}</h1>
        <p><strong>Matrícula:</strong> {{ $aluno->matricula }}</p>
        <p><strong>Turma:</strong> {{ $aluno->turma->nome ?? '—' }}</p>
        <p><strong>Curso:</strong> {{ $aluno->turma->curso ?? '—' }}</p>

<img src="{{ route('admin.qrcode.imagem', $aluno) }}" 
     width="200" height="200" alt="QR Code"
     style="border: 1px solid #ddd; border-radius: 8px;">

        <p style="font-size:11px;color:#999">{{ $aluno->qrcode_token }}</p>

        <a href="{{ route('admin.qrcode.ler', $aluno->qrcode_token) }}" class="btn">
            Simular Leitura
        </a>
        <br>
        <a href="{{ route('admin.alunos.index') }}" class="btn" style="background:#6b7280;margin-top:8px">
            Voltar
        </a>
    </div>
</body>
</html>