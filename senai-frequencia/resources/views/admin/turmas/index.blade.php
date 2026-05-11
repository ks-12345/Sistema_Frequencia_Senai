<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turmas – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        body{
            font-family: 'Inter', sans-serif;
            background: #f4f7fb;
        }

        .table-row{
            transition: .2s ease;
        }

        .table-row:hover{
            background: #f8fafc;
        }

        .finalizada{
            background: #f8fafc;
            opacity: .75;
        }
    </style>
</head>
<body>

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-72 bg-[#07122b] text-white flex flex-col">

        <!-- Logo -->
        <div class="h-20 flex items-center px-7 border-b border-white/10">

            <div>
                <h1 class="text-2xl font-bold">
                    Rede SENAI
                </h1>

                <p class="text-slate-400 text-sm">
                    Painel Administrativo
                </p>
            </div>

        </div>

        <!-- Menu -->
        <nav class="flex-1 px-4 py-6 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">

                <i class="ti ti-layout-dashboard"></i>
                Dashboard

            </a>

            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600">

                <i class="ti ti-school"></i>
                Turmas

            </a>

        </nav>

    </aside>

    <!-- Conteúdo -->
    <main class="flex-1 p-10">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">

            <div>

                <h1 class="text-4xl font-bold text-slate-800">
                    Turmas
                </h1>

                <p class="text-slate-500 mt-2">
                    Gerencie as turmas cadastradas no sistema.
                </p>

            </div>

            <div class="flex gap-4">

                <a href="{{ route('admin.dashboard') }}"
                   class="bg-white border border-slate-200 px-5 py-3 rounded-2xl
                          font-medium hover:bg-slate-50 transition">

                    ← Dashboard

                </a>

                <a href="{{ route('admin.turmas.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3
                          rounded-2xl font-semibold shadow-lg transition">

                    <i class="ti ti-plus mr-2"></i>
                    Nova Turma

                </a>

            </div>

        </div>

        <!-- Alertas -->
        @if(session('success'))

            <div class="mb-6 bg-green-50 border border-green-200 text-green-700
                        rounded-2xl p-5 flex items-center gap-3">

                <i class="ti ti-circle-check text-2xl"></i>

                <span class="font-medium">
                    {{ session('success') }}
                </span>

            </div>

        @endif

        @if(session('error'))

            <div class="mb-6 bg-red-50 border border-red-200 text-red-700
                        rounded-2xl p-5 flex items-center gap-3">

                <i class="ti ti-alert-circle text-2xl"></i>

                <span class="font-medium">
                    {{ session('error') }}
                </span>

            </div>

        @endif

        <!-- Card -->
        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">

            <!-- Topo -->
            <div class="p-6 border-b border-slate-100 flex flex-col lg:flex-row gap-4 lg:items-center lg:justify-between">

                <div>

                    <h2 class="text-2xl font-bold text-slate-800">
                        Lista de Turmas
                    </h2>

                    <p class="text-slate-500 text-sm mt-1">
                        Total: {{ $turmas->total() }} turmas cadastradas
                    </p>

                </div>

                <!-- Busca -->
                <div class="flex items-center bg-slate-100 rounded-xl px-4 py-3 w-full lg:w-80">

                    <i class="ti ti-search text-slate-400"></i>

                    <input type="text"
                           placeholder="Buscar turma..."
                           class="bg-transparent outline-none px-3 w-full text-sm">

                </div>

            </div>

            <!-- Tabela -->
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50">

                        <tr class="text-left text-slate-600 text-sm">

                            <th class="px-6 py-4 font-semibold">
                                Turma
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                Curso
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                Período
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                Professor
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                Status
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                Finalizada em
                            </th>

                            <th class="px-6 py-4 font-semibold text-center">
                                Ações
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($turmas as $turma)

                        <tr class="table-row border-t border-slate-100
                                   {{ $turma->isFinalizada() ? 'finalizada' : '' }}">

                            <!-- Nome -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-2xl
                                                {{ $turma->isFinalizada()
                                                    ? 'bg-slate-200 text-slate-600'
                                                    : 'bg-blue-100 text-blue-700' }}
                                                flex items-center justify-center text-xl">

                                        <i class="ti ti-school"></i>

                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-slate-800">
                                            {{ $turma->nome }}
                                        </h3>

                                        <p class="text-sm text-slate-500">
                                            Turma SENAI
                                        </p>

                                    </div>

                                </div>

                            </td>

                            <!-- Curso -->
                            <td class="px-6 py-5 text-slate-600">

                                {{ $turma->curso }}

                            </td>

                            <!-- Período -->
                            <td class="px-6 py-5 text-slate-600">

                                {{ $turma->periodo }}

                            </td>

                            <!-- Professor -->
                            <td class="px-6 py-5 text-slate-600">

                                {{ $turma->professor->name ?? '—' }}

                            </td>

                            <!-- Status -->
                            <td class="px-6 py-5">

                                @if($turma->isFinalizada())

                                    <span class="bg-red-100 text-red-700
                                                 px-4 py-2 rounded-full
                                                 text-sm font-semibold">

                                        Finalizada

                                    </span>

                                @else

                                    <span class="bg-green-100 text-green-700
                                                 px-4 py-2 rounded-full
                                                 text-sm font-semibold">

                                        Ativa

                                    </span>

                                @endif

                            </td>

                            <!-- Data -->
                            <td class="px-6 py-5 text-slate-600">

                                {{ $turma->finalizada_em?->format('d/m/Y') ?? '—' }}

                            </td>

                            <!-- Ações -->
                            <td class="px-6 py-5">

                                <div class="flex flex-wrap justify-center gap-2">

                                    @if(!$turma->isFinalizada())

                                        <!-- Editar -->
                                        <a href="{{ route('admin.turmas.edit', $turma) }}"
                                           class="bg-yellow-100 hover:bg-yellow-200
                                                  text-yellow-700 px-4 py-2 rounded-xl
                                                  text-sm font-medium transition">

                                            <i class="ti ti-edit mr-1"></i>
                                            Editar

                                        </a>

                                        <!-- Finalizar -->
                                        <form method="POST"
                                              action="{{ route('admin.turmas.finalizar', $turma) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    onclick="return confirm('Finalizar a turma {{ $turma->nome }}? Isso bloqueará edições.')"
                                                    class="bg-blue-100 hover:bg-blue-200
                                                           text-blue-700 px-4 py-2 rounded-xl
                                                           text-sm font-medium transition">

                                                <i class="ti ti-lock mr-1"></i>
                                                Finalizar

                                            </button>

                                        </form>

                                        <!-- Excluir -->
                                        <form method="POST"
                                              action="{{ route('admin.turmas.destroy', $turma) }}">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    onclick="return confirm('Confirmar exclusão?')"
                                                    class="bg-red-100 hover:bg-red-200
                                                           text-red-700 px-4 py-2 rounded-xl
                                                           text-sm font-medium transition">

                                                <i class="ti ti-trash mr-1"></i>
                                                Excluir

                                            </button>

                                        </form>

                                    @else

                                        <!-- Reativar -->
                                        <form method="POST"
                                              action="{{ route('admin.turmas.reativar', $turma) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="bg-green-100 hover:bg-green-200
                                                           text-green-700 px-4 py-2 rounded-xl
                                                           text-sm font-medium transition">

                                                <i class="ti ti-refresh mr-1"></i>
                                                Reativar

                                            </button>

                                        </form>

                                        <!-- Certificados -->
                                        <a href="{{ route('admin.certificados.index', $turma) }}"
                                           class="bg-purple-100 hover:bg-purple-200
                                                  text-purple-700 px-4 py-2 rounded-xl
                                                  text-sm font-medium transition">

                                            <i class="ti ti-certificate mr-1"></i>
                                            Certificados

                                        </a>

                                    @endif

                                </div>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <!-- Paginação -->
            <div class="p-6 border-t border-slate-100">

                {{ $turmas->links() }}

            </div>

        </div>

    </main>

</div>

</body>
</html>