<!DOCTYPE html>
<html>
<head><title>Empresas – SENAI</title></head>
<body>
    <h1>Empresas</h1>
    <a href="{{ route('admin.empresas.create') }}">Nova Empresa</a>
    <a href="{{ route('admin.dashboard') }}">Voltar ao Dashboard</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <tr>
            <th>Nome</th>
            <th>CNPJ</th>
            <th>Responsável</th>
            <th>Ações</th>
        </tr>
        @foreach($empresas as $empresa)
        <tr>
            <td>{{ $empresa->nome }}</td>
            <td>{{ $empresa->cnpj }}</td>
            <td>{{ $empresa->responsavel }}</td>
            <td>
                <a href="{{ route('admin.empresas.edit', $empresa) }}">Editar</a>
                <form method="POST" action="{{ route('admin.empresas.destroy', $empresa) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Confirmar exclusão?')">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {{ $empresas->links() }}
</body>
</html>