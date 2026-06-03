<?php

/**
 * index.php
 * Front Controller — ponto de entrada único da aplicação.
 * Toda requisição passa por aqui antes de qualquer coisa.
 */

require_once __DIR__ . '/router.php';
require_once __DIR__ . '/UsuarioRepository.php';
require_once __DIR__ . '/service.php';
require_once __DIR__ . '/controller.php';

// Injeção de Dependência (Container simplificado)
$repository = new UsuarioRepository();
$service    = new Routh2oService($repository);
$controller = new Routh2oController($repository, $service);

// A migração do banco de dados deve ser executada uma vez via 'php migration.php'
// Não deve ser executada em cada requisição web.

// Captura método HTTP e URI da requisição atual
$metodo = $_SERVER['REQUEST_METHOD'];          // 'GET' ou 'POST'
$uri    = $_SERVER['REQUEST_URI'];             // ex.: '/', '/foo'

// Entrega ao Router para despacho
$router = new Router();
if ($router->despachar($metodo, $uri, $controller) === false) {
    return false; // Permite que o servidor embutido do PHP sirva arquivos estáticos
}
