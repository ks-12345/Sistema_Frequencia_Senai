<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunos – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f7fb;
        }
        .table-row {
            transition: .2s ease;
        }
        .table-row:hover {
            background: #f8fafc;
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
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300 hover:text-white">
                <i class="ti ti-layout-grid text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="#"
               class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-users text-xl"></i>
                <span class="font-medium">Alunos</span>
            </a>
        </nav>

    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">
            <div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Alunos</h1>
                <p class="text-slate-500 mt-2">Gerencie os estudantes e emita credenciais de acesso.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                    <i class="ti ti-arrow-left"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.alunos.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-blue-200 transition flex items-center gap-2">
                    <i class="ti ti-plus"></i>
                    Novo Aluno
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 flex items-center gap-3">
                <i class="ti ti-circle-check text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-sm">

            <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-[#0a1128]">Lista de Alunos</h2>
                    <p class="text-slate-400 text-sm mt-1">Gerenciamento de matrículas e turmas</p>
                </div>

                <div class="relative">
                    <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" placeholder="Buscar aluno ou matrícula..." 
                           class="bg-slate-100 border-none rounded-xl pl-11 pr-4 py-2.5 w-80 text-sm outline-none focus:ring-2 ring-blue-500/20 transition">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white">
                        <tr class="text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="px-8 py-5">Aluno</th>
                            <th class="px-8 py-5">Matrícula</th>
                            <th class="px-8 py-5">Turma / Empresa</th>
                            <th class="px-8 py-5 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($alunos as $aluno)
                        <tr class="table-row group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($aluno->nome, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-slate-700">{{ $aluno->nome }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-lg text-sm font-mono font-medium">
                                    {{ $aluno->matricula }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-slate-700 font-medium text-sm">{{ $aluno->turma->nome ?? 'Sem Turma' }}</span>
                                    <span class="text-slate-400 text-xs">{{ $aluno->empresa->nome ?? 'Sem Empresa' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.qrcode.cracha', $aluno) }}" 
                                       title="Gerar QR Code"
                                       class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-lg transition">
                                        <i class="ti ti-qrcode text-lg"></i>
                                    </a>

                                    <a href="{{ route('admin.alunos.edit', $aluno) }}" 
                                       class="p-2 bg-slate-50 text-slate-400 hover:bg-blue-600 hover:text-white rounded-lg transition">
                                        <i class="ti ti-edit text-lg"></i>
                                    </a>
                                    
                                    <form method="POST" action="{{ route('admin.alunos.destroy', $aluno) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Confirmar exclusão?')" 
                                                class="p-2 bg-slate-50 text-slate-400 hover:bg-red-600 hover:text-white rounded-lg transition">
                                            <i class="ti ti-trash text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50">
                {{ $alunos->links() }}
            </div>
        </div>
    </main>
</div>

</body>
</html>