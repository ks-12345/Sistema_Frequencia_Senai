<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Aluno – SENAI</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
        .card-gradient { background: linear-gradient(135deg, #0a1128 0%, #1c2a4e 100%); }
    </style>
</head>
<body class="text-slate-900">

<div class="min-h-screen pb-12">
    <nav class="bg-[#0a1128] text-white px-6 py-4 mb-8 shadow-lg">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="ti ti-school text-xl"></i>
                </div>
                <span class="font-black tracking-tighter uppercase text-sm">Rede SENAI</span>
            </div>
            
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-red-400 transition">
                Sair <i class="ti ti-logout text-lg"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6">
        
        <div class="mb-8">
            <p class="text-blue-600 font-black text-[10px] uppercase tracking-[0.3em] mb-1">Painel do Aprendiz</p>
            <h1 class="text-3xl font-black text-[#0a1128] tracking-tight">
                Olá, {{ explode(' ', $aluno->nome ?? Auth::user()->name)[0] }}! 
            </h1>
            <p class="text-slate-500 text-sm mt-1">Sua jornada técnica começa aqui.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-blue-900/10 border border-slate-200 overflow-hidden mb-8">
            <div class="card-gradient p-8 text-white relative">
                <div class="absolute right-[-20px] top-[-20px] w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 rounded-2xl bg-blue-600 flex items-center justify-center shadow-xl border border-white/10">
                            <i class="ti ti-user-circle text-4xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-extrabold tracking-tight">{{ $aluno->nome ?? Auth::user()->name }}</h2>
                            <p class="text-blue-300 text-xs font-bold uppercase tracking-widest">{{ $aluno->turma->nome ?? 'Aprendizagem Industrial' }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/10">
                        <p class="text-[10px] font-black uppercase text-blue-200 tracking-[0.2em]">Registro de Matrícula</p>
                        <p class="text-2xl font-black font-mono tracking-tighter">{{ $aluno->matricula ?? '---' }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8 grid md:grid-cols-2 gap-8 bg-white">
                <div class="space-y-6">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 flex items-center gap-2">
                        <i class="ti ti-id-badge-2 text-blue-600 text-lg"></i> Informações do Aluno
                    </h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">Documento (CPF)</p>
                            <p class="text-sm font-bold text-slate-700">{{ $aluno->cpf ?? 'Não cadastrado' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">Nascimento</p>
                            <p class="text-sm font-bold text-slate-700">{{ optional($aluno->data_nascimento)->format('d/m/Y') ?? '---' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">Email de Contato</p>
                            <p class="text-sm font-bold text-slate-700 truncate">{{ $aluno->email ?? '---' }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-center">
                    <div class="bg-blue-50 p-8 rounded-[2rem] border border-blue-100 flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md mb-4">
                            <i class="ti ti-qrcode text-3xl text-blue-600"></i>
                        </div>
                        <h4 class="font-bold text-[#0a1128]">Frequência Digital</h4>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Apresente seu QR Code no coletor da unidade para registrar sua entrada e saída.
                        </p>
                        
                        <a href="{{ route('aluno.cracha') }}" class="mt-6 w-full inline-flex items-center justify-center gap-2 bg-[#0a1128] text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-900/20 active:scale-95">
                            <i class="ti ti-scan text-lg"></i> Abrir Meu Crachá
                        </a>
                        <a href="{{ route('aluno.justificativas.index') }}" class="mt-3 w-full inline-flex items-center justify-center gap-2 bg-white text-[#0a1128] border border-blue-100 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-50 transition-all active:scale-95">
                            <i class="ti ti-file-description text-lg"></i> Justificativas e Atestados
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em]">
                Sistema Integrado de Gestão SENAI &copy; 2026
            </p>
        </div>
    </div>
</div>

</body>
</html>
