<?php

require_once __DIR__ . '/middleware.php';
require_once __DIR__ . '/view.php';

/**
 * router.php
 * Responsabilidade: avaliar método HTTP e URL, direcionar ao destino correto.
 */

class Router
{
    public function despachar(string $metodo, string $uri, Routh2oController $controller): bool
    {
        // Normaliza a URI (remove query string e trailing slash)
        $caminho = strtok($uri, '?');

        $caminho = rtrim($caminho, '/') ?: '/';

        // ── GET / → Redireciona para o HTML principal ─────────────────────
        if ($metodo === 'GET' && $caminho === '/') {
            header('Location: index.html');
            return true;
        }

        $middleware = new Middleware();

        // ── Proteção de Páginas HTML ─────────────────────────────────────
        // Lista de páginas que exigem que o usuário esteja logado
        $paginasProtegidas = [
            '/treino.html',
            '/perfil.html',
            '/relatorios.html',
            '/atividade_dom.html'
        ];

        if ($metodo === 'GET' && in_array($caminho, $paginasProtegidas)) {
            $middleware->sessaoAtiva();
        }

        // Se o arquivo físico existir (CSS, JS, HTML), permite que o servidor entregue diretamente.
        if ($caminho !== '/' && file_exists(__DIR__ . $caminho)) {
            return false;
        }

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
