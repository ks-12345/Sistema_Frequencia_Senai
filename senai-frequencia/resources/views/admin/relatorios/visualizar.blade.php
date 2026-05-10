<!DOCTYPE html>
<html>
<head><title>{{ $titulo }} – SENAI</title></head>
<body>
    <h1>{{ $titulo }}</h1>
    <a href="{{ route('admin.relatorios.index') }}">← Voltar aos filtros</a>

    {{-- Resumo estatístico --}}
    <table border="1" cellpadding="10" style="margin: 16px 0">
        <tr>
            <td><strong>Total de registros</strong><br>{{ $totalRegistros }}</td>
            <td style="color:green"><strong>Presenças</strong><br>{{ $totalPresencas }}</td>
            <td style="color:red"><strong>Faltas</strong><br>{{ $totalFaltas }}</td>
            <td style="color:orange"><strong>Atrasos</strong><br>{{ $totalAtrasos }}</td>
            <td><strong>% Presença</strong><br>{{ $percentual }}%</td>
        </tr>
    </table>

    {{-- Botões de exportação mantendo os filtros --}}
    <form method="GET" style="display:inline">
        @foreach($request->all() as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="submit" formaction="{{ route('admin.relatorios.pdf') }}">Exportar PDF</button>
        &nbsp;
        <button type="submit" formaction="{{ route('admin.relatorios.csv') }}">Exportar CSV</button>
    </form>

    {{-- Tabela de frequências --}}
    <table border="1" cellpadding="8" style="margin-top:16px; width:100%">
        <tr>
            <th>Data</th>
            <th>Aluno</th>
            <th>Matrícula</th>
            <th>Turma</th>
            <th>Empresa</th>
            <th>Status</th>
            <th>Lançado por</th>
            <th>Observação</th>
        </tr>
        @forelse($frequencias as $f)
        <tr>
            <td>{{ $f->data->format('d/m/Y') }}</td>
            <td>{{ $f->aluno->nome }}</td>
            <td>{{ $f->aluno->matricula }}</td>
            <td>{{ $f->aluno->turma->nome ?? '—' }}</td>
            <td>{{ $f->aluno->empresa->nome ?? '—' }}</td>
            <td style="color: {{ $f->status_presenca === 'presente' ? 'green' : ($f->status_presenca === 'falta' ? 'red' : 'orange') }}">
                {{ ucfirst($f->status_presenca) }}
            </td>
            <td>{{ $f->lancadoPor->name ?? '—' }}</td>
            <td>{{ $f->observacao ?? '—' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center">Nenhum registro encontrado.</td>
        </tr>
        @endforelse
    </table>
</body>
</html>