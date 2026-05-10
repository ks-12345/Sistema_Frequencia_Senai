<!DOCTYPE html>
<html>
<head><title>Editar Turma</title></head>
<body>
    <h1>Editar Turma</h1>
    <a href="{{ route('admin.turmas.index') }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.turmas.update', $turma) }}">
        @csrf @method('PUT')
        <p>
            <label>Nome da Turma</label><br>
            <input type="text" name="nome" value="{{ old('nome', $turma->nome) }}" required>
        </p>
        <p>
            <label>Curso</label><br>
            <input type="text" name="curso" value="{{ old('curso', $turma->curso) }}" required>
        </p>
        <p>
            <label>Período</label><br>
            <input type="text" name="periodo" value="{{ old('periodo', $turma->periodo) }}" required>
        </p>
        <p>
            <label>Professor Responsável</label><br>
            <select name="professor_id" required>
                <option value="">Selecione...</option>
                @foreach($professores as $professor)
                    <option value="{{ $professor->id }}" {{ $turma->professor_id == $professor->id ? 'selected' : '' }}>
                        {{ $professor->name }}
                    </option>
                @endforeach
            </select>
        </p>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>