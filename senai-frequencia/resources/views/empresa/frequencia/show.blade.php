<!DOCTYPE html>
<html>
<head><title>Frequência – {{ $aluno->nome }}</title></head>
<body>
    <h1>Frequência de {{ $aluno->nome }}</h1>
    <a href="{{ route('empresa.frequencia.index') }}">Voltar</a>

    <p>Percentual de presença: <strong>{{ $percentual }}%</strong></p>

    <table border="1" cellpadding="8">
        <tr>
            <th>Data</th>
            <th>Status</th>
            <th>Lançado por</th>
            <th>Observação</th>
        </tr>
        @foreach($frequencias as $frequencia)
        <tr>
            <td>{{ $frequencia->data->format('d/m/Y') }}</td>
            <td>{{ ucfirst($frequencia->status_presenca) }}</td>
            <td>{{ $frequencia->lancadoPor->name ?? '—' }}</td>
            <td>{{ $frequencia->observacao ?? '—' }}</td>
        </tr>
        @endforeach
    </table>

    {{ $frequencias->links() }}
</body>
</html>