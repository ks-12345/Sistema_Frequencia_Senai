<!DOCTYPE html>
<html>
<head><title>Lançar Frequência – {{ $turma->nome }}</title></head>
<body>
    <h1>Frequência – {{ $turma->nome }}</h1>
    <a href="{{ route('professor.frequencia.index') }}">Voltar</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('professor.frequencia.store') }}">
        @csrf
        <input type="hidden" name="turma_id" value="{{ $turma->id }}">
        <p>
            <label>Data</label><br>
            <input type="date" name="data" value="{{ $data }}" required>
        </p>

        <table border="1" cellpadding="8">
            <tr>
                <th>Aluno</th>
                <th>Matrícula</th>
                <th>Presença</th>
                <th>Observação</th>
            </tr>
            @foreach($alunos as $aluno)
            <tr>
                <td>{{ $aluno->nome }}</td>
                <td>{{ $aluno->matricula }}</td>
                <td>
                    <select name="frequencias[{{ $aluno->id }}]" required>
                        <option value="presente">Presente</option>
                        <option value="falta">Falta</option>
                        <option value="atraso">Atraso</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="observacoes[{{ $aluno->id }}]" placeholder="Opcional">
                </td>
            </tr>
            @endforeach
        </table>

        <br>
        <button type="submit">Salvar Frequência</button>
    </form>
</body>
</html>