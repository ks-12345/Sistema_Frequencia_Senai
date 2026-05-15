<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequencias - {{ $turma->nome }}</title>
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
                <p class="text-blue-600 font-black text-[10px] uppercase tracking-[0.3em] mb-2">Historico por turma</p>
                <h1 class="text-3xl font-black text-[#0a1128]">{{ $turma->nome }}</h1>
                <p class="text-slate-500 mt-2">{{ $turma->curso }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('professor.frequencia.lancar', $turma) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-bold flex items-center gap-2">
                    <i class="ti ti-plus"></i> Nova chamada
                </a>
                <a href="{{ route('professor.frequencia.index') }}" class="bg-white border border-slate-200 px-5 py-3 rounded-2xl font-bold text-slate-600">
                    Voltar
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-black uppercase tracking-widest text-slate-400">
                        <th class="px-8 py-5">Data</th>
                        <th class="px-6 py-5 text-center">Total</th>
                        <th class="px-6 py-5 text-center">Presentes</th>
                        <th class="px-6 py-5 text-center">Faltas</th>
                        <th class="px-6 py-5 text-center">Atrasos</th>
                        <th class="px-6 py-5 text-center">Saidas</th>
                        <th class="px-8 py-5 text-right">Acao</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($registros as $registro)
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-8 py-5 font-black text-[#0a1128]">{{ \Carbon\Carbon::parse($registro->data)->format('d/m/Y') }}</td>
                            <td class="px-6 py-5 text-center font-bold">{{ $registro->total }}</td>
                            <td class="px-6 py-5 text-center text-emerald-600 font-bold">{{ $registro->presentes }}</td>
                            <td class="px-6 py-5 text-center text-red-600 font-bold">{{ $registro->faltas }}</td>
                            <td class="px-6 py-5 text-center text-amber-600 font-bold">{{ $registro->atrasos }}</td>
                            <td class="px-6 py-5 text-center text-blue-600 font-bold">{{ $registro->saidas }}</td>
                            <td class="px-8 py-5 text-right">
<a href="{{ route('professor.frequencia.editar', [$turma, \Carbon\Carbon::parse($registro->data)->format('Y-m-d')]) }}" class="inline-flex items-center gap-2 text-sm font-black text-blue-600 hover:text-blue-800">
                                    Editar <i class="ti ti-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-8 py-16 text-center text-slate-400 font-bold">Nenhuma frequencia lancada para esta turma.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $registros->links() }}</div>
    </div>
</div>
</body>
</html>
