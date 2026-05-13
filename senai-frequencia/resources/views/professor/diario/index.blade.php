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
        .turma-card:hover { transform: translateY(-4px); }
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
            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-book text-xl"></i>
                <span class="font-medium">Meus Diários</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-12">
            <div>
                <div class="flex items-center gap-2 text-blue-600 font-bold text-sm uppercase tracking-widest mb-2">
                    <i class="ti ti-folders"></i> Gestão Acadêmica
                </div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Diários de Classe</h1>
                <p class="text-slate-500 mt-2">Selecione uma turma para registrar aulas, frequências ou conteúdos.</p>
            </div>
            
            <a href="{{ route('professor.dashboard') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                <i class="ti ti-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($turmas as $turma)
            <div class="turma-card bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="ti ti-users-group text-2xl"></i>
                        </div>
                        @if($turma->isFinalizada())
                            <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase border border-red-100 flex items-center gap-1">
                                <i class="ti ti-lock"></i> Finalizada
                            </span>
                        @else
                            <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase border border-emerald-100 flex items-center gap-1">
                                <i class="ti ti-circle-check"></i> Ativa
                            </span>
                        @endif
                    </div>

                    <h3 class="text-xl font-bold text-[#0a1128] mb-1">{{ $turma->nome }}</h3>
                    <p class="text-slate-500 text-sm font-medium mb-4">{{ $turma->curso }}</p>
                    
                    <div class="space-y-2 mb-8">
                        <div class="flex items-center gap-2 text-xs text-slate-400">
                            <i class="ti ti-clock-hour-4"></i>
                            Período: <span class="text-slate-600 font-bold">{{ $turma->periodo }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-slate-400">
                            <i class="ti ti-calendar-event"></i>
                            Semestre: <span class="text-slate-600 font-bold">2026.1</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('professor.diario.turma', $turma) }}" 
                   class="w-full bg-slate-100 hover:bg-[#0a1128] hover:text-white text-slate-700 font-bold py-4 rounded-2xl transition-all flex items-center justify-center gap-2 group">
                    Abrir Diário 
                    <i class="ti ti-chevron-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            @endforeach
        </div>

        <div class="mt-12 p-6 bg-[#0a1128] rounded-[2rem] text-white flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-blue-400">
                    <i class="ti ti-bulb text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold">Dica de Produtividade</h4>
                    <p class="text-slate-400 text-sm">Você pode editar aulas registradas nos últimos 7 dias diretamente pelo diário da turma.</p>
                </div>
            </div>
            <div class="text-xs text-slate-500 font-mono">
                Versão do Sistema: 3.2.0-stable
            </div>
        </div>

    </main>
</div>

</body>
</html>