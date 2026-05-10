<!DOCTYPE html>
<html>
<head><title>Empresa – SENAI</title></head>
<body>
    <h1>Dashboard da Empresa</h1>
    <p>Bem-vindo, {{ auth()->user()->name }}</p>

    <p>Total de aprendizes: <strong>{{ $totalAlunos }}</strong></p>
    <p>Percentual geral de presença: <strong>{{ $percentual }}%</strong></p>

    <nav>
        <a href="{{ route('empresa.frequencia.index') }}">Ver Frequências</a>
    </nav>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Sair</button>
    </form>
</body>
</html>