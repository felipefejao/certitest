# CertiTest — Especificação para Desenvolvimento com AI Harness / Devin

## 1. Visão geral

**Nome do projeto:** CertiTest

**Slogan:** Teste seus conhecimentos. Prepare-se para conquistar sua certificação.

O CertiTest é uma plataforma web de simulados e preparação para certificações e provas. O sistema permite que candidatos se cadastrem, escolham simulados, respondam questões, finalizem a prova, recebam o resultado imediatamente e acompanhem seu histórico de desempenho.

Administradores podem cadastrar e gerenciar provas e questões através do painel administrativo.

O produto deve ter aparência moderna, premium e educacional, utilizando **Glassmorphism**, microinterações e animações suaves.

---

# 2. Objetivos

## Objetivo principal

Criar uma plataforma simples, rápida e agradável para que usuários possam testar seus conhecimentos e acompanhar sua evolução.

## Objetivos secundários

- Facilitar a criação de simulados pelo administrador.
- Fornecer resultado imediato.
- Permitir compartilhamento dos resultados.
- Manter histórico de provas realizadas.
- Criar uma base arquitetural preparada para evolução futura para SaaS.
- Priorizar experiência mobile.
- Manter código limpo, testável e seguro.

---

# 3. Stack obrigatória

## Backend

- PHP
- Laravel
- Eloquent ORM
- Laravel Validation
- Laravel Policies/Gates
- Laravel Authentication

## Frontend

- Blade
- Livewire 4
- Tailwind CSS 4
- Alpine.js quando necessário

## Administração

- Filament 5

## Banco de dados

- PostgreSQL

## Animações

- Framer Motion ou solução compatível com a arquitetura Blade/Livewire.
- Caso Framer Motion não seja tecnicamente apropriado para determinado componente Blade/Livewire, utilizar CSS transitions ou Alpine.js, preservando o mesmo conceito visual.

## Testes

- PHPUnit ou Pest
- Laravel Feature Tests
- Laravel Unit Tests

---

# 4. Princípios de desenvolvimento

O agente de desenvolvimento deve:

1. Priorizar código simples e legível.
2. Evitar overengineering.
3. Seguir convenções oficiais do Laravel.
4. Utilizar componentes reutilizáveis.
5. Evitar duplicação.
6. Validar todas as entradas no backend.
7. Nunca confiar no frontend para regras críticas.
8. Garantir autorização através de Policies/Gates.
9. Garantir que candidatos nunca tenham acesso ao painel administrativo.
10. Garantir que respostas corretas nunca sejam expostas ao frontend antes da submissão.
11. Garantir responsividade mobile-first.
12. Criar testes para as regras de negócio principais.
13. Não implementar funcionalidades futuras antes de concluir o MVP.
14. Não adicionar dependências sem necessidade.
15. Documentar decisões técnicas relevantes.

---

# 5. Perfis de usuário

Existem dois roles:

```text
admin
candidate
```

## Admin

Pode:

- acessar painel Filament;
- criar provas;
- editar provas;
- excluir/desativar provas;
- cadastrar questões;
- visualizar candidatos;
- visualizar tentativas;
- visualizar resultados.

## Candidate

Pode:

- criar conta;
- fazer login;
- visualizar provas disponíveis;
- iniciar prova;
- responder questões;
- navegar entre questões;
- finalizar prova;
- visualizar resultado;
- compartilhar resultado;
- consultar histórico;
- visualizar resultados anteriores.

---

# 6. Autenticação

## Cadastro

Campos:

- nome;
- e-mail;
- senha;
- confirmação da senha.

Regras:

- e-mail obrigatório;
- e-mail único;
- senha obrigatória;
- senha deve ser armazenada com hash;
- validação server-side.

## Login

Permitir:

- e-mail;
- senha.

## Recuperação

Implementar recuperação de senha utilizando os recursos nativos do Laravel.

---

# 7. Modelo de dados

## users

Campos:

```text
id
name
email
password
role
email_verified_at
remember_token
created_at
updated_at
```

`role`:

```text
admin
candidate
```

Default:

```text
candidate
```

---

# 8. Tabela exams

Representa uma prova/simulado.

Campos:

```text
id
name
slug
description
questions
status
created_at
updated_at
```

## questions

No MVP, as questões podem ser armazenadas em JSON/JSONB no campo `questions`.

Formato:

