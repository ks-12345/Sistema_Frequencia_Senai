<!DOCTYPE html>
<html>
<head>
    <title>Admin – SENAI</title>
</head>
<body>
    <h1>Dashboard do Administrador</h1>
    <p>Bem-vindo, {{ auth()->user()->name }}</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Sair</button>
    </form>
</body>
</html>