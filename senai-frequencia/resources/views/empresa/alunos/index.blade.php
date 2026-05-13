<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Aprendizes – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .sidebar-item:hover { background: rgba(255, 255, 255, 0.05); }
        input::placeholder { color: #94a3b8; }
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen shadow-2xl">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-2xl font-bold tracking-tight">Rede SENAI</h1>
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

        <div class="p-6 border-t border-white/5 space-y-4">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl border border-white/10 text-[10px] font-black uppercase tracking-widest hover:bg-red-600 hover:border-red-600 transition-all">
                    <i class="ti ti-power text-base"></i> Sair do Sistema
                </button>
            </form>

            <div class="bg-white/5 rounded-2xl p-4 flex items-center gap-3 border border-white/5">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center font-bold shadow-lg">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="truncate text-left">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Usuário</p>
                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Usuário' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-8 lg:p-12">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-12">
            <div>
                <h2 class="text-4xl font-black text-[#0a1128] tracking-tight">Meus Aprendizes</h2>
                <p class="text-slate-500 mt-2 font-medium">Gestão detalhada de colaboradores em programa de aprendizagem.</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="bg-white border border-slate-200 px-6 py-4 rounded-[2rem] shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                        <i class="ti ti-users-group text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Base Ativa</p>
                        <p class="text-2xl font-black text-[#0a1128]">{{ $alunos->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/30 overflow-hidden">
            
            <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/30">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="ti ti-list-details text-blue-600"></i> Lista de Alunos
                </h3>
                <div class="relative w-full md:w-80">
                    <input type="text" placeholder="Buscar por nome ou CPF..." 
                           class="w-full pl-12 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm">
                    <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 border-b border-slate-100">
                            <th class="px-8 py-6 text-[11px] font-black uppercase tracking-[0.15em]">Aprendiz</th>
                            <th class="px-6 py-6 text-[11px] font-black uppercase tracking-[0.15em]">CPF / Identificação</th>
                            <th class="px-6 py-6 text-[11px] font-black uppercase tracking-[0.15em]">Turma alocada</th>
                            <th class="px-6 py-6 text-[11px] font-black uppercase tracking-[0.15em] text-center">Status</th>
                            <th class="px-8 py-6 text-[11px] font-black uppercase tracking-[0.15em] text-right">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($alunos as $aluno)
                        <tr class="group hover:bg-blue-50/30 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                        <i class="ti ti-user text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 group-hover:text-blue-700 transition-colors">{{ $aluno->nome }}</p>
                                        <p class="text-xs text-slate-400 italic">{{ $aluno->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                @php
                                    $soNumeros = preg_replace('/[^0-9]/', '', $aluno->cpf);
                                    $cpfFormatado = (strlen($soNumeros) === 11) 
                                        ? vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split($soNumeros)) 
                                        : $aluno->cpf;
                                @endphp
                                <span class="text-sm font-mono text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">
                                    {{ $cpfFormatado }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">{{ $aluno->turma->nome ?? '—' }}</span>
                                    <span class="text-[10px] text-blue-500 font-bold uppercase tracking-tighter">SENAI Industrial</span>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-center">
                                @php
                                    $statusStyle = ($aluno->status === 'ativo' || $aluno->status === 'Ativo') 
                                        ? 'bg-emerald-50 text-emerald-600 border-emerald-100' 
                                        : 'bg-red-50 text-red-600 border-red-100';
                                @endphp
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase border {{ $statusStyle }}">
                                    {{ $aluno->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="{{ route('empresa.frequencia.show', $aluno) }}" 
                                   class="inline-flex items-center gap-2 bg-white border border-slate-200 px-4 py-2 rounded-xl text-xs font-black text-slate-600 hover:bg-[#0a1128] hover:text-white hover:border-[#0a1128] transition-all shadow-sm">
                                    <i class="ti ti-eye text-base"></i> Detalhes
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center opacity-20">
                                    <i class="ti ti-users-off text-7xl mb-4"></i>
                                    <p class="font-black text-xl uppercase tracking-widest">Nenhum aprendiz na base</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($alunos->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                {{ $alunos->links() }}
            </div>
            @endif
        </div>

        <footer class="mt-12 text-center text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">
            © 2026 Rede SENAI — Gestão de Aprendizagem Industrial
        </footer>

    </main>
</div>

</body>
</html>