```json
{
  "questions": [
    {
      "id": "uuid-ou-identificador",
      "question": "Qual é a alternativa correta?",
      "options": {
        "A": "Alternativa A",
        "B": "Alternativa B",
        "C": "Alternativa C",
        "D": "Alternativa D"
      },
      "correct_answer": "A"
    }
  ]
}
```

### Importante

A resposta correta nunca deve ser enviada ao navegador durante a execução da prova.

O backend deve utilizar a resposta correta somente durante a correção da tentativa.

---

# 9. Tabela attempts

Representa uma tentativa de um candidato.

Campos:

```text
id
user_id
exam_id
total_questions
correct_answers
wrong_answers
percentage
started_at
finished_at
created_at
updated_at
```

Relacionamentos:

```text
User hasMany Attempts
Exam hasMany Attempts
Attempt belongsTo User
Attempt belongsTo Exam
```

---

# 10. Tabela answers

Representa a resposta dada pelo candidato em uma tentativa.

Campos:

```text
id
attempt_id
question_id
selected_answer
is_correct
created_at
updated_at
```

Relacionamentos:

```text
Attempt hasMany Answers
Answer belongsTo Attempt
```

A tabela `answers` deve armazenar o identificador da questão e a resposta selecionada, permitindo reconstruir a tentativa posteriormente.

---

# 11. Status da prova

Uma prova pode ter:

```text
draft
published
inactive
```

Somente provas `published` devem aparecer para candidatos.

---

# 12. Fluxo do candidato

```text
HOME
  ↓
CADASTRO / LOGIN
  ↓
DASHBOARD
  ↓
LISTA DE PROVAS
  ↓
DETALHES DA PROVA
  ↓
CONFIRMAÇÃO
  ↓
INICIAR PROVA
  ↓
QUESTÕES
  ↓
RESPONDER
  ↓
PRÓXIMA QUESTÃO
  ↓
ÚLTIMA QUESTÃO
  ↓
CONFIRMAR ENVIO
  ↓
CORREÇÃO NO BACKEND
  ↓
RESULTADO
  ↓
HISTÓRICO
```

---

# 13. Home

Criar uma landing page moderna, atraente e persuasiva.

## Hero

Mensagem principal:

```text
TESTE SEUS
CONHECIMENTOS.
```

Texto:

```text
Prepare-se para certificações, provas e desafios profissionais
com simulados que mostram onde você realmente precisa melhorar.
```

CTA principal:

```text
Começar agora
```

CTA secundário:

```text
Explorar simulados
```

---

# 14. Seções da Home

A Home deve conter:

## Hero

- título forte;
- subtítulo;
- CTA;
- elementos visuais de questões/resultados;
- animações suaves.

## Como funciona

3 etapas:

```text
1. Escolha seu simulado
2. Teste seus conhecimentos
3. Veja seu resultado
```

## Benefícios

- Simulados práticos;
- Resultado instantâneo;
- Histórico de desempenho;
- Preparação focada;
- Experiência responsiva.

## Provas disponíveis

Exibir cards de provas publicadas.

## Estatísticas

Exemplos:

```text
+10.000 questões respondidas
+50 simulados
+1.000 candidatos
```

Os números devem ser configuráveis ou calculados dinamicamente. Não inventar métricas reais em produção.

## CTA final

```text
Pronto para descobrir o quanto você sabe?

Comece seu primeiro simulado agora.
```

---

# 15. Design System

## Estilo

O design deve seguir:

- Glassmorphism;
- Moderno;
- Premium;
- Educacional;
- Tecnológico;
- Minimalista;
- Mobile-first.

## Características visuais

- fundos com gradientes;
- cards translúcidos;
- backdrop blur;
- bordas sutis;
- sombras suaves;
- cantos arredondados;
- tipografia moderna;
- alto contraste;
- estados hover;
- microinterações.

## Acessibilidade

Garantir:

- contraste adequado;
- foco visível;
- navegação por teclado;
- labels apropriados;
- feedback visual e textual;
- áreas de toque adequadas em mobile.

---

# 16. Dashboard do candidato

Exibir:

```text
Olá, {nome} 👋

Continue sua preparação.
```

Cards:

```text
Provas realizadas
Média geral
Melhor resultado
Último resultado
```

Exibir também:

- provas disponíveis;
- últimos resultados;
- botão para continuar estudando;
- link para histórico.

---

