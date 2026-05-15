<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Frequências – {{ $turma->nome }}</title>
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
                <p class="text-blue-600 font-black text-[10px] uppercase tracking-[0.3em] mb-2">Turma</p>
                <h1 class="text-3xl font-black text-[#0a1128]">{{ $turma->nome }}</h1>
                <p class="text-slate-500 mt-2">{{ $turma->curso }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('secretaria.frequencias.index') }}" class="bg-white border border-slate-200 px-5 py-3 rounded-2xl text-slate-600 font-black hover:bg-slate-50 transition">Voltar para turmas</a>
                <a href="{{ route('secretaria.frequencias.turma', $turma) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-black">Atualizar lista</a>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 mb-8">
            @foreach(['pendente_aprovacao' => 'Pendentes', 'aprovado' => 'Aprovadas', 'devolvido_correcao' => 'Devolvidas', '' => 'Todos'] as $key => $label)
                <a href="{{ route('secretaria.frequencias.turma', [$turma, 'status' => $key]) }}" class="px-4 py-3 rounded-2xl {{ $status === $key ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }} text-xs font-black uppercase tracking-widest">{{ $label }}</a>
            @endforeach
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 font-bold text-sm">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400">
                        <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.15em]">Data</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em] text-center">Total</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em] text-center">Presentes</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em] text-center">Faltas</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em] text-center">Atrasos</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em] text-center">Saídas</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-[0.15em] text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.15em] text-right">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($registros as $registro)
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-8 py-5 font-bold text-slate-700">{{ \Carbon\Carbon::parse($registro->data)->format('d/m/Y') }}</td>
                            <td class="px-6 py-5 text-center font-semibold text-slate-700">{{ $registro->total }}</td>
                            <td class="px-6 py-5 text-center text-emerald-600 font-bold">{{ $registro->presentes }}</td>
                            <td class="px-6 py-5 text-center text-red-600 font-bold">{{ $registro->faltas }}</td>
                            <td class="px-6 py-5 text-center text-amber-600 font-bold">{{ $registro->atrasos }}</td>
                            <td class="px-6 py-5 text-center text-blue-600 font-bold">{{ $registro->saidas }}</td>
                            <td class="px-6 py-5 text-center uppercase tracking-[0.12em] font-black text-slate-600">{{ str_replace('_', ' ', $registro->pendentes ? 'pendente_aprovacao' : ($registro->devolvidos ? 'devolvido_correcao' : 'aprovado')) }}</td>
                            <td class="px-8 py-5 text-right">
                                <a href="{{ route('secretaria.frequencias.detalhes', [$turma, $registro->data]) }}" class="inline-flex items-center gap-2 text-sm font-black text-blue-600 hover:text-blue-800">Abrir <i class="ti ti-arrow-right"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-8 py-16 text-center text-slate-400 font-bold">Nenhum registro de frequência encontrado para esta turma.</td>
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
