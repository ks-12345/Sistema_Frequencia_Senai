<!DOCTYPE html>
<html>
<head><title>Histórico de Acesso – {{ $aluno->nome }}</title></head>
<body>
    <h1>Histórico de Acesso – {{ $aluno->nome }}</h1>
    <a href="{{ route('admin.acesso.index') }}">Voltar</a>

    <table border="1" cellpadding="8" style="margin-top:16px; width:100%">
        <tr>
            <th>Data</th>
            <th>Horário</th>
            <th>Tipo</th>
            <th>Local</th>
            <th>Status</th>
        </tr>
        @forelse($registros as $registro)
        <tr>
            <td>{{ $registro->registrado_em->format('d/m/Y') }}</td>
            <td>{{ $registro->registrado_em->format('H:i:s') }}</td>
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
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center">Nenhum registro encontrado.</td>
        </tr>
        @endforelse
    </table>

    {{ $registros->links() }}
</body>
</html>