# 17. Lista de provas

Cada prova deve aparecer em um card contendo:

```text
Nome
Descrição
Quantidade de questões
Status
Melhor resultado do candidato
Botão "Começar simulado"
```

Filtros futuros podem incluir:

- categoria;
- dificuldade;
- certificação.

No MVP, não implementar filtros complexos sem necessidade.

---

# 18. Detalhes / confirmação da prova

Antes de iniciar, mostrar:

```text
Nome da prova

Descrição

Quantidade de questões

Você poderá navegar entre as questões
antes de finalizar.

[Cancelar]
[Começar simulado]
```

Ao iniciar:

- criar `attempt`;
- registrar `started_at`;
- direcionar para a primeira questão.

---

# 19. Tela da prova

A experiência deve ser extremamente simples.

Exemplo:

```text
Questão 12 de 50

Qual alternativa está correta?

○ Alternativa A

○ Alternativa B

○ Alternativa C

○ Alternativa D

[Anterior]                     [Próxima]
```

Exibir:

```text
Questão 12 de 50
████████████░░░░░░░░ 24%
```

---

# 20. Navegação das questões

Criar indicador de questões.

Estados:

```text
respondida
não respondida
atual
```

Opcional no MVP:

```text
marcada para revisão
```

O candidato deve conseguir retornar a questões anteriores.

---

# 21. Lazy loading

As questões devem ser carregadas de forma eficiente.

Não carregar todo o conteúdo desnecessariamente na primeira renderização quando isso puder ser evitado.

Utilizar Livewire para controlar a questão atual.

Objetivos:

- menor payload;
- melhor experiência mobile;
- menor consumo;
- transições suaves.

---

# 22. Persistência das respostas

A resposta selecionada deve ser preservada durante a tentativa.

Exemplo:

```text
attempt_id
question_id
selected_answer
```

O candidato pode alterar a resposta antes de finalizar.

A correção definitiva ocorre somente no envio da prova.

---

# 23. Finalização

O botão de finalização deve ficar disponível somente no momento apropriado, preferencialmente na última etapa ou como ação claramente separada da navegação.

Antes de enviar:

```text
Tem certeza que deseja finalizar?

Você respondeu X de Y questões.

Questões não respondidas serão consideradas incorretas.

[Voltar]
[Finalizar prova]
```

Após confirmação:

```text
POST /attempts/{attempt}/submit
```

A operação deve:

1. validar que o candidato é dono da tentativa;
2. verificar que a tentativa ainda não foi finalizada;
3. obter a prova;
4. obter as respostas corretas no backend;
5. comparar respostas;
6. calcular acertos;
7. calcular erros;
8. calcular percentual;
9. salvar resultado;
10. registrar `finished_at`;
11. redirecionar para resultado.

---

# 24. Fórmula do resultado

```text
percentage = (correct_answers / total_questions) * 100
```

Arredondar conforme padrão definido pelo sistema.

Exemplo:

```text
50 questões
42 acertos
8 erros

84%
```

---

# 25. Tela de resultado

Mostrar:

```text
Simulado concluído!

84%

42 acertos
8 erros

Aproveitamento: 84%
```

Usar visualização gráfica para:

- percentual de acertos;
- percentual de erros.

Exibir também:

- nome da prova;
- data;
- quantidade total;
- acertos;
- erros;
- percentual.

---

# 26. Compartilhamento

Adicionar:

- WhatsApp;
- LinkedIn;
- Facebook;
- X;
- copiar link.

Mensagem padrão:

```text
Acabei de fazer o simulado {NOME_DA_PROVA} no CertiTest e consegui {PERCENTUAL}% de aproveitamento!

Teste seus conhecimentos também.
```

Não compartilhar dados privados.

---

# 27. Resultado público

Criar uma página pública de resultado utilizando um identificador seguro.

Exemplo:

```text
/result/{public_token}
```

A página pode mostrar:

```text
Resultado no CertiTest

PHP Certification

84% de aproveitamento

42/50 questões

Teste seus conhecimentos também.
[Começar simulado]
```

Nunca expor:

- e-mail;
- senha;
- dados internos;
- respostas privadas;
- informações sensíveis.

---

# 28. Histórico

Rota conceitual:

```text
/history
```

Mostrar:

```text
Prova
Data
Acertos
Erros
Percentual
Ação
```

Ação:

```text
Ver resultado
```

