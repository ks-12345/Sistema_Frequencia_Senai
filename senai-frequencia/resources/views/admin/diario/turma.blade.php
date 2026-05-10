<!DOCTYPE html>
<html>
<head><title>Diário – {{ $turma->nome }}</title></head>
<body>
    <h1>Diário de Classe – {{ $turma->nome }}</h1>
    <p>Curso: {{ $turma->curso }} | Período: {{ $turma->periodo }}</p>
    <a href="{{ route('admin.diario.index') }}">Voltar</a>

    <table border="1" cellpadding="8" style="margin-top:16px; width:100%">
        <tr>
            <th>Aula Nº</th>
            <th>Data</th>
            <th>Título</th>
            <th>Conteúdo</th>
            <th>Professor</th>
        </tr>
        @forelse($aulas as $aula)
        <tr>
            <td style="text-align:center">{{ $aula->aula_numero }}</td>
            <td>{{ $aula->data->format('d/m/Y') }}</td>
            <td>{{ $aula->titulo }}</td>
            <td>{{ Str::limit($aula->conteudo, 80) }}</td>
            <td>{{ $aula->professor->name ?? '—' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center">Nenhuma aula registrada.</td>
        </tr>
        @endforelse
    </table>

    {{ $aulas->links() }}
</body>
</html>