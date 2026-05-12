# Sistema: Controle de Frequência – Rede SENAI 📚

## Visão Geral
Sistema web para gerenciamento de frequência acadêmica focado em segurança, rastreabilidade e integração entre escola, professores e empresas.

## 🛠 Tecnologias 
- **Backend:** PHP (Laravel) 
- **Banco de Dados:** MySQL
- **Segurança:** RBAC (Controle de Acesso Baseado em Perfis)

## 🔐 Níveis de Acesso
1. **Administrador:** Acesso total, auditoria e cadastros.
2. **Professor:** Lançamento de chamada, controle de professores substitutos e históricos.
3. **Empresa:** Acompanhamento exclusivo de seus aprendizes (apenas leitura).

## Diferencial: Controle de Saída
O sistema permite registrar de forma detalhada:
- Horário de saída e retorno.
- Motivo (Almoço, Médico, Emergência).
- Cálculo automático de tempo fora e impacto na assiduidade.

## 📊 Estrutura de Dados 
- `Usuarios`: Login e permissões.
- `Alunos`: Dados acadêmicos e vínculo com empresas.
- `Frequencias`: Registros diários e status.
- `Empresas`: Gestão de parceiros.

## 📝 Status de Frequência
| Status | Descrição |
| :--- | :--- |
| **Presente** | Participação normal |
| **Atraso** | Entrada pós-horário |
| **Saída Temporária** | Saiu e retornou |
| **Falta Parcial** | Saiu antes do fim |

---

## Conclusão

O sistema de **Controle de Frequência da Rede SENAI** consolida-se como uma ferramenta estratégica de governança, automatizando o monitoramento das atividades docentes e a precisão dos registros acadêmicos. Ao integrar professores e administração em uma plataforma única, a solução mitiga falhas operacionais e substitui processos manuais por um fluxo de trabalho **auditável** e de alta rastreabilidade.

O diferencial do sistema reside no rigoroso **controle de saídas e substituições**, permitindo uma supervisão detalhada da jornada em sala de aula e da dinâmica de ensino. A automação no registro de atrasos e ausências oferece à gestão escolar uma visão analítica imediata, garantindo que a carga horária seja cumprida com exatidão e que as empresas parceiras recebam dados de assiduidade baseados em **informações precisas e comprováveis**.

Em suma, o projeto entrega uma infraestrutura robusta que otimiza a gestão de recursos humanos e pedagógicos, refletindo diretamente na qualidade da **formação profissional**. Ao converter a presença em uma base de dados inteligente, o sistema assegura o estrito cumprimento das normas administrativas e reafirma o compromisso do SENAI com a excelência educacional e a transparência perante o setor industrial.

---
*Documentação gerada para suporte ao projeto de Controle de Frequência SENAI.*
