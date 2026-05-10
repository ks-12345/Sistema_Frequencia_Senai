<!DOCTYPE html>
<html>
<head><title>Nova Aula – {{ $turma->nome }}</title></head>
<body>
    <h1>Registrar Nova Aula</h1>
    <p>Turma: <strong>{{ $turma->nome }}</strong> – {{ $turma->curso }}</p>
    <a href="{{ route('professor.diario.turma', $turma) }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('professor.diario.store', $turma) }}">
        @csrf
        <p>
            <label>Número da Aula</label><br>
            <input type="number" name="aula_numero" value="{{ old('aula_numero', $proximaAula) }}" min="1" required>
        </p>
        <p>
            <label>Data</label><br>
            <input type="date" name="data" value="{{ old('data', today()->toDateString()) }}" required>
        </p>
        <p>
            <label>Título / Tema da Aula</label><br>
            <input type="text" name="titulo" value="{{ old('titulo') }}" style="width:400px" required
                   placeholder="Ex: Introdução aos circuitos elétricos">
        </p>
        <p>
            <label>Conteúdo Desenvolvido</label><br>
            <textarea name="conteudo" rows="6" cols="60" required
                      placeholder="Descreva o conteúdo abordado na aula...">{{ old('conteudo') }}</textarea>
        </p>
        <button type="submit">Salvar no Diário</button>
    </form>
</body>
</html>