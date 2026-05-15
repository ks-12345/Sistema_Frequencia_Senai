<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Acesso - SENAI</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f3f4f6; margin: 0; }
        .card { width: 380px; padding: 32px; border-radius: 22px; background: #fff; border: 2px solid {{ $registro->status === 'ok' ? '#16a34a' : '#f59e0b' }}; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08); text-align: center; }
        h1 { color: {{ $registro->status === 'ok' ? '#16a34a' : '#f59e0b' }}; font-size: 22px; margin: 0 0 18px; }
        p { font-size: 15px; margin: 8px 0; color: #334155; }
        .btn { display: inline-block; margin-top: 16px; padding: 10px 18px; background: #2563eb; color: #fff; border-radius: 999px; text-decoration: none; font-size: 13px; }
        .btn-secondary { background: #64748b; }
    </style>
</head>
<body>
    <div class="card">
        @if($registro->status === 'ok')
            <h1>Acesso Registrado</h1>
        @else
            <h1>Bloco Incorreto</h1>
        @endif

        <p><strong>Aluno:</strong> {{ $registro->aluno->nome }}</p>
        <p><strong>Matricula:</strong> {{ $registro->aluno->matricula }}</p>
        <p><strong>Turma:</strong> {{ $registro->aluno->turma->nome ?? '---' }}</p>
        <p><strong>Tipo:</strong> {{ match($registro->tipo) {
            'entrada_portaria' => 'Entrada Portaria',
            'entrada_bloco' => 'Entrada Bloco',
            'saida' => 'Saida',
        } }}</p>
        <p><strong>Local:</strong> {{ $registro->local ?? '---' }}</p>
        <p><strong>Horario:</strong> {{ $registro->registrado_em->format('H:i:s') }}</p>

        @if($registro->observacao)
            <p style="color:#f59e0b"><strong>Obs:</strong> {{ $registro->observacao }}</p>
        @endif

        <a href="{{ route('aluno.leitura') }}" class="btn">Nova passagem</a>
        <a href="{{ route('aluno.dashboard') }}" class="btn btn-secondary">Voltar ao Painel</a>
    </div>
</body>
</html>
