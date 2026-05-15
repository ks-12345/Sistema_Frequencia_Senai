<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
        .progress-ring { transition: stroke-dashoffset 0.35s; transform: rotate(-90deg); transform-origin: 50% 50%; }
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-80 bg-[#060b26] text-white flex flex-col sticky top-0 h-screen shadow-2xl">
        <div class="h-28 flex flex-col justify-center px-10 border-b border-white/5">
            <h1 class="text-2xl font-extrabold tracking-tighter italic">SENAI<span class="text-blue-500 text-sm align-top ml-1">CORP</span></h1>
            <p class="text-slate-500 text-[10px] uppercase tracking-[0.3em] font-bold">Portal da Empresa</p>
        </div>

        <div class="p-8">
            <div class="bg-white/5 rounded-[2rem] p-6 border border-white/10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                        <i class="ti ti-building-factory-2 text-xl text-white"></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Parceiro</p>
                        <p class="text-sm font-bold truncate">{{ auth()->user()->name }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full py-2 text-xs font-bold text-slate-400 hover:text-white transition-colors flex items-center justify-center gap-2 border-t border-white/5 pt-4">
                        <i class="ti ti-power"></i> Encerrar Sessão
                    </button>
                </form>
            </div>
        </div>

        <nav class="flex-1 px-6 space-y-2">
            <a href="#" class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-blue-600 text-white shadow-xl shadow-blue-900/40">
                <i class="ti ti-chart-pie text-xl"></i>
                <span class="font-bold">Visão Geral</span>
            </a>
            <a href="{{ route('empresa.frequencia.index') }}" class="flex items-center gap-4 px-6 py-4 rounded-2xl text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                <i class="ti ti-users text-xl"></i>
                <span class="font-medium">Lista de Aprendizes</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-12">
        
        <header class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-4xl font-black text-slate-800 tracking-tight">Analytics de Aprendizagem</h2>
                <p class="text-slate-500 mt-2 font-medium">Gestão e monitoramento dos aprendizes alocados.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-white px-5 py-3 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-slate-600 uppercase tracking-widest">Dados Sincronizados</span>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            
            <div class="bg-white p-8 rounded-[3.5rem] border border-slate-200 shadow-sm relative overflow-hidden group transition-all hover:border-blue-200">
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total de Aprendizes</p>
                    <h3 class="text-6xl font-black text-slate-800 tracking-tighter">{{ $totalAlunos }}</h3>
                    <div class="mt-6 inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold italic">
                        <i class="ti ti-activity"></i> Matrículas Ativas
                    </div>
                </div>
                <i class="ti ti-users text-9xl absolute -right-6 -bottom-6 text-slate-50 group-hover:text-blue-50/50 transition-colors"></i>
            </div>

            <div class="bg-white p-8 rounded-[3.5rem] border border-slate-200 shadow-sm flex items-center justify-between group transition-all hover:border-blue-200">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Presença Global</p>
                    <h3 class="text-6xl font-black text-slate-800 tracking-tighter">{{ $percentual }}%</h3>
                    <p class="text-slate-400 text-xs mt-6 font-medium">Meta Corporativa: <span class="font-bold text-slate-700">90%</span></p>
                </div>
                
                <div class="relative flex items-center justify-center">
                    <svg class="w-28 h-28">
                        <circle class="text-slate-100" stroke-width="10" stroke="currentColor" fill="transparent" r="45" cx="56" cy="56"/>
                        <circle class="text-blue-600 progress-ring" stroke-width="10" stroke-dasharray="282.6" stroke-dashoffset="{{ 282.6 - (282.6 * $percentual / 100) }}" stroke-linecap="round" stroke="currentColor" fill="transparent" r="45" cx="56" cy="56"/>
                    </svg>
                    <i class="ti ti-chart-dots absolute text-blue-600 text-2xl"></i>
                </div>
            </div>

            <a href="{{ route('empresa.frequencia.index') }}" class="bg-[#060b26] p-8 rounded-[3.5rem] shadow-2xl shadow-blue-900/20 flex flex-col justify-between hover:bg-[#0a1128] transition-all group">
                <div class="flex justify-between items-start">
                    <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-3xl shadow-lg shadow-blue-600/30">
                        <i class="ti ti-external-link"></i>
                    </div>
                </div>
                <div class="mt-8">
                    <h4 class="text-white text-xl font-bold leading-tight">Auditoria de<br>Frequência</h4>
                    <p class="text-slate-400 text-xs mt-2">Clique para detalhar as presenças por aluno.</p>
                </div>
            </a>
        </div>

        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-[3rem] p-10 text-white relative overflow-hidden shadow-xl shadow-blue-900/10">
            <div class="absolute right-0 top-0 h-full w-1/4 bg-white/5 skew-x-12 translate-x-12"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="max-w-xl">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="ti ti-info-circle-filled"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Comunicado Importante</span>
                    </div>
                    <h4 class="text-2xl font-bold mb-2">Fechamento Mensal de Ponto</h4>
                    <p class="text-blue-100/80 leading-relaxed text-sm italic">
                        Os relatórios de frequência de Maio de 2026 estarão disponíveis para download definitivo a partir do dia 05 do próximo mês.
                    </p>
</div>
            </div>
        </div>

    </main>
</div>

</body>
</html>