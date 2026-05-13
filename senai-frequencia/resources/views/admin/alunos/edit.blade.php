<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno – SENAI</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fb; }
        .input-focus:focus {
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            border-color: #3b82f6;
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
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-layout-grid text-xl"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('admin.alunos.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20">
                <i class="ti ti-users text-xl"></i>
                <span class="font-medium">Alunos</span>
            </a>

            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition text-slate-300">
                <i class="ti ti-building text-xl"></i>
                <span class="font-medium">Empresas</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">
            <div>
                <div class="flex items-center gap-2 text-blue-600 font-bold text-sm uppercase tracking-wider mb-2">
                    <i class="ti ti-edit"></i> Atualização de Cadastro
                </div>
                <h1 class="text-4xl font-bold text-[#0a1128] tracking-tight">Editar Aluno</h1>
                <p class="text-slate-500 mt-2">Modifique as informações de matrícula, turma ou vínculo empresarial.</p>
            </div>
            <a href="{{ route('admin.alunos.index') }}" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl font-medium hover:bg-slate-50 transition flex items-center gap-2 text-slate-700 shadow-sm">
                <i class="ti ti-arrow-left"></i> Voltar
            </a>
        </div>

        @if($errors->any())
            <div class="mb-8 bg-red-50 border border-red-100 text-red-700 rounded-2xl p-5 flex gap-4">
                <i class="ti ti-alert-circle text-2xl"></i>
                <div>
                    <p class="font-bold">Ajuste os seguintes pontos:</p>
                    <ul class="list-disc list-inside text-sm opacity-90 mt-1">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="max-w-4xl bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            
            <div class="p-8 border-b border-slate-100 bg-slate-50/30 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xl shadow-lg shadow-blue-100">
                    {{ strtoupper(substr($aluno->nome, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-[#0a1128]">{{ $aluno->nome }}</h2>
                    <p class="text-slate-400 text-sm italic">Matrícula: {{ $aluno->matricula }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.alunos.update', $aluno) }}" class="p-8 space-y-8">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Nome Completo</label>
                        <input type="text" name="nome" value="{{ old('nome', $aluno->nome) }}" required
                               class="input-focus bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Número de Matrícula</label>
                        <input type="text" name="matricula" value="{{ old('matricula', $aluno->matricula) }}" required
                               class="input-focus bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 font-mono text-slate-800 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Turma Atual</label>
                        <div class="relative">
                            <select name="turma_id" required
                                    class="w-full bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none focus:ring-2 ring-blue-500/20 transition appearance-none">
                                <option value="">Selecione a turma...</option>
                                @foreach($turmas as $turma)
                                    <option value="{{ $turma->id }}" {{ $aluno->turma_id == $turma->id ? 'selected' : '' }}>
                                        {{ $turma->nome }} – {{ $turma->curso }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="ti ti-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Empresa Parceira (Opcional)</label>
                        <div class="relative">
                            <select name="empresa_id"
                                    class="w-full bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none focus:ring-2 ring-blue-500/20 transition appearance-none">
                                <option value="">Nenhuma empresa vinculada</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ $aluno->empresa_id == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->nome }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="ti ti-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">CPF *</label>
                        <input type="text" name="cpf" value="{{ old('cpf', $aluno->cpf) }}" required
                               placeholder="000.000.000-00"
                               class="input-focus bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 font-mono text-slate-800 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Email do Aluno *</label>
                        <input type="email" name="email" value="{{ old('email', $aluno->email) }}" required
                               placeholder="aluno@dominio.com"
                               class="input-focus bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Nova Senha</label>
                        <input type="password" name="password"
                               placeholder="Deixe em branco para manter a atual"
                               class="input-focus bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Confirmar Senha</label>
                        <input type="password" name="password_confirmation"
                               placeholder="Confirme a nova senha"
                               class="input-focus bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Data de Nascimento *</label>
                        <input type="date" name="data_nascimento" value="{{ old('data_nascimento', $aluno->data_nascimento?->format('Y-m-d')) }}" required
                               class="input-focus bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Endereço *</label>
                        <textarea name="endereco" required rows="3"
                                  class="input-focus bg-slate-100 border-2 border-transparent rounded-2xl px-5 py-3.5 text-slate-800 outline-none transition-all">{{ old('endereco', $aluno->endereco) }}</textarea>
                    </div>

                </div>

                <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.alunos.index') }}" class="px-6 py-3 rounded-xl font-bold text-slate-400 hover:text-slate-600 transition">
                        Descartar Alterações
                    </a>
                    <button type="submit"
                            class="bg-[#0a1128] hover:bg-blue-700 text-white font-bold px-10 py-3.5 rounded-2xl transition shadow-lg shadow-blue-100 flex items-center gap-2">
                        <i class="ti ti-check text-xl"></i> Atualizar Aluno
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

</body>
</html>