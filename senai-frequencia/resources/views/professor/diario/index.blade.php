<!DOCTYPE html>
<html>
<head><title>Diário de Classe – SENAI</title></head>
<body>
    <h1>Diário de Classe</h1>
    <a href="{{ route('professor.dashboard') }}">Voltar</a>

    <table border="1" cellpadding="8" style="margin-top:16px; width:100%">
        <tr>
            <th>Turma</th>
            <th>Curso</th>
            <th>Período</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        @foreach($turmas as $turma)
        <tr>
            <td>{{ $turma->nome }}</td>
            <td>{{ $turma->curso }}</td>
            <td>{{ $turma->periodo }}</td>
            <td style="color: {{ $turma->isFinalizada() ? 'red' : 'green' }}">
                {{ $turma->isFinalizada() ? 'Finalizada' : 'Ativa' }}
            </td>
            <td>
                <a href="{{ route('professor.diario.turma', $turma) }}">Ver Diário</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>