<!DOCTYPE html>
<html>
<head><title>Editar Aula – {{ $turma->nome }}</title></head>
<body>
    <h1>Editar Aula Nº {{ $aula->aula_numero }}</h1>
    <p>Turma: <strong>{{ $turma->nome }}</strong> – {{ $turma->curso }}</p>
    <a href="{{ route('professor.diario.turma', $turma) }}">Voltar</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('professor.diario.update', [$turma, $aula]) }}">
        @csrf @method('PUT')
        <p>
            <label>Número da Aula</label><br>
            <input type="number" name="aula_numero" value="{{ old('aula_numero', $aula->aula_numero) }}" min="1" required>
        </p>
        <p>
            <label>Data</label><br>
            <input type="date" name="data" value="{{ old('data', $aula->data->toDateString()) }}" required>
        </p>
        <p>
            <label>Título / Tema da Aula</label><br>
            <input type="text" name="titulo" value="{{ old('titulo', $aula->titulo) }}" style="width:400px" required>
        </p>
        <p>
            <label>Conteúdo Desenvolvido</label><br>
            <textarea name="conteudo" rows="6" cols="60" required>{{ old('conteudo', $aula->conteudo) }}</textarea>
        </p>
        <button type="submit">Atualizar</button>
    </form>
</body>
</html>