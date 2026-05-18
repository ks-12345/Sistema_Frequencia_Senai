# TODO - Fluxo de Aprovação de Frequência (Professor -> Secretaria -> Empresa)

## Planejado (aprovado)
1. Criar modelo/tabela para registrar episódio de substituição (turma, professor titular, substituto, início/fim).
2. Criar workflow pós-login: tela/rota “Como você deseja atuar hoje?” com opções Titular/Substituto.
3. Ao selecionar Substituto, registrar episódio com:
   - turma selecionada
   - titular identificado via `turma.professor_id`
   - data/hora de início (fim ao sair de substituto)
4. Ajustar controllers `Professor\FrequenciaController` e `Professor\DiarioAulaController` para usar o “estado de atuação atual” ao invés de `is_substituto` permanente.
5. Implementar filtro de turmas para Substituto (manter pivot `professor_turma` como “quais turmas o substituto pode cobrir”).
6. Criar relatório Excel de substituições por período (filtro data_início/data_fim) para o professor.
7. Atualizar UI (dashboard do professor) para permitir alternância e indicar atuação atual.

## Progresso
- [ ] Criar tabela/modelo para episódios de substituição
- [ ] Criar controller/rota/tela de workflow pós-login
- [ ] Implementar registro do episódio ao iniciar Substituição
- [ ] Ajustar lógica de turmas/atuação em Frequencia/Diário
- [ ] Gerar export Excel do relatório de substituições
- [ ] Atualizar UI e navegação

