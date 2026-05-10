<!DOCTYPE html>
<html>
<head><title>Diário de Classe – Admin</title></head>
<body>
    <h1>Diário de Classe</h1>
    <a href="{{ route('admin.dashboard') }}">Voltar</a>

    <table border="1" cellpadding="8" style="margin-top:16px; width:100%">
        <tr>
            <th>Turma</th>
            <th>Curso</th>
            <th>Status</th>
            <th>Total de Aulas</th>
            <th>Ações</th>
        </tr>
        @foreach($turmas as $turma)
        <tr>
            <td>{{ $turma->nome }}</td>
            <td>{{ $turma->curso }}</td>
            <td style="color: {{ $turma->isFinalizada() ? 'red' : 'green' }}">
                {{ $turma->isFinalizada() ? 'Finalizada' : 'Ativa' }}
            </td>
            <td style="text-align:center">{{ $turma->diario_aulas_count }}</td>
            <td>
                <a href="{{ route('admin.diario.turma', $turma) }}">Ver Diário</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>