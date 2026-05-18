<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atuacao Docente - SENAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background: #f8fafc; }</style>
</head>
<body class="text-slate-900">
<main class="min-h-screen flex items-center justify-center p-6">
    <section class="w-full max-w-5xl">
        <div class="mb-8">
            <p class="text-blue-600 text-xs uppercase tracking-[0.3em] font-black">Portal do Docente</p>
            <h1 class="text-4xl font-black text-[#0a1128] mt-2">Como deseja atuar hoje?</h1>
            <p class="text-slate-500 mt-2">Sua conta e historico continuam unicos. O sistema muda apenas o contexto da sessao.</p>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-4 font-bold">{{ session('error') }}</div>
        @endif

        @if($activeSubstitution)
            <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-amber-700">Substituicao ativa</p>
                    <p class="font-bold text-slate-800 mt-1">
                        {{ $activeSubstitution->turma->nome ?? 'Turma' }} - titular {{ $activeSubstitution->substitutedTeacher->name ?? '-' }}
                    </p>
                </div>
                <form method="POST" action="{{ route('professor.context.finish') }}">
                    @csrf
                    <button class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-3 rounded-xl font-bold flex items-center gap-2">
                        <i class="ti ti-player-stop"></i> Encerrar substituicao
                    </button>
                </form>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <form method="POST" action="{{ route('professor.context.titular') }}" class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm">
                @csrf
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                    <i class="ti ti-school"></i>
                </div>
                <h2 class="text-2xl font-black text-[#0a1128]">Professor Titular</h2>
                <p class="text-slate-500 mt-2 mb-8">Acesse apenas as turmas oficiais vinculadas ao seu cadastro.</p>
                <button class="w-full bg-[#0a1128] hover:bg-blue-700 text-white py-4 rounded-2xl font-bold flex items-center justify-center gap-2">
                    Atuar como titular <i class="ti ti-arrow-right"></i>
                </button>
            </form>

            <a href="{{ route('professor.context.substitute.form') }}" class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm block">
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                    <i class="ti ti-user-share"></i>
                </div>
                <h2 class="text-2xl font-black text-[#0a1128]">Professor Substituto</h2>
                <p class="text-slate-500 mt-2 mb-8">Informe turma, professor titular substituido e inicio para registrar a substituicao.</p>
                <span class="w-full bg-amber-600 hover:bg-amber-700 text-white py-4 rounded-2xl font-bold flex items-center justify-center gap-2">
                    Atuar como substituto <i class="ti ti-arrow-right"></i>
                </span>
            </a>
        </div>
    </section>
</main>
</body>
</html>
