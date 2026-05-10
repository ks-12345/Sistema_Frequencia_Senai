<!DOCTYPE html>
<html>
<head><title>Substitutos – SENAI</title></head>
<body>
    <h1>Professores Substitutos</h1>
    <a href="{{ route('admin.substitutos.create') }}">Gerar Novo Acesso</a>
    <a href="{{ route('admin.dashboard') }}">Voltar</a>

    @if(session('credenciais'))
        @php $c = session('credenciais') @endphp
        <div style="background:#d4edda;padding:16px;margin:16px 0;border:1px solid #28a745">
            <h3>Credenciais geradas — anote agora!</h3>
            <p><strong>Nome:</strong> {{ $c['nome'] }}</p>
            <p><strong>Email:</strong> {{ $c['email'] }}</p>
            <p><strong>Senha:</strong> {{ $c['senha'] }}</p>
        </div>
    @endif

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Turma</th>
            <th>Expira em</th>
            <th>Ações</th>
        </tr>
        @foreach($substitutos as $sub)
        <tr>
            <td>{{ $sub->name }}</td>
            <td>{{ $sub->email }}</td>
            <td>{{ $sub->turmas->first()->nome ?? '—' }}</td>
            <td>{{ $sub->acesso_expira_em?->format('d/m/Y H:i') ?? '—' }}</td>
            <td>
                <form method="POST" action="{{ route('admin.substitutos.destroy', $sub) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Remover acesso?')">Remover</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>