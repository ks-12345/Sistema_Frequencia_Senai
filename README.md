# Sistema: Controle de Frequência – Rede SENAI 📚

## Visão Geral
Sistema web para gerenciamento de frequência acadêmica focado em segurança, rastreabilidade e integração entre escola, professores e empresas.

## Tecnologias 
- **Backend:** PHP (Laravel) 
- **Frontend:** TailwindCSS
- **Banco de Dados:** MySQL
- **Segurança:** RBAC (Controle de Acesso Baseado em Perfis)

## Níveis de Acesso
1. **Administrador:** Acesso total, auditoria e cadastros.
2. **Professor:** Lançamento de chamada, controle de professores substitutos e históricos.
3. **Empresa:** Acompanhamento exclusivo de seus aprendizes (apenas leitura).

## Diferencial: Controle de Saída
O sistema permite registrar:
- Horário de saída e retorno.
- Motivo (Almoço, Médico, Emergência).
- Cálculo automático de tempo fora e impacto na assiduidade.

## Estrutura de Dados 
- `Usuarios`: Login e permissões.
- `Alunos`: Dados acadêmicos e vínculo com empresas.
- `Frequencias`: Registros diários e status.
- `Empresas`: Gestão de parceiros.

## Status de Frequência
| Status | Descrição |
| :--- | :--- |
| **Presente** | Participação normal |
| **Atraso** | Entrada pós-horário |
| **Saída Temporária** | Saiu e retornou |
| **Falta Parcial** | Saiu antes do fim |

---
*Documentação gerada para suporte ao projeto de Controle de Frequência SENAI.*