O candidato somente pode acessar suas próprias tentativas.

---

# 29. Filament 5

Criar painel administrativo utilizando Filament 5.

## Resources

```text
ExamResource
UserResource
AttemptResource
```

## ExamResource

Permitir:

- listar;
- criar;
- editar;
- excluir/desativar;
- publicar;
- despublicar.

Campos:

```text
name
slug
description
status
questions
```

O editor de questões deve ser amigável.

Idealmente utilizar um Repeater/Builder para:

```text
Pergunta
Opção A
Opção B
Opção C
Opção D
Resposta correta
```

O administrador não deve precisar editar JSON manualmente.

---

# 30. Dashboard Admin

Indicadores:

```text
Candidatos
Provas
Tentativas
Média geral
```

Exibir gráficos:

- tentativas por período;
- provas mais realizadas;
- média de aproveitamento;
- candidatos cadastrados.

---

# 31. Autorização

Implementar autorização rigorosa.

Regras:

```text
admin
    → acesso ao Filament

candidate
    → sem acesso ao Filament
```

Um candidato não pode:

- criar prova;
- editar prova;
- excluir prova;
- alterar respostas corretas;
- acessar tentativa de outro candidato;
- manipular resultado;
- finalizar tentativa de outro usuário.

Utilizar:

- Policies;
- Gates;
- Middleware;
- validações server-side.

---

# 32. Segurança

Obrigatório:

- CSRF;
- XSS protection;
- validação server-side;
- autorização server-side;
- password hashing;
- rate limiting onde apropriado;
- proteção contra mass assignment;
- IDs/token públicos não previsíveis;
- evitar exposição das respostas corretas;
- logs para operações administrativas importantes.

---

# 33. LGPD

O sistema deve seguir princípios básicos da LGPD.

Coletar somente os dados necessários.

Dados do candidato:

```text
nome
email
senha
```

Evitar armazenar informações desnecessárias.

Adicionar futuramente:

- política de privacidade;
- termos de uso;
- gerenciamento de consentimento quando aplicável;
- mecanismo para exclusão de conta.

---

# 34. Rotas conceituais

```text
/
 /login
 /register
 /forgot-password

 /dashboard
 /exams
 /exams/{exam}
 /exams/{exam}/start

 /attempts/{attempt}
 /attempts/{attempt}/submit
 /attempts/{attempt}/result

 /history
 /results/{token}
```

As rotas reais devem seguir convenções RESTful do Laravel quando apropriado.

---

# 35. Componentes Blade/Livewire sugeridos

```text
resources/views/
├── layouts/
├── components/
│   ├── glass-card.blade.php
│   ├── button.blade.php
│   ├── progress-bar.blade.php
│   ├── exam-card.blade.php
│   ├── result-card.blade.php
│   └── stat-card.blade.php
│
├── pages/
│   ├── home.blade.php
│   ├── dashboard.blade.php
│   ├── exams/
│   ├── attempts/
│   ├── history.blade.php
│   └── results/
│
└── livewire/
    ├── exam-list.blade.php
    ├── exam-player.blade.php
    ├── exam-result.blade.php
    └── history-list.blade.php
```

A estrutura pode ser adaptada às convenções do projeto.

---

# 36. Models sugeridos

```text
User
Exam
Attempt
Answer
```

Relacionamentos:

```text
User
 ├── hasMany Attempt

Exam
 └── hasMany Attempt

Attempt
 ├── belongsTo User
 ├── belongsTo Exam
 └── hasMany Answer

Answer
 └── belongsTo Attempt
```

---

# 37. Services sugeridos

Evitar colocar toda a lógica no Controller.

Criar serviços quando fizer sentido:

```text
ExamAttemptService
ExamCorrectionService
ResultSharingService
```

### ExamCorrectionService

Responsável por:

- receber tentativa;
- analisar respostas;
- calcular acertos;
- calcular erros;
- calcular percentual;
- persistir resultado.

---

# 38. Regras críticas de negócio

## Regra 1

Somente admins podem gerenciar provas.

## Regra 2

Somente candidatos podem realizar simulados.

## Regra 3

Somente provas publicadas podem ser iniciadas.

## Regra 4

Um candidato somente pode acessar suas próprias tentativas.

## Regra 5

Uma tentativa finalizada não pode ser alterada.

## Regra 6

O resultado deve ser calculado exclusivamente no backend.

