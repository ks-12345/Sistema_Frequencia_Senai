<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Frequencia - {{ $turma->nome }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background: #f8fafc; }</style>
</head>
<body class="text-slate-900">
<div class="min-h-screen p-8 lg:p-12">
    <div class="max-w-6xl mx-auto">
        <form method="POST" action="{{ route('professor.frequencia.atualizar', [$turma, $data]) }}">
            @csrf
            @method('PUT')

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                <div>
                    <p class="text-blue-600 font-black text-[10px] uppercase tracking-[0.3em] mb-2">Editar chamada</p>
                    <h1 class="text-3xl font-black text-[#0a1128]">{{ $turma->nome }}</h1>
                    <p class="text-slate-500 mt-2">Data: {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" name="acao" value="salvar" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-black flex items-center gap-2">
                        <i class="ti ti-device-floppy"></i> Salvar alteracoes
                    </button>
                    <button type="submit" name="acao" value="enviar" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-black flex items-center gap-2">
                        <i class="ti ti-send"></i> Enviar para Secretaria
                    </button>
                    <a href="{{ route('professor.frequencia.historico', $turma) }}" class="bg-white border border-slate-200 px-5 py-3 rounded-2xl font-bold text-slate-600">
                        Voltar
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-4 text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-black uppercase tracking-widest text-slate-400">
                            <th class="px-8 py-5">Aluno</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-8 py-5">Observacao</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($alunos as $aluno)
                            @php($frequencia = $frequencias->get($aluno->id))
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="px-8 py-5">
                                    <p class="font-black text-[#0a1128]">{{ $aluno->nome }}</p>
                                    <p class="text-xs text-slate-400 font-mono">{{ $aluno->matricula }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <select name="frequencias[{{ $aluno->id }}]" class="w-full max-w-xs rounded-xl border border-slate-200 px-4 py-2 text-sm font-bold outline-none focus:border-blue-400">
                                        @foreach(['presente' => 'Presente', 'falta' => 'Falta', 'atraso' => 'Atraso', 'saida_antecipada' => 'Saida antecipada'] as $value => $label)
                                            <option value="{{ $value }}" @selected(old('frequencias.'.$aluno->id, $frequencia->status_presenca ?? 'presente') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-8 py-5">
                                    <input type="text" name="observacoes[{{ $aluno->id }}]" value="{{ old('observacoes.'.$aluno->id, $frequencia->observacao ?? '') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm outline-none focus:border-blue-400" placeholder="Observacao opcional...">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
</body>
</html>
