<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificados – {{ $turma->nome }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fb; }
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

            <a href="{{ route('admin.turmas.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-users text-xl"></i>
                <span class="font-medium">Turmas</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <div class="mb-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                <div>
                    <div class="flex items-center gap-2 text-indigo-600 font-bold text-sm uppercase tracking-widest mb-2">
                        <i class="ti ti-award"></i> Emissão de Documentos
                    </div>
                    <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Certificados</h1>
                    <div class="flex items-center gap-4 mt-3">
                        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold uppercase">{{ $turma->nome }}</span>
                        <span class="text-slate-500 text-sm flex items-center gap-1">
                            <i class="ti ti-hourglass-low"></i> Carga Horária: <strong>{{ $turma->carga_horaria }}h</strong>
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.turmas.index') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                        <i class="ti ti-arrow-left"></i> Voltar
                    </a>
                    
                    <form method="POST" action="{{ route('admin.certificados.gerar-todos', $turma) }}">
                        @csrf
                        <button onclick="return confirm('Gerar certificados para todos os alunos aptos?')" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl transition shadow-lg shadow-indigo-100 flex items-center gap-2">
                            <i class="ti ti-copy-check"></i> Gerar Todos
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl p-4 flex items-center gap-3">
                <i class="ti ti-circle-check-filled text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-4 flex items-center gap-3">
                <i class="ti ti-alert-circle-filled text-xl"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 text-xs uppercase tracking-widest">
                        <th class="px-8 py-5 font-bold">Aluno / Matrícula</th>
                        <th class="px-6 py-5 font-bold text-center">Frequência</th>
                        <th class="px-6 py-5 font-bold">Autenticação</th>
                        <th class="px-8 py-5 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($alunos as $aluno)
                    @php $cert = $certificados->get($aluno->id) @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="font-bold text-[#0a1128]">{{ $aluno->nome }}</div>
                            <div class="text-xs text-slate-400 font-mono tracking-tighter">{{ $aluno->matricula }}</div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            @if($cert)
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $cert->percentual_presenca >= 75 ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    <i class="ti {{ $cert->percentual_presenca >= 75 ? 'ti-circle-check' : 'ti-alert-triangle' }}"></i>
                                    {{ $cert->percentual_presenca }}%
                                </div>
                            @else
                                <span class="text-slate-300 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-6">
                            @if($cert)
                                <span class="text-xs font-mono bg-slate-100 px-2 py-1 rounded text-slate-500">{{ $cert->codigo }}</span>
                            @else
                                <span class="text-slate-300 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-3">
                                <form method="POST" action="{{ route('admin.certificados.gerar', [$turma, $aluno]) }}">
                                    @csrf
                                    <button class="text-sm font-bold {{ $cert ? 'text-slate-400 hover:text-indigo-600' : 'text-indigo-600 hover:text-indigo-800' }} transition flex items-center gap-1">
                                        <i class="ti {{ $cert ? 'ti-refresh' : 'ti-circle-plus' }}"></i>
                                        {{ $cert ? 'Regenerar' : 'Gerar Certificado' }}
                                    </button>
                                </form>

                                @if($cert)
                                    <div class="w-px h-4 bg-slate-200"></div>
                                    <a href="{{ route('admin.certificados.download', $cert) }}" 
                                       class="bg-slate-100 hover:bg-slate-200 text-slate-700 p-2 rounded-lg transition"
                                       title="Download PDF">
                                        <i class="ti ti-download text-lg"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="mt-6 text-center text-slate-400 text-xs flex items-center justify-center gap-2">
            <i class="ti ti-info-circle"></i>
            A presença mínima exigida para certificação é de 75% conforme regimento institucional.
        </p>

    </main>
</div>

</body>
</html>