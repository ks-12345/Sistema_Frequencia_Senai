<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Turmas – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .action-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
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
                <i class="ti ti-layout-dashboard text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-checklist text-xl"></i>
                <span class="font-medium">Chamada Diária</span>
            </a>
            <a href="{{ route('professor.diario.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-book text-xl"></i>
                <span class="font-medium">Diários de Classe</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-8 lg:p-12">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h2 class="text-3xl font-bold text-[#0a1128] tracking-tight">Registro de Frequência</h2>
                <p class="text-slate-500 mt-2">Selecione a turma para realizar a chamada de hoje.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('professor.frequencia.pendentes') }}" class="relative bg-amber-50 text-amber-700 px-6 py-3 rounded-2xl font-bold text-sm hover:bg-amber-100 transition flex items-center gap-2 border border-amber-200">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                    </span>
                    Ver Pendentes
                </a>
                <a href="{{ route('professor.dashboard') }}" class="bg-white border border-slate-200 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50 transition shadow-sm">
                    <i class="ti ti-arrow-back-up text-xl"></i>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-10 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-3xl p-5 flex items-center gap-4 shadow-sm">
                <div class="bg-emerald-500 text-white p-2 rounded-xl">
                    <i class="ti ti-check text-xl"></i>
                </div>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($turmas as $turma)
            <div class="action-card bg-white rounded-[2.5rem] border border-slate-200 p-8 transition-all duration-300 flex flex-col shadow-sm">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                            <i class="ti ti-school text-3xl"></i>
                        </div>
                        <span class="bg-slate-100 text-slate-500 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter">
                            Ref: {{ date('d/m') }}
                        </span>
                    </div>

                    <h3 class="text-2xl font-bold text-[#0a1128] leading-tight mb-2">{{ $turma->nome }}</h3>
                    <p class="text-slate-400 text-sm font-medium mb-6">{{ $turma->curso }}</p>

                    <div class="flex flex-wrap gap-3 mb-8">
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 border border-slate-100">
                            <i class="ti ti-clock text-blue-500"></i>
                            {{ $turma->periodo }}
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 border border-slate-100">
                            <i class="ti ti-users text-blue-500"></i>
                            {{ rand(20, 35) }} Alunos
                        </div>
                    </div>
                </div>

                <a href="{{ route('professor.frequencia.lancar', $turma) }}" 
                   class="group w-full bg-[#0a1128] hover:bg-blue-600 text-white font-bold py-5 rounded-2xl transition-all flex items-center justify-center gap-3 shadow-lg shadow-blue-900/10">
                    Realizar Chamada
                    <i class="ti ti-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            @endforeach
        </div>

        <div class="mt-12 p-8 bg-blue-50 rounded-[3rem] flex flex-col md:flex-row items-center gap-6 border border-blue-100">
            <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center text-blue-600 text-3xl shadow-sm shrink-0">
                <i class="ti ti-bulb"></i>
            </div>
            <div>
                <h4 class="font-bold text-blue-900 text-lg">Chamada Inteligente</h4>
                <p class="text-blue-700/70 text-sm max-w-2xl">
                    Ao abrir a lista de presença, todos os alunos já vêm marcados como <strong>Presentes</strong> por padrão. Basta alterar apenas as faltas ou atrasos para economizar tempo.
                </p>
            </div>
        </div>

    </main>
</div>

</body>
</html>