<?php

class Middleware
{
    // ── Verifica campos obrigatórios e sanitiza contra XSS ──
    public static function validarCadastroUsuario(): void
    {
        $camposObrigatorios = ['nome', 'email', 'senha'];

        foreach ($camposObrigatorios as $campo) {
            $valor = filter_input(INPUT_POST, $campo, FILTER_SANITIZE_SPECIAL_CHARS);

            if ($valor === null || trim($valor) === '') {
                http_response_code(422);
                $erro = "O campo '{$campo}' é obrigatório.";
                require_once __DIR__ . '/../../views/usuarios/create.php';
                exit;
            }

            // Detecta tentativa de injeção de tags HTML/script
            $valorBruto = $_POST[$campo] ?? '';
            if ($valorBruto !== strip_tags($valorBruto)) {
                http_response_code(400);
                $erro = "Entrada inválida detectada no campo '{$campo}'. Tags HTML não são permitidas.";
                require_once __DIR__ . '/../../views/usuarios/create.php';
                exit;
            }
        }

        // Valida formato do e-mail
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if ($email === false || $email === null) {
            http_response_code(422);
            $erro = 'O e-mail informado não é válido.';
            require_once __DIR__ . '/../../views/usuarios/create.php';
            exit;
        }
    }

    // ── Verifica se o usuário está autenticado (sessão) ──
    public static function autenticado(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit;
        }
    }

    // ── Verifica se o usuário tem perfil de admin ──
    public static function apenasAdmin(): void
    {
        self::autenticado();

        if (($_SESSION['usuario_perfil'] ?? '') !== 'admin') {
            http_response_code(403);
            require_once __DIR__ . '/../../views/error.php';
            exit;
        }
    }
}
