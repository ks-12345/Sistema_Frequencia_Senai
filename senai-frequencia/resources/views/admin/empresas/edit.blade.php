<!DOCTYPE html>
<html>
<head><title>Editar Empresa</title></head>
<body>
    <h1>Editar Empresa</h1>
    <a href="{{ route('admin.empresas.index') }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.empresas.update', $empresa) }}">
        @csrf @method('PUT')
        <p>
            <label>Nome</label><br>
            <input type="text" name="nome" value="{{ old('nome', $empresa->nome) }}" required>
        </p>
        <p>
            <label>CNPJ</label><br>
            <input type="text" name="cnpj" value="{{ old('cnpj', $empresa->cnpj) }}" required>
        </p>
        <p>
            <label>Responsável</label><br>
            <input type="text" name="responsavel" value="{{ old('responsavel', $empresa->responsavel) }}" required>
        </p>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>