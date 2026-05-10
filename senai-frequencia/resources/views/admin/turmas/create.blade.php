<!DOCTYPE html>
<html>
<head><title>Nova Turma</title></head>
<body>
    <h1>Nova Turma</h1>
    <a href="{{ route('admin.turmas.index') }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.turmas.store') }}">
        @csrf
        <p>
            <label>Nome da Turma</label><br>
            <input type="text" name="nome" value="{{ old('nome') }}" required>
        </p>
        <p>
            <label>Curso</label><br>
            <input type="text" name="curso" value="{{ old('curso') }}" required>
        </p>
        <p>
            <label>Período</label><br>
            <input type="text" name="periodo" value="{{ old('periodo') }}" placeholder="Ex: Manhã, Tarde, Noite" required>
        </p>
        <p>
            <label>Professor Responsável</label><br>
            <select name="professor_id" required>
                <option value="">Selecione...</option>
                @foreach($professores as $professor)
                    <option value="{{ $professor->id }}" {{ old('professor_id') == $professor->id ? 'selected' : '' }}>
                        {{ $professor->name }}
                    </option>
                @endforeach
            </select>
        </p>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>