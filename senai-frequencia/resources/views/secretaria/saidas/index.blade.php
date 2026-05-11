<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Saídas – Secretaria SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
        .input-pill:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-xl font-bold tracking-tight flex items-center gap-2">
                <i class="ti ti-shield-check text-blue-400"></i> Secretaria
            </h1>
            <p class="text-slate-400 text-[10px] uppercase tracking-widest font-semibold">Controle de Fluxo</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/40">
                <i class="ti ti-door-exit text-xl"></i>
                <span class="font-medium">Validar Saídas</span>
            </a>
            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-user-check text-xl"></i>
                <span class="font-medium">Frequência Geral</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-8">

        <div class="mb-10">
            <h2 class="text-3xl font-bold text-[#0a1128] tracking-tight">Saídas Antecipadas</h2>
            <p class="text-slate-500 mt-1">Autorize ou recuse solicitações de saída de alunos em tempo real.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 flex items-center gap-3 animate-pulse">
                <i class="ti ti-circle-check-filled text-xl"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <section class="mb-12">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                <i class="ti ti-clock-pause text-amber-500 text-lg"></i> Pendentes de Validação
            </h3>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                @forelse($pendentes as $saida)
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-[4rem] -mr-8 -mt-8 transition-colors group-hover:bg-amber-100/50"></div>
                    
                    <div class="relative">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="text-xl font-bold text-[#0a1128]">{{ $saida->aluno->nome }}</h4>
                                <p class="text-sm text-blue-600 font-medium">{{ $saida->aluno->turma->nome ?? 'Sem Turma' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-bold text-slate-400 block uppercase">Horário Saída</span>
                                <span class="text-lg font-mono font-bold text-slate-700">{{ $saida->horario_saida->format('H:i') }}</span>
                            </div>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i class="ti ti-notes text-slate-400"></i>
                                <span class="font-medium italic">"{{ $saida->motivo ?? 'Não informado' }}"</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-400">
                                <i class="ti ti-user-edit"></i>
                                Solicitado por: <strong>{{ $saida->solicitadoPor->name }}</strong>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-2xl flex flex-col gap-3">
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('secretaria.saidas.autorizar', $saida) }}" class="flex-1 flex gap-2">
                                    @csrf @method('PATCH')
                                    <input type="text" name="observacao_secretaria" placeholder="Obs. de autorização..." 
                                           class="flex-1 bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs input-pill">
                                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1">
                                        <i class="ti ti-check"></i> Autorizar
                                    </button>
                                </form>
                            </div>
                            <div class="border-t border-slate-200 pt-3">
                                <form method="POST" action="{{ route('secretaria.saidas.nao-autorizar', $saida) }}" class="flex gap-2">
                                    @csrf @method('PATCH')
                                    <input type="text" name="observacao_secretaria" required placeholder="Motivo obrigatório para recusa..." 
                                           class="flex-1 bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs input-pill">
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1">
                                        <i class="ti ti-x"></i> Recusar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white/50 border-2 border-dashed border-slate-200 rounded-[2rem] p-12 text-center">
                    <i class="ti ti-circle-check text-slate-300 text-5xl mb-3"></i>
                    <p class="text-slate-400 font-medium">Tudo em ordem! Nenhuma saída pendente no momento.</p>
                </div>
                @endforelse
            </div>
        </section>

        <section>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Histórico Recente</h3>
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            <th class="px-8 py-4">Aluno</th>
                            <th class="px-6 py-4">Data/Hora</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Validado por</th>
                            <th class="px-8 py-4">Observação Secretaria</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($historico as $saida)
                        <tr>
                            <td class="px-8 py-5 font-bold text-slate-700">{{ $saida->aluno->nome }}</td>
                            <td class="px-6 py-5 text-slate-500 font-mono text-xs">{{ $saida->horario_saida->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-5 text-center">
                                @if($saida->status === 'autorizada')
                                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase">✅ Autorizada</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase">❌ Recusada</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-slate-600 text-xs">{{ $saida->validadoPor->name ?? '—' }}</td>
                            <td class="px-8 py-5 text-slate-400 italic text-xs max-w-xs truncate">{{ $saida->observacao_secretaria ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-10 text-center text-slate-300 italic">Nenhum registro de histórico.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-8 py-4 bg-slate-50/50 border-t border-slate-100">
                    {{ $historico->links() }}
                </div>
            </div>
        </section>

    </main>
</div>

</body>
</html>