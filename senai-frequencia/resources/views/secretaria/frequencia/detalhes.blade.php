<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Chamada – {{ $turma->nome }} ({{ \Carbon\Carbon::parse($data)->format('d/m/Y') }})</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background: #f8fafc; }</style>
</head>
<body class="text-slate-900">
<div class="min-h-screen p-8 lg:p-12">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <p class="text-blue-600 font-black text-[10px] uppercase tracking-[0.3em] mb-2">Detalhes da chamada</p>
                <h1 class="text-3xl font-black text-[#0a1128]">{{ $turma->nome }}</h1>
                <p class="text-slate-500 mt-2">Data: {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('secretaria.frequencias.turma', $turma) }}" class="bg-white border border-slate-200 px-5 py-3 rounded-2xl text-slate-600 font-black hover:bg-slate-50 transition">Voltar</a>
                <a href="{{ route('secretaria.frequencias.index') }}" class="bg-white border border-slate-200 px-5 py-3 rounded-2xl text-slate-600 font-black hover:bg-slate-50 transition">Turmas</a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 font-bold text-sm">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden mb-8">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400">
                        <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.15em]">Aluno</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em]">Status</th>
                        <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.15em]">Observação</th>
                        <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.15em]">Professor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($frequencias as $frequencia)
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-8 py-5 font-bold text-slate-700">{{ $frequencia->aluno->nome }}</td>
                            <td class="px-6 py-5 uppercase tracking-[0.12em] font-black text-slate-700">{{ str_replace('_', ' ', $frequencia->status_presenca) }}</td>
                            <td class="px-8 py-5 text-slate-500">{{ $frequencia->observacao ?? '—' }}</td>
                            <td class="px-8 py-5 text-slate-500">{{ $frequencia->lancadoPor->name ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @php($status = $frequencias->first()->status)
        @if($status === 'pendente_aprovacao')
            <div class="grid gap-4 lg:grid-cols-[1fr_320px]">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6">
                    <h2 class="text-xl font-black text-[#0a1128] mb-4">Ações da Secretaria</h2>
                    <form method="POST" action="{{ route('secretaria.frequencias.aprovar.data', [$turma, $data]) }}">
                        @csrf
                        @method('PATCH')
                        <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl py-4 font-black uppercase tracking-[0.2em]">Aprovar chamada</button>
                    </form>
                </div>
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6">
                    <h2 class="text-xl font-black text-[#0a1128] mb-4">Devolver para correção</h2>
                    <form method="POST" action="{{ route('secretaria.frequencias.rejeitar.data', [$turma, $data]) }}">
                        @csrf
                        @method('PATCH')
                        <textarea name="motivo" rows="5" required placeholder="Informe o motivo da devolução para o professor" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none mb-4"></textarea>
                        <button class="w-full bg-red-600 hover:bg-red-700 text-white rounded-2xl py-4 font-black uppercase tracking-[0.2em]">Devolver com motivo</button>
                    </form>
                </div>
            </div>
        @else
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 text-slate-600">
                <p class="font-bold">Status da chamada:</p>
                <p class="mt-2 text-sm">{{ str_replace('_', ' ', $status) }}</p>
            </div>
        @endif
    </div>
</div>
</body>
</html>