## Regra 7

A resposta correta não deve ser enviada ao frontend durante a prova.

## Regra 8

Questões não respondidas devem ser consideradas erradas.

## Regra 9

Uma tentativa deve possuir data de início e finalização.

---

# 39. Testes obrigatórios

Criar testes para:

### Autenticação

- cadastro;
- login;
- logout;
- recuperação.

### Autorização

- candidato não acessa admin;
- candidato não gerencia provas;
- candidato não acessa tentativa de outro usuário.

### Provas

- prova publicada aparece;
- prova não publicada não aparece;
- admin consegue criar prova.

### Simulado

- candidato consegue iniciar;
- respostas são persistidas;
- candidato consegue alterar resposta;
- candidato consegue finalizar.

### Correção

Testar:

```text
10 questões
10 acertos = 100%

10 questões
5 acertos = 50%

10 questões
0 acertos = 0%
```

Também testar:

- questões não respondidas;
- respostas inválidas;
- tentativa já finalizada.

### Histórico

- candidato vê suas tentativas;
- candidato não vê tentativas de terceiros.

---

# 40. Seed inicial

Criar seeders para ambiente de desenvolvimento.

## Admin

Criar usuário administrativo através de configuração segura ou Seeder.

Nunca colocar senha real de produção no código.

## Provas

Criar pelo menos 2 provas fictícias para desenvolvimento.

Exemplo:

```text
PHP Fundamentals
Laravel Fundamentals
```

Cada uma com aproximadamente 10 questões.

---

# 41. UX Mobile

A plataforma deve ser pensada primeiro para celular.

Na tela de prova:

- opções grandes;
- botões acessíveis;
- progresso visível;
- navegação simples;
- evitar excesso de elementos;
- evitar scroll desnecessário.

---

# 42. Performance

Prioridades:

- queries eficientes;
- eager loading quando necessário;
- paginação;
- lazy loading;
- evitar N+1;
- assets otimizados;
- cache quando realmente necessário.

Não otimizar prematuramente.

---

# 43. SEO

A Home deve possuir:

- title;
- meta description;
- Open Graph;
- Twitter/X Card;
- URL amigável;
- headings semânticos.

Exemplo:

```text
Title:
CertiTest — Teste seus conhecimentos e prepare-se para certificações

Description:
Faça simulados, descubra seu desempenho e prepare-se melhor para suas próximas certificações.
```

---

# 44. Open Graph

Criar imagem de compartilhamento para resultados.

Quando possível, o resultado público deve possuir metadata dinâmica:

```text
Título:
Felipe conseguiu 84% no CertiTest

Descrição:
Veja o resultado e teste seus conhecimentos.
```

Não expor informações pessoais além do nome que o usuário escolheu tornar público.

---

# 45. Definition of Done — MVP

O MVP somente estará concluído quando:

- [ ] Laravel configurado
- [ ] PostgreSQL configurado
- [ ] Tailwind configurado
- [ ] Livewire configurado
- [ ] Filament 5 configurado
- [ ] Autenticação funcionando
- [ ] Roles funcionando
- [ ] Admin funcionando
- [ ] Candidato funcionando
- [ ] CRUD de provas funcionando
- [ ] Editor de questões funcionando
- [ ] Listagem de provas funcionando
- [ ] Início de tentativa funcionando
- [ ] Questões funcionando
- [ ] Persistência de respostas funcionando
- [ ] Finalização funcionando
- [ ] Correção backend funcionando
- [ ] Resultado funcionando
- [ ] Histórico funcionando
- [ ] Compartilhamento básico funcionando
- [ ] Responsividade funcionando
- [ ] Testes principais funcionando
- [ ] Seeders funcionando
- [ ] README atualizado

---

# 46. Ordem recomendada de implementação

## Sprint 1 — Fundação

1. Criar projeto Laravel.
2. Configurar PostgreSQL.
3. Configurar Tailwind.
4. Configurar Livewire.
5. Configurar Filament.
6. Configurar autenticação.
7. Implementar roles.
8. Criar estrutura base de layouts.

## Sprint 2 — Admin

1. Model User.
2. Model Exam.
3. Migration Exam.
4. ExamResource.
5. Editor de questões.
6. Publicação/despublicação.
7. Seeders.

## Sprint 3 — Candidato

1. Home.
2. Dashboard.
3. Lista de provas.
4. Detalhes.
5. Confirmação.
6. Início da tentativa.

