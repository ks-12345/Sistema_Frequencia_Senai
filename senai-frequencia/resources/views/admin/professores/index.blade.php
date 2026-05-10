<!DOCTYPE html>
<html>
<head><title>Professores – SENAI</title></head>
<body>
    <h1>Professores</h1>
    <a href="{{ route('admin.professores.create') }}">Novo Professor</a>
    <a href="{{ route('admin.dashboard') }}">Voltar ao Dashboard</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        @foreach($professores as $professor)
        <tr>
            <td>{{ $professor->name }}</td>
            <td>{{ $professor->email }}</td>
            <td>
                <a href="{{ route('admin.professores.edit', $professor) }}">Editar</a>
                <form method="POST" action="{{ route('admin.professores.destroy', $professor) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Confirmar exclusão?')">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {{ $professores->links() }}
</body>
</html>