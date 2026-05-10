<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body{
            background: linear-gradient(to bottom right, #0f172a, #1e293b);
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .card{
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.1);
            transition: 0.3s;
        }

        .card:hover{
            transform: translateY(-4px);
            background: rgba(255,255,255,0.12);
        }

        .menu-card{
            transition: 0.3s;
        }

        .menu-card:hover{
            transform: scale(1.03);
        }
    </style>
</head>

<body class="text-white">

    <!-- HEADER -->
    <header class="bg-black/30 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">

            <div>
                <h1 class="text-3xl font-bold">🎓 Dashboard SENAI</h1>
                <p class="text-slate-300 mt-1">
                    Bem-vindo, {{ auth()->user()->name }}
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="bg-red-500 hover:bg-red-600 px-5 py-2 rounded-xl font-semibold shadow-lg transition"
                >
                    Sair
                </button>
            </form>

        </div>
    </header>

    <!-- CONTEÚDO -->
    <main class="max-w-7xl mx-auto px-6 py-8">

        <!-- RESUMO -->
        <section>
            <h2 class="text-2xl font-bold mb-6">
                📊 Resumo Geral
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                <div class="card rounded-2xl p-6 shadow-xl">
                    <p class="text-slate-300 text-sm">Alunos</p>
                    <h3 class="text-4xl font-bold mt-2">{{ $totalAlunos }}</h3>
                </div>

                <div class="card rounded-2xl p-6 shadow-xl">
                    <p class="text-slate-300 text-sm">Turmas</p>
                    <h3 class="text-4xl font-bold mt-2">{{ $totalTurmas }}</h3>
                </div>

                <div class="card rounded-2xl p-6 shadow-xl">
                    <p class="text-slate-300 text-sm">Professores</p>
                    <h3 class="text-4xl font-bold mt-2">{{ $totalProfessores }}</h3>
                </div>

                <div class="card rounded-2xl p-6 shadow-xl">
                    <p class="text-slate-300 text-sm">Empresas</p>
                    <h3 class="text-4xl font-bold mt-2">{{ $totalEmpresas }}</h3>
                </div>

                <div class="card rounded-2xl p-6 shadow-xl">
                    <p class="text-slate-300 text-sm">Presença Geral</p>
                    <h3 class="text-4xl font-bold mt-2 text-green-400">
                        {{ $percentualGeral }}%
                    </h3>
                </div>

                <div class="card rounded-2xl p-6 shadow-xl">
                    <p class="text-slate-300 text-sm">Pendentes</p>
                    <h3 class="text-4xl font-bold mt-2 text-yellow-400">
                        {{ $pendentes }}
                    </h3>
                </div>

            </div>
        </section>

        <!-- GERENCIAMENTO -->
        <section class="mt-12">
            <h2 class="text-2xl font-bold mb-6">
                ⚙️ Gerenciamento
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                <a href="{{ route('admin.alunos.index') }}"
                   class="menu-card bg-blue-500 hover:bg-blue-600 rounded-2xl p-6 shadow-xl">
                    <h3 class="text-xl font-bold">👨‍🎓 Alunos</h3>
                    <p class="text-sm mt-2 text-white/80">
                        Gerencie os alunos cadastrados
                    </p>
                </a>

                <a href="{{ route('admin.turmas.index') }}"
                   class="menu-card bg-purple-500 hover:bg-purple-600 rounded-2xl p-6 shadow-xl">
                    <h3 class="text-xl font-bold">🏫 Turmas</h3>
                    <p class="text-sm mt-2 text-white/80">
                        Controle e organização das turmas
                    </p>
                </a>

                <a href="{{ route('admin.professores.index') }}"
                   class="menu-card bg-emerald-500 hover:bg-emerald-600 rounded-2xl p-6 shadow-xl">
                    <h3 class="text-xl font-bold">👨‍🏫 Professores</h3>
                    <p class="text-sm mt-2 text-white/80">
                        Cadastro e gerenciamento dos professores
                    </p>
                </a>

                <a href="{{ route('admin.empresas.index') }}"
                   class="menu-card bg-orange-500 hover:bg-orange-600 rounded-2xl p-6 shadow-xl">
                    <h3 class="text-xl font-bold">🏢 Empresas</h3>
                    <p class="text-sm mt-2 text-white/80">
                        Empresas vinculadas ao sistema
                    </p>
                </a>

                <a href="{{ route('admin.relatorios.index') }}"
                   class="menu-card bg-pink-500 hover:bg-pink-600 rounded-2xl p-6 shadow-xl">
                    <h3 class="text-xl font-bold">📄 Relatórios</h3>
                    <p class="text-sm mt-2 text-white/80">
                        Exportações e relatórios completos
                    </p>
                </a>

            </div>
        </section>

    </main>

</body>
</html>