<!DOCTYPE html>
<html>
<head><title>Alunos – SENAI</title></head>
<body>
    <h1>Alunos</h1>
    <a href="{{ route('admin.alunos.create') }}">Novo Aluno</a>
    <a href="{{ route('admin.dashboard') }}">Voltar ao Dashboard</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <tr>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Turma</th>
            <th>Empresa</th>
            <th>Ações</th>
        </tr>
        @foreach($alunos as $aluno)
        <tr>
            <td>{{ $aluno->nome }}</td>
            <td>{{ $aluno->matricula }}</td>
            <td>{{ $aluno->turma->nome ?? '—' }}</td>
            <td>{{ $aluno->empresa->nome ?? '—' }}</td>
            <td>
                <a href="{{ route('admin.qrcode.cracha', $aluno) }}">QR Code</a>
                <a href="{{ route('admin.alunos.edit', $aluno) }}">Editar</a>
                <form method="POST" action="{{ route('admin.alunos.destroy', $aluno) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Confirmar exclusão?')">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {{ $alunos->links() }}
</body>
</html>