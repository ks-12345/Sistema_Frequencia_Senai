<!DOCTYPE html>
<html>
<head><title>Aprendizes – SENAI</title></head>
<body>
    <h1>Meus Aprendizes</h1>
    <a href="{{ route('empresa.dashboard') }}">Voltar</a>

    <table border="1" cellpadding="8">
        <tr>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Turma</th>
            <th>Total de Aulas</th>
            <th>Presenças</th>
            <th>Ação</th>
        </tr>
        @foreach($alunos as $aluno)
        <tr>
            <td>{{ $aluno->nome }}</td>
            <td>{{ $aluno->matricula }}</td>
            <td>{{ $aluno->turma->nome ?? '—' }}</td>
            <td>{{ $aluno->frequencias->count() }}</td>
            <td>{{ $aluno->frequencias->where('status_presenca', 'presente')->count() }}</td>
            <td>
                <a href="{{ route('empresa.frequencia.show', $aluno) }}">Ver Detalhes</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>