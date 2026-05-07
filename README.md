# 📋 Sistema de Matrícula — Arquitetura MVC em PHP

Projeto didático com arquitetura em camadas: **Migration → Model → Service → Controller → View**, protegido por **Middleware** e roteado por um **Router**, tudo acessado via um único **Front Controller**.

---

## 📁 Estrutura de arquivos

```
matricula-php/
├── index.php        ← Front Controller (ponto de entrada único)
├── router.php       ← Avalia método HTTP e direciona
├── middleware.php   ← Validação e segurança da entrada
├── controller.php   ← Orquestra Service + Model
├── service.php      ← Regras de negócio (idade mínima, bolsa)
├── model.php        ← Acesso ao banco (PDO + Prepared Statements)
├── view.php         ← Formulário HTML
├── migration.php    ← Cria o banco e a tabela (rodar 1× só)
├── style.css        ← Estilo compartilhado
└── database.sqlite  ← Gerado automaticamente pela migration
```

---

## 🚀 Como rodar

### 1. Rode a migration (apenas uma vez)
```bash
php migration.php
```
Isso cria o arquivo `database.sqlite` com a tabela `alunos`.

### 2. Suba o servidor built-in
```bash
php -S localhost:8000
```

### 3. Acesse no navegador
```
http://localhost:8000
```

---

## 🧪 Roteiro de testes

| Teste | O que observar |
|---|---|
| Enviar formulário **vazio** | `middleware.php` bloqueia com mensagem de aviso |
| Idade **não numérica** (ex.: `abc`) | `middleware.php` recusa |
| Aluno com **idade menor** que o mínimo do curso | `service.php` lança exceção com mensagem clara |
| Aluno com **60+ anos** | `service.php` retorna flag de bolsa; Controller exibe aviso amarelo |
| Dados **válidos e completos** | Sucesso — linha salva no SQLite |
| Abrir `database.sqlite` no SQLite Viewer (VSCode) | Confirmar registro na tabela `alunos` |

---

## 🏗 Fluxo de uma requisição POST

```
Navegador (POST /)
    └─→ index.php          (Front Controller)
         └─→ router.php    (identifica POST /)
              └─→ middleware.php  (valida campos)
                   └─→ controller.php  (orquestra)
                        ├─→ service.php   (regras de negócio)
                        └─→ model.php     (salva no SQLite)
                             └─→ database.sqlite
```

---

## 📌 Cursos disponíveis e idades mínimas

| Curso | Idade mínima |
|---|---|
| Design Gráfico | 16 anos |
| Engenharia de Software | 17 anos |
| Pedagogia | 17 anos |
| Medicina | 18 anos |
| Direito | 18 anos |

> Alunos com **60 anos ou mais** são pré-selecionados para bolsa de estudos.

---

## 💡 Conceitos praticados

- **PDO** com SQLite e Prepared Statements (proteção contra SQL Injection)
- **Encapsulamento** — propriedades `private` com getters/setters públicos
- **Separation of Concerns** — cada arquivo tem uma única responsabilidade
- **Exception handling** — `try/catch` no Controller, `throw` no Service
- **Front Controller Pattern** — toda requisição passa pelo `index.php`
- **Middleware** — camada de segurança antes do processamento

---

## 🔼 Commit sugerido

```bash
git init
git add .
git commit -m "feat: sistema de matrícula MVC com PDO, middleware e SQLite"
git remote add origin <url-do-seu-repo>
git push -u origin main
```
