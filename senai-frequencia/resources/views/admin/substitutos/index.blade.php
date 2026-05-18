<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Substituicoes - SENAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background: #f4f7fb; }</style>
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
                <i class="ti ti-layout-grid text-xl"></i><span class="font-medium">Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-user-share text-xl"></i><span class="font-medium">Substituicoes</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">
            <div>
                <h1 class="text-4xl font-black text-[#0a1128] tracking-tight">Substituicoes docentes</h1>
                <p class="text-slate-500 mt-2">Auditoria, filtros e exportacao Excel das atuacoes como substituto.</p>
            </div>
            <a href="{{ route('admin.substitutos.export', request()->query()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-emerald-100 transition flex items-center gap-2">
                <i class="ti ti-file-spreadsheet"></i> Exportar XLSX
            </a>
        </div>

        <form method="GET" action="{{ route('admin.substitutos.index') }}" class="bg-white border border-slate-200 rounded-[2rem] p-6 mb-8 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-7 gap-4">
                <select name="teacher_id" class="bg-slate-100 rounded-xl border-0 px-4 py-3 text-sm">
                    <option value="">Substituto</option>
                    @foreach($professores as $professor)
                        <option value="{{ $professor->id }}" @selected(($filters['teacher_id'] ?? '') == $professor->id)>{{ $professor->name }}</option>
                    @endforeach
                </select>
                <select name="substituted_teacher_id" class="bg-slate-100 rounded-xl border-0 px-4 py-3 text-sm">
                    <option value="">Titular</option>
                    @foreach($professores as $professor)
                        <option value="{{ $professor->id }}" @selected(($filters['substituted_teacher_id'] ?? '') == $professor->id)>{{ $professor->name }}</option>
                    @endforeach
                </select>
                <select name="turma_id" class="bg-slate-100 rounded-xl border-0 px-4 py-3 text-sm">
                    <option value="">Turma</option>
                    @foreach($turmas as $turma)
                        <option value="{{ $turma->id }}" @selected(($filters['turma_id'] ?? '') == $turma->id)>{{ $turma->nome }}</option>
                    @endforeach
                </select>
                <input type="text" name="disciplina" value="{{ $filters['disciplina'] ?? '' }}" placeholder="Disciplina" class="bg-slate-100 rounded-xl border-0 px-4 py-3 text-sm">
                <select name="status" class="bg-slate-100 rounded-xl border-0 px-4 py-3 text-sm">
                    <option value="">Status</option>
                    <option value="ativa" @selected(($filters['status'] ?? '') === 'ativa')>Ativa</option>
                    <option value="encerrada" @selected(($filters['status'] ?? '') === 'encerrada')>Encerrada</option>
                    <option value="cancelada" @selected(($filters['status'] ?? '') === 'cancelada')>Cancelada</option>
                </select>
                <input type="date" name="data_inicio" value="{{ $filters['data_inicio'] ?? '' }}" class="bg-slate-100 rounded-xl border-0 px-4 py-3 text-sm">
                <input type="date" name="data_fim" value="{{ $filters['data_fim'] ?? '' }}" class="bg-slate-100 rounded-xl border-0 px-4 py-3 text-sm">
            </div>
            <div class="mt-5 flex justify-end gap-3">
                <a href="{{ route('admin.substitutos.index') }}" class="px-5 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-50">Limpar</a>
                <button class="bg-[#0a1128] hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2">
                    <i class="ti ti-filter"></i> Filtrar
                </button>
            </div>
        </form>

        <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-100 bg-slate-50">
                            <th class="px-6 py-4">Substituto</th>
                            <th class="px-6 py-4">Titular</th>
                            <th class="px-6 py-4">Turma</th>
                            <th class="px-6 py-4">Disciplina</th>
                            <th class="px-6 py-4">Inicio</th>
                            <th class="px-6 py-4">Fim</th>
                            <th class="px-6 py-4">Horas</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($logs as $log)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 font-bold text-slate-700">{{ $log->substituteTeacher->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $log->substitutedTeacher->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $log->turma->nome ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $log->turma->curso ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $log->started_at?->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $log->ended_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $log->total_hours ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $log->status === 'ativa' ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="px-6 py-12 text-center text-slate-400 font-bold">Nenhuma substituicao encontrada.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-slate-100">
                {{ $logs->links() }}
            </div>
        </div>
    </main>
</div>
</body>
</html>
