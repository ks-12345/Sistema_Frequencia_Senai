<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diário – {{ $turma->nome }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fb; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
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

            <a href="{{ route('admin.diario.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-book text-xl"></i>
                <span class="font-medium">Diário de Classe</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <div class="mb-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                <div>
                    <div class="flex items-center gap-2 text-blue-600 font-bold text-sm uppercase tracking-widest mb-2">
                        <i class="ti ti-calendar-event"></i> Histórico de Aulas
                    </div>
                    <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Diário de Classe</h1>
                    <div class="flex items-center gap-4 mt-3">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase">{{ $turma->nome }}</span>
                        <span class="text-slate-500 text-sm flex items-center gap-1">
                            <i class="ti ti-school"></i> {{ $turma->curso }}
                        </span>
                        <span class="text-slate-500 text-sm flex items-center gap-1 border-l pl-4 border-slate-200">
                            <i class="ti ti-clock"></i> {{ $turma->periodo }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('admin.diario.index') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                    <i class="ti ti-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 text-xs uppercase tracking-widest">
                            <th class="px-8 py-5 font-bold">Nº</th>
                            <th class="px-6 py-5 font-bold">Data</th>
                            <th class="px-6 py-5 font-bold">Título da Aula</th>
                            <th class="px-6 py-5 font-bold">Conteúdo Resumido</th>
                            <th class="px-6 py-5 font-bold">Professor</th>
                            <th class="px-8 py-5 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600 divide-y divide-slate-50 text-sm">
                        @forelse($aulas as $aula)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="px-8 py-6">
                                <span class="bg-slate-100 text-slate-700 w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs">
                                    {{ $aula->aula_numero }}
                                </span>
                            </td>
                            <td class="px-6 py-6 font-semibold text-[#0a1128]">
                                {{ $aula->data->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-6 font-medium">
                                {{ $aula->titulo }}
                            </td>
                            <td class="px-6 py-6 text-slate-400">
                                <p class="line-clamp-2 max-w-xs">{{ $aula->conteudo }}</p>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-[10px] font-bold">
                                        {{ strtoupper(substr($aula->professor->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="text-slate-700 font-medium">{{ $aula->professor->name ?? '—' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <button class="p-2 text-slate-400 hover:text-blue-600 transition" title="Ver Detalhes">
                                    <i class="ti ti-eye text-xl"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="ti ti-book-off text-5xl text-slate-200 mb-4"></i>
                                    <p class="text-slate-400 text-lg">Nenhuma aula registrada até o momento.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                {{ $aulas->links() }}
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            <button onclick="window.print()" class="text-slate-400 hover:text-slate-600 flex items-center gap-2 text-sm font-medium transition">
                <i class="ti ti-printer"></i> Gerar versão para impressão (PDF)
            </button>
        </div>

    </main>
</div>

</body>
</html>