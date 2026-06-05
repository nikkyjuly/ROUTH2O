<?php

/**
 * index.php
 * Front Controller — ponto de entrada único da aplicação.
 * Toda requisição passa por aqui antes de qualquer coisa.
 */

// Novos caminhos após a reestruturação do Passo 4
require_once __DIR__ . '/autoload.php';

// Entrega ao Router para despacho
$router = new Router();
if ($router->run() === false) {
    return false; // Permite que o servidor embutido do PHP sirva arquivos estáticos
}
