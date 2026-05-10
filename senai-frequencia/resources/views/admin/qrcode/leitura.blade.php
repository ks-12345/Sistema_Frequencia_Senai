<!DOCTYPE html>
<html>
<head>
<title>Leitura QR Code – SENAI</title>
<style>
    body { font-family: Arial, sans-serif; display: flex; justify-content: center; padding: 40px; }
    .card {
        border: 2px solid #16a34a;
        border-radius: 12px;
        padding: 32px;
        width: 340px;
        text-align: center;
    }
    .card h1 { color: #16a34a; font-size: 20px; }
    .card p  { font-size: 15px; margin: 8px 0; }
    .badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        margin-top: 8px;
    }
    .ativa    { background:#dcfce7; color:#16a34a; }
    .finalizada { background:#fee2e2; color:#dc2626; }
    .btn { display: inline-block; margin-top: 16px; padding: 8px 16px;
           background: #1a56db; color: #fff; border-radius: 6px;
           text-decoration: none; font-size: 13px; }
</style>
</head>
<body>
    <div class="card">
        <h1>✅ Aluno Identificado</h1>
        <p><strong>Nome:</strong> {{ $aluno->nome }}</p>
        <p><strong>Matrícula:</strong> {{ $aluno->matricula }}</p>
        <p><strong>Turma:</strong> {{ $aluno->turma->nome ?? '—' }}</p>
        <p><strong>Curso:</strong> {{ $aluno->turma->curso ?? '—' }}</p>
        <p><strong>Empresa:</strong> {{ $aluno->empresa->nome ?? '—' }}</p>

        <span class="badge {{ $aluno->turma?->status === 'ativa' ? 'ativa' : 'finalizada' }}">
            Turma {{ ucfirst($aluno->turma?->status ?? 'indefinida') }}
        </span>

        <br>
        <p style="font-size:12px;color:#999;margin-top:16px">
            Leitura realizada em: {{ now()->format('d/m/Y H:i:s') }}
        </p>

        <a href="{{ route('admin.qrcode.cracha', $aluno) }}" class="btn">Ver Crachá</a>
        <a href="{{ route('admin.alunos.index') }}" class="btn" style="background:#6b7280">Voltar</a>
    </div>
</body>
</html>