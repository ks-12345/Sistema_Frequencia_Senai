<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequência: {{ $aluno->nome }} – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-white border-r border-slate-200 flex flex-col sticky top-0 h-screen">
        <div class="h-24 flex items-center px-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                    <i class="ti ti-building-factory-2 text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold leading-tight">Painel Empresa</h1>
                    <p class="text-slate-400 text-[10px] uppercase tracking-widest font-bold">Portal do Parceiro</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-1">
            <a href="{{ route('empresa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition text-slate-500">
                <i class="ti ti-smart-home text-xl"></i>
                <span class="font-medium text-sm">Visão Geral</span>
            </a>
            <a href="{{ route('empresa.frequencia.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-50 text-blue-700 transition">
                <i class="ti ti-users text-xl"></i>
                <span class="font-bold text-sm">Meus Aprendizes</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-8 lg:p-12">

        <div class="flex flex-col lg:flex-row gap-8 mb-10 items-start lg:items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-[2rem] bg-white border-2 border-blue-100 flex items-center justify-center text-3xl text-blue-600 shadow-sm">
                    <i class="ti ti-user-scan"></i>
                </div>
                <div>
                    <a href="{{ route('empresa.frequencia.index') }}" class="text-slate-400 hover:text-blue-600 text-xs font-bold uppercase tracking-widest flex items-center gap-1 mb-1 transition">
                        <i class="ti ti-arrow-left"></i> Voltar à lista
                    </a>
                    <h2 class="text-3xl font-bold text-slate-800 tracking-tight">{{ $aluno->nome }}</h2>
                    <p class="text-slate-500 font-medium italic">Matrícula: {{ $aluno->matricula }}</p>
                </div>
            </div>

            <div class="bg-white px-8 py-4 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-6">
                <div class="relative flex items-center justify-center">
                    <svg class="w-16 h-16 transform -rotate-90">
                        <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="6" fill="transparent" class="text-slate-100" />
                        <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="6" fill="transparent" 
                                stroke-dasharray="{{ (2 * 3.14 * 28) }}" 
                                stroke-dashoffset="{{ (2 * 3.14 * 28) * (1 - $percentual / 100) }}" 
                                class="{{ $percentual >= 75 ? 'text-emerald-500' : 'text-amber-500' }} transition-all duration-1000" />
                    </svg>
                    <span class="absolute text-sm font-bold text-slate-700">{{ $percentual }}%</span>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Assiduidade Total</p>
                    <p class="text-sm font-bold {{ $percentual >= 75 ? 'text-emerald-600' : 'text-amber-600' }}">
                        {{ $percentual >= 75 ? 'Dentro da Meta' : 'Abaixo do Limite' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-700 flex items-center gap-2">
                    <i class="ti ti-list-check text-blue-600"></i> Diário de Frequência Individual
                </h3>
                <span class="text-xs text-slate-400 italic">Exibindo registros mais recentes</span>
            </div>
            
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-50">
                        <th class="px-8 py-5">Data da Aula</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5">Registrado por</th>
                        <th class="px-8 py-5">Observações do Docente</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($frequencias as $frequencia)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <i class="ti ti-calendar text-slate-300"></i>
                                <span class="font-semibold text-slate-700">{{ $frequencia->data->format('d/m/Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            @php
                                $status = strtolower($frequencia->status_presenca);
                                $color = $status == 'presente' ? 'emerald' : ($status == 'falta' ? 'red' : 'amber');
                            @endphp
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-{{ $color }}-50 text-{{ $color }}-700 border border-{{ $color }}-100">
                                <span class="status-dot bg-{{ $color }}-500"></span>
                                {{ ucfirst($frequencia->status_presenca) }}
                            </span>
                        </td>
                        <td class="px-6 py-6 text-sm text-slate-500">
                            <div class="flex items-center gap-2">
                                <i class="ti ti-user-edit opacity-60"></i>
                                {{ $frequencia->lancadoPor->name ?? '—' }}
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @if($frequencia->observacao)
                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs text-slate-600 italic leading-relaxed max-w-xs">
                                    "{{ $frequencia->observacao }}"
                                </div>
                            @else
                                <span class="text-slate-300 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-8 py-6 bg-slate-50/30 border-t border-slate-100">
                {{ $frequencias->links() }}
            </div>
        </div>

        <div class="mt-8 flex items-center gap-6 p-6 rounded-3xl bg-amber-50 border border-amber-100">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="ti ti-alert-triangle"></i>
            </div>
            <p class="text-sm text-amber-800 leading-relaxed">
                <strong>Atenção gestor:</strong> Alunos com frequência abaixo de <strong>75%</strong> podem estar sujeitos à rescisão do contrato de aprendizagem, conforme legislação vigente. Recomendamos o acompanhamento próximo e orientação do aprendiz em caso de faltas sucessivas.
            </p>
        </div>

    </main>
</div>

</body>
</html>