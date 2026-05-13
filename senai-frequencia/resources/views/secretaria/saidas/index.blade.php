<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Saídas – Secretaria SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
        .input-pill:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        .sidebar-item:hover { background: rgba(255, 255, 255, 0.05); }
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen shadow-2xl">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-xl font-bold tracking-tight flex items-center gap-2">
                <i class="ti ti-shield-check text-blue-400"></i> Secretaria
            </h1>
            <p class="text-slate-400 text-[10px] uppercase tracking-widest font-black">Controle de Fluxo</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="#" class="sidebar-item flex items-center gap-4 px-4 py-3.5 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/40 transition">
                <i class="ti ti-door-exit text-xl"></i>
                <span class="font-bold">Validar Saídas</span>
            </a>
            <a href="#" class="sidebar-item flex items-center gap-4 px-4 py-3.5 rounded-xl transition text-slate-400 hover:text-white">
                <i class="ti ti-user-check text-xl"></i>
                <span class="font-medium">Frequência Geral</span>
            </a>
        </nav>

        <div class="p-6 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 mb-4 rounded-xl border border-white/10 text-[10px] font-black uppercase tracking-[0.2em] hover:bg-red-600 hover:border-red-600 transition-all">
                    <i class="ti ti-power text-base"></i> Sair do Sistema
                </button>
            </form>
            
            <div class="bg-white/5 rounded-2xl p-4 flex items-center gap-3 border border-white/5">
                <div class="w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center font-bold text-white shadow-inner">
                    <i class="ti ti-user-shield text-xl"></i>
                </div>
                <div class="truncate text-left">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-tighter">Administrador</p>
                    <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Usuário' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-8 lg:p-12">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h2 class="text-4xl font-black text-[#0a1128] tracking-tight">Gestão de Saídas</h2>
                <p class="text-slate-500 mt-2 font-medium">Validação e autorização de fluxo de aprendizes.</p>
            </div>

        </div>

        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-[1.5rem] p-5 flex items-center gap-3 shadow-sm animate-pulse">
                <div class="bg-emerald-500 text-white p-1 rounded-full">
                    <i class="ti ti-check text-sm"></i>
                </div>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <section class="mb-12">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-2">
                <span class="w-2 h-2 bg-amber-500 rounded-full animate-ping"></span>
                Pendentes de Validação
            </h3>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                @forelse($pendentes as $saida)
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm hover:shadow-xl hover:shadow-blue-900/5 transition-all p-8 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-bl-[5rem] -mr-10 -mt-10 transition-colors group-hover:bg-amber-100/40"></div>
                    
                    <div class="relative">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h4 class="text-2xl font-black text-[#0a1128] tracking-tight">{{ $saida->aluno->nome }}</h4>
                                <p class="text-xs text-blue-600 font-black uppercase tracking-widest mt-1">{{ $saida->aluno->turma->nome ?? 'Sem Turma' }}</p>
                            </div>
                            <div class="bg-white shadow-sm border border-slate-100 px-4 py-2 rounded-2xl text-right">
                                <span class="text-[9px] font-black text-slate-400 block uppercase tracking-tighter">Horário</span>
                                <span class="text-xl font-mono font-black text-slate-700">{{ $saida->horario_saida->format('H:i') }}</span>
                            </div>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-start gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <i class="ti ti-quote text-blue-300 text-2xl"></i>
                                <span class="text-sm text-slate-600 font-medium italic">"{{ $saida->motivo ?? 'Não informado' }}"</span>
                            </div>
                            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">
                                <i class="ti ti-user-edit text-blue-500"></i>
                                Solicitado por: <span class="text-slate-600">{{ $saida->solicitadoPor->name }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <form method="POST" action="{{ route('secretaria.saidas.autorizar', $saida) }}" class="flex gap-2">
                                @csrf @method('PATCH')
                                <input type="text" name="observacao_secretaria" placeholder="Observações de liberação..." 
                                       class="flex-1 bg-slate-50 border-none rounded-2xl px-5 py-3 text-xs input-pill font-medium">
                                <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-emerald-900/10 active:scale-95">
                                    Liberar
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('secretaria.saidas.nao-autorizar', $saida) }}" class="flex gap-2">
                                @csrf @method('PATCH')
                                <input type="text" name="observacao_secretaria" required placeholder="Motivo da recusa (obrigatório)..." 
                                       class="flex-1 bg-red-50/30 border-none rounded-2xl px-5 py-3 text-xs input-pill font-medium text-red-900 placeholder:text-red-300">
                                <button class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-red-900/10 active:scale-95">
                                    Recusar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white/50 border-2 border-dashed border-slate-200 rounded-[3rem] p-16 text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-slate-100">
                        <i class="ti ti-circle-check text-emerald-500 text-4xl"></i>
                    </div>
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Nenhuma solicitação pendente</p>
                </div>
                @endforelse
            </div>
        </section>

        <section>
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-6">Histórico Recente</h3>
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="px-8 py-5">Aprendiz</th>
                            <th class="px-6 py-5">Data/Hora</th>
                            <th class="px-6 py-5 text-center">Status</th>
                            <th class="px-8 py-5">Observação Secretaria</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm font-medium">
                        @forelse($historico as $saida)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5 text-[#0a1128] font-bold">{{ $saida->aluno->nome }}</td>
                            <td class="px-6 py-5 text-slate-500 font-mono text-xs">{{ $saida->horario_saida->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-5 text-center">
                                @if($saida->status === 'autorizada')
                                    <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter">Autorizada</span>
                                @else
                                    <span class="bg-red-50 text-red-600 border border-red-100 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter">Recusada</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-slate-400 italic text-xs max-w-xs truncate">{{ $saida->observacao_secretaria ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-10 text-center text-slate-300 italic text-xs">Sem registros históricos.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <footer class="mt-16 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.4em]">
            Rede SENAI &copy; 2026 — Protocolo de Segurança Escolar
        </footer>

    </main>
</div>

</body>
</html>