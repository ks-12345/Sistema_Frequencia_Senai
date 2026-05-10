<!DOCTYPE html>
<html>
<head><title>Certificados – {{ $turma->nome }}</title></head>
<body>
    <h1>Certificados – {{ $turma->nome }}</h1>
    <p>Curso: {{ $turma->curso }} | Carga horária: {{ $turma->carga_horaria }}h</p>
    <a href="{{ route('admin.turmas.index') }}">Voltar</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('admin.certificados.gerar-todos', $turma) }}">
        @csrf
        <button onclick="return confirm('Gerar certificados para todos os alunos?')">
            Gerar todos os certificados
        </button>
    </form>

    <table border="1" cellpadding="8" style="margin-top:16px">
        <tr>
            <th>Aluno</th>
            <th>Matrícula</th>
            <th>% Presença</th>
            <th>Código</th>
            <th>Ações</th>
        </tr>
        @foreach($alunos as $aluno)
        @php $cert = $certificados->get($aluno->id) @endphp
        <tr>
            <td>{{ $aluno->nome }}</td>
            <td>{{ $aluno->matricula }}</td>
            <td>{{ $cert ? $cert->percentual_presenca . '%' : '—' }}</td>
            <td>{{ $cert ? $cert->codigo : '—' }}</td>
            <td>
                <form method="POST" action="{{ route('admin.certificados.gerar', [$turma, $aluno]) }}" style="display:inline">
                    @csrf
                    <button>{{ $cert ? 'Regenerar' : 'Gerar' }}</button>
                </form>
                @if($cert)
                    <a href="{{ route('admin.certificados.download', $cert) }}">Download PDF</a>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>