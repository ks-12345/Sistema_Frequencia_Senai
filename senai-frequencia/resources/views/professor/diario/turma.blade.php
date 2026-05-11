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
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-2xl font-bold tracking-tight">Rede SENAI</h1>
            <p class="text-slate-400 text-xs mt-1">Portal do Docente</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('professor.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-smart-home text-xl"></i>
                <span class="font-medium">Início</span>
            </a>
            <a href="{{ route('professor.diario.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-book text-xl"></i>
                <span class="font-medium">Meus Diários</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-8 lg:p-12">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('professor.diario.index') }}" class="text-blue-600 hover:text-blue-800 transition">
                        <i class="ti ti-arrow-left"></i> Voltar
                    </a>
                </div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Diário de Classe</h1>
                <div class="flex items-center gap-4 mt-3">
                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold uppercase">{{ $turma->nome }}</span>
                    <span class="text-slate-500 text-sm flex items-center gap-1">
                        <i class="ti ti-briefcase"></i> {{ $turma->curso }}
                    </span>
                    <span class="text-slate-500 text-sm flex items-center gap-1 border-l pl-4">
                        <i class="ti ti-clock"></i> {{ $turma->periodo }}
                    </span>
                </div>
            </div>

            @if(!$turma->isFinalizada())
                <a href="{{ route('professor.diario.create', $turma) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-4 rounded-2xl transition shadow-lg shadow-blue-900/20 flex items-center gap-2">
                    <i class="ti ti-plus text-xl"></i> Registrar Nova Aula
                </a>
            @else
                <div class="bg-red-50 text-red-600 border border-red-100 px-6 py-4 rounded-2xl flex items-center gap-3">
                    <i class="ti ti-lock-square-rounded text-2xl"></i>
                    <div>
                        <p class="text-xs font-bold uppercase">Diário Finalizado</p>
                        <p class="text-sm">Os registros estão em modo de leitura.</p>
                    </div>
                </div>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 flex items-center gap-3">
                <i class="ti ti-circle-check text-xl"></i>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-4 flex items-center gap-3">
                <i class="ti ti-alert-triangle text-xl"></i>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-widest font-bold">
                            <th class="px-8 py-5 text-center w-24">Nº Aula</th>
                            <th class="px-6 py-5 w-40">Data</th>
                            <th class="px-6 py-5">Título / Tema</th>
                            <th class="px-6 py-5">Conteúdo Desenvolvido</th>
                            <th class="px-8 py-5 text-right">Gerenciar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($aulas as $aula)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6 text-center">
                                <span class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-slate-600 mx-auto group-hover:bg-blue-600 group-hover:text-white transition-all">
                                    {{ $aula->aula_numero }}
                                </span>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="flex items-center gap-2 font-medium text-slate-700 italic">
                                    <i class="ti ti-calendar text-slate-300 text-lg"></i>
                                    {{ $aula->data->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="font-bold text-[#0a1128] leading-tight">{{ $aula->titulo }}</div>
                            </td>
                            <td class="px-6 py-6">
                                <p class="text-sm text-slate-500 leading-relaxed line-clamp-2" title="{{ $aula->conteudo }}">
                                    {{ $aula->conteudo }}
                                </p>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if(!$turma->isFinalizada())
                                        <a href="{{ route('professor.diario.edit', [$turma, $aula]) }}" 
                                           class="p-2.5 rounded-xl border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-200 transition"
                                           title="Editar aula">
                                            <i class="ti ti-edit text-lg"></i>
                                        </a>
                                        
                                        <form method="POST" action="{{ route('professor.diario.destroy', [$turma, $aula]) }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button onclick="return confirm('Deseja realmente excluir este registro de aula?')" 
                                                    class="p-2.5 rounded-xl border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 transition"
                                                    title="Excluir">
                                                <i class="ti ti-trash text-lg"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[10px] font-bold text-slate-300 uppercase tracking-tighter">Locked</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-4">
                                        <i class="ti ti-book-off text-5xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium">Nenhuma aula registrada ainda para esta turma.</p>
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

    </main>
</div>

</body>
</html>