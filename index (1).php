<?php

// ── Autoload manual dos arquivos ──
require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/Models/Usuario.php';
require_once __DIR__ . '/src/Repositories/IUsuarioRepository.php';
require_once __DIR__ . '/src/Repositories/UsuarioRepository.php';
require_once __DIR__ . '/src/Services/UsuarioService.php';
require_once __DIR__ . '/src/Controllers/UsuarioController.php';
require_once __DIR__ . '/src/Exceptions/BusinessRuleException.php';
require_once __DIR__ . '/src/Middleware.php';

// ── Container de Injeção de Dependência ──
// Montagem das dependências na ordem correta:
// PDO → Repository → Service → Controller
$pdo        = Database::getConnection();
$repository = new UsuarioRepository($pdo);
$service    = new UsuarioService($repository);
$controller = new UsuarioController($service);

// ── Roteador simples ──
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

match (true) {

    // GET /usuarios/criar → exibe formulário
    $uri === '/usuarios/criar' && $method === 'GET' => $controller->create(),

    // POST /usuarios → valida middleware + salva
    $uri === '/usuarios' && $method === 'POST' => (function () use ($controller) {
        Middleware::validarCadastroUsuario(); // sanitização e XSS antes de qualquer coisa
        $controller->store();
    })(),

    // GET /usuarios/{id} → exibe usuário
    preg_match('#^/usuarios/(\d+)$#', $uri, $m) && $method === 'GET'
        => $controller->show((int) $m[1]),

    // DELETE /usuarios/{id} → exclui usuário (apenas admin)
    preg_match('#^/usuarios/(\d+)$#', $uri, $m) && $method === 'DELETE'
        => (function () use ($controller, $m) {
            Middleware::apenasAdmin();
            $controller->destroy((int) $m[1]);
        })(),

    // Rota não encontrada
    default => (function () {
        http_response_code(404);
        echo '404 — Página não encontrada.';
    })()
};
