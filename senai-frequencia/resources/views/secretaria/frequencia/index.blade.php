<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turmas – Secretaria</title>
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
            <p class="text-slate-400 text-[10px] uppercase tracking-widest font-black">Fluxo de Frequências</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('secretaria.saidas.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl bg-white text-slate-700 hover:bg-slate-50 transition">
                <i class="ti ti-door-exit text-xl"></i>
                <span class="font-bold">Saídas Antecipadas</span>
            </a>
            <a href="{{ route('secretaria.frequencias.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/40">
                <i class="ti ti-checklist text-xl"></i>
                <span class="font-bold">Frequências</span>
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
                <h1 class="text-4xl font-black text-[#0a1128] tracking-tight">Aprovação por turma</h1>
                <p class="text-slate-500 mt-2">Selecione a turma para ver o histórico de frequência e aprovar a chamada inteira.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 font-bold text-sm">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-400">
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em]">Turma</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em]">Curso</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em]">Alunos</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em]">Pendentes</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em]">Aprovadas</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em]">Última chamada</th>
                        <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.15em] text-right">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($turmas as $turma)
                        @php($meta = $resumo[$turma->id] ?? null)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-5 font-bold text-slate-700">{{ $turma->nome }}</td>
                            <td class="px-6 py-5 text-slate-500">{{ $turma->curso }}</td>
                            <td class="px-6 py-5 text-slate-500">{{ $turma->alunos_count }}</td>
                            <td class="px-6 py-5 text-amber-600 font-black">{{ $meta->pendentes ?? 0 }}</td>
                            <td class="px-6 py-5 text-emerald-600 font-black">{{ $meta->aprovadas ?? 0 }}</td>
                            <td class="px-6 py-5 text-slate-500">{{ $meta?->ultima_data ? \Carbon\Carbon::parse($meta->ultima_data)->format('d/m/Y') : 'Nenhuma' }}</td>
                            <td class="px-8 py-5 text-right">
                                <a href="{{ route('secretaria.frequencias.turma', $turma) }}" class="inline-flex items-center gap-2 text-sm font-black text-blue-600 hover:text-blue-800">
                                    Ver histórico <i class="ti ti-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-bold">Nenhuma turma encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
