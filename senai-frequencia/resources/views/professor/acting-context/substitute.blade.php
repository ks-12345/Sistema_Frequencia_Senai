<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Substituicao - SENAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background: #f8fafc; }</style>
</head>
<body class="text-slate-900">
<main class="min-h-screen p-6 lg:p-10">
    <section class="max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <p class="text-amber-600 text-xs uppercase tracking-[0.3em] font-black">Modo substituto</p>
                <h1 class="text-4xl font-black text-[#0a1128] mt-2">Registrar contexto</h1>
                <p class="text-slate-500 mt-2">A sessao sera auditada desde o inicio ate o encerramento.</p>
            </div>
            <a href="{{ route('professor.context.select') }}" class="bg-white border border-slate-200 px-5 py-3 rounded-xl font-bold text-slate-700 flex items-center gap-2">
                <i class="ti ti-arrow-left"></i> Voltar
            </a>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-5">
                <ul class="list-disc list-inside text-sm font-bold">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('professor.context.substitute') }}" class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Turma *</label>
                    <select name="turma_id" required class="w-full bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-4 outline-none focus:border-amber-500">
                        <option value="">Selecione...</option>
                        @foreach($turmas as $turma)
                            <option value="{{ $turma->id }}" data-professor="{{ $turma->professor_id }}" {{ old('turma_id') == $turma->id ? 'selected' : '' }}>
                                {{ $turma->nome }} - {{ $turma->curso }} - Titular: {{ $turma->professor->name ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Professor titular substituido *</label>
                    <select name="substituted_teacher_id" required class="w-full bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-4 outline-none focus:border-amber-500">
                        <option value="">Selecione...</option>
                        @foreach($professores as $professor)
                            <option value="{{ $professor->id }}" {{ old('substituted_teacher_id') == $professor->id ? 'selected' : '' }}>
                                {{ $professor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Inicio da substituicao</label>
                    <input type="datetime-local" name="started_at" value="{{ old('started_at', now()->format('Y-m-d\TH:i')) }}"
                           class="w-full bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-4 outline-none focus:border-amber-500">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-4 rounded-2xl font-bold flex items-center gap-3">
                    <i class="ti ti-player-play"></i> Iniciar substituicao
                </button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
