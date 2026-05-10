<!DOCTYPE html>
<html>
<head><title>Diário – {{ $turma->nome }}</title></head>
<body>
    <h1>Diário de Classe – {{ $turma->nome }}</h1>
    <p>Curso: {{ $turma->curso }} | Período: {{ $turma->periodo }}</p>

    @if(!$turma->isFinalizada())
        <a href="{{ route('professor.diario.create', $turma) }}">+ Nova Aula</a>
    @endif
    <a href="{{ route('professor.diario.index') }}">Voltar</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <table border="1" cellpadding="8" style="margin-top:16px; width:100%">
        <tr>
            <th>Aula Nº</th>
            <th>Data</th>
            <th>Título</th>
            <th>Conteúdo</th>
            <th>Ações</th>
        </tr>
        @forelse($aulas as $aula)
        <tr>
            <td style="text-align:center">{{ $aula->aula_numero }}</td>
            <td>{{ $aula->data->format('d/m/Y') }}</td>
            <td>{{ $aula->titulo }}</td>
            <td>{{ Str::limit($aula->conteudo, 80) }}</td>
            <td>
                @if(!$turma->isFinalizada())
                    <a href="{{ route('professor.diario.edit', [$turma, $aula]) }}">Editar</a>
                    <form method="POST" action="{{ route('professor.diario.destroy', [$turma, $aula]) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Remover esta aula?')">Excluir</button>
                    </form>
                @else
                    <span style="color:#999">Somente leitura</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center">Nenhuma aula registrada ainda.</td>
        </tr>
        @endforelse
    </table>

    {{ $aulas->links() }}
</body>
</html>