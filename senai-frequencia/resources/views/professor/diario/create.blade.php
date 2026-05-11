<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Aula – {{ $turma->nome }}</title>

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
            <p class="text-slate-400 text-xs mt-1">Portal do Docente</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('professor.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-smart-home text-xl"></i>
                <span class="font-medium">Início</span>
            </a>
            <a href="{{ route('professor.diario.turma', $turma) }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-book text-xl"></i>
                <span class="font-medium">Diário da Turma</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">
            <div>
                <div class="flex items-center gap-2 text-blue-600 font-bold text-sm uppercase tracking-widest mb-2">
                    <i class="ti ti-pencil"></i> Planejamento & Registro
                </div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Registrar Aula</h1>
                <div class="flex items-center gap-3 mt-3">
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase">{{ $turma->nome }}</span>
                    <span class="text-slate-500 text-sm italic">{{ $turma->curso }}</span>
                </div>
            </div>
            <a href="{{ route('professor.diario.turma', $turma) }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                <i class="ti ti-arrow-left"></i> Voltar ao Diário
            </a>
        </div>

        @if($errors->any())
            <div class="mb-8 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-5 flex gap-4">
                <i class="ti ti-alert-circle text-2xl"></i>
                <ul class="list-disc list-inside text-sm font-medium">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="max-w-5xl bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            
            <form method="POST" action="{{ route('professor.diario.store', $turma) }}" class="p-8 lg:p-12 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Número da Aula *</label>
                        <div class="relative">
                            <i class="ti ti-list-numbers absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="number" name="aula_numero" value="{{ old('aula_numero', $proximaAula) }}" min="1" required
                                   class="input-focus w-full bg-slate-50 border-2 border-transparent rounded-2xl pl-12 pr-5 py-4 text-slate-800 outline-none transition-all font-bold">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Data da Realização *</label>
                        <div class="relative">
                            <i class="ti ti-calendar-event absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="date" name="data" value="{{ old('data', today()->toDateString()) }}" required
                                   class="input-focus w-full bg-slate-50 border-2 border-transparent rounded-2xl pl-12 pr-5 py-4 text-slate-800 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-3">
                        <label class="text-sm font-bold text-slate-700 ml-1">Título / Tema da Aula *</label>
                        <div class="relative">
                            <i class="ti ti-bookmark absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="titulo" value="{{ old('titulo') }}" required
                                   placeholder="Ex: Fundamentos de Logística Industrial"
                                   class="input-focus w-full bg-slate-50 border-2 border-transparent rounded-2xl pl-12 pr-5 py-4 text-slate-800 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-3">
                        <label class="text-sm font-bold text-slate-700 ml-1">Conteúdo Desenvolvido *</label>
                        <textarea name="conteudo" rows="8" required
                                  placeholder="Descreva detalhadamente os tópicos abordados, metodologias aplicadas e atividades realizadas..."
                                  class="input-focus w-full bg-slate-50 border-2 border-transparent rounded-3xl px-6 py-5 text-slate-800 outline-none transition-all resize-none leading-relaxed">{{ old('conteudo') }}</textarea>
                    </div>

                </div>

                <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-4">
                    <button type="reset" class="px-6 py-3 rounded-xl font-bold text-slate-400 hover:text-slate-600 transition">
                        Limpar Campos
                    </button>
                    <button type="submit"
                            class="bg-[#0a1128] hover:bg-blue-700 text-white font-bold px-12 py-5 rounded-2xl transition shadow-xl shadow-blue-900/10 flex items-center gap-3 text-lg">
                        <i class="ti ti-device-floppy text-2xl"></i> Finalizar Registro
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 flex items-center gap-4 p-6 bg-blue-50 rounded-3xl border border-blue-100 max-w-5xl">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shrink-0">
                <i class="ti ti-info-circle text-xl"></i>
            </div>
            <p class="text-sm text-blue-800 leading-relaxed">
                <strong>Lembrete:</strong> Este registro alimenta automaticamente o relatório de assiduidade das empresas parceiras. Seja claro e objetivo na descrição do conteúdo para facilitar o acompanhamento dos aprendizes.
            </p>
        </div>

    </main>
</div>

</body>
</html>