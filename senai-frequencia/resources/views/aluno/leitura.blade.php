<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simular Acesso - SENAI</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f3f4f6; margin: 0; }
        .card { width: 380px; padding: 32px; border-radius: 22px; background: #fff; border: 1px solid #dbeafe; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08); text-align: center; }
        .card h1 { color: #0f172a; font-size: 22px; margin: 0 0 8px; }
        .card p { font-size: 15px; margin: 8px 0; color: #334155; }
        label { display: block; margin: 18px 0 8px; text-align: left; color: #334155; font-size: 13px; font-weight: bold; }
        select, input { width: 100%; box-sizing: border-box; border: 1px solid #cbd5e1; border-radius: 14px; padding: 12px 14px; color: #334155; font-size: 14px; }
        button { width: 100%; border: 0; cursor: pointer; }
        .btn { display: inline-block; margin-top: 16px; padding: 10px 18px; background: #2563eb; color: #fff; border-radius: 999px; text-decoration: none; font-size: 13px; }
        .btn-secondary { background: #64748b; }
        .error { margin-top: 14px; padding: 12px; border-radius: 14px; background: #fee2e2; color: #b91c1c; font-size: 13px; text-align: left; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Simular passagem do cracha</h1>
        <p><strong>Nome:</strong> {{ $aluno->nome }}</p>
        <p><strong>Matricula:</strong> {{ $aluno->matricula }}</p>
        <p><strong>Turma:</strong> {{ $aluno->turma->nome ?? '---' }}</p>

        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('aluno.registrar-acesso') }}">
            @csrf

            <label for="tipo">Tipo de registro</label>
            <select id="tipo" name="tipo" required>
                <option value="entrada_portaria">Entrada Portaria</option>
                <option value="entrada_bloco">Entrada Bloco</option>
                <option value="saida">Saida</option>
            </select>

            <label for="local">Local</label>
            <input id="local" type="text" name="local" placeholder="Ex: Bloco A">

            <button type="submit" class="btn">Confirmar passagem</button>
        </form>

        <a href="{{ route('aluno.cracha') }}" class="btn">Ver Cracha</a>
        <a href="{{ route('aluno.dashboard') }}" class="btn btn-secondary">Voltar ao Painel</a>
    </div>
</body>
</html>
