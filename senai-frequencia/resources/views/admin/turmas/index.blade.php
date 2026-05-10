<!DOCTYPE html>
<html>
<head><title>Turmas – SENAI</title></head>
<body>
    <h1>Turmas</h1>
    <a href="{{ route('admin.turmas.create') }}">Nova Turma</a>
    <a href="{{ route('admin.dashboard') }}">Voltar ao Dashboard</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <tr>
            <th>Nome</th>
            <th>Curso</th>
            <th>Período</th>
            <th>Professor</th>
            <th>Status</th>
            <th>Finalizada em</th>
            <th>Ações</th>
        </tr>
        @foreach($turmas as $turma)
        <tr style="{{ $turma->isFinalizada() ? 'background:#f5f5f5;color:#999' : '' }}">
            <td>{{ $turma->nome }}</td>
            <td>{{ $turma->curso }}</td>
            <td>{{ $turma->periodo }}</td>
            <td>{{ $turma->professor->name ?? '—' }}</td>
            <td>
                @if($turma->isFinalizada())
                    <span style="color:red">Finalizada</span>
                @else
                    <span style="color:green">Ativa</span>
                @endif
            </td>
            <td>{{ $turma->finalizada_em?->format('d/m/Y') ?? '—' }}</td>
            <td>
                @if(!$turma->isFinalizada())
                    <a href="{{ route('admin.turmas.edit', $turma) }}">Editar</a>


                    <form method="POST" action="{{ route('admin.turmas.finalizar', $turma) }}" style="display:inline">
                        @csrf @method('PATCH')
                        <button onclick="return confirm('Finalizar a turma {{ $turma->nome }}? Isso bloqueará edições.')">
                            Finalizar
                        </button>
                        
                    </form>

                    <form method="POST" action="{{ route('admin.turmas.destroy', $turma) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Confirmar exclusão?')">Excluir</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.turmas.reativar', $turma) }}" style="display:inline">
                        @csrf @method('PATCH')
                        <button>Reativar</button>
                    <a href="{{ route('admin.certificados.index', $turma) }}">Certificados</a>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </table>

    {{ $turmas->links() }}
</body>
</html>