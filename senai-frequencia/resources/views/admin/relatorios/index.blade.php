<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fb; }
        select, input[type="date"] {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.2em;
        }
    </style>
</head>
<body>

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-2xl font-bold tracking-tight">Rede SENAI</h1>
            <p class="text-slate-400 text-xs mt-1">Painel Administrativo</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-layout-grid text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-chart-bar text-xl"></i>
                <span class="font-medium">Relatórios</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">
            <div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Relatórios de Frequência</h1>
                <p class="text-slate-500 mt-2">Gere documentos PDF ou CSV com base nos filtros abaixo.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                <i class="ti ti-arrow-left"></i> Voltar
            </a>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-5">
                <div class="flex items-center gap-2 font-bold mb-2">
                    <i class="ti ti-alert-circle"></i> Atenção
                </div>
                <ul class="list-disc list-inside text-sm opacity-80">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-xl font-bold text-[#0a1128]">Configurações do Relatório</h2>
            </div>

            <form method="GET" id="form-relatorio" class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Tipo de Relatório</label>
                        <select name="tipo" id="tipo" onchange="mostrarFiltro()" required
                                class="w-full bg-slate-100 border-none rounded-2xl px-5 py-3.5 text-slate-700 outline-none focus:ring-2 ring-blue-500/20 transition">
                            <option value="">Selecione o tipo...</option>
                            <option value="geral">Geral (Toda a Unidade)</option>
                            <option value="aluno">Por Aluno Específico</option>
                            <option value="turma">Por Turma</option>
                            <option value="empresa">Por Empresa</option>
                        </select>
                    </div>

                    <div id="filtro-aluno" style="display:none" class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Selecione o Aluno</label>
                        <select name="aluno_id" class="w-full bg-slate-100 border-none rounded-2xl px-5 py-3.5 text-slate-700 outline-none focus:ring-2 ring-blue-500/20 transition">
                            <option value="">Selecione...</option>
                            @foreach($alunos as $aluno)
                                <option value="{{ $aluno->id }}">{{ $aluno->nome }} ({{ $aluno->matricula }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="filtro-turma" style="display:none" class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Selecione a Turma</label>
                        <select name="turma_id" class="w-full bg-slate-100 border-none rounded-2xl px-5 py-3.5 text-slate-700 outline-none focus:ring-2 ring-blue-500/20 transition">
                            <option value="">Selecione...</option>
                            @foreach($turmas as $turma)
                                <option value="{{ $turma->id }}">{{ $turma->nome }} – {{ $turma->curso }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="filtro-empresa" style="display:none" class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Selecione a Empresa</label>
                        <select name="empresa_id" class="w-full bg-slate-100 border-none rounded-2xl px-5 py-3.5 text-slate-700 outline-none focus:ring-2 ring-blue-500/20 transition">
                            <option value="">Selecione...</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}">{{ $empresa->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Data Início</label>
                        <input type="date" name="data_inicio" class="w-full bg-slate-100 border-none rounded-2xl px-5 py-3 text-slate-700 outline-none focus:ring-2 ring-blue-500/20 transition">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Data Fim</label>
                        <input type="date" name="data_fim" class="w-full bg-slate-100 border-none rounded-2xl px-5 py-3 text-slate-700 outline-none focus:ring-2 ring-blue-500/20 transition">
                    </div>
                </div>

                <div class="mt-12 flex flex-wrap gap-4 border-t border-slate-100 pt-8">
                    <button type="submit" formaction="{{ route('admin.relatorios.visualizar') }}"
                            class="flex-1 min-w-[200px] bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-blue-200 flex items-center justify-center gap-2">
                        <i class="ti ti-eye text-xl"></i> Visualizar Dados
                    </button>

                    <button type="submit" formaction="{{ route('admin.relatorios.pdf') }}"
                            class="flex-1 min-w-[200px] bg-slate-800 hover:bg-slate-900 text-white font-bold py-4 rounded-2xl transition flex items-center justify-center gap-2">
                        <i class="ti ti-file-type-pdf text-xl text-red-400"></i> Exportar PDF
                    </button>

                    <button type="submit" formaction="{{ route('admin.relatorios.csv') }}"
                            class="flex-1 min-w-[200px] bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl transition flex items-center justify-center gap-2">
                        <i class="ti ti-file-spreadsheet text-xl"></i> Exportar CSV
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    function mostrarFiltro() {
        const tipo = document.getElementById('tipo').value;
        const filtros = ['aluno', 'turma', 'empresa'];
        
        filtros.forEach(f => {
            const el = document.getElementById(`filtro-${f}`);
            if (el) el.style.display = (tipo === f) ? 'flex' : 'none';
        });
    }
</script>

</body>
</html>