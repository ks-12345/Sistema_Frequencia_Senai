<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saídas Antecipadas – Professor</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-2xl font-bold tracking-tight">Rede SENAI</h1>
            <p class="text-slate-400 text-[10px] uppercase tracking-widest font-bold">Portal do Docente</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('professor.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-layout-dashboard text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-door-exit text-xl"></i>
                <span class="font-bold">Saídas Antecipadas</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-8 lg:p-12">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h2 class="text-3xl font-bold text-[#0a1128] tracking-tight">Saídas Antecipadas</h2>
                <p class="text-slate-500 mt-1">Acompanhe o status das liberações solicitadas para seus alunos.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('professor.saidas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-2xl font-bold transition flex items-center gap-2 shadow-lg shadow-blue-900/20">
                    <i class="ti ti-plus text-xl"></i> Registrar Saída
                </a>
                <a href="{{ route('professor.dashboard') }}" class="bg-white border border-slate-200 px-4 py-3.5 rounded-2xl text-slate-600 hover:bg-slate-50 transition">
                    <i class="ti ti-arrow-back-up text-xl"></i>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 flex items-center gap-3 shadow-sm">
                <i class="ti ti-circle-check-filled text-xl"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Aluno / Turma</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Horário Previsto</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Motivo Informado</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">Status Secretaria</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Validado Por</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($saidas as $saida)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div>
                                    <p class="font-bold text-slate-800 leading-tight">{{ $saida->aluno->nome }}</p>
                                    <p class="text-xs text-blue-600 font-medium">{{ $saida->aluno->turma->nome ?? '—' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">{{ $saida->data->format('d/m/Y') }}</span>
                                    <span class="text-xs text-slate-400 font-mono">{{ substr($saida->horario_saida, 0, 5) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <p class="text-sm text-slate-500 italic max-w-xs truncate" title="{{ $saida->motivo }}">
                                    "{{ $saida->motivo ?? 'Não informado' }}"
                                </p>
                            </td>
                            <td class="px-6 py-6 text-center">
                                @php
                                    $statusClasses = match($saida->status) {
                                        'pendente' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'em_analise' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'justificado', 'aprovado' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'recusado', 'falta_mantida' => 'bg-red-50 text-red-600 border-red-100',
                                        default => 'bg-slate-50 text-slate-500 border-slate-100'
                                    };
                                    $statusLabel = match($saida->status) {
                                        'pendente' => 'Em Analise',
                                        'em_analise' => 'Justificativa enviada',
                                        'justificado', 'aprovado' => 'Justificada',
                                        'recusado', 'falta_mantida' => 'Falta mantida',
                                        default => 'Indefinido'
                                    };
                                @endphp
                                <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase border {{ $statusClasses }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-xs text-slate-400">
                                    {{ $saida->analisadoPor->name ?? '---' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center opacity-30">
                                    <i class="ti ti-door-off text-6xl mb-4"></i>
                                    <p class="font-medium">Nenhum registro de saída antecipada encontrado.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                {{ $saidas->links() }}
            </div>
        </div>

    </main>
</div>

</body>
</html>
