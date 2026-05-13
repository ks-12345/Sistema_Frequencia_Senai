<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequência: {{ $aluno->nome }} – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .sidebar-item:hover { background: rgba(255, 255, 255, 0.05); }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
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

        <div class="p-6 border-t border-white/5">
            <div class="bg-white/5 rounded-2xl p-4 flex items-center gap-3 border border-white/5">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center font-bold shadow-lg">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="truncate">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest text-left">Empresa</p>
                    <p class="text-xs font-bold text-white truncate text-left">{{ Auth::user()->name }}</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-8 lg:p-12">

        <div class="flex flex-col lg:flex-row gap-8 mb-10 items-start lg:items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-[2.5rem] bg-[#0a1128] flex items-center justify-center text-4xl text-white shadow-xl shadow-blue-900/20">
                    <i class="ti ti-user-scan"></i>
                </div>
                <div>
                    <a href="{{ route('empresa.alunos.index') }}" class="text-blue-600 hover:text-blue-800 text-[10px] font-black uppercase tracking-[0.2em] flex items-center gap-1 mb-2 transition">
                        <i class="ti ti-arrow-narrow-left text-lg"></i> Voltar aos Aprendizes
                    </a>
                    <h2 class="text-4xl font-black text-[#0a1128] tracking-tight">{{ $aluno->nome }}</h2>
                    <p class="text-slate-400 font-bold mt-1 tracking-wide">ID Matrícula: <span class="text-slate-600">{{ $aluno->matricula }}</span></p>
                </div>
            </div>

            <div class="bg-white px-10 py-6 rounded-[2.5rem] border border-slate-200 shadow-sm flex items-center gap-8 group transition-all hover:border-blue-300">
                <div class="relative flex items-center justify-center">
                    <svg class="w-20 h-20 transform -rotate-90">
                        <circle cx="40" cy="40" r="34" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-100" />
                        <circle cx="40" cy="40" r="34" stroke="currentColor" stroke-width="8" fill="transparent" 
                                stroke-dasharray="{{ (2 * 3.14 * 34) }}" 
                                stroke-dashoffset="{{ (2 * 3.14 * 34) * (1 - $percentual / 100) }}" 
                                stroke-linecap="round"
                                class="{{ $percentual >= 75 ? 'text-emerald-500' : 'text-red-500' }} transition-all duration-1000" />
                    </svg>
                    <span class="absolute text-sm font-black text-slate-800">{{ $percentual }}%</span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Taxa de Assiduidade</p>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter {{ $percentual >= 75 ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-red-50 text-red-600 border border-red-100' }}">
                        <i class="ti {{ $percentual >= 75 ? 'ti-circle-check' : 'ti-alert-circle' }}"></i>
                        {{ $percentual >= 75 ? 'Dentro da Meta' : 'Abaixo do Limite' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
            <div class="p-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-black text-[#0a1128] uppercase tracking-widest text-xs flex items-center gap-2">
                    <i class="ti ti-list-check text-blue-600 text-lg"></i> Detalhamento de Frequência
                </h3>
                <span class="text-[10px] font-bold text-slate-400 italic">Dados sincronizados com o diário docente</span>
            </div>
            
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[11px] font-black text-slate-400 uppercase tracking-wider border-b border-slate-50">
                        <th class="px-8 py-5">Data da Aula</th>
                        <th class="px-6 py-5">Status de Presença</th>
                        <th class="px-6 py-5">Docente Responsável</th>
                        <th class="px-8 py-5">Observações Internas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($frequencias as $frequencia)
                    @php
                        $status = strtolower($frequencia->status_presenca);
                        $colorClass = $status == 'presente' ? 'emerald' : ($status == 'falta' ? 'red' : 'amber');
                    @endphp
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                                <span class="font-bold text-slate-700">{{ $frequencia->data->format('d/m/Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase bg-{{ $colorClass }}-50 text-{{ $colorClass }}-700 border border-{{ $colorClass }}-100/50">
                                <span class="status-dot bg-{{ $colorClass }}-500"></span>
                                {{ $frequencia->status_presenca }}
                            </span>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                                <i class="ti ti-certificate opacity-30 text-lg"></i>
                                {{ $frequencia->lancadoPor->name ?? '—' }}
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @if($frequencia->observacao)
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-[11px] text-slate-500 italic leading-relaxed max-w-sm">
                                    "{{ $frequencia->observacao }}"
                                </div>
                            @else
                                <span class="text-slate-300 text-xs font-bold uppercase tracking-widest italic">— Sem registros</span>
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

        <div class="mt-8 flex items-center gap-8 p-8 rounded-[2.5rem] bg-[#0a1128] border border-blue-900 shadow-2xl shadow-blue-900/20 relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-24 bg-white/5 skew-x-[-20deg] translate-x-12"></div>
            <div class="w-16 h-16 rounded-[1.5rem] bg-blue-600 text-white flex items-center justify-center text-3xl flex-shrink-0 shadow-lg">
                <i class="ti ti-gavel"></i>
            </div>
            <div class="relative z-10">
                <h4 class="text-white font-black uppercase tracking-widest text-xs mb-1">Nota de Compliance e Legislação</h4>
                <p class="text-blue-100/70 text-xs leading-relaxed max-w-3xl">
                    Conforme o Art. 433 da CLT e normativas do programa de aprendizagem, a frequência escolar e técnica é requisito obrigatório para a manutenção do contrato. Aprendizes com assiduidade inferior a <strong>75%</strong> sem justificativa legal estão sujeitos a desligamento administrativo.
                </p>
            </div>
        </div>

        <footer class="mt-12 text-center text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">
            Portal de Transparência SENAI Corporate — Gestão de Capital Humano
        </footer>

    </main>
</div>

</body>
</html>