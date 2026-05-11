<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Substitutos – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fb; }
        .table-row { transition: .2s ease; }
        .table-row:hover { background: #f8fafc; }
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

            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-user-share text-xl"></i>
                <span class="font-medium">Substitutos</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">
            <div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Professores Substitutos</h1>
                <p class="text-slate-500 mt-2">Gerencie acessos temporários para docentes visitantes.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                    <i class="ti ti-arrow-left"></i> Voltar
                </a>

                <a href="{{ route('admin.substitutos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-blue-200 transition flex items-center gap-2">
                    <i class="ti ti-shield-lock"></i> Gerar Novo Acesso
                </a>
            </div>
        </div>

        @if(session('credenciais'))
            @php $c = session('credenciais') @endphp
            <div class="mb-8 bg-amber-50 border-2 border-amber-200 rounded-[2rem] p-8 shadow-xl shadow-amber-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-6 opacity-10">
                    <i class="ti ti-key text-8xl text-amber-600"></i>
                </div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-4 text-amber-700">
                        <i class="ti ti-alert-triangle-filled text-2xl"></i>
                        <h3 class="text-xl font-bold">Credenciais Geradas — Anote agora!</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white/60 p-4 rounded-2xl">
                            <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Nome do Docente</p>
                            <p class="text-slate-800 font-bold">{{ $c['nome'] }}</p>
                        </div>
                        <div class="bg-white/60 p-4 rounded-2xl">
                            <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">E-mail de Acesso</p>
                            <p class="text-slate-800 font-bold">{{ $c['email'] }}</p>
                        </div>
                        <div class="bg-white/60 p-4 rounded-2xl border-2 border-amber-300">
                            <p class="text-[10px] uppercase font-bold text-amber-600 mb-1">Senha Temporária</p>
                            <p class="text-xl font-mono font-black text-amber-700 tracking-wider">{{ $c['senha'] }}</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-amber-600 font-medium italic">
                        * Por questões de segurança, esta senha não será exibida novamente.
                    </p>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 flex items-center gap-3">
                <i class="ti ti-circle-check text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-sm">
            <div class="p-8 border-b border-slate-100 bg-white">
                <h2 class="text-xl font-bold text-[#0a1128]">Acessos Ativos</h2>
                <p class="text-slate-400 text-sm mt-1">Lista de professores com permissão temporária</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-100 bg-slate-50/30">
                            <th class="px-8 py-5">Professor Substituto</th>
                            <th class="px-8 py-5">E-mail</th>
                            <th class="px-8 py-5">Turma Atribuída</th>
                            <th class="px-8 py-5">Expiração</th>
                            <th class="px-8 py-5 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($substitutos as $sub)
                        <tr class="table-row group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold">
                                        <i class="ti ti-user-bolt"></i>
                                    </div>
                                    <span class="font-bold text-slate-700">{{ $sub->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-slate-500 text-sm">
                                {{ $sub->email }}
                            </td>
                            <td class="px-8 py-5">
                                <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg text-xs font-bold">
                                    {{ $sub->turmas->first()->nome ?? '—' }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2 text-slate-600 font-medium">
                                    <i class="ti ti-clock-hour-4 text-amber-500"></i>
                                    <span class="text-sm">
                                        {{ $sub->acesso_expira_em?->format('d/m/Y H:i') ?? 'Manual' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex justify-end">
                                    <form method="POST" action="{{ route('admin.substitutos.destroy', $sub) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Revogar acesso imediatamente?')" 
                                                class="flex items-center gap-2 text-red-500 hover:bg-red-50 px-4 py-2 rounded-xl transition font-bold text-sm">
                                            <i class="ti ti-user-x"></i> Revogar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

</body>
</html>