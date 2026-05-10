<!DOCTYPE html>
<html>
<head><title>Gerar Acesso Substituto</title></head>
<body>
    <h1>Gerar Acesso para Professor Substituto</h1>
    <a href="{{ route('admin.substitutos.index') }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.substitutos.store') }}">
        @csrf
        <p>
            <label>Nome do Substituto</label><br>
            <input type="text" name="nome" value="{{ old('nome') }}" required>
        </p>
        <p>
            <label>Turma</label><br>
            <select name="turma_id" required>
                <option value="">Selecione...</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" {{ old('turma_id') == $turma->id ? 'selected' : '' }}>
                        {{ $turma->nome }} – {{ $turma->curso }}
                        (Prof. {{ $turma->professor->name ?? '?' }})
                    </option>
                @endforeach
            </select>
        </p>
        <p>
            <label>Acesso expira em</label><br>
            <input type="datetime-local" name="expira_em" value="{{ old('expira_em') }}" required>
        </p>
        <button type="submit">Gerar Credenciais</button>
    </form>
</body>
</html>