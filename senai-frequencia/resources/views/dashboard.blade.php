<x-app-layout>
    <div class="py-12 bg-[#f4f7fb] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-[#0a1128] tracking-tight">
                        Olá, Prof. {{ Auth::user()->name }}! 👋
                    </h1>
                    <p class="text-slate-500 mt-1">Bem-vindo ao seu painel de controle acadêmico.</p>
                </div>
                <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-3">
                    <i class="ti ti-calendar-event text-blue-600 text-xl"></i>
                    <span class="text-sm font-bold text-slate-700">{{ now()->translatedFormat('d \d\e F \d\e Y') }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl">
                        <i class="ti ti-users-group"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Minhas Turmas</p>
                        <p class="text-2xl font-black text-[#0a1128]">04</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl">
                        <i class="ti ti-clock-pause"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pendências</p>
                        <p class="text-2xl font-black text-[#0a1128]">02</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl">
                        <i class="ti ti-checkbox"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Aulas Dadas</p>
                        <p class="text-2xl font-black text-[#0a1128]">128</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-[#0a1128] ml-2">Ações Rápidas</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <a href="{{ route('professor.frequencia.index') }}" class="group bg-[#0a1128] p-6 rounded-[2rem] text-white hover:bg-blue-700 transition-all shadow-xl shadow-blue-900/20">
                            <i class="ti ti-checklist text-3xl mb-4 block group-hover:scale-110 transition-transform"></i>
                            <span class="block font-bold text-lg leading-tight">Lançar<br>Frequência</span>
                        </a>

                        <a href="{{ route('professor.diario.index') }}" class="group bg-white p-6 rounded-[2rem] border border-slate-200 text-[#0a1128] hover:border-blue-300 transition-all shadow-sm">
                            <i class="ti ti-book text-3xl mb-4 block text-blue-600 group-hover:scale-110 transition-transform"></i>
                            <span class="block font-bold text-lg leading-tight">Diário de<br>Classe</span>
                        </a>

                        <a href="{{ route('professor.saidas.create') }}" class="group bg-white p-6 rounded-[2rem] border border-slate-200 text-[#0a1128] hover:border-blue-300 transition-all shadow-sm">
                            <i class="ti ti-door-exit text-3xl mb-4 block text-red-500 group-hover:scale-110 transition-transform"></i>
                            <span class="block font-bold text-lg leading-tight">Saída<br>Antecipada</span>
                        </a>

                        <a href="{{ route('professor.frequencia.pendentes') }}" class="group bg-amber-50 p-6 rounded-[2rem] border border-amber-100 text-amber-900 hover:bg-amber-100 transition-all shadow-sm">
                            <div class="flex justify-between items-start">
                                <i class="ti ti-alert-circle text-3xl mb-4 block text-amber-600"></i>
                                <span class="bg-amber-600 text-white text-[10px] px-2 py-1 rounded-lg font-black">2 NOVO</span>
                            </div>
                            <span class="block font-bold text-lg leading-tight">Aprovar<br>Pendências</span>
                        </a>

                    </div>
                </div>

                <div class="bg-blue-600 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-blue-900/30">
                    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <span class="bg-white/20 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest">Sua Próxima Aula</span>
                        <h4 class="text-3xl font-black mt-4 leading-tight">Manutenção de<br>Sistemas Hidráulicos</h4>
                        
                        <div class="mt-8 space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                                    <i class="ti ti-map-pin"></i>
                                </div>
                                <span class="font-medium text-blue-50">Laboratório de Mecânica - Bloco B</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                                    <i class="ti ti-clock"></i>
                                </div>
                                <span class="font-medium text-blue-50">13:30 - 17:30 (Tarde)</span>
                            </div>
                        </div>

                        <div class="mt-10 pt-6 border-t border-white/10 flex items-center justify-between">
                            <div class="flex -space-x-3">
                                <div class="w-8 h-8 rounded-full border-2 border-blue-600 bg-slate-200"></div>
                                <div class="w-8 h-8 rounded-full border-2 border-blue-600 bg-slate-300"></div>
                                <div class="w-8 h-8 rounded-full border-2 border-blue-600 bg-slate-400 text-[8px] flex items-center justify-center font-bold text-white">+24</div>
                            </div>
                            <button class="text-xs font-bold bg-white text-blue-600 px-4 py-2 rounded-xl hover:bg-blue-50 transition">Ver Alunos</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-center py-6 text-slate-400 text-sm">
                Precisa de ajuda com o portal? <a href="#" class="text-blue-600 font-bold hover:underline">Entre em contato com o TI</a>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</x-app-layout>