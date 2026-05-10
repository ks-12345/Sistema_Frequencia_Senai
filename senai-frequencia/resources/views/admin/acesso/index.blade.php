<!DOCTYPE html>
<html>
<head><title>Controle de Acesso – SENAI</title></head>
<body>
    <h1>Controle de Acesso — Hoje</h1>
    <a href="{{ route('admin.acesso.leitura') }}">Nova Leitura</a>
    <a href="{{ route('admin.dashboard') }}">Voltar</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8" style="margin-top:16px; width:100%">
        <tr>
            <th>Horário</th>
            <th>Aluno</th>
            <th>Turma</th>
            <th>Tipo</th>
            <th>Local</th>
            <th>Status</th>
            <th>Observação</th>
        </tr>
        @forelse($registros as $registro)
        <tr style="{{ $registro->status !== 'ok' ? 'background:#fff3cd' : '' }}">
            <td>{{ $registro->registrado_em->format('H:i:s') }}</td>
            <td>{{ $registro->aluno->nome }}</td>
            <td>{{ $registro->aluno->turma->nome ?? '—' }}</td>
            <td>{{ match($registro->tipo) {
                'entrada_portaria' => 'Entrada Portaria',
                'entrada_bloco'    => 'Entrada Bloco',
                'saida'            => 'Saída',
            } }}</td>
            <td>{{ $registro->local ?? '—' }}</td>
            <td style="color: {{ $registro->status === 'ok' ? 'green' : 'red' }}">
                {{ match($registro->status) {
                    'ok'           => '✅ OK',
                    'bloco_errado' => '⚠️ Bloco Errado',
                    'ausente_sala' => '❌ Ausente',
                } }}
            </td>
            <td>{{ $registro->observacao ?? '—' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center">Nenhum registro hoje.</td>
        </tr>
        @endforelse
    </table>

    {{ $registros->links() }}
</body>
</html>