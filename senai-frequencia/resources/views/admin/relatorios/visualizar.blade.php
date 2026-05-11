<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }} – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fb; }
        @media print {
            .no-print { display: none; }
            body { background: white; }
            .print-card { border: 1px solid #e2e8f0; box-shadow: none; }
        }
    </style>
</head>
<body>

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen no-print">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-2xl font-bold tracking-tight">Rede SENAI</h1>
            <p class="text-slate-400 text-xs mt-1">Painel Administrativo</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-layout-grid text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('admin.relatorios.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-chart-bar text-xl"></i>
                <span class="font-medium">Relatórios</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-6 lg:p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">
            <div>
                <a href="{{ route('admin.relatorios.index') }}" class="text-blue-600 font-bold text-xs uppercase tracking-widest mb-2 flex items-center gap-1 no-print">
                    <i class="ti ti-arrow-left"></i> Voltar aos Filtros
                </a>
                <h1 class="text-3xl font-bold text-[#0a1128] tracking-tight">{{ $titulo }}</h1>
                <p class="text-slate-500 text-sm mt-1 italic">Relatório gerado em {{ now()->format('d/m/Y H:i') }}</p>
            </div>

            <div class="flex items-center gap-3 no-print">
                <form method="GET" class="flex gap-2">
                    @foreach($request->all() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <button type="submit" formaction="{{ route('admin.relatorios.csv') }}" 
                            class="bg-white border border-slate-200 px-4 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                        <i class="ti ti-file-spreadsheet text-emerald-600"></i> CSV
                    </button>
                    
                    <button type="submit" formaction="{{ route('admin.relatorios.pdf') }}" 
                            class="bg-[#0a1128] text-white px-6 py-2.5 rounded-xl font-bold hover:bg-blue-900 transition flex items-center gap-2 shadow-lg shadow-blue-900/10">
                        <i class="ti ti-file-type-pdf"></i> Exportar PDF
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white p-5 rounded-3xl border border-slate-200 print-card">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Registros</p>
                <h3 class="text-2xl font-bold text-[#0a1128] mt-1">{{ $totalRegistros }}</h3>
            </div>
            <div class="bg-white p-5 rounded-3xl border border-slate-200 border-l-4 border-l-emerald-500 print-card">
                <p class="text-emerald-600 text-xs font-bold uppercase tracking-wider">Presenças</p>
                <h3 class="text-2xl font-bold text-[#0a1128] mt-1">{{ $totalPresencas }}</h3>
            </div>
            <div class="bg-white p-5 rounded-3xl border border-slate-200 border-l-4 border-l-red-500 print-card">
                <p class="text-red-600 text-xs font-bold uppercase tracking-wider">Faltas</p>
                <h3 class="text-2xl font-bold text-[#0a1128] mt-1">{{ $totalFaltas }}</h3>
            </div>
            <div class="bg-white p-5 rounded-3xl border border-slate-200 border-l-4 border-l-amber-500 print-card">
                <p class="text-amber-600 text-xs font-bold uppercase tracking-wider">Atrasos</p>
                <h3 class="text-2xl font-bold text-[#0a1128] mt-1">{{ $totalAtrasos }}</h3>
            </div>
            <div class="bg-blue-600 p-5 rounded-3xl shadow-lg shadow-blue-200 print-card">
                <p class="text-blue-100 text-xs font-bold uppercase tracking-wider">% Assiduidade</p>
                <h3 class="text-2xl font-bold text-white mt-1">{{ $percentual }}%</h3>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden print-card">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                            <th class="px-6 py-4">Data</th>
                            <th class="px-6 py-4">Aluno / Matrícula</th>
                            <th class="px-6 py-4">Vínculos</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Lançamento</th>
                            <th class="px-6 py-4">Observação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-xs lg:text-sm">
                        @forelse($frequencias as $f)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-700">
                                {{ $f->data->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-[#0a1128]">{{ $f->aluno->nome }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $f->aluno->matricula }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="text-slate-600 flex items-center gap-1">
                                        <i class="ti ti-users text-xs"></i> {{ $f->aluno->turma->nome ?? '—' }}
                                    </span>
                                    <span class="text-slate-400 text-[11px] flex items-center gap-1">
                                        <i class="ti ti-building text-xs"></i> {{ $f->aluno->empresa->nome ?? 'Particular' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'presente' => 'bg-emerald-100 text-emerald-700',
                                        'falta' => 'bg-red-100 text-red-700',
                                        'atraso' => 'bg-amber-100 text-amber-700'
                                    ];
                                    $class = $statusClasses[$f->status_presenca] ?? 'bg-slate-100 text-slate-600';
                                @endphp
                                <span class="{{ $class }} px-2.5 py-1 rounded-full text-[10px] font-bold uppercase">
                                    {{ $f->status_presenca }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                <div class="flex items-center gap-1">
                                    <i class="ti ti-user-check opacity-50"></i>
                                    {{ $f->lancadoPor->name ?? '—' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-400 italic max-w-[150px] truncate" title="{{ $f->observacao }}">
                                    {{ $f->observacao ?? '—' }}
                                </p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="ti ti-search-off text-5xl text-slate-200 mb-4"></i>
                                    <p class="text-slate-400 text-lg italic">Nenhum registro encontrado para os filtros aplicados.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="hidden print:block mt-12 border-t pt-8">
            <div class="flex justify-between items-end">
                <div class="text-xs text-slate-400">
                    <p>Rede SENAI de Educação Profissional</p>
                    <p>Sistema de Controle de Frequência - Versão 3.0</p>
                </div>
                <div class="text-center w-64 border-t border-slate-300 pt-2">
                    <p class="text-xs font-bold text-slate-600 uppercase">Assinatura do Responsável</p>
                </div>
            </div>
        </div>

    </main>
</div>

</body>
</html>