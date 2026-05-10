<!DOCTYPE html>
<html>
<head><title>Registrar Saída Antecipada</title></head>
<body>
    <h1>Registrar Saída Antecipada</h1>
    <a href="{{ route('professor.saidas.index') }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('professor.saidas.store') }}">
        @csrf
        <p>
            <label>Aluno</label><br>
            <select name="aluno_id" required>
                <option value="">Selecione...</option>
                @foreach($alunos as $aluno)
                    <option value="{{ $aluno->id }}">{{ $aluno->nome }} – {{ $aluno->turma->nome ?? '' }}</option>
                @endforeach
            </select>
        </p>
        <p>
            <label>Horário de Saída</label><br>
            <input type="datetime-local" name="horario_saida" required>
        </p>
        <p>
            <label>Motivo</label><br>
            <textarea name="motivo" rows="3" cols="40" placeholder="Descreva o motivo..."></textarea>
        </p>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>