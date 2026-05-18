<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Professor – SENAI</title>

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

            <a href="{{ route('admin.professores.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-user-star text-xl"></i>
                <span class="font-medium">Professores</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">
            <div>
                <div class="flex items-center gap-2 text-blue-600 font-bold text-sm uppercase tracking-widest mb-2">
                    <i class="ti ti-user-plus"></i> Novo Colaborador
                </div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Cadastrar Professor</h1>
                <p class="text-slate-500 mt-2">Crie uma nova conta de acesso para um docente da instituição.</p>
            </div>
            <a href="{{ route('admin.professores.index') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                <i class="ti ti-arrow-left"></i> Voltar para Lista
            </a>
        </div>

        @if($errors->any())
            <div class="mb-8 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-5 flex gap-4">
                <i class="ti ti-alert-circle-filled text-2xl"></i>
                <div>
                    <p class="font-bold">Correções necessárias:</p>
                    <ul class="list-disc list-inside text-sm opacity-90">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="max-w-4xl bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            
            <div class="p-8 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-[#0a1128]">Credenciais de Acesso</h2>
                    <p class="text-slate-400 text-sm">O professor utilizará o e-mail e senha abaixo para login.</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i class="ti ti-key text-2xl"></i>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.professores.store') }}" class="p-8 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Nome Completo *</label>
                        <div class="relative">
                            <i class="ti ti-user-edit absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   placeholder="Ex: Prof. Marcos Silva"
                                   class="input-focus w-full bg-slate-100 border-2 border-transparent rounded-2xl pl-12 pr-5 py-3.5 text-slate-800 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">E-mail Institucional *</label>
                        <div class="relative">
                            <i class="ti ti-mail absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="professor@senai.br"
                                   class="input-focus w-full bg-slate-100 border-2 border-transparent rounded-2xl pl-12 pr-5 py-3.5 text-slate-800 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">CPF</label>
                        <div class="relative">
                            <i class="ti ti-id absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="cpf" value="{{ old('cpf') }}"
                                   placeholder="000.000.000-00"
                                   class="input-focus w-full bg-slate-100 border-2 border-transparent rounded-2xl pl-12 pr-5 py-3.5 text-slate-800 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Senha de Acesso *</label>
                        <div class="relative">
                            <i class="ti ti-lock-square absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="password" name="password" required
                                   placeholder="Crie uma senha segura"
                                   class="input-focus w-full bg-slate-100 border-2 border-transparent rounded-2xl pl-12 pr-5 py-3.5 text-slate-800 outline-none transition-all">
                        </div>
                        <p class="text-[11px] text-slate-400 ml-1 mt-1">
                            A senha deve conter no mínimo 8 caracteres para garantir a segurança.
                        </p>
                    </div>

                </div>

                <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-4">
                    <button type="reset" class="px-6 py-3 rounded-xl font-bold text-slate-400 hover:text-slate-600 transition">
                        Limpar
                    </button>
                    <button type="submit"
                            class="bg-[#0a1128] hover:bg-blue-700 text-white font-bold px-12 py-4 rounded-2xl transition shadow-lg shadow-blue-100 flex items-center gap-3 text-lg">
                        <i class="ti ti-user-check text-2xl"></i> Cadastrar Professor
                    </button>
                </div>
            </form>
        </div>

    </main>
</div>

</body>
</html>
