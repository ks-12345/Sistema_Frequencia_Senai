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
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-white border-r border-slate-200 flex flex-col sticky top-0 h-screen">
        <div class="h-24 flex items-center px-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                    <i class="ti ti-building-factory-2 text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold leading-tight">Painel Empresa</h1>
                    <p class="text-slate-400 text-[10px] uppercase tracking-widest font-bold">Portal do Parceiro</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-1">
            <a href="{{ route('empresa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition text-slate-500">
                <i class="ti ti-smart-home text-xl"></i>
                <span class="font-medium text-sm">Visão Geral</span>
            </a>
            <a href="{{ route('empresa.alunos.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-50 text-blue-700 transition">
                <i class="ti ti-users text-xl"></i>
                <span class="font-bold text-sm">Meus Aprendizes</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-100">
            <div class="bg-slate-50 rounded-2xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center">
                    <i class="ti ti-user-circle text-slate-500 text-xl"></i>
                </div>
                <div class="truncate">
                    <p class="text-xs font-bold truncate">Gestor RH</p>
                    <p class="text-[10px] text-slate-400 truncate">Sua Empresa S.A.</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-8 lg:p-12">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Aprendizes Alocados</h2>
                <p class="text-slate-500 mt-2">Acompanhe a frequência e o aproveitamento dos seus colaboradores em formação.</p>
            </div>
            <div class="flex gap-3">
                <div class="bg-white border border-slate-200 px-6 py-3 rounded-2xl shadow-sm">
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Total de Aprendizes</p>
                    <p class="text-xl font-bold text-blue-600">{{ $alunos->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aprendiz</th>
                        <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Turma / Curso</th>
                        <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Assiduidade</th>
                        <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Presenças</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($alunos as $aluno)
                    @php 
                        $total = $aluno->frequencias->count();
                        $presencas = $aluno->frequencias->where('status_presenca', 'presente')->count();
                        $porcentagem = $total > 0 ? round(($presencas / $total) * 100) : 0;
                    @endphp
                    <tr class="group hover:bg-slate-50/80 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-blue-100 group-hover:text-blue-600 transition">
                                    <i class="ti ti-user"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-700">{{ $aluno->nome }}</p>
                                    <p class="text-xs text-slate-400 font-mono">{{ $aluno->matricula }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <span class="text-sm font-medium text-slate-600">{{ $aluno->turma->nome ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col gap-2 min-w-[120px]">
                                <div class="flex justify-between text-[10px] font-bold">
                                    <span class="{{ $porcentagem >= 75 ? 'text-emerald-500' : 'text-amber-500' }}">{{ $porcentagem }}%</span>
                                    <span class="text-slate-300">{{ $total }} aulas</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full {{ $porcentagem >= 75 ? 'bg-emerald-500' : 'bg-amber-500' }} rounded-full" style="width: {{ $porcentagem }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-xs font-bold">
                                {{ $presencas }} / {{ $total }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('empresa.frequencia.show', $aluno) }}" 
                               class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-blue-600 transition">
                                Ver Diário <i class="ti ti-chevron-right"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 bg-blue-600 rounded-3xl p-8 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl shadow-blue-200">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-3xl">
                    <i class="ti ti-download"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold">Relatório Mensal Consolidado</h3>
                    <p class="text-blue-100 text-sm">Baixe a planilha completa de frequência de todos os seus aprendizes.</p>
                </div>
            </div>
            <button class="bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold hover:bg-blue-50 transition shadow-lg">
                Exportar Excel (.xlsx)
            </button>
        </div>

    </main>
</div>

</body>
</html>