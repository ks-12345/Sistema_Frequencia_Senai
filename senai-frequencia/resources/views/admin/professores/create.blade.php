<!DOCTYPE html>
<html>
<head><title>Novo Professor</title></head>
<body>
    <h1>Novo Professor</h1>
    <a href="{{ route('admin.professores.index') }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.professores.store') }}">
        @csrf
        <p>
            <label>Nome</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </p>
        <p>
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </p>
        <p>
            <label>Senha</label><br>
            <input type="password" name="password" required>
        </p>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>