<?php

/**
 * middleware.php
 * Responsabilidade: Validação de dados de usuário e proteção de rotas.
 */
class Middleware
{
    public function validarCadastro(array $dados): array
    {
        // FILTER_SANITIZE_FULL_SPECIAL_CHARS é mais robusto contra XSS
        $nome  = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = $dados['senha'] ?? '';

        // Verifica se os valores filtrados são válidos
        if (empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($senha)) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['erro' => 'Dados de cadastro inválidos ou incompletos.']);
            exit;
        }

        return [
            'nome'  => $nome,
            'email' => $email,
            'senha' => $senha
        ];
    }

    public function sessaoAtiva(): void 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_id'])) {
            // Removida a barra inicial para manter consistência com o Router
            header('Location: /view/index.html');
            exit;
        }
    }
}
