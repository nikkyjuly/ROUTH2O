<?php

require_once __DIR__ . '/model.php';
require_once __DIR__ . '/service.php';

/**
 * controller.php
 * Responsabilidade: orquestrar o fluxo POST.
 * Recebe dados → chama Service → chama Model → decide resposta.
 */

class MatriculaController
{
    public function processarMatricula(array $dadosBrutos): void
    {
        $service = new MatriculaService();

        try {
            // ── 1. Aplica regras de negócio ───────────────────────────────
            $dadosProcessados = $service->processar($dadosBrutos);

            // ── 2. Persiste via Model ─────────────────────────────────────
            $aluno = new AlunoModel();
            $aluno->setNome($dadosProcessados['nome']);
            $aluno->setIdade($dadosProcessados['idade']);
            $aluno->setCurso($dadosProcessados['curso']);
            $aluno->save();

            // ── 3. Resposta de sucesso ────────────────────────────────────
            $bolsaMsg = $dadosProcessados['bolsa']
                ? '<p class="bolsa">🎓 Parabéns! Você foi pré-selecionado para <strong>bolsa de estudos</strong>.</p>'
                : '';

            $this->renderFeedback('sucesso', $dadosProcessados['nome'], $dadosProcessados['curso'], $bolsaMsg);

        } catch (Exception $e) {
            // ── 4. Resposta de erro (regra de negócio) ────────────────────
            $this->renderFeedback('erro', mensagem: $e->getMessage());
        }
    }

    // ── Helper de resposta ────────────────────────────────────────────────
    private function renderFeedback(
        string  $tipo,
        string  $nome     = '',
        string  $curso    = '',
        string  $extra    = '',
        string  $mensagem = ''
    ): void {
        if ($tipo === 'sucesso') {
            echo <<<HTML
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Matrícula Confirmada</title>
                <link rel="stylesheet" href="style.css">
            </head>
            <body>
                <div class="card sucesso">
                    <h2>✅ Matrícula realizada!</h2>
                    <p><strong>$nome</strong> foi matriculado(a) em <strong>$curso</strong> com sucesso.</p>
                    $extra
                    <a href="/" class="btn">← Voltar ao formulário</a>
                </div>
            </body>
            </html>
            HTML;
        } else {
            echo <<<HTML
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Matrícula Recusada</title>
                <link rel="stylesheet" href="style.css">
            </head>
            <body>
                <div class="card erro">
                    <h2>❌ Matrícula recusada</h2>
                    <p>$mensagem</p>
                    <a href="/" class="btn">← Tentar novamente</a>
                </div>
            </body>
            </html>
            HTML;
        }
    }
}
