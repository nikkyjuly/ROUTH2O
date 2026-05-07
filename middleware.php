<?php

/**
 * middleware.php
 * Responsabilidade: segurança e validação de entrada ANTES do Controller.
 * Encerra a execução imediatamente se os dados forem inválidos.
 */

class Middleware
{
    /**
     * Valida os dados do POST.
     * Mata a requisição com mensagem de aviso se algo estiver errado.
     *
     * @param  array $dados  Normalmente $_POST
     * @return array         Dados higienizados, prontos para o Controller
     */
    public function validar(array $dados): array
    {
        $erros = [];

        // ── Regra 1: campos obrigatórios ──────────────────────────────────
        $camposObrigatorios = ['nome', 'idade', 'curso'];

        foreach ($camposObrigatorios as $campo) {
            if (empty(trim($dados[$campo] ?? ''))) {
                $erros[] = "O campo <strong>$campo</strong> é obrigatório.";
            }
        }

        // ── Regra 2: idade deve ser numérica e positiva ───────────────────
        if (isset($dados['idade']) && trim($dados['idade']) !== '') {
            if (!is_numeric($dados['idade']) || (int)$dados['idade'] <= 0) {
                $erros[] = "O campo <strong>idade</strong> deve ser um número inteiro positivo.";
            }
        }

        // ── Se houver erros: encerra aqui ─────────────────────────────────
        if (!empty($erros)) {
            $lista = implode('</li><li>', $erros);
            http_response_code(400);
            echo <<<HTML
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Dados inválidos</title>
                <link rel="stylesheet" href="style.css">
            </head>
            <body>
                <div class="card erro">
                    <h2>⚠️ Dados inválidos</h2>
                    <ul><li>$lista</li></ul>
                    <a href="/" class="btn">← Corrigir formulário</a>
                </div>
            </body>
            </html>
            HTML;
            exit;
        }

        // ── Higienização básica antes de retornar ─────────────────────────
        return [
            'nome'  => htmlspecialchars(trim($dados['nome']),  ENT_QUOTES, 'UTF-8'),
            'idade' => (int) $dados['idade'],
            'curso' => htmlspecialchars(trim($dados['curso']), ENT_QUOTES, 'UTF-8'),
        ];
    }
}
