<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Acesso – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fb; }
        .table-row { transition: .2s ease; }
        .table-row:hover { background: #f8fafc; }
    </style>
</head>
<body>

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-2xl font-bold tracking-tight">Rede SENAI</h1>
            <p class="text-slate-400 text-xs mt-1">Painel Administrativo</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-layout-grid text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-lock-access text-xl"></i>
                <span class="font-medium">Acesso</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">
            <div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Controle de Acesso</h1>
                <p class="text-slate-500 mt-2">Monitoramento de portaria e blocos em tempo real (Hoje).</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                    <i class="ti ti-arrow-left"></i> Voltar
                </a>

                <a href="{{ route('admin.acesso.leitura') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-blue-200 transition flex items-center gap-2">
                    <i class="ti ti-qrcode"></i> Nova Leitura
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 flex items-center gap-3">
                <i class="ti ti-circle-check text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-sm">
            
            <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-white">
                <div>
                    <h2 class="text-xl font-bold text-[#0a1128]">Registros Recentes</h2>
                    <p class="text-slate-400 text-sm mt-1">Atualizado automaticamente</p>
                </div>
                <span class="flex items-center gap-2 text-xs font-bold text-emerald-500 bg-emerald-50 px-3 py-1.5 rounded-full uppercase tracking-wider">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Sistema Online
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-8 py-5">Horário</th>
                            <th class="px-8 py-5">Aluno / Turma</th>
                            <th class="px-8 py-5">Tipo & Local</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5">Observação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($registros as $registro)
                        <tr class="table-row {{ $registro->status !== 'ok' ? 'bg-amber-50/50' : '' }}">
                            <td class="px-8 py-5">
                                <span class="font-mono font-bold text-slate-700 bg-slate-100 px-2.5 py-1.5 rounded-lg text-sm">
                                    {{ $registro->registrado_em->format('H:i:s') }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-800">{{ $registro->aluno->nome }}</span>
                                    <span class="text-xs text-slate-400 font-medium">{{ $registro->aluno->turma->nome ?? '—' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs font-bold px-2 py-1 rounded bg-slate-200 text-slate-600 self-start uppercase">
                                        {{ match($registro->tipo) {
                                            'entrada_portaria' => 'Portaria Principal',
                                            'entrada_bloco'    => 'Entrada de Bloco',
                                            'saida'            => 'Saída Unidade',
                                        } }}
                                    </span>
                                    <span class="text-sm text-slate-500 italic">{{ $registro->local ?? '—' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                @if($registro->status === 'ok')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                        <i class="ti ti-circle-check"></i> ACESSO OK
                                    </span>
                                @elseif($registro->status === 'bloco_errado')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">
                                        <i class="ti ti-alert-triangle"></i> BLOCO ERRADO
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                        <i class="ti ti-circle-x"></i> AUSENTE
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-sm text-slate-400 italic">
                                {{ $registro->observacao ?? '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="ti ti-search text-4xl text-slate-200"></i>
                                    <p class="text-slate-400 font-medium">Nenhum registro de acesso hoje.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50">
                {{ $registros->links() }}
            </div>
        </div>
    </main>
</div>

</body>
</html>