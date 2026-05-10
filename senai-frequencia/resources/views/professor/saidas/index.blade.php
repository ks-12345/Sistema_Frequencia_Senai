<!DOCTYPE html>
<html>
<head><title>Saídas Antecipadas – Professor</title></head>
<body>
    <h1>Saídas Antecipadas</h1>
    <a href="{{ route('professor.saidas.create') }}">Registrar Saída</a>
    <a href="{{ route('professor.dashboard') }}">Voltar</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8" style="margin-top:16px; width:100%">
        <tr>
            <th>Aluno</th>
            <th>Turma</th>
            <th>Horário Saída</th>
            <th>Motivo</th>
            <th>Status</th>
            <th>Validado por</th>
        </tr>
        @forelse($saidas as $saida)
        <tr>
            <td>{{ $saida->aluno->nome }}</td>
            <td>{{ $saida->aluno->turma->nome ?? '—' }}</td>
            <td>{{ $saida->horario_saida->format('d/m/Y H:i') }}</td>
            <td>{{ $saida->motivo ?? '—' }}</td>
            <td style="color: {{ match($saida->status) {
                'pendente'       => 'orange',
                'autorizada'     => 'green',
                'nao_autorizada' => 'red',
            } }}">
                {{ match($saida->status) {
                    'pendente'       => '⏳ Pendente',
                    'autorizada'     => '✅ Autorizada',
                    'nao_autorizada' => '❌ Não Autorizada',
                } }}
            </td>
            <td>{{ $saida->validadoPor->name ?? '—' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center">Nenhuma saída registrada.</td>
        </tr>
        @endforelse
    </table>
    {{ $saidas->links() }}
</body>
</html>