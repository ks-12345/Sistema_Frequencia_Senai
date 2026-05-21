<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Justificativas e Atestados - SENAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background: #f1f5f9; }</style>
</head>
<body class="text-slate-900">
<div class="min-h-screen">
    <nav class="bg-[#0a1128] text-white px-6 py-4 shadow-lg">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="{{ route('aluno.dashboard') }}" class="flex items-center gap-2 font-black uppercase text-sm">
                <i class="ti ti-school text-xl text-blue-400"></i> Rede SENAI
            </a>
            <a href="{{ route('aluno.cracha') }}" class="text-xs font-bold uppercase tracking-widest text-slate-300 hover:text-white">Meu Cracha</a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
            <div>
                <p class="text-blue-600 font-black text-[10px] uppercase tracking-[0.3em] mb-2">Area do Aluno</p>
                <h1 class="text-3xl font-black text-[#0a1128] tracking-tight">Justificativas e Atestados</h1>
                <p class="text-slate-500 text-sm mt-2">Envie documentos e acompanhe a analise das suas saidas antecipadas e atrasos.</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Pendencias</p>
                <p class="text-3xl font-black text-blue-600">{{ $pendentes }}</p>
            </div>
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
            @foreach(['' => 'Todos', 'pendente' => 'Pendente', 'em_analise' => 'Em analise', 'aprovado' => 'Aprovado', 'recusado' => 'Recusado', 'falta_mantida' => 'Falta mantida', 'justificado' => 'Justificado'] as $value => $label)
                <button name="status" value="{{ $value }}" class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest border {{ $status === $value || (!$status && $value === '') ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-500 border-slate-200' }}">
                    {{ $label }}
                </button>
            @endforeach
        </form>

        <div class="space-y-5">
            @forelse($solicitacoes as $solicitacao)
                @php
                    $isAtraso = $solicitacao->isAtraso();
                    $statusClasses = [
                        'pendente' => 'bg-amber-50 text-amber-700 border-amber-100',
                        'em_analise' => 'bg-blue-50 text-blue-700 border-blue-100',
                        'aprovado' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                        'recusado' => 'bg-red-50 text-red-700 border-red-100',
                        'falta_mantida' => 'bg-red-50 text-red-700 border-red-100',
                        'justificado' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                    ][$solicitacao->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                @endphp
                <section class="bg-white border border-slate-200 rounded-[2rem] shadow-sm overflow-hidden">
                    <div class="p-6 lg:p-8 grid lg:grid-cols-[1fr_360px] gap-8">
                        <div>
                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                <span class="px-3 py-1 rounded-full border text-[10px] font-black uppercase tracking-widest {{ $isAtraso ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-blue-50 text-blue-700 border-blue-100' }}">{{ $solicitacao->tipo_ocorrencia_label }}</span>
                                <span class="px-3 py-1 rounded-full border text-[10px] font-black uppercase tracking-widest {{ $statusClasses }}">{{ str_replace('_', ' ', $solicitacao->status) }}</span>
                                <span class="text-xs font-bold text-slate-400">{{ $solicitacao->data->format('d/m/Y') }} as {{ substr($solicitacao->horario_saida, 0, 5) }}</span>
                            </div>
                            <h2 class="text-xl font-black text-[#0a1128]">{{ $solicitacao->turma->nome ?? 'Turma nao informada' }}</h2>
                            <p class="text-sm text-slate-500 mt-2"><strong>Motivo:</strong> {{ $solicitacao->motivo }}</p>
                            <p class="text-sm text-slate-500 mt-1"><strong>{{ $solicitacao->horario_ocorrencia_label }}:</strong> {{ substr($solicitacao->horario_saida, 0, 5) }}</p>
                            <p class="text-sm text-slate-500 mt-1"><strong>Professor:</strong> {{ $solicitacao->professor->name ?? '---' }}</p>

                            <div class="mt-5 border-t border-slate-100 pt-5">
                                <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Justificativas enviadas</h3>
                                @forelse($solicitacao->justificativas as $justificativa)
                                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 mb-3">
                                        <p class="text-sm text-slate-600">{{ $justificativa->descricao }}</p>
                                        <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-slate-400 font-bold">
                                            <span>{{ str_replace('_', ' ', $justificativa->status) }}</span>
                                            @if($justificativa->arquivo)
                                                <a class="text-blue-600 hover:text-blue-800" href="{{ asset('storage/'.$justificativa->arquivo) }}" target="_blank">Ver anexo</a>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-slate-400 italic">Nenhuma justificativa enviada ainda.</p>
                                @endforelse
                            </div>
                        </div>

                        @if(in_array($solicitacao->status, ['pendente', 'em_analise'], true))
                            <form method="POST" action="{{ route('aluno.justificativas.store') }}" enctype="multipart/form-data" class="bg-slate-50 border border-slate-100 rounded-[1.5rem] p-5">
                                @csrf
                                <input type="hidden" name="solicitacao_saida_id" value="{{ $solicitacao->id }}">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Descricao</label>
                                <textarea name="descricao" rows="4" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-blue-400" placeholder="Explique sua justificativa..."></textarea>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mt-4 mb-2">Atestado ou documento</label>
                                <input type="file" name="arquivo" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-sm text-slate-500">
                                <button class="mt-5 w-full bg-[#0a1128] hover:bg-blue-700 text-white rounded-2xl py-3 text-xs font-black uppercase tracking-widest">Enviar justificativa</button>
                            </form>
                        @else
                            <div class="bg-slate-50 border border-slate-100 rounded-[1.5rem] p-5 flex items-center justify-center text-center">
                                <p class="text-sm font-bold text-slate-400">Solicitacao encerrada pela secretaria.</p>
                            </div>
                        @endif
                    </div>
                </section>
            @empty
                <div class="bg-white border-2 border-dashed border-slate-200 rounded-[2rem] p-12 text-center text-slate-400 font-bold">Nenhuma solicitacao encontrada.</div>
            @endforelse
        </div>

        <div class="mt-8">{{ $solicitacoes->links() }}</div>
    </main>
</div>
</body>
</html>
