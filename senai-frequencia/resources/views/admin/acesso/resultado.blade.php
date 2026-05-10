<!DOCTYPE html>
<html>
<head><title>Resultado – SENAI</title></head>
<body>
    <div style="max-width:400px; margin:40px auto; text-align:center; 
                border:2px solid {{ $registro->status === 'ok' ? 'green' : 'orange' }};
                border-radius:12px; padding:32px">

        @if($registro->status === 'ok')
            <h1 style="color:green">✅ Acesso Registrado</h1>
        @elseif($registro->status === 'bloco_errado')
            <h1 style="color:orange">⚠️ Bloco Incorreto</h1>
        @else
            <h1 style="color:red">❌ Alerta</h1>
        @endif

        <p><strong>Aluno:</strong> {{ $registro->aluno->nome }}</p>
        <p><strong>Matrícula:</strong> {{ $registro->aluno->matricula }}</p>
        <p><strong>Turma:</strong> {{ $registro->aluno->turma->nome ?? '—' }}</p>
        <p><strong>Tipo:</strong> {{ match($registro->tipo) {
            'entrada_portaria' => 'Entrada Portaria',
            'entrada_bloco'    => 'Entrada Bloco',
            'saida'            => 'Saída',
        } }}</p>
        <p><strong>Local:</strong> {{ $registro->local ?? '—' }}</p>
        <p><strong>Horário:</strong> {{ $registro->registrado_em->format('H:i:s') }}</p>

        @if($registro->observacao)
            <p style="color:orange"><strong>Obs:</strong> {{ $registro->observacao }}</p>
        @endif

        <a href="{{ route('admin.acesso.leitura') }}"
           style="display:inline-block;margin-top:16px;padding:10px 20px;
                  background:#1a56db;color:#fff;border-radius:8px;text-decoration:none">
            Nova Leitura
        </a>
        <a href="{{ route('admin.acesso.index') }}"
           style="display:inline-block;margin-top:8px;padding:10px 20px;
                  background:#6b7280;color:#fff;border-radius:8px;text-decoration:none">
            Ver Todos
        </a>
    </div>
</body>
</html>