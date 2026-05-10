<!DOCTYPE html>
<html>
<head>
    <title>Professor – SENAI</title>
</head>
<body>
    <h1>Dashboard do Professor</h1>
    <p>Bem-vindo, {{ auth()->user()->name }}</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Sair</button>
    </form>
</body>
</html>