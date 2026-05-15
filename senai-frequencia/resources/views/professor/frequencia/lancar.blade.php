<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançar Frequência – {{ $turma->nome }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .select-custom {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d=' immigration 19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
        }
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-2xl font-bold tracking-tight">Rede SENAI</h1>
            <p class="text-slate-400 text-xs mt-1">Portal do Docente</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('professor.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-layout-dashboard text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('professor.frequencia.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-checklist text-xl"></i>
                <span class="font-medium">Chamada Diária</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-8 lg:p-12">

        <form method="POST" action="{{ route('professor.frequencia.store') }}">
            @csrf
            <input type="hidden" name="turma_id" value="{{ $turma->id }}">

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
                <div>
                    <div class="flex items-center gap-2 text-blue-600 font-bold text-xs uppercase tracking-widest mb-2">
                        <i class="ti ti-clipboard-check"></i> Registro de Presença
                    </div>
                    <h2 class="text-3xl font-bold text-[#0a1128] tracking-tight">{{ $turma->nome }}</h2>
                    <p class="text-slate-500 text-sm mt-1">Marque a presença dos alunos para a aula de hoje.</p>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="relative w-full sm:w-48">
                        <label class="absolute -top-2 left-3 bg-white px-1 text-[10px] font-bold text-slate-400 uppercase">Data da Aula</label>
                        <input type="date" name="data" value="{{ $data }}" required
                               class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:border-blue-500 transition-all">
                    </div>
                    <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3.5 rounded-2xl transition shadow-lg shadow-emerald-900/10 flex items-center justify-center gap-2">
                        <i class="ti ti-device-floppy text-xl"></i> Salvar Chamada
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 flex items-center gap-3">
                    <i class="ti ti-circle-check text-xl"></i>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-8 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-4">
                    <p class="font-bold text-sm mb-1">Revise os dados da chamada</p>
                    @foreach($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Aprendiz</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Matrícula</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Status de Presença</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Observações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($alunos as $aluno)
                        <tr class="group hover:bg-blue-50/30 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xs group-hover:bg-white transition-colors">
                                        {{ substr($aluno->nome, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-700 group-hover:text-blue-700 transition-colors">{{ $aluno->nome }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-xs font-mono text-slate-400 bg-slate-50 px-2 py-1 rounded-md">{{ $aluno->matricula }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <select name="frequencias[{{ $aluno->id }}]" required
                                        class="select-custom w-full sm:w-40 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm font-semibold outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all cursor-pointer">
                                    <option value="presente" class="text-emerald-600 font-bold">🟢 Presente</option>
                                    <option value="falta" class="text-red-600 font-bold">🔴 Falta</option>
                                    <option value="atraso" class="text-amber-600 font-bold">🟡 Atraso</option>
                                    <option value="saida_antecipada" class="text-blue-600 font-bold">Saida antecipada</option>
                                </select>
                            </td>
                            <td class="px-8 py-5">
                                <input type="text" name="observacoes[{{ $aluno->id }}]" placeholder="Nota opcional..."
                                       class="w-full bg-slate-50 border border-transparent rounded-xl px-4 py-2 text-sm text-slate-600 placeholder:text-slate-300 outline-none focus:bg-white focus:border-slate-200 transition-all italic">
                                <div class="saida-fields mt-3 hidden rounded-2xl border border-blue-100 bg-blue-50/60 p-4" data-aluno="{{ $aluno->id }}">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest text-blue-500 mb-1">Horario da saida</label>
                                            <input type="time" name="saida_horario[{{ $aluno->id }}]"
                                                   class="w-full rounded-xl border border-blue-100 bg-white px-3 py-2 text-sm text-slate-700 outline-none focus:border-blue-400">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest text-blue-500 mb-1">Justificativa no momento</label>
                                            <select name="saida_apresentou_justificativa[{{ $aluno->id }}]"
                                                    class="w-full rounded-xl border border-blue-100 bg-white px-3 py-2 text-sm text-slate-700 outline-none focus:border-blue-400">
                                                <option value="0">Nao apresentou</option>
                                                <option value="1">Apresentou</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-blue-500 mb-1">Motivo informado pelo aluno</label>
                                        <input type="text" name="saida_motivo[{{ $aluno->id }}]" placeholder="Ex: consulta medica, emergencia familiar..."
                                               class="w-full rounded-xl border border-blue-100 bg-white px-3 py-2 text-sm text-slate-700 outline-none focus:border-blue-400">
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-blue-500 mb-1">Observacao adicional</label>
                                        <textarea name="saida_observacoes[{{ $aluno->id }}]" rows="2"
                                                  class="w-full rounded-xl border border-blue-100 bg-white px-3 py-2 text-sm text-slate-700 outline-none focus:border-blue-400"></textarea>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex items-center justify-between px-4">
                <a href="{{ route('professor.frequencia.index') }}" class="text-slate-400 hover:text-slate-600 font-bold text-sm flex items-center gap-2">
                    <i class="ti ti-arrow-left"></i> Cancelar e Voltar
                </a>
                <p class="text-xs text-slate-400 italic">
                    * Todos os registros são salvos com seu carimbo de data e hora de usuário.
                </p>
            </div>
        </form>

    </main>
</div>

<script>
    document.querySelectorAll('select[name^="frequencias"]').forEach((select) => {
        const toggleFields = () => {
            const match = select.name.match(/\[(\d+)\]/);
            if (!match) return;

            const fields = document.querySelector(`.saida-fields[data-aluno="${match[1]}"]`);
            if (!fields) return;

            fields.classList.toggle('hidden', select.value !== 'saida_antecipada');
        };

        select.addEventListener('change', toggleFields);
        toggleFields();
    });
</script>
</body>
</html>
