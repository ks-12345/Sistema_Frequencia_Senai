<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fluxo de Saida Antecipada - Secretaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background: #f1f5f9; }</style>
</head>
<body class="text-slate-900">
<div class="flex min-h-screen">
    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen shadow-2xl">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-xl font-black flex items-center gap-2"><i class="ti ti-shield-check text-blue-400"></i> Secretaria</h1>
            <p class="text-slate-400 text-[10px] uppercase tracking-widest font-black">Fluxo de Saida</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('secretaria.saidas.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/40">
                <i class="ti ti-door-exit text-xl"></i>
                <span class="font-bold">Saidas Antecipadas</span>
            </a>
        </nav>
        <div class="p-6 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl border border-white/10 text-[10px] font-black uppercase tracking-[0.2em] hover:bg-red-600 hover:border-red-600">
                    <i class="ti ti-power text-base"></i> Sair
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 lg:p-12">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
            <div>
                <p class="text-blue-600 font-black text-[10px] uppercase tracking-[0.3em] mb-2">Secretaria</p>
                <h1 class="text-4xl font-black text-[#0a1128] tracking-tight">Fluxo de Saida Antecipada</h1>
                <p class="text-slate-500 mt-2">Analise justificativas, autorize saidas e acompanhe bloqueios.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            @foreach([
                ['label' => 'Pendentes', 'value' => $resumo['pendente'], 'color' => 'amber'],
                ['label' => 'Em analise', 'value' => $resumo['em_analise'], 'color' => 'blue'],
                ['label' => 'Justificadas', 'value' => $resumo['justificado'], 'color' => 'emerald'],
                ['label' => 'Faltas mantidas', 'value' => $resumo['falta_mantida'], 'color' => 'red'],
            ] as $card)
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $card['label'] }}</p>
                    <p class="text-3xl font-black text-{{ $card['color'] }}-600">{{ $card['value'] }}</p>
                </div>
            @endforeach
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 font-bold text-sm">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-4 text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="GET" class="mb-6 flex flex-wrap gap-2">
            @foreach(['' => 'Todos', 'pendente' => 'Pendente', 'em_analise' => 'Em analise', 'justificado' => 'Justificado', 'falta_mantida' => 'Falta mantida'] as $value => $label)
                <button name="status" value="{{ $value }}" class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest border {{ $status === $value || (!$status && $value === '') ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-500 border-slate-200' }}">
                    {{ $label }}
                </button>
            @endforeach
        </form>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            @forelse($solicitacoes as $saida)
                @php
                    $isAberta = in_array($saida->status, ['pendente', 'em_analise'], true);
                    $menor = $saida->aluno?->isMenorDeIdade();
                @endphp
                <section class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6">
                    <div class="flex items-start justify-between gap-4 mb-5">
                        <div>
                            <h2 class="text-2xl font-black text-[#0a1128]">{{ $saida->aluno->nome }}</h2>
                            <p class="text-xs text-blue-600 font-black uppercase tracking-widest">{{ $saida->turma->nome ?? 'Sem turma' }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $isAberta ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-slate-50 text-slate-600 border-slate-100' }}">
                            {{ str_replace('_', ' ', $saida->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-5 text-sm">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Data/Hora</p>
                            <p class="font-bold text-slate-700">{{ $saida->data->format('d/m/Y') }} {{ substr($saida->horario_saida, 0, 5) }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Menor de idade</p>
                            <p class="font-bold {{ $menor ? 'text-red-600' : 'text-emerald-600' }}">{{ $menor ? 'Sim' : 'Nao' }}</p>
                        </div>
                    </div>

                    <p class="text-sm text-slate-600 mb-2"><strong>Motivo:</strong> {{ $saida->motivo }}</p>
                    <p class="text-sm text-slate-500 mb-5"><strong>Observacao:</strong> {{ $saida->observacoes ?? '---' }}</p>

                    <div class="border-t border-slate-100 pt-5 mb-5">
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Justificativas e anexos</h3>
                        @forelse($saida->justificativas as $justificativa)
                            <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 mb-3">
                                <p class="text-sm text-slate-600">{{ $justificativa->descricao }}</p>
                                <div class="mt-2 flex flex-wrap gap-3 text-xs font-bold text-slate-400">
                                    <span>{{ str_replace('_', ' ', $justificativa->status) }}</span>
                                    @if($justificativa->arquivo)
                                        <a href="{{ asset('storage/'.$justificativa->arquivo) }}" target="_blank" class="text-blue-600 hover:text-blue-800">Abrir anexo</a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400 italic">Aluno ainda nao enviou justificativa.</p>
                        @endforelse
                    </div>

                    @if($isAberta)
                        <div class="grid md:grid-cols-2 gap-3">
                            <form method="POST" action="{{ route('secretaria.saidas.autorizar', $saida) }}" class="rounded-2xl bg-emerald-50 border border-emerald-100 p-4">
                                @csrf @method('PATCH')
                                <input type="hidden" name="decisao" value="aprovar">
                                <textarea name="observacao" rows="2" placeholder="Observacao da aprovacao..." class="w-full rounded-xl border border-emerald-100 px-3 py-2 text-sm outline-none"></textarea>
                                <button class="mt-3 w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl py-3 text-xs font-black uppercase tracking-widest">Aprovar</button>
                            </form>
                            <form method="POST" action="{{ route('secretaria.saidas.nao-autorizar', $saida) }}" class="rounded-2xl bg-red-50 border border-red-100 p-4">
                                @csrf @method('PATCH')
                                <input type="hidden" name="decisao" value="recusar">
                                <textarea name="observacao" rows="2" required placeholder="Motivo da recusa..." class="w-full rounded-xl border border-red-100 px-3 py-2 text-sm outline-none"></textarea>
                                <button class="mt-3 w-full bg-red-600 hover:bg-red-700 text-white rounded-xl py-3 text-xs font-black uppercase tracking-widest">Recusar</button>
                            </form>
                        </div>
                    @else
                        <p class="rounded-2xl bg-slate-50 border border-slate-100 p-4 text-sm font-bold text-slate-400">Analise encerrada por {{ $saida->analisadoPor->name ?? 'secretaria' }}.</p>
                    @endif
                </section>
            @empty
                <div class="xl:col-span-2 bg-white border-2 border-dashed border-slate-200 rounded-[2rem] p-12 text-center text-slate-400 font-bold">Nenhuma solicitacao encontrada.</div>
            @endforelse
        </div>

        <div class="mt-8">{{ $solicitacoes->links() }}</div>
    </main>
</div>
</body>
</html>
