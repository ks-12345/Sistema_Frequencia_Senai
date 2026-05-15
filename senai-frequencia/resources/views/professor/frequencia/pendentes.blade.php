<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequências Pendentes – SENAI</title>

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
            <h1 class="text-2xl font-bold tracking-tight text-white">Rede SENAI</h1>
            <p class="text-slate-400 text-[10px] uppercase tracking-widest font-bold">Portal do Docente</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('professor.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-layout-dashboardhboard text-xl"></i>
                <span class="font-medium">Início</span>
            </a>
            <a href="{{ route('professor.frequencia.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600/10 text-blue-400 border border-blue-500/20 shadow-lg">
                <i class="ti ti-checklist text-xl"></i>
                <span class="font-bold">Frequências</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-8 lg:p-12">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <div class="flex items-center gap-2 text-amber-600 font-bold text-xs uppercase tracking-widest mb-2">
                    <i class="ti ti-hourglass-low-full"></i> Aguardando Revisão
                </div>
                <h2 class="text-3xl font-bold text-[#0a1128] tracking-tight">Frequências Pendentes</h2>
                <p class="text-slate-500 mt-1">Valide os registros de presença submetidos para aprovação final.</p>
            </div>
            <a href="{{ route('professor.frequencia.index') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm text-sm">
                <i class="ti ti-arrow-left"></i> Voltar
            </a>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 flex items-center gap-3 shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
                <i class="ti ti-circle-check-filled text-xl"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if($frequencias->isEmpty())
            <div class="bg-white rounded-[2.5rem] border-2 border-dashed border-slate-200 p-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-6">
                    <i class="ti ti-mood-smile text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Tudo em dia!</h3>
                <p class="text-slate-400 mt-2">Nenhuma frequência pendente de aprovação no momento.</p>
            </div>
        @else
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Data</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Aluno / Turma</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">Status Lançado</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Lançador</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-right">Decisão</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($frequencias as $frequencia)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <i class="ti ti-calendar-event text-blue-500"></i>
                                    <span class="font-bold text-slate-700">{{ $frequencia->data->format('d/m/Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div>
                                    <p class="font-bold text-slate-800">{{ $frequencia->aluno->nome }}</p>
                                    <p class="text-xs text-blue-600 font-medium">{{ $frequencia->aluno->turma->nome }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-center">
                                @php
                                    $status = strtolower($frequencia->status_presenca);
                                    $colorClass = $status === 'presente' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 
                                                 ($status === 'falta' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-amber-50 text-amber-600 border-amber-100');
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border {{ $colorClass }}">
                                    {{ ucfirst($frequencia->status_presenca) }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-2 text-sm text-slate-500 italic">
                                    <i class="ti ti-user-share opacity-40"></i>
                                    {{ $frequencia->lancadoPor->name }}
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('professor.frequencia.aprovar', $frequencia) }}">
                                        @csrf @method('PATCH')
                                        <button class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center shadow-sm" title="Aprovar">
                                            <i class="ti ti-check text-xl"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('professor.frequencia.rejeitar', $frequencia) }}">
                                        @csrf @method('PATCH')
                                        <button onclick="return confirm('Deseja realmente rejeitar este lançamento?')" 
                                                class="w-10 h-10 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all flex items-center justify-center shadow-sm" title="Rejeitar">
                                            <i class="ti ti-x text-xl"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-8 flex items-center gap-4 p-6 bg-blue-50 rounded-3xl border border-blue-100">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shrink-0">
                <i class="ti ti-info-square-rounded text-xl"></i>
            </div>
            <p class="text-xs text-blue-800 leading-relaxed max-w-2xl">
                <strong>Dica de Fluxo:</strong> Registros pendentes geralmente ocorrem quando monitores ou estagiários realizam o lançamento inicial. Sua aprovação confirma o dado no prontuário oficial do aluno e envia a atualização para a empresa parceira.
            </p>
        </div>

    </main>
</div>

</body>
</html>