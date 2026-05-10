<!DOCTYPE html>
<html>
<head><title>Minhas Turmas – SENAI</title></head>
<body>
    <h1>Minhas Turmas</h1>
    <a href="{{ route('professor.frequencia.pendentes') }}">Ver Pendentes</a>
    <a href="{{ route('professor.dashboard') }}">Voltar</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <tr>
            <th>Turma</th>
            <th>Curso</th>
            <th>Período</th>
            <th>Ação</th>
        </tr>
        @foreach($turmas as $turma)
        <tr>
            <td>{{ $turma->nome }}</td>
            <td>{{ $turma->curso }}</td>
            <td>{{ $turma->periodo }}</td>
            <td>
                <a href="{{ route('professor.frequencia.lancar', $turma) }}">Lançar Frequência</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>