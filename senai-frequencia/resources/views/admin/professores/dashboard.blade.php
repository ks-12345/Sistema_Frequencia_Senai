<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        body{
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #f1f5f9, #e2e8f0);
        }

        .glass{
            background: rgba(255,255,255,.75);
            backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="glass w-full max-w-4xl rounded-[32px] shadow-2xl overflow-hidden border border-white/40">

        <div class="grid md:grid-cols-2">

            <!-- Lado esquerdo -->
            <div class="bg-[#07122b] text-white p-12 flex flex-col justify-between">

                <div>

                    <div class="flex items-center gap-3 mb-12">

                        <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center">
                            <i class="ti ti-school text-3xl"></i>
                        </div>

                        <div>
                            <h1 class="text-3xl font-bold">
                                Rede SENAI
                            </h1>

                            <p class="text-slate-400 text-sm">
                                Sistema Acadêmico
                            </p>
                        </div>

                    </div>

                    <h2 class="text-4xl font-bold leading-tight">
                        Dashboard
                        do Professor
                    </h2>

                    <p class="text-slate-400 mt-6 leading-relaxed">
                        Gerencie frequências, turmas,
                        diários de classe e acompanhe
                        as atividades acadêmicas.
                    </p>

                </div>

                <div class="mt-12 flex gap-4">

                    <div class="bg-white/10 rounded-2xl p-4 flex-1">
                        <p class="text-3xl font-bold">12</p>
                        <span class="text-sm text-slate-300">
                            Turmas
                        </span>
                    </div>

                    <div class="bg-white/10 rounded-2xl p-4 flex-1">
                        <p class="text-3xl font-bold">248</p>
                        <span class="text-sm text-slate-300">
                            Alunos
                        </span>
                    </div>

                </div>

            </div>

            <!-- Lado direito -->
            <div class="p-12 bg-white flex flex-col justify-center">

                <div class="flex justify-center mb-8">

                    <div class="w-28 h-28 rounded-full bg-blue-100
                                flex items-center justify-center
                                text-blue-700 text-5xl font-bold shadow-lg">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>

                </div>

                <div class="text-center">

                    <h2 class="text-4xl font-bold text-slate-800">
                        Bem-vindo
                    </h2>

                    <p class="text-slate-500 mt-3 text-lg">
                        {{ auth()->user()->name }}
                    </p>

                </div>

                <!-- Cards -->
                <div class="grid grid-cols-2 gap-4 mt-10">

                    <div class="border border-slate-200 rounded-2xl p-5 hover:shadow-lg transition">

                        <div class="w-12 h-12 rounded-xl bg-blue-100
                                    text-blue-600 flex items-center justify-center text-2xl">

                            <i class="ti ti-checkup-list"></i>

                        </div>

                        <h3 class="font-bold text-slate-800 mt-4">
                            Frequência
                        </h3>

                    </div>

                    <div class="border border-slate-200 rounded-2xl p-5 hover:shadow-lg transition">

                        <div class="w-12 h-12 rounded-xl bg-green-100
                                    text-green-600 flex items-center justify-center text-2xl">

                            <i class="ti ti-book"></i>

                        </div>

                        <h3 class="font-bold text-slate-800 mt-4">
                            Diário
                        </h3>

                    </div>

                    <div class="border border-slate-200 rounded-2xl p-5 hover:shadow-lg transition">

                        <div class="w-12 h-12 rounded-xl bg-yellow-100
                                    text-yellow-600 flex items-center justify-center text-2xl">

                            <i class="ti ti-alert-circle"></i>

                        </div>

                        <h3 class="font-bold text-slate-800 mt-4">
                            Pendentes
                        </h3>

                    </div>

                    <div class="border border-slate-200 rounded-2xl p-5 hover:shadow-lg transition">

                        <div class="w-12 h-12 rounded-xl bg-red-100
                                    text-red-600 flex items-center justify-center text-2xl">

                            <i class="ti ti-logout"></i>

                        </div>

                        <h3 class="font-bold text-slate-800 mt-4">
                            Encerrar
                        </h3>

                    </div>

                </div>

                <!-- Botão -->
                <form method="POST"
                     action="{{ route('logout') }}"
                      class="mt-10">

                    @csrf

                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700
                                   transition text-white py-4 rounded-2xl
                                   font-semibold text-lg shadow-lg">

                        <i class="ti ti-logout mr-2"></i>
                        Sair do Sistema

                    </button>

                </form>

            </div>

        </div>

    </div>

</body>
</html>