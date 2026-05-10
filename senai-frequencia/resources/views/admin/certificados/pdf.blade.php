<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: Arial, sans-serif;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        padding: 40px;
    }
    .certificado {
        border: 8px double #1a56db;
        padding: 50px 60px;
        text-align: center;
        width: 100%;
    }
    .titulo    { font-size: 32px; color: #1a56db; font-weight: bold; margin-bottom: 8px; }
    .subtitulo { font-size: 16px; color: #555; margin-bottom: 40px; }
    .texto     { font-size: 16px; margin: 12px 0; color: #333; }
    .nome      { font-size: 30px; font-weight: bold; color: #111; margin: 24px 0; border-bottom: 2px solid #1a56db; padding-bottom: 12px; }
    .curso     { font-size: 22px; color: #1a56db; margin: 16px 0; font-weight: bold; }
    .rodape    { font-size: 12px; color: #999; margin-top: 40px; }
    .codigo    { font-size: 11px; color: #bbb; margin-top: 8px; }
    .assinatura { margin-top: 48px; display: inline-block; border-top: 1px solid #333; padding-top: 8px; font-size: 13px; }
</style>
</head>
<body>
    <div class="certificado">
        <div class="titulo">CERTIFICADO DE CONCLUSÃO</div>
        <div class="subtitulo">Rede SENAI – Sistema de Frequência Acadêmica</div>

        <div class="texto">Certificamos que</div>
        <div class="nome">{{ $certificado->aluno->nome }}</div>

        <div class="texto">concluiu com êxito o curso de</div>
        <div class="curso">{{ $certificado->turma->curso }}</div>

        <div class="texto">
            com carga horária de <strong>{{ $certificado->carga_horaria }} horas</strong>
            e frequência de <strong>{{ $certificado->percentual_presenca }}%</strong>.
        </div>

        <div class="texto">
            Turma: <strong>{{ $certificado->turma->nome }}</strong> —
            Concluído em: <strong>{{ $certificado->data_conclusao->format('d/m/Y') }}</strong>
        </div>

        <div class="assinatura">
            Direção SENAI
        </div>

        <div class="rodape">Este certificado é válido mediante apresentação de documento de identidade.</div>
        <div class="codigo">Código de verificação: {{ $certificado->codigo }}</div>
    </div>
</body>
</html>