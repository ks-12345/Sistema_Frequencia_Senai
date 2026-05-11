<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresas – SENAI</title>

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

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300 hover:text-white">
                <i class="ti ti-layout-grid text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="#"
               class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-building text-xl"></i>
                <span class="font-medium">Empresas</span>
            </a>
            
            </nav>

    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">
            <div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Empresas</h1>
                <p class="text-slate-500 mt-2">Gerencie as empresas cadastradas no sistema.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                    <i class="ti ti-arrow-left"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.empresas.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-blue-200 transition flex items-center gap-2">
                    <i class="ti ti-plus"></i>
                    Nova Empresa
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

            <div class="p-8 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-[#0a1128]">Lista de Empresas</h2>
                    <p class="text-slate-400 text-sm mt-1">Total: {{ $empresas->total() }} empresas cadastradas</p>
                </div>

                <div class="relative group">
                    <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" placeholder="Buscar empresa..." 
                           class="bg-slate-100 border-none rounded-xl pl-11 pr-4 py-2.5 w-72 text-sm outline-none focus:ring-2 ring-blue-500/20 transition">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white">
                        <tr class="text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="px-8 py-5">Empresa</th>
                            <th class="px-8 py-5">CNPJ</th>
                            <th class="px-8 py-5">Responsável</th>
                            <th class="px-8 py-5 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($empresas as $empresa)
                        <tr class="table-row group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500">
                                        <i class="ti ti-building-factory-2 text-xl"></i>
                                    </div>
                                    <span class="font-bold text-slate-700">{{ $empresa->nome }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-slate-500 font-medium">
                                {{ $empresa->cnpj }}
                            </td>
                            <td class="px-8 py-5 text-slate-500">
                                {{ $empresa->responsavel }}
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.empresas.edit', $empresa) }}" 
                                       class="p-2 hover:bg-slate-100 rounded-lg text-slate-400 hover:text-blue-600 transition">
                                        <i class="ti ti-edit text-lg"></i>
                                    </a>
                                    
                                    <form method="POST" action="{{ route('admin.empresas.destroy', $empresa) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Confirmar exclusão?')" 
                                                class="p-2 hover:bg-red-50 rounded-lg text-slate-400 hover:text-red-600 transition">
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
                {{ $empresas->links() }}
            </div>
        </div>
    </main>
</div>

</body>
</html>