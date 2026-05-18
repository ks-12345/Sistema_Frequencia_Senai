<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docência – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .sidebar-item:hover { background: rgba(255, 255, 255, 0.05); }
        .action-card:hover { transform: translateY(-5px); border-color: #3b82f6; }
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen shadow-2xl">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-2xl font-bold tracking-tight">Rede SENAI</h1>
            <p class="text-blue-400 text-[10px] uppercase tracking-widest font-black">Portal do Docente</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('professor.context.select') }}" class="sidebar-item flex items-center gap-4 px-4 py-3.5 rounded-xl transition text-slate-400 hover:text-white">
                <i class="ti ti-switch-horizontal text-xl"></i>
                <span class="font-medium">Trocar Atuacao</span>
            </a>
            <a href="#" class="sidebar-item flex items-center gap-4 px-4 py-3.5 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20 transition">
                <i class="ti ti-layout-dashboard text-xl"></i>
                <span class="font-bold">Dashboard</span>
            </a>
            <a href="{{ route('professor.frequencia.index') }}" class="sidebar-item flex items-center gap-4 px-4 py-3.5 rounded-xl transition text-slate-400 hover:text-white">
                <i class="ti ti-checkbox text-xl"></i>
                <span class="font-medium">Lançar Presença</span>
            </a>
            <a href="{{ route('professor.diario.index') }}" class="sidebar-item flex items-center gap-4 px-4 py-3.5 rounded-xl transition text-slate-400 hover:text-white">
                <i class="ti ti-book text-xl"></i>
                <span class="font-medium">Diário de Classe</span>
            </a>
            <a href="{{ route('professor.saidas.index') }}" class="sidebar-item flex items-center gap-4 px-4 py-3.5 rounded-xl transition text-slate-400 hover:text-white">
                <i class="ti ti-door-exit text-xl"></i>
                <span class="font-medium">Saídas Antecipadas</span>
            </a>
        </nav>

        <div class="p-6 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}" class="mb-4">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl border border-white/10 text-xs font-black uppercase tracking-widest hover:bg-red-600 hover:border-red-600 transition-all">
                    <i class="ti ti-power"></i> Encerrar Sessão
                </button>
            </form>
            <div class="bg-white/5 rounded-2xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="truncate text-left">
                    <p class="text-[10px] font-black text-slate-500 uppercase">Professor(a)</p>
                    <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-8 lg:p-12">
        
        <header class="mb-12">
            <p class="text-blue-600 font-black text-[10px] uppercase tracking-[0.3em] mb-1">Ambiente de Gestão Acadêmica</p>
            <h2 class="text-4xl font-black text-[#0a1128] tracking-tight">Bem-vindo, Docente.</h2>
            <p class="text-slate-500 mt-2 font-medium">Selecione uma das ferramentas abaixo para gerenciar suas turmas.</p>
        </header>

        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <section class="mb-8 bg-white border border-slate-200 rounded-3xl p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 shadow-sm">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Modo Atual</p>
                <h3 class="text-xl font-black text-[#0a1128] mt-1">
                    Professor {{ session('teacher_acting_mode') === 'substituto' ? 'Substituto' : 'Titular' }}
                </h3>
                @if($activeSubstitution)
                    <p class="text-sm text-slate-500 mt-1">
                        Turma {{ $activeSubstitution->turma->nome ?? '-' }} substituindo {{ $activeSubstitution->substitutedTeacher->name ?? '-' }}
                    </p>
                @endif
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('professor.context.select') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-xl font-bold flex items-center gap-2">
                    <i class="ti ti-switch-horizontal"></i> Alternar
                </a>
                @if($activeSubstitution)
                    <form method="POST" action="{{ route('professor.context.finish') }}">
                        @csrf
                        <button class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-3 rounded-xl font-bold flex items-center gap-2">
                            <i class="ti ti-player-stop"></i> Encerrar
                        </button>
                    </form>
                @endif
            </div>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <a href="{{ route('professor.frequencia.index') }}" class="action-card bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50 transition-all flex flex-col group">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <i class="ti ti-user-check"></i>
                </div>
                <h3 class="text-lg font-black text-[#0a1128] mb-2 tracking-tight">Lançar Frequência</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-6">Inicie a chamada via QR Code ou registro manual para as aulas de hoje.</p>
                <span class="mt-auto text-blue-600 font-bold text-xs uppercase tracking-widest flex items-center gap-2">
                    Acessar Ferramenta <i class="ti ti-arrow-right"></i>
                </span>
            </a>

            <a href="{{ route('professor.frequencia.pendentes') }}" class="action-card bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50 transition-all flex flex-col group">
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-amber-600 group-hover:text-white transition-all">
                    <i class="ti ti-clock-pause"></i>
                </div>
                <h3 class="text-lg font-black text-[#0a1128] mb-2 tracking-tight">Pendentes</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-6">Revise e aprove justificativas de falta ou registros em análise.</p>
                <span class="mt-auto text-amber-600 font-bold text-xs uppercase tracking-widest flex items-center gap-2">
                    Ver Pendências <i class="ti ti-arrow-right"></i>
                </span>
            </a>

            <a href="{{ route('professor.diario.index') }}" class="action-card bg-[#0a1128] p-8 rounded-[2.5rem] shadow-xl shadow-blue-900/20 transition-all flex flex-col group">
                <div class="w-14 h-14 bg-white/10 text-white rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-white group-hover:text-[#0a1128] transition-all">
                    <i class="ti ti-notebook"></i>
                </div>
                <h3 class="text-lg font-black text-white mb-2 tracking-tight">Diário de Classe</h3>
                <p class="text-sm text-blue-100/60 leading-relaxed mb-6">Consulte o histórico de presenças e o desempenho global das turmas.</p>
                <span class="mt-auto text-blue-400 font-bold text-xs uppercase tracking-widest flex items-center gap-2">
                    Abrir Relatórios <i class="ti ti-arrow-right"></i>
                </span>
            </a>

        </div>

        <footer class="mt-16 pt-8 border-t border-slate-200 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center md:text-left">
                Rede SENAI — Gestão de Aprendizagem Industrial 2026
            </p>
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-2 text-[10px] font-bold text-emerald-600 uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Servidor Online
                </span>
            </div>
        </footer>
    </main>
</div>

</body>
</html>
