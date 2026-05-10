<!DOCTYPE html>
<html>
<head><title>Frequências Pendentes</title></head>
<body>
    <h1>Frequências Pendentes de Aprovação</h1>
    <a href="{{ route('professor.frequencia.index') }}">Voltar</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if($frequencias->isEmpty())
        <p>Nenhuma frequência pendente.</p>
    @else
    <table border="1" cellpadding="8">
        <tr>
            <th>Data</th>
            <th>Aluno</th>
            <th>Turma</th>
            <th>Presença</th>
            <th>Lançado por</th>
            <th>Ações</th>
        </tr>
        @foreach($frequencias as $frequencia)
        <tr>
            <td>{{ $frequencia->data->format('d/m/Y') }}</td>
            <td>{{ $frequencia->aluno->nome }}</td>
            <td>{{ $frequencia->aluno->turma->nome }}</td>
            <td>{{ ucfirst($frequencia->status_presenca) }}</td>
            <td>{{ $frequencia->lancadoPor->name }}</td>
            <td>
                <form method="POST" action="{{ route('professor.frequencia.aprovar', $frequencia) }}" style="display:inline">
                    @csrf @method('PATCH')
                    <button>Aprovar</button>
                </form>
                <form method="POST" action="{{ route('professor.frequencia.rejeitar', $frequencia) }}" style="display:inline">
                    @csrf @method('PATCH')
                    <button onclick="return confirm('Rejeitar esta frequência?')">Rejeitar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    @endif
</body>
</html>