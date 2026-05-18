# Modulo de substituicoes docentes

## Arquitetura

O professor possui uma unica conta em `users`. A atuacao como titular ou substituto e um contexto de sessao (`teacher_acting_mode`) escolhido apos o login. Quando o modo substituto e iniciado, o sistema cria um registro em `teacher_substitution_logs` e usa esse registro para limitar as turmas acessiveis.

Camadas principais:

- Controllers de contexto: `Professor\ActingContextController`
- Controllers operacionais: frequencia e diario usam o contexto ativo para autorizar turma
- Auditoria: `TeacherSubstitutionLog` e `spatie/laravel-activitylog`
- Relatorio administrativo: `Admin\TeacherSubstitutionLogController`
- Exportacao: `TeacherSubstitutionLogsExport`

## Modelagem

Tabela `teacher_substitution_logs`:

- `teacher_id`: professor substituto
- `substituted_teacher_id`: professor titular substituido
- `class_id`: turma acessada
- `subject_id`: reservado para futura tabela de disciplinas
- `started_at`, `ended_at`, `total_hours`
- `created_by`: usuario que criou/autorizou o registro
- `status`: `ativa`, `encerrada` ou `cancelada`

Como o sistema atual nao possui entidade `disciplina`, a exportacao usa `turmas.curso` como coluna de disciplina.

## Fluxograma

Login -> escolha de atuacao -> contexto titular ou substituto -> atividades -> encerramento da substituicao -> relatorios.

No modo titular, o professor ve somente turmas onde `turmas.professor_id = users.id`.

No modo substituto, o professor seleciona turma e titular. O sistema valida que a turma pertence ao titular informado e grava a sessao em `teacher_substitution_logs`.

## APIs REST/rotas

- `GET /professor/atuacao`: tela de escolha
- `POST /professor/atuacao/titular`: ativa modo titular
- `GET /professor/atuacao/substituto`: formulario de substituicao
- `POST /professor/atuacao/substituto`: inicia substituicao
- `POST /professor/atuacao/substituto/encerrar`: encerra substituicao ativa
- `GET /admin/substitutos`: relatorio administrativo com filtros por professor, titular, turma, disciplina, periodo e status
- `GET /admin/substitutos/exportar`: exporta XLSX

## Regras de negocio

- Nao criar contas temporarias para substitutos.
- Um professor nao pode substituir a si mesmo.
- A turma escolhida deve pertencer ao professor titular substituido.
- Apenas uma substituicao ativa por sessao; iniciar outra encerra a anterior.
- Horas totais sao calculadas no encerramento, sem campo editavel na interface.
- Frequencia e diario autorizam turma pelo contexto ativo.

## Casos de uso

- Professor titular acessa suas turmas oficiais.
- Professor substituto registra uma substituicao e atua somente na turma selecionada.
- Administrador consulta e exporta substituicoes por professor, titular, turma, periodo e status.

## Edge cases

- Sessao sem contexto: redireciona para escolha de atuacao.
- Log ativo ausente ou encerrado: limpa contexto e solicita nova escolha.
- Turma finalizada: segue bloqueio operacional ja existente nas telas de frequencia/diario.
- Troca de titular para substituto: encerra substituicao ativa antes de mudar o contexto.

## Auditoria e seguranca

- `teacher_substitution_logs` guarda dados estruturados da substituicao.
- `activitylog` registra troca de contexto, inicio e encerramento.
- Rotas permanecem protegidas por `auth` e `role:professor`/`role:admin`.
- A duracao e calculada pelo backend no encerramento.
- Indices por professor, titular, turma e periodo mantem consultas administrativas eficientes.

## Exportacao Excel

A exportacao usa `maatwebsite/excel` e gera `.xlsx` com as colunas:

- Professor Substituto
- Professor Titular
- Turma
- Disciplina
- Data
- Hora Inicio
- Hora Fim
- Total de Horas
- Status

## Escalabilidade

- Criar uma tabela de disciplinas e substituir o `subject_id` reservado por FK real.
- Mover regras de contexto para um service dedicado se mais controllers passarem a depender delas.
- Adicionar autorizacao administrativa previa usando `created_by` como aprovador.
- Criar job assinado para encerrar automaticamente substituicoes esquecidas.
