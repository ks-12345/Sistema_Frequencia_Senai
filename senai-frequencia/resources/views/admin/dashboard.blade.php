<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – SENAI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-52 min-h-screen bg-[#1a2f5e] flex flex-col fixed top-0 left-0 z-30">
        <!-- Logo -->
        <div class="px-5 py-5 border-b border-white/10">
            <div class="text-white font-bold text-lg leading-none">SENAI</div>
            <div class="text-blue-300 text-[9px] tracking-widest uppercase mt-0.5">Gestão de Frequência</div>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/10 text-white text-sm font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.turmas.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-white/10 hover:text-white text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Turmas
            </a>
            <a href="{{ route('admin.alunos.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-white/10 hover:text-white text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Alunos
            </a>
            <a href="{{ route('admin.professores.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-white/10 hover:text-white text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Professores
            </a>
            <a href="{{ route('admin.empresas.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-white/10 hover:text-white text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Empresas
            </a>
            <a href="{{ route('admin.relatorios.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-white/10 hover:text-white text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Relatórios
            </a>
            <a href="{{ route('admin.acesso.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-white/10 hover:text-white text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Acesso
            </a>
            <a href="{{ route('admin.diario.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-white/10 hover:text-white text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Diário
            </a>
            <a href="{{ route('admin.substitutos.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-white/10 hover:text-white text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
                Substitutos
            </a>
        </nav>

        <!-- Nova chamada -->
        <div class="px-3 py-3 border-t border-white/10">
            <a href="{{ route('admin.acesso.leitura') }}"
               class="flex items-center justify-center gap-2 w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2.5 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Chamada
            </a>
        </div>

        <!-- Rodapé sidebar -->
        <div class="px-3 py-3 space-y-1">
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-blue-300 hover:text-white text-xs transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Suporte
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2 rounded-lg text-blue-300 hover:text-white text-xs w-full transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sair
                </button>
            </form>
        </div>
    </aside>

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="ml-52 flex-1 flex flex-col min-h-screen">

        <!-- TOPBAR -->
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between sticky top-0 z-20">
            <h1 class="text-lg font-bold text-gray-800">Portal de Frequência SENAI</h1>
            <div class="flex items-center gap-4">
                <!-- Busca -->
                <div class="relative hidden md:block">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Buscar turmas ou alunos..."
                        class="pl-9 pr-4 py-1.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1a2f5e] w-56">
                </div>
                <!-- Ícones -->
                <button class="relative p-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($pendentes > 0)
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </button>
                <a href="#" class="p-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </a>
                <!-- Usuário -->
                <div class="flex items-center gap-2 pl-3 border-l border-gray-200">
                    <div class="text-right">
                        <div class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-400">Administrador</div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-[#1a2f5e] flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTEÚDO -->
        <main class="flex-1 p-6">

            <!-- Breadcrumb -->
            <div class="text-xs text-gray-400 mb-4 uppercase tracking-wider">
                Principal &rsaquo; <span class="text-gray-600 font-semibold">Dashboard</span>
            </div>

            <!-- Cards de resumo -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                <!-- Total Alunos -->
                <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start mb-3">
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total de Alunos</div>
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-800 mb-1">{{ $totalAlunos }}</div>
                    <div class="text-xs text-green-500 font-medium flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        Alunos cadastrados
                    </div>
                </div>

                <!-- Turmas Ativas -->
                <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start mb-3">
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Turmas Ativas</div>
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-800 mb-1">{{ $totalTurmas }}</div>
                    <div class="text-xs text-gray-400">Turmas no sistema</div>
                </div>

                <!-- Frequência Geral -->
                <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start mb-3">
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Frequência Geral</div>
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-800 mb-1">{{ $percentualGeral }}%</div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                        <div class="bg-[#1a2f5e] h-1.5 rounded-full" style="width: {{ $percentualGeral }}%"></div>
                    </div>
                </div>

                <!-- Pendentes -->
                <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start mb-3">
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Alertas de Falta</div>
                        <svg class="w-5 h-5 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-red-600 mb-1">{{ $pendentes }}</div>
                    <div class="text-xs text-red-400 font-medium">
                        @if($pendentes > 0) Requer atenção imediata @else Tudo em dia @endif
                    </div>
                </div>
            </div>

            <!-- Linha inferior -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                <!-- Links rápidos -->
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h2 class="text-sm font-bold text-gray-700 mb-4">Acesso Rápido</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach([
                            ['label' => 'Alunos', 'route' => 'admin.alunos.index', 'color' => 'blue'],
                            ['label' => 'Turmas', 'route' => 'admin.turmas.index', 'color' => 'blue'],
                            ['label' => 'Professores', 'route' => 'admin.professores.index', 'color' => 'blue'],
                            ['label' => 'Empresas', 'route' => 'admin.empresas.index', 'color' => 'blue'],
                            ['label' => 'Relatórios', 'route' => 'admin.relatorios.index', 'color' => 'blue'],
                            ['label' => 'Substitutos', 'route' => 'admin.substitutos.index', 'color' => 'blue'],
                            ['label' => 'Diário', 'route' => 'admin.diario.index', 'color' => 'blue'],
                            ['label' => 'QR Code', 'route' => 'admin.alunos.index', 'color' => 'blue'],
                            ['label' => 'Acesso', 'route' => 'admin.acesso.index', 'color' => 'blue'],
                        ] as $item)
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center justify-center py-3 px-4 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:bg-[#1a2f5e] hover:text-white hover:border-[#1a2f5e] transition-all">
                            {{ $item['label'] }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Resumo lateral -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-bold text-gray-700">Resumo do Sistema</h2>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-xs text-gray-500">Professores</span>
                            <span class="text-sm font-bold text-gray-700">{{ $totalProfessores }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-xs text-gray-500">Empresas parceiras</span>
                            <span class="text-sm font-bold text-gray-700">{{ $totalEmpresas }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-xs text-gray-500">Frequências pendentes</span>
                            <span class="text-sm font-bold {{ $pendentes > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $pendentes }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-xs text-gray-500">Taxa de presença</span>
                            <span class="text-sm font-bold text-[#1a2f5e]">{{ $percentualGeral }}%</span>
                        </div>
                    </div>

                    <a href="{{ route('admin.relatorios.index') }}"
                       class="mt-4 w-full flex items-center justify-center gap-2 border border-[#1a2f5e] text-[#1a2f5e] hover:bg-[#1a2f5e] hover:text-white text-xs font-semibold py-2 rounded-lg transition-colors">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Exportar Relatório
                    </a>
                </div>
            </div>
        </main>
    </div>

</body>
</html>