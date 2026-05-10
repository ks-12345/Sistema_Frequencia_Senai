<!DOCTYPE html>
<html>
<head><title>Professor – SENAI</title></head>
<body>
    <h1>Dashboard do Professor</h1>
    <p>Bem-vindo, {{ auth()->user()->name }}</p>

    <nav>
        <a href="{{ route('professor.frequencia.index') }}">Lançar Frequência</a> |
        <a href="{{ route('professor.frequencia.pendentes') }}">Pendentes de Aprovação</a>
        <a href="{{ route('professor.saidas.index') }}">Saídas Antecipadas</a>
        <a href="{{ route('professor.diario.index') }}">Diário de Classe</a> |
    </nav>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Sair</button>
    </form>
</body>
</html>