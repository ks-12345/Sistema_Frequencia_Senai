<!DOCTYPE html>
<html>
<head><title>Leitura de Acesso – SENAI</title></head>
<body>
    <h1>Registrar Acesso</h1>
    <a href="{{ route('admin.acesso.index') }}">Voltar</a>

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif
    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.acesso.registrar') }}">
        @csrf
        <p>
            <label>Token do QR Code (ou matrícula)</label><br>
            <input type="text" name="token" autofocus required
                   placeholder="Cole o token ou escaneie o QR Code"
                   style="width:400px">
        </p>
        <p>
            <label>Tipo de registro</label><br>
            <select name="tipo" required>
                <option value="entrada_portaria">Entrada Portaria</option>
                <option value="entrada_bloco">Entrada Bloco</option>
                <option value="saida">Saída</option>
            </select>
        </p>
        <p>
            <label>Local (ex: Bloco A, Portaria)</label><br>
            <input type="text" name="local" placeholder="Ex: Bloco A">
        </p>
        <button type="submit">Registrar</button>
    </form>

    <hr>
    <h2>Buscar por Token do Aluno</h2>
    <p>Acesse o crachá do aluno para ver o token:</p>
    <a href="{{ route('admin.alunos.index') }}">Ver Alunos</a>
</body>
</html>