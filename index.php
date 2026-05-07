<?php

/**
 * index.php
 * Front Controller — ponto de entrada único da aplicação.
 * Toda requisição passa por aqui antes de qualquer coisa.
 */

require_once __DIR__ . '/router.php';

// Captura método HTTP e URI da requisição atual
$metodo = $_SERVER['REQUEST_METHOD'];          // 'GET' ou 'POST'
$uri    = $_SERVER['REQUEST_URI'];             // ex.: '/', '/foo'

// Entrega ao Router para despacho
$router = new Router();
$router->despachar($metodo, $uri);
