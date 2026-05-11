<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saída Antecipada – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .input-focus:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
        }
    </style>
</head>
<body class="text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-[#0a1128] text-white flex flex-col sticky top-0 h-screen">
        <div class="h-24 flex flex-col justify-center px-8 border-b border-white/5">
            <h1 class="text-2xl font-bold tracking-tight">Rede SENAI</h1>
            <p class="text-slate-400 text-[10px] uppercase tracking-widest font-bold">Portal do Docente</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('professor.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-smart-home text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('professor.saidas.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-door-exit text-xl"></i>
                <span class="font-bold">Saídas Antecipadas</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-8 lg:p-12 flex flex-col items-center">

        <div class="w-full max-w-3xl">
            <div class="mb-10 text-center">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-[1.5rem] flex items-center justify-center mx-auto mb-4">
                    <i class="ti ti-file-alert text-3xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-[#0a1128] tracking-tight">Solicitar Saída Antecipada</h2>
                <p class="text-slate-500 mt-2">Informe os dados do aluno para análise da secretaria.</p>
            </div>

            @if($errors->any())
                <div class="mb-8 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-5 flex gap-3 animate-shake">
                    <i class="ti ti-circle-x text-2xl"></i>
                    <ul class="text-sm font-medium">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
                <form method="POST" action="{{ route('professor.saidas.store') }}" class="p-8 lg:p-12 space-y-8">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Selecione o Aluno *</label>
                        <div class="relative">
                            <i class="ti ti-user-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <select name="aluno_id" required
                                    class="w-full bg-slate-50 border-2 border-transparent rounded-2xl pl-12 pr-5 py-4 text-slate-800 outline-none transition-all input-focus appearance-none font-medium">
                                <option value="">Pesquisar por nome ou turma...</option>
                                @foreach($alunos as $aluno)
                                    <option value="{{ $aluno->id }}">{{ $aluno->nome }} — {{ $aluno->turma->nome ?? 'S/ Turma' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Horário Previsto de Saída *</label>
                        <div class="relative">
                            <i class="ti ti-clock-play absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="datetime-local" name="horario_saida" required
                                   class="w-full bg-slate-50 border-2 border-transparent rounded-2xl pl-12 pr-5 py-4 text-slate-800 outline-none transition-all input-focus">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Motivo da Saída *</label>
                        <textarea name="motivo" rows="4" required
                                  placeholder="Ex: Consulta médica agendada ou liberação autorizada pelo responsável..."
                                  class="w-full bg-slate-50 border-2 border-transparent rounded-3xl px-6 py-5 text-slate-800 outline-none transition-all input-focus resize-none leading-relaxed"></textarea>
                    </div>

                    <div class="pt-6 flex flex-col sm:flex-row items-center gap-4">
                        <button type="submit" class="w-full bg-[#0a1128] hover:bg-blue-700 text-white font-bold py-5 rounded-2xl transition shadow-lg shadow-blue-900/10 flex items-center justify-center gap-3 text-lg">
                            <i class="ti ti-send text-xl"></i> Enviar para Secretaria
                        </button>
                        <a href="{{ route('professor.saidas.index') }}" class="text-slate-400 hover:text-slate-600 font-bold text-sm px-6">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

            <div class="mt-10 p-6 bg-blue-50 rounded-3xl border border-blue-100 flex gap-4">
                <i class="ti ti-shield-lock text-2xl text-blue-600"></i>
                <p class="text-xs text-blue-800 leading-relaxed font-medium">
                    <strong>Atenção Docente:</strong> O registro desta saída gera um alerta imediato na Secretaria. O aluno só poderá se ausentar da unidade após a validação oficial no sistema e, se menor de idade, contato com os responsáveis.
                </p>
            </div>
        </div>

    </main>
</div>

</body>
</html>