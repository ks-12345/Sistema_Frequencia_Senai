# TODO - Fluxo de Aprovação de Frequência (Professor -> Secretaria -> Empresa)

## Passos
- [ ] 1. Corrigir backend da Empresa para **filtrar somente frequências `status = aprovado`** (e manter filtro por `empresa_id`/alunos vinculados).
- [ ] 2. Implementar no Professor: botão **“Enviar para Secretaria”** por **data/turma (bulk)**
  - [ ] 2.1 Ao enviar: setar `status = pendente_aprovacao` e `enviado_secretaria_em = now()` para todos os registros da turma na data.
  - [ ] 2.2 Bloquear edição: impedir `atualizar` quando `status` for `pendente_aprovacao`.
- [ ] 3. Criar controller da Secretaria (novo): listagem de pendentes e ações
  - [ ] 3.1 `aprovar` (bulk ou por registro): setar `status = aprovado`, `aprovado_secretaria_em = now()`, `aprovado_por = Auth::id()`.
  - [ ] 3.2 `devolver` (bulk ou por registro): setar `status = devolvido_correcao` e salvar `motivo_devolucao`.
- [ ] 4. Criar views da Secretaria
  - [ ] 4.1 Painel de pendências com agregados (quantidade, presenças/faltas/atrasos/saídas antecipadas)
  - [ ] 4.2 Botões aprovar/devolver + modal com motivo
- [ ] 5. Atualizar views do Professor
  - [ ] 5.1 Badge do status e aviso de bloqueio após envio
  - [ ] 5.2 Botão “Enviar para Secretaria” na tela de lançamento
- [ ] 6. Regras de permissão
  - [ ] 6.1 Criar/ajustar Policy/Gate para bloquear acesso indevido
  - [ ] 6.2 Validar também no controller (server-side) para impedir edição/visualização por status
- [ ] 7. Histórico/log
  - [ ] 7.1 Criar tabela/model (ou mecanismo existente) para registrar toda mudança de status e responsável
  - [ ] 7.2 Registrar quando professor envia, secretaria aprova/devolve, e professor volta a editar
- [ ] 8. Adicionar rotas em `routes/web.php` para professor/secretaria
- [ ] 9. Testar fluxo completo (professor -> secretaria -> empresa) e garantir bloqueios