## Sprint 4 — Player

1. Tela de questão.
2. Navegação.
3. Progresso.
4. Persistência.
5. Lazy loading.
6. Finalização.

## Sprint 5 — Resultado

1. Correção.
2. Estatísticas.
3. Tela de resultado.
4. Histórico.
5. Compartilhamento.
6. Resultado público.

## Sprint 6 — Refinamento

1. Glassmorphism.
2. Microinterações.
3. Animações.
4. Responsividade.
5. Acessibilidade.
6. SEO.
7. Testes.
8. Performance.
9. Revisão de segurança.

---

# 47. Critérios de qualidade

O agente deve revisar o código procurando:

- Controllers muito grandes;
- Models com lógica excessiva;
- Queries duplicadas;
- N+1;
- ausência de autorização;
- validações somente no frontend;
- dados sensíveis expostos;
- respostas corretas expostas;
- componentes Blade duplicados;
- problemas mobile;
- problemas de acessibilidade;
- dependências desnecessárias.

---

# 48. Funcionalidades NÃO implementar no MVP

Não implementar inicialmente:

- pagamentos;
- assinatura;
- multi-tenancy;
- ranking global;
- gamificação complexa;
- IA;
- geração automática de questões;
- aplicativo mobile nativo;
- API pública;
- white-label;
- marketplace;
- certificados oficiais.

Essas funcionalidades devem ficar para fases posteriores.

---

# 49. Roadmap futuro

## Fase 2

- categorias;
- dificuldade;
- tags;
- banco de questões;
- questões aleatórias;
- revisão de questões;
- estatísticas por assunto.

## Fase 3

- ranking;
- conquistas;
- gamificação;
- metas;
- evolução;
- recomendações de estudo.

## Fase 4

- planos pagos;
- Stripe/Asaas;
- assinatura;
- conteúdo premium.

## Fase 5

- multi-tenancy;
- academias;
- empresas;
- white-label;
- API.

---

# 50. Instruções específicas para o AI Agent

Ao desenvolver este projeto:

1. Antes de implementar uma funcionalidade, verificar se ela já existe.
2. Não sobrescrever código funcional sem necessidade.
3. Fazer alterações pequenas e verificáveis.
4. Após cada módulo relevante, executar testes.
5. Corrigir erros antes de avançar.
6. Não criar funcionalidades fora do escopo atual.
7. Manter migrations reversíveis.
8. Não utilizar dados mockados onde o banco real já estiver disponível.
9. Não expor respostas corretas no HTML/JavaScript durante a prova.
10. Validar autorização em todas as operações sensíveis.
11. Utilizar transações de banco durante a finalização/correção da tentativa.
12. Impedir submissão duplicada da mesma tentativa.
13. Considerar concorrência e refresh da página durante uma prova.
14. Garantir que o usuário não consiga alterar uma tentativa finalizada.
15. Utilizar componentes reutilizáveis para manter consistência visual.
16. Priorizar mobile.
17. Manter a interface em **Português do Brasil (pt-BR)**.
18. Código, classes, métodos e variáveis devem utilizar nomes em inglês.
19. Textos exibidos ao usuário devem estar em pt-BR.
20. Atualizar o README com instruções para instalação, configuração e execução.

---

# 51. Resultado esperado

Ao finalizar o MVP, deverá existir uma aplicação funcional onde:

```text
ADMIN
  ↓
Login
  ↓
Filament
  ↓
Criar prova
  ↓
Adicionar questões
  ↓
Publicar


CANDIDATO
  ↓
Cadastro
  ↓
Login
  ↓
Dashboard
  ↓
Escolher prova
  ↓
Iniciar
  ↓
Responder questões
  ↓
Finalizar
  ↓
Resultado
  ↓
Compartilhar
  ↓
Histórico
```

O sistema deve estar preparado para receber novas funcionalidades sem necessidade de reescrever a arquitetura principal.

---

# 52. Identidade do produto

**Nome:** CertiTest

**Slogan:**

> Teste seus conhecimentos. Prepare-se para conquistar sua certificação.

**Posicionamento:**

Uma plataforma moderna de simulados para quem quer transformar estudo em resultado.

**Tom de comunicação:**

- motivador;
- profissional;
- direto;
- tecnológico;
- educacional;
- sem linguagem excessivamente técnica.

