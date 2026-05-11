<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Turma – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fb; }
        .input-focus:focus {
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            border-color: #3b82f6;
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

            <a href="{{ route('admin.turmas.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-users text-xl"></i>
                <span class="font-medium">Turmas</span>
            </a>
    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">
            <div>
                <div class="flex items-center gap-3 mb-2 text-blue-600 font-bold text-sm uppercase tracking-widest">
                    <i class="ti ti-plus"></i> Cadastro de Unidade
                </div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Nova Turma</h1>
                <p class="text-slate-500 mt-2">Preencha os dados abaixo para abrir uma nova turma no sistema.</p>
            </div>
            <a href="{{ route('admin.turmas.index') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                <i class="ti ti-arrow-left"></i> Voltar para Lista
            </a>
        </div>

        @if($errors->any())
            <div class="mb-8 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-5">
                <div class="flex items-center gap-2 font-bold mb-2 text-red-800">
                    <i class="ti ti-alert-circle"></i> Ocorreram alguns problemas:
                </div>
                <ul class="list-disc list-inside text-sm opacity-80">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="max-w-4xl bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-xl font-bold text-[#0a1128]">Configurações da Turma</h2>
            </div>

            <form method="POST" action="{{ route('admin.turmas.store') }}" class="p-8 space-y-8">
                @csrf 

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Nome da Turma</label>
                        <input type="text" name="nome" value="{{ old('nome') }}" required
                               placeholder="Ex: TI-2026-MANHÃ-A"
                               class="input-focus bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Período</label>
                        <input type="text" name="periodo" value="{{ old('periodo') }}" required
                               placeholder="Ex: Manhã, Tarde ou Noite"
                               class="input-focus bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Curso</label>
                        <input type="text" name="curso" value="{{ old('curso') }}" required
                               placeholder="Ex: Técnico em Desenvolvimento de Sistemas"
                               class="input-focus bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Professor Responsável</label>
                        <div class="relative">
                            <select name="professor_id" required
                                    class="w-full bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none focus:ring-2 ring-blue-500/20 transition appearance-none">
                                <option value="">Selecione o professor para esta turma...</option>
                                @foreach($professores as $professor)
                                    <option value="{{ $professor->id }}" {{ old('professor_id') == $professor->id ? 'selected' : '' }}>
                                        {{ $professor->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="ti ti-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>

                </div>

                <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-4">
                    <button type="reset" class="px-8 py-3.5 rounded-2xl font-bold text-slate-400 hover:text-slate-600 transition">
                        Limpar Campos
                    </button>
                    <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-10 py-3.5 rounded-2xl transition shadow-lg shadow-emerald-100 flex items-center gap-2">
                        <i class="ti ti-check text-xl"></i> Cadastrar Turma
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

</body>
</html>