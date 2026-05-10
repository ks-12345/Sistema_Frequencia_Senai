<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>{{ $titulo }}</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h1   { font-size: 16px; margin-bottom: 4px; }
    p    { margin: 2px 0; color: #555; }
    table { width: 100%; border-collapse: collapse; margin-top: 16px; }
    th   { background: #1a56db; color: #fff; padding: 6px 8px; text-align: left; }
    td   { padding: 5px 8px; border-bottom: 1px solid #ddd; }
    tr:nth-child(even) td { background: #f5f5f5; }
    .presente { color: #16a34a; font-weight: bold; }
    .falta    { color: #dc2626; font-weight: bold; }
    .atraso   { color: #d97706; font-weight: bold; }
</style>
</head>
<body>
    <h1>{{ $titulo }}</h1>
    <p>Gerado em: {{ now()->format('d/m/Y H:i') }}</p>
    @if($request->data_inicio || $request->data_fim)
        <p>Período: {{ $request->data_inicio ? \Carbon\Carbon::parse($request->data_inicio)->format('d/m/Y') : '—' }}
           até {{ $request->data_fim ? \Carbon\Carbon::parse($request->data_fim)->format('d/m/Y') : '—' }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Aluno</th>
                <th>Matrícula</th>
                <th>Turma</th>
                <th>Empresa</th>
                <th>Status</th>
                <th>Lançado por</th>
            </tr>
        </thead>
        <tbody>
            @forelse($frequencias as $f)
            <tr>
                <td>{{ $f->data->format('d/m/Y') }}</td>
                <td>{{ $f->aluno->nome }}</td>
                <td>{{ $f->aluno->matricula }}</td>
                <td>{{ $f->aluno->turma->nome ?? '—' }}</td>
                <td>{{ $f->aluno->empresa->nome ?? '—' }}</td>
                <td class="{{ $f->status_presenca }}">{{ ucfirst($f->status_presenca) }}</td>
                <td>{{ $f->lancadoPor->name ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center">Nenhum registro encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top:16px">Total de registros: {{ $frequencias->count() }}</p>
</body>
</html>