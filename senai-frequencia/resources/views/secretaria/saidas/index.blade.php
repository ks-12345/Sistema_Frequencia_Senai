<!DOCTYPE html>
<html>
<head><title>Validar Saídas – Secretaria</title></head>
<body>
    <h1>Saídas Antecipadas – Secretaria</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <h2>Pendentes de Validação</h2>
    @forelse($pendentes as $saida)
    <div style="border:1px solid #ddd; padding:16px; margin:8px 0; border-radius:8px">
        <p><strong>Aluno:</strong> {{ $saida->aluno->nome }} — {{ $saida->aluno->turma->nome ?? '—' }}</p>
        <p><strong>Horário:</strong> {{ $saida->horario_saida->format('d/m/Y H:i') }}</p>
        <p><strong>Motivo:</strong> {{ $saida->motivo ?? '—' }}</p>
        <p><strong>Solicitado por:</strong> {{ $saida->solicitadoPor->name }}</p>

        <form method="POST" action="{{ route('secretaria.saidas.autorizar', $saida) }}" style="display:inline">
            @csrf @method('PATCH')
            <input type="text" name="observacao_secretaria" placeholder="Observação (opcional)">
            <button style="background:green;color:#fff;padding:6px 12px;border:none;border-radius:4px">
                Autorizar
            </button>
        </form>

        <form method="POST" action="{{ route('secretaria.saidas.nao-autorizar', $saida) }}" style="display:inline;margin-left:8px">
            @csrf @method('PATCH')
            <input type="text" name="observacao_secretaria" placeholder="Motivo da recusa">
            <button style="background:red;color:#fff;padding:6px 12px;border:none;border-radius:4px">
                Não Autorizar
            </button>
        </form>
    </div>
    @empty
        <p>Nenhuma saída pendente.</p>
    @endforelse

    <h2>Histórico</h2>
    <table border="1" cellpadding="8" style="width:100%">
        <tr>
            <th>Aluno</th>
            <th>Horário</th>
            <th>Status</th>
            <th>Validado por</th>
            <th>Observação</th>
        </tr>
        @forelse($historico as $saida)
        <tr>
            <td>{{ $saida->aluno->nome }}</td>
            <td>{{ $saida->horario_saida->format('d/m/Y H:i') }}</td>
            <td style="color: {{ $saida->status === 'autorizada' ? 'green' : 'red' }}">
                {{ $saida->status === 'autorizada' ? '✅ Autorizada' : '❌ Não Autorizada' }}
            </td>
            <td>{{ $saida->validadoPor->name ?? '—' }}</td>
            <td>{{ $saida->observacao_secretaria ?? '—' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center">Nenhum histórico.</td>
        </tr>
        @endforelse
    </table>
    {{ $historico->links() }}
</body>
</html>