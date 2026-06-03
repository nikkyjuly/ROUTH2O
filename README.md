# 💧 ROUTH2O — Bio-rastreamento e Performance Hídrica

O **ROUTH2O** é uma plataforma focada no monitoramento de performance física e gestão inteligente de hidratação. O projeto foi desenvolvido seguindo princípios de **Clean Architecture**, visando um código desacoplado, testável e de fácil manutenção.

## 🏗️ Arquitetura e Padrões de Projeto

A aplicação utiliza PHP 8+ no backend e uma interface dinâmica baseada em componentes no frontend, comunicando-se via **Fetch API**.

### Padrões Implementados:
*   **Repository Pattern**: Abstração da camada de dados através da interface `IUsuarioRepository`, permitindo a troca de motores de banco de dados sem afetar a lógica de negócio.
*   **Dependency Injection (DI)**: Utilizado no `index.php` para montar o grafo de objetos (`Repository -> Service -> Controller`).
*   **Singleton Pattern**: Implementado na classe `Database` para garantir uma única conexão PDO ativa por ciclo de vida da requisição.
*   **Service Layer**: Toda a regra de negócio (cálculos de hidratação e validações) está isolada em `Routh2oService`.
*   **Front Controller**: Todas as requisições passam pelo `index.php`, centralizando o roteamento e a inicialização.

## 📁 Organização do Projeto

```text
ROUTH2O/
├── index.php             # Ponto de entrada e Container de Injeção de Dependência
├── router.php            # Roteamento inteligente de endpoints e arquivos estáticos
├── middleware.php        # Camada de segurança (Sanitização XSS e Controle de Sessão)
├── controller.php        # Orquestrador de fluxo entre Service e View
├── service.php           # Núcleo das regras de negócio e validações
├── UsuarioRepository.php # Implementação concreta da persistência (SQLite)
├── IUsuarioRepository.php # Contrato de abstração da camada de dados
├── Database.php          # Conexão PDO centralizada (Singleton)
├── model.php             # Entidade simples (Usuario)
├── view.php              # Utilitário para respostas JSON consistentes
├── migration.php         # Script de setup e estruturação do banco de dados
├── config.ini            # Configurações de ambiente (Database path)
├── controller.js         # Lógica de interação frontend e chamadas assíncronas
└── style.css             # Identidade visual moderna e responsiva
```

## 🚀 Como Executar

### 1. Requisitos
*   PHP 8.0 ou superior instalado.
*   Extensão `pdo_sqlite` habilitada.

### 2. Configuração do Banco de Dados
Antes de rodar a aplicação, execute o script de migração no terminal para criar as tabelas necessárias:
```bash
php migration.php
```
Isso criará o arquivo `database.sqlite` com as tabelas `Usuario` (incluindo campos de bio e objetivos) e `Treino`.

### 3. Iniciando o Servidor
Para que o roteamento funcione corretamente, utilize o servidor embutido do PHP apontando para o arquivo principal:
```bash
php -S localhost:8000 index.php
```

### 4. Acesso
Abra o navegador e acesse: `http://localhost:8000`

## 🛡️ Segurança e Validação

*   **Proteção XSS**: Todas as entradas de texto são sanitizadas via `FILTER_SANITIZE_FULL_SPECIAL_CHARS` na camada de Middleware.
*   **Persistência de Senhas**: Utiliza o algoritmo BCRYPT através de `password_hash` e `password_verify`.
*   **Controle de Sessão**: Rotas críticas (Perfil, Treino, Relatórios) são protegidas por verificação de sessão ativa no servidor.
*   **SQL Injection**: Proteção nativa através do uso exclusivo de *Prepared Statements* na camada de Repositório.

## 🧪 Fluxo de Trabalho

1.  **Registro/Login**: O usuário cria uma conta; os dados são sanitizados pelo Middleware e validados pelo Service antes de serem salvos no Repository.
2.  **Laboratório**: Permite calcular a meta de ingestão de água baseada na distância percorrida, utilizando lógica processada no backend.
3.  **Treino**: Interface para monitoramento em tempo real (simulação de GPS).
4.  **Perfil**: Atualização de dados biométricos e objetivos, persistidos diretamente no SQLite via Fetch assíncrono.

---
**Desenvolvido com foco em excelência arquitetural e bio-performance.**