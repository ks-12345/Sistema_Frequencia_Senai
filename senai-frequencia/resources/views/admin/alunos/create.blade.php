<!DOCTYPE html>
<html>
<head><title>Novo Aluno</title></head>
<body>
    <h1>Novo Aluno</h1>
    <a href="{{ route('admin.alunos.index') }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.alunos.store') }}">
        @csrf
        <p>
            <label>Nome</label><br>
            <input type="text" name="nome" value="{{ old('nome') }}" required>
        </p>
        <p>
            <label>Matrícula</label><br>
            <input type="text" name="matricula" value="{{ old('matricula') }}" required>
        </p>
        <p>
            <label>Turma</label><br>
            <select name="turma_id" required>
                <option value="">Selecione...</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" {{ old('turma_id') == $turma->id ? 'selected' : '' }}>
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
                    <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                        {{ $empresa->nome }}
                    </option>
                @endforeach
            </select>
        </p>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>