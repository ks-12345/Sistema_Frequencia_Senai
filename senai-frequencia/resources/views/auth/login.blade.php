<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENAI – Gestão de Frequência</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        <!-- Card principal -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            <!-- Topo -->
            <div class="px-8 pt-8 pb-6">

                <!-- Logo -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-[#1a2f5e] rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[#1a2f5e] font-bold text-lg leading-none">SENAI</div>
                        <div class="text-gray-400 text-[10px] tracking-widest uppercase">Gestão de Frequência</div>
                    </div>
                </div>

                <!-- Título -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">Acesse sua conta</h1>
                <p class="text-gray-500 text-sm mb-6">Insira suas credenciais para gerenciar presenças e turmas.</p>

                <!-- Erros -->
                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-4">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Formulário -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Perfil de acesso -->
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Perfil de Acesso
                        </label>
                        <div class="relative">
                            <select name="role_hint"
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-gray-700 bg-white appearance-none focus:outline-none focus:ring-2 focus:ring-[#1a2f5e] focus:border-transparent text-sm">
                                <option>Administrador</option>
                                <option selected>Professor</option>
                                <option>Empresa Parceira</option>
                                <option>Secretaria</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            E-mail Corporativo
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="seu.nome@senai.br"
                                class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#1a2f5e] focus:border-transparent"
                                required autofocus>
                        </div>
                    </div>

                    <!-- Senha -->
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Senha
                            </label>
                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-[#1a2f5e] hover:underline font-medium">
                                    Esqueceu a senha?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" name="password" id="password"
                                placeholder="••••••••"
                                class="w-full border border-gray-200 rounded-lg pl-10 pr-10 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#1a2f5e] focus:border-transparent"
                                required>
                            <button type="button" onclick="toggleSenha()"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg id="icon-ver" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Manter conectado -->
                    <div class="flex items-center gap-2 mb-6">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded border-gray-300 text-[#1a2f5e] focus:ring-[#1a2f5e]">
                        <label for="remember" class="text-sm text-gray-600">Manter conectado neste dispositivo</label>
                    </div>

                    <!-- Botão -->
                    <button type="submit"
                        class="w-full bg-[#1a2f5e] hover:bg-[#15264f] text-white font-semibold py-3 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-sm">
                        Entrar no Sistema
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Rodapé do card -->
            <div class="bg-gray-50 border-t border-gray-100 px-8 py-4 text-center">
                <p class="text-xs text-gray-400">Dúvidas ou problemas no acesso?</p>
                <a href="#" class="text-xs text-[#1a2f5e] font-semibold hover:underline">
                    Contate o Suporte Técnico de TI
                </a>
            </div>
        </div>

        <!-- Status bar -->
        <div class="flex items-center justify-center gap-6 mt-4">
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-green-400"></div>
                <span class="text-xs text-gray-500">Servidor Online</span>
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <span class="text-xs text-gray-500">Acesso Seguro SSL</span>
            </div>
        </div>
    </div>

    <script>
        function toggleSenha() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>