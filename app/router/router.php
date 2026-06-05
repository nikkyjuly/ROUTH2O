<?php

/**
 * router.php
 * Responsabilidade: avaliar método HTTP e URL, direcionar ao destino correto.
 */

class Router
{
    public function run(): bool
    {
        // Captura método HTTP e URI da requisição atual
        $metodo = $_SERVER['REQUEST_METHOD'];
        $uri    = $_SERVER['REQUEST_URI'];

        // Injeção de Dependência (Container movido do index.php)
        $repository = new UsuarioRepository();
        $service    = new Routh2oService($repository);
        $controller = new Routh2oController($repository, $service);

        return $this->despachar($metodo, $uri, $controller);
    }

    public function despachar(string $metodo, string $uri, Routh2oController $controller): bool
    {
        // Normaliza a URI (remove query string e trailing slash)
        $caminho = strtok($uri, '?');

        $caminho = rtrim($caminho, '/') ?: '/';

        // ── GET / → Redireciona para o HTML principal ─────────────────────
        if ($metodo === 'GET' && $caminho === '/') {
            header('Location: /view/index.html');
            return true;
        }

        $middleware = new Middleware();

        // ── Proteção de Páginas HTML ─────────────────────────────────────
        // Incluímos as versões com e sem o prefixo /view/ para garantir segurança total
        $paginasProtegidas = [
            '/treino.html',
            '/perfil.html',
            '/relatorios.html',
            '/atividade_dom.html',
            '/view/treino.html',
            '/view/perfil.html',
            '/view/relatorios.html',
            '/view/atividade_dom.html'
        ];

        if ($metodo === 'GET' && in_array($caminho, $paginasProtegidas)) {
            $middleware->sessaoAtiva(); 
        }

        // Tenta encontrar o arquivo na raiz ou dentro da pasta /view automaticamente
        $arquivoNaRaiz = __DIR__ . '/../../' . ltrim($caminho, '/');
        $arquivoNaView = __DIR__ . '/../../view/' . ltrim($caminho, '/');

        if ($caminho !== '/' && (file_exists($arquivoNaRaiz) || file_exists($arquivoNaView))) {
            return false; // Deixa o PHP servir o arquivo estático (CSS, JS, etc)
        }

        // Verifica se o arquivo físico existe (CSS, JS, Imagens, HTML)
        // ── Rotas de Autenticação e Perfil ────────────────────────────────
        if ($metodo === 'POST' && $caminho === '/login') {
            $controller->login($_POST);
            return true;
        }

        if ($metodo === 'POST' && $caminho === '/registrar') {
            $dadosLimpos = $middleware->validarCadastro($_POST);
            $controller->registrar($dadosLimpos);
            return true;
        }

        if ($metodo === 'POST' && $caminho === '/perfil') {
            $middleware->sessaoAtiva();
            $controller->salvarPerfil($_SESSION['usuario_id'], $_POST);
            return true;
        }

        if ($metodo === 'GET' && $caminho === '/calcular') {
            $km = isset($_GET['km']) ? (float)$_GET['km'] : 0;
            $controller->calcularHidratacao($km);
            return true;
        }

        // ── Rota não encontrada ───────────────────────────────────────────
        http_response_code(404);
        echo '<h2>404 — Página não encontrada.</h2>';
        return true;
    }
}
