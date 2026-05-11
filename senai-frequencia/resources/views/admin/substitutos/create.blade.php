<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Substituto – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fb; }
        .input-focus:focus {
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
            border-color: #f59e0b;
        }
    </style>
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
                <i class="ti ti-layout-grid text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('admin.substitutos.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-amber-600 text-white shadow-lg shadow-amber-900/20">
                <i class="ti ti-user-replace text-xl"></i>
                <span class="font-medium">Substitutos</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">
            <div>
                <div class="flex items-center gap-2 text-amber-600 font-bold text-sm uppercase tracking-widest mb-2">
                    <i class="ti ti-shield-lock"></i> Segurança & Acesso
                </div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Gerar Acesso Temporário</h1>
                <p class="text-slate-500 mt-2">Crie credenciais de curta duração para professores substitutos.</p>
            </div>
            <a href="{{ route('admin.substitutos.index') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                <i class="ti ti-arrow-left"></i> Voltar
            </a>
        </div>

        @if($errors->any())
            <div class="mb-8 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-5 flex gap-4">
                <i class="ti ti-circle-x-filled text-2xl"></i>
                <ul class="list-disc list-inside text-sm font-medium">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="max-w-4xl bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            
            <div class="p-8 border-b border-slate-100 bg-amber-50/30 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-[#0a1128]">Configuração da Credencial</h2>
                    <p class="text-slate-400 text-sm">O sistema revogará o acesso automaticamente após o prazo.</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i class="ti ti-clock-bolt text-2xl"></i>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.substitutos.store') }}" class="p-8 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Nome do Professor Substituto *</label>
                        <div class="relative">
                            <i class="ti ti-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="nome" value="{{ old('nome') }}" required
                                   placeholder="Nome completo do docente"
                                   class="input-focus w-full bg-slate-100 border-2 border-transparent rounded-2xl pl-12 pr-5 py-3.5 text-slate-800 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Turma Vinculada *</label>
                        <div class="relative">
                            <select name="turma_id" required
                                    class="w-full bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none focus:ring-2 ring-amber-500/20 transition appearance-none">
                                <option value="">Selecione a turma...</option>
                                @foreach($turmas as $turma)
                                    <option value="{{ $turma->id }}" {{ old('turma_id') == $turma->id ? 'selected' : '' }}>
                                        {{ $turma->nome }} – Prof. {{ $turma->professor->name ?? '?' }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="ti ti-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Válido até *</label>
                        <div class="relative">
                            <i class="ti ti-calendar-time absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="datetime-local" name="expira_em" value="{{ old('expira_em') }}" required
                                   class="input-focus w-full bg-slate-100 border-2 border-transparent rounded-2xl pl-12 pr-5 py-3.5 text-slate-800 outline-none transition-all">
                        </div>
                    </div>

                </div>

                <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-4">
                    <button type="reset" class="px-6 py-3 rounded-xl font-bold text-slate-400 hover:text-slate-600 transition">
                        Limpar
                    </button>
                    <button type="submit"
                            class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-10 py-4 rounded-2xl transition shadow-lg shadow-amber-100 flex items-center gap-3">
                        <i class="ti ti-key text-2xl"></i> Gerar Credenciais
                    </button>
                </div>
            </form>
        </div>

        <div class="max-w-4xl mt-8 p-6 bg-slate-800 rounded-3xl text-white flex items-start gap-4">
            <div class="bg-white/10 p-2 rounded-lg">
                <i class="ti ti-info-square text-amber-400 text-xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm">Como funciona o acesso substituto?</h4>
                <p class="text-slate-400 text-xs mt-1 leading-relaxed">
                    O professor substituto receberá um link ou código temporário. Ele terá permissão apenas para registrar frequência e conteúdos no diário da turma selecionada. Todos os registros serão marcados como realizados por "Substituto" para fins de auditoria.
                </p>
            </div>
        </div>

    </main>
</div>

</body>
</html>