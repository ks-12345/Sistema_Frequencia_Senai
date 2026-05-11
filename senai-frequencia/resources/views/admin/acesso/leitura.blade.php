<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitura de Acesso – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fb; }
        .scanner-focus:focus {
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2);
            border-color: #2563eb;
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

            <a href="{{ route('admin.acesso.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-qrcode text-xl"></i>
                <span class="font-medium">Leitura de Acesso</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col items-center justify-center p-10">

        <div class="w-full max-w-2xl">
            
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600 text-white rounded-3xl shadow-xl shadow-blue-200 mb-6">
                    <i class="ti ti-scan text-4xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Registrar Acesso</h1>
                <p class="text-slate-500 mt-2 text-lg">Aponte o leitor para o QR Code ou digite a matrícula.</p>
            </div>

            @if(session('error') || $errors->any())
                <div class="mb-8 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-5 flex items-start gap-4">
                    <i class="ti ti-circle-x-filled text-2xl mt-0.5"></i>
                    <div>
                        <p class="font-bold">Falha no registro</p>
                        <p class="text-sm opacity-90">{{ session('error') }}</p>
                        @foreach($errors->all() as $error) <p class="text-sm opacity-90">{{ $error }}</p> @endforeach
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-2xl p-10">
                <form method="POST" action="{{ route('admin.acesso.registrar') }}" class="space-y-8">
                    @csrf
                    
                    <div class="space-y-3">
                        <label class="text-sm font-bold text-slate-700 ml-1">Token do QR Code / Matrícula</label>
                        <div class="relative">
                            <i class="ti ti-barcode absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-2xl"></i>
                            <input type="text" name="token" autofocus required
                                   placeholder="Aguardando leitura..."
                                   class="scanner-focus w-full bg-slate-100 border-2 border-transparent rounded-2xl pl-14 pr-6 py-5 text-xl font-mono text-slate-800 outline-none transition-all placeholder:text-slate-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <label class="text-sm font-bold text-slate-700 ml-1">Tipo de Registro</label>
                            <div class="relative">
                                <select name="tipo" required
                                        class="w-full bg-slate-100 border-none rounded-2xl px-5 py-4 text-slate-700 outline-none focus:ring-2 ring-blue-500/20 transition appearance-none">
                                    <option value="entrada_portaria">Entrada Portaria</option>
                                    <option value="entrada_bloco">Entrada Bloco</option>
                                    <option value="saida">Saída</option>
                                </select>
                                <i class="ti ti-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-sm font-bold text-slate-700 ml-1">Localização</label>
                            <input type="text" name="local" placeholder="Ex: Bloco A"
                                   class="w-full bg-slate-100 border-none rounded-2xl px-5 py-4 text-slate-700 outline-none focus:ring-2 ring-blue-500/20 transition">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-[#0a1128] hover:bg-blue-700 text-white font-bold py-5 rounded-2xl transition-all shadow-lg hover:shadow-blue-200 flex items-center justify-center gap-3 text-lg mt-4">
                        <i class="ti ti-device-floppy text-2xl"></i> Confirmar Registro
                    </button>
                </form>
            </div>

            <div class="mt-12 flex items-center justify-between px-6">
                <a href="{{ route('admin.acesso.index') }}" class="text-slate-500 hover:text-blue-600 font-medium flex items-center gap-2 transition">
                    <i class="ti ti-arrow-left"></i> Ver registros de hoje
                </a>
                <a href="{{ route('admin.alunos.index') }}" class="text-slate-500 hover:text-blue-600 font-medium flex items-center gap-2 transition">
                    Buscar aluno por nome <i class="ti ti-search"></i>
                </a>
            </div>

        </div>
    </main>
</div>

</body>
</html>