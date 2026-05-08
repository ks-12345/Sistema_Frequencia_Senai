<!DOCTYPE html>
<html>
<head>
    <title>Empresa – SENAI</title>
</head>
<body>
    <h1>Dashboard da Empresa</h1>
    <p>Bem-vindo, {{ auth()->user()->name }}</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Sair</button>
    </form>
</body>
</html>