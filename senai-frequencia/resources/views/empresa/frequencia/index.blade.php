<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Aprendizes – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .sidebar-item:hover { background: rgba(255, 255, 255, 0.05); }
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen shadow-2xl">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-2xl font-bold tracking-tight text-white">Rede SENAI</h1>
            <p class="text-blue-400 text-[10px] uppercase tracking-widest font-black">Portal do Parceiro</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('empresa.dashboard') }}" class="sidebar-item flex items-center gap-4 px-4 py-3.5 rounded-xl transition text-slate-400 hover:text-white">
                <i class="ti ti-chart-pie text-xl"></i>
                <span class="font-medium">Visão Geral</span>
            </a>
            <a href="{{ route('empresa.alunos.index') }}" class="sidebar-item flex items-center gap-4 px-4 py-3.5 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20 transition">
                <i class="ti ti-users text-xl"></i>
                <span class="font-bold">Meus Aprendizes</span>
            </a>
        </nav>

        <div class="p-6 border-t border-white/5">
            <div class="bg-white/5 rounded-2xl p-4 flex items-center gap-3 border border-white/5">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center font-bold shadow-lg shadow-blue-900/40">
                    S
                </div>
                <div class="truncate">
                    <p class="text-xs font-bold text-white truncate">Gestor RH</p>
                    <p class="text-[10px] text-slate-500 truncate">Sua Empresa S.A.</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-8 lg:p-12">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-12">
            <div>
                <h2 class="text-4xl font-black text-[#0a1128] tracking-tight">Aprendizes Alocados</h2>
                <p class="text-slate-500 mt-2 font-medium">Acompanhe a assiduidade dos seus colaboradores em formação.</p>
            </div>
            
            <div class="bg-white border border-slate-200 px-8 py-4 rounded-[2rem] shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                    <i class="ti ti-user-check text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Alocados</p>
                    <p class="text-2xl font-black text-[#0a1128]">{{ $alunos->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/30 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400">
                        <th class="px-8 py-6 text-[11px] font-bold uppercase tracking-[0.15em]">Aprendiz</th>
                        <th class="px-6 py-6 text-[11px] font-bold uppercase tracking-[0.15em]">Turma / Curso</th>
                        <th class="px-6 py-6 text-[11px] font-bold uppercase tracking-[0.15em]">Assiduidade</th>
                        <th class="px-6 py-6 text-[11px] font-bold uppercase tracking-[0.15em] text-center">Presenças</th>
                        <th class="px-8 py-6 text-[11px] font-bold uppercase tracking-[0.15em] text-right">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($alunos as $aluno)
                    @php 
                        $total = $aluno->frequencias->count();
                        $presencas = $aluno->frequencias->where('status_presenca', 'presente')->count();
                        $porcentagem = $total > 0 ? round(($presencas / $total) * 100) : 0;
                        $isWarning = $porcentagem < 75;
                    @endphp
                    <tr class="group hover:bg-blue-50/30 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                    <i class="ti ti-user text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 group-hover:text-blue-700 transition-colors">{{ $aluno->nome }}</p>
                                    <p class="text-xs text-slate-400 font-mono">{{ $aluno->matricula }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <span class="text-sm font-semibold text-slate-600">{{ $aluno->turma->nome ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col gap-2 min-w-[140px]">
                                <div class="flex justify-between items-end">
                                    <span class="text-xs font-black {{ $isWarning ? 'text-red-500' : 'text-emerald-500' }}">
                                        {{ $porcentagem }}%
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-300 uppercase">{{ $total }} AULAS</span>
                                </div>
                                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full {{ $isWarning ? 'bg-red-500' : 'bg-emerald-500' }} rounded-full" style="width: {{ $porcentagem }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <span class="bg-slate-100 text-slate-600 px-4 py-1.5 rounded-xl text-xs font-black border border-slate-200/50">
                                {{ $presencas }} <span class="text-slate-300 mx-1">/</span> {{ $total }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('empresa.frequencia.show', $aluno) }}" 
                               class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-blue-600 transition-all">
                                Detalhes <i class="ti ti-arrow-right text-lg"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-12 bg-[#0a1128] rounded-[2.5rem] p-10 text-white flex flex-col md:flex-row items-center justify-between gap-8 shadow-2xl shadow-blue-900/30">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-blue-600 rounded-3xl flex items-center justify-center text-4xl shadow-xl shadow-blue-600/20">
                    <i class="ti ti-file-spreadsheet"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold tracking-tight">Relatório Consolidado</h3>
                    <p class="text-slate-400 text-sm mt-1">Gere um documento oficial com a frequência de todo o quadro de aprendizes.</p>
                </div>
            </div>
            <button class="bg-white text-[#0a1128] px-10 py-5 rounded-2xl font-black hover:bg-blue-50 transition-all shadow-lg flex items-center gap-3">
                <i class="ti ti-download text-xl"></i> Exportar Dados
            </button>
        </div>

        <footer class="mt-12 text-center text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">
            © 2026 Rede SENAI de Ensino — Área Restrita à Empresa Parceira
        </footer>

    </main>
</div>

</body>
</html>