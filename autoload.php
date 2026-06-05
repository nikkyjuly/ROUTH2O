<?php

spl_autoload_register(function ($class) {
    $mapping = [
        'Routh2oController'  => 'app/controller/controller.php',
        'View'               => 'app/controller/view.php',
        'IUsuarioRepository' => 'app/model/IUsuarioRepository.php',
        'Usuario'            => 'app/model/model.php',
        'UsuarioRepository'  => 'app/model/UsuarioRepository.php',
        'Database'           => 'app/model/Database.php',
        'Middleware'         => 'app/middleware/middleware.php',
        'Router'             => 'app/router/Router.php',
        'Routh2oService'     => 'app/service/service.php'
    ];

    if (isset($mapping[$class])) {
        $path = __DIR__ . '/' . $mapping[$class];
        if (file_exists($path)) {
            require_once $path;
        }
    }
});