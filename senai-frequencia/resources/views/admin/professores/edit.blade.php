<!DOCTYPE html>
<html>
<head><title>Editar Professor</title></head>
<body>
    <h1>Editar Professor</h1>
    <a href="{{ route('admin.professores.index') }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.professores.update', $professore) }}">
        @csrf @method('PUT')
        <p>
            <label>Nome</label><br>
            <input type="text" name="name" value="{{ old('name', $professore->name) }}" required>
        </p>
        <p>
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email', $professore->email) }}" required>
        </p>
        <p>
            <label>Nova senha (deixe em branco para manter)</label><br>
            <input type="password" name="password">
        </p>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>