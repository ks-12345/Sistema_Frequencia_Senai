<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diário de Classe – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fb; }
        .table-row { transition: .2s ease; }
        .table-row:hover { background: #f8fafc; }
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
                <i class="ti ti-notebook text-xl"></i>
                <span class="font-medium">Diário de Classe</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">
            <div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Diário de Classe</h1>
                <p class="text-slate-500 mt-2">Acompanhe a frequência e o registro de aulas por turma.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                <i class="ti ti-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-sm">
            
            <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-[#0a1128]">Turmas Disponíveis</h2>
                    <p class="text-slate-400 text-sm mt-1">Selecione uma turma para gerenciar o diário</p>
                </div>

                <div class="relative">
                    <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" placeholder="Filtrar turmas..." 
                           class="bg-slate-100 border-none rounded-xl pl-11 pr-4 py-2.5 w-72 text-sm outline-none focus:ring-2 ring-blue-500/20 transition">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-100 bg-slate-50/30">
                            <th class="px-8 py-5">Identificação da Turma</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-center">Aulas Registradas</th>
                            <th class="px-8 py-5 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($turmas as $turma)
                        <tr class="table-row group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold shadow-inner">
                                        <i class="ti ti-school text-2xl"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-700 text-lg group-hover:text-blue-600 transition">{{ $turma->nome }}</span>
                                        <span class="text-xs text-slate-400 font-medium uppercase tracking-wide">{{ $turma->curso }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @if($turma->isFinalizada())
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-bold ring-1 ring-red-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Finalizada
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold ring-1 ring-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Ativa
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col items-center">
                                    <span class="text-xl font-black text-slate-700">{{ $turma->diario_aulas_count }}</span>
                                    <span class="text-[10px] text-slate-400 uppercase font-bold tracking-tighter">Registros</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end">
                                    <a href="{{ route('admin.diario.turma', $turma) }}" 
                                       class="flex items-center gap-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all shadow-sm">
                                        Ver Diário <i class="ti ti-chevron-right"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-8 py-4 bg-slate-50/50 border-t border-slate-100 text-[11px] text-slate-400 font-medium flex justify-between">
                <span>Relatórios de frequência sincronizados</span>
                <span>Data atual: {{ date('d/m/Y') }}</span>
            </div>

        </div>
    </main>
</div>

</body>
</html>