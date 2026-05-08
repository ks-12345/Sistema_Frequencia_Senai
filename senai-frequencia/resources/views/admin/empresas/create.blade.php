<!DOCTYPE html>
<html>
<head><title>Nova Empresa</title></head>
<body>
    <h1>Nova Empresa</h1>
    <a href="{{ route('admin.empresas.index') }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.empresas.store') }}">
        @csrf
        <p>
            <label>Nome</label><br>
            <input type="text" name="nome" value="{{ old('nome') }}" required>
        </p>
        <p>
            <label>CNPJ (formato: 00.000.000/0000-00)</label><br>
            <input type="text" name="cnpj" value="{{ old('cnpj') }}" required>
        </p>
        <p>
            <label>Responsável</label><br>
            <input type="text" name="responsavel" value="{{ old('responsavel') }}" required>
        </p>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>