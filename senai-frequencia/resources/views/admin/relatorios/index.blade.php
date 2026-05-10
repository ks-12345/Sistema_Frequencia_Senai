<!DOCTYPE html>
<html>
<head><title>Relatórios – SENAI</title></head>
<body>
    <h1>Relatórios de Frequência</h1>
    <a href="{{ route('admin.dashboard') }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="GET" id="form-relatorio">
        <p>
            <label>Tipo de relatório</label><br>
            <select name="tipo" id="tipo" onchange="mostrarFiltro()" required>
                <option value="">Selecione...</option>
                <option value="geral">Geral</option>
                <option value="aluno">Por Aluno</option>
                <option value="turma">Por Turma</option>
                <option value="empresa">Por Empresa</option>
            </select>
        </p>

        <div id="filtro-aluno" style="display:none">
            <p>
                <label>Aluno</label><br>
                <select name="aluno_id">
                    <option value="">Selecione...</option>
                    @foreach($alunos as $aluno)
                        <option value="{{ $aluno->id }}">{{ $aluno->nome }} – {{ $aluno->matricula }}</option>
                    @endforeach
                </select>
            </p>
        </div>

        <div id="filtro-turma" style="display:none">
            <p>
                <label>Turma</label><br>
                <select name="turma_id">
                    <option value="">Selecione...</option>
                    @foreach($turmas as $turma)
                        <option value="{{ $turma->id }}">{{ $turma->nome }} – {{ $turma->curso }}</option>
                    @endforeach
                </select>
            </p>
        </div>

        <div id="filtro-empresa" style="display:none">
            <p>
                <label>Empresa</label><br>
                <select name="empresa_id">
                    <option value="">Selecione...</option>
                    @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}">{{ $empresa->nome }}</option>
                    @endforeach
                </select>
            </p>
        </div>

        <p>
            <label>Data início</label><br>
            <input type="date" name="data_inicio">
        </p>
        <p>
            <label>Data fim</label><br>
            <input type="date" name="data_fim">
        </p>

        <p>
            <button type="submit" formaction="{{ route('admin.relatorios.visualizar') }}">
                Visualizar
            </button>
            &nbsp;
            <button type="submit" formaction="{{ route('admin.relatorios.pdf') }}">
                Exportar PDF
            </button>
            &nbsp;
            <button type="submit" formaction="{{ route('admin.relatorios.csv') }}">
                Exportar CSV
            </button>
        </p>
    </form>

    <script>
        function mostrarFiltro() {
            const tipo = document.getElementById('tipo').value;
            document.getElementById('filtro-aluno').style.display   = tipo === 'aluno'   ? 'block' : 'none';
            document.getElementById('filtro-turma').style.display   = tipo === 'turma'   ? 'block' : 'none';
            document.getElementById('filtro-empresa').style.display = tipo === 'empresa' ? 'block' : 'none';
        }
    </script>
</body>
</html>