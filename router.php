<?php

require_once __DIR__ . '/middleware.php';
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/view.php';   // apenas para referência — include feito no método

/**
 * router.php
 * Responsabilidade: avaliar método HTTP e URL, direcionar ao destino correto.
 */

class Router
{
    public function despachar(string $metodo, string $uri): void
    {
        // Normaliza a URI (remove query string e trailing slash)
        $caminho = strtok($uri, '?');
        $caminho = rtrim($caminho, '/') ?: '/';

        // ── GET / → exibe o formulário ────────────────────────────────────
        if ($metodo === 'GET' && $caminho === '/') {
            include __DIR__ . '/view.php';
            return;
        }

        // ── POST / → Middleware → Controller ─────────────────────────────
        if ($metodo === 'POST' && $caminho === '/') {
            $middleware = new Middleware();
            $dadosLimpos = $middleware->validar($_POST);   // encerra se inválido

            $controller = new MatriculaController();
            $controller->processarMatricula($dadosLimpos);
            return;
        }

        // ── Rota não encontrada ───────────────────────────────────────────
        http_response_code(404);
        echo '<h2>404 — Página não encontrada.</h2>';
    }
}
