<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte Técnico - SENAI</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-52 min-h-screen bg-[#1a2f5e] flex flex-col fixed top-0 left-0">

        <!-- Logo -->
        <div class="px-5 py-5 border-b border-white/10">
            <div class="text-white font-bold text-lg">
                SENAI
            </div>

            <div class="text-blue-300 text-[10px] uppercase tracking-widest">
                Gestão de Frequência
            </div>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-3 py-4">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-white/10 hover:text-white text-sm transition-colors mb-2">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>

                Dashboard
            </a>

            <a href="{{ route('suporte') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/10 text-white text-sm font-semibold">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 5.636l-1.414-1.414a2 2 0 00-2.828 0l-9.9 9.9L3 21l6.878-1.222 9.9-9.9a2 2 0 000-2.828z"/>
                </svg>

                Suporte
            </a>

        </nav>

        <!-- Rodapé -->
        <div class="p-4 border-t border-white/10">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2.5 rounded-lg transition">

                    Sair
                </button>
            </form>

        </div>

    </aside>

    <!-- CONTEÚDO -->
    <div class="ml-52 flex-1 flex flex-col min-h-screen">

        <!-- TOPBAR -->
        <header class="bg-white border-b border-gray-200 px-6 py-4">

            <h1 class="text-lg font-bold text-gray-800">
                Central de Suporte Técnico
            </h1>

        </header>

        <!-- MAIN -->
        <main class="flex-1 flex items-center justify-center p-6">

            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-10 max-w-lg w-full text-center">

                <div class="w-16 h-16 bg-[#1a2f5e] rounded-full flex items-center justify-center mx-auto mb-5">

                    <svg class="w-8 h-8 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 5h2l3.6 7.59-1.35 2.45A1 1 0 008 16h12v-2H8.42a.25.25 0 01-.22-.37L9.1 12h7.45a2 2 0 001.79-1.11L21 6H7"/>

                    </svg>

                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-3">
                    Precisa de ajuda?
                </h2>

                <p class="text-gray-500 text-sm leading-relaxed">
                    Entre em contato com o suporte técnico através do ramal:
                </p>

                <div class="mt-6 text-4xl font-bold text-[#1a2f5e] tracking-wide">
                    4002-8922
                </div>

                <div class="mt-4 text-xs text-gray-400">
                    Atendimento disponível em horário comercial.
                </div>

            </div>

        </main>

    </div>

</body>
</html>