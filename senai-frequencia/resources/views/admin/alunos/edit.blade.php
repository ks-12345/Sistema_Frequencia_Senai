<!DOCTYPE html>
<html>
<head><title>Editar Aluno</title></head>
<body>
    <h1>Editar Aluno</h1>
    <a href="{{ route('admin.alunos.index') }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.alunos.update', $aluno) }}">
        @csrf @method('PUT')
        <p>
            <label>Nome</label><br>
            <input type="text" name="nome" value="{{ old('nome', $aluno->nome) }}" required>
        </p>
        <p>
            <label>Matrícula</label><br>
            <input type="text" name="matricula" value="{{ old('matricula', $aluno->matricula) }}" required>
        </p>
        <p>
            <label>Turma</label><br>
            <select name="turma_id" required>
                <option value="">Selecione...</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" {{ $aluno->turma_id == $turma->id ? 'selected' : '' }}>
                        {{ $turma->nome }} – {{ $turma->curso }}
                    </option>
                @endforeach
            </select>
        </p>
        <p>
            <label>Empresa (opcional)</label><br>
            <select name="empresa_id">
                <option value="">Nenhuma</option>
                @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}" {{ $aluno->empresa_id == $empresa->id ? 'selected' : '' }}>
                        {{ $empresa->nome }}
                    </option>
                @endforeach
            </select>
        </p>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>