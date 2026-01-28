# Estagfy — TCC de Gestão de Estágios

> Uma plataforma web para conectar estudantes, empresas e instituições, centralizando todo o ciclo do estágio em um só lugar.

<p align="center">
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="PHP" width="48" height="48" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" alt="JavaScript" width="48" height="48" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" alt="HTML5" width="48" height="48" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" alt="CSS3" width="48" height="48" />
</p>

<p align="center">
  <strong>Organizado. Transparente. Aprovado.</strong>
</p>

---

## Visão geral
O **Estagfy** nasceu como TCC para resolver um problema real: o processo de estágio costuma ser manual, fragmentado e burocrático. A proposta é transformar isso em um fluxo simples, digital e rastreável, trazendo agilidade para estudantes, coordenadores e empresas.

**Destaques rápidos**
- Centraliza documentos, vagas e aprovações
- Acompanha o status do estágio em tempo real
- Facilita comunicação entre as partes
- Reduz erros e retrabalho

## Problema que o projeto resolve
Muitos estágios são geridos por planilhas, e‑mails e documentos soltos, o que gera:
- Falta de rastreabilidade
- Prazos perdidos
- Assinaturas e termos inconsistentes
- Baixa visibilidade para coordenadores

O Estagfy propõe um fluxo claro e auditável, do cadastro da vaga até a finalização do estágio.

## Funcionalidades (principais)
- Cadastro e gestão de vagas
- Registro de estudantes e empresas
- Fluxo de aprovação do estágio
- Acompanhamento de etapas e prazos
- Painel por perfil (estudante, empresa, coordenação)

## Linguagens usadas
- PHP
- JavaScript
- HTML
- CSS

## Stack e tecnologias
- **Backend:** Laravel (PHP)
- **Frontend:** Blade + Tailwind CSS
- **Build:** Vite
- **Banco de dados:** MySQL 


## Como rodar localmente
> Pré‑requisitos: PHP, Composer, Node.js e um banco de dados.

```bash
# 1) Instale dependências do backend
composer install

# 2) Configure o ambiente
cp .env.example .env
php artisan key:generate

# 3) Configure o banco no .env e rode as migrações
php artisan migrate

# 4) Instale dependências do frontend
npm install

# 5) Execute o projeto
npm run dev
php artisan serve
```

## Estrutura do projeto
```
app/            # Regras de negócio
resources/      # Views e assets
routes/         # Rotas da aplicação
database/       # Migrações e seeders
public/         # Arquivos públicos
```

## Roadmap (próximos passos)
- Notificações por e‑mail e alertas
- Relatórios por curso e empresa
- Assinatura digital de termos
- Dashboard com métricas

## Demonstração
```
📸 /public/demo
```

## Sobre o TCC
**Tema:** 

**Objetivo:** Propor e implementar uma plataforma que reduza burocracia e aumente transparência no processo de estágio.

## Autoria
- **Autor(a):** Luis Gustavo Cardoso da Silva
- **Orientador(a):** Professor Mestre George Mendes Dourado
- **Instituição:** Instituto Federal Baiano
- **Curso:** Análise e Desenvolvimento de Sistemas
- **Ano:** 2026

---

### Quer contribuir?
Sugestões e melhorias são bem‑vindas. Abra uma issue ou entre em contato!
