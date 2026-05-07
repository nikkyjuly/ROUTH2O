<?php

class UsuarioController
{
    // Dependência injetada via construtor
    public function __construct(private UsuarioService $service) {}

    // ── Exibe formulário de cadastro ──
    public function create(): void
    {
        require_once __DIR__ . '/../../views/usuarios/create.php';
    }

    // ── Processa o formulário (POST) ──
    public function store(): void
    {
        try {
            $nome   = filter_input(INPUT_POST, 'nome',   FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $email  = filter_input(INPUT_POST, 'email',  FILTER_SANITIZE_EMAIL)         ?? '';
            $senha  = filter_input(INPUT_POST, 'senha',  FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $perfil = filter_input(INPUT_POST, 'perfil', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'usuario';

            $this->service->cadastrar($nome, $email, $senha, $perfil);

            // Sucesso: redireciona
            header('Location: /usuarios?sucesso=1');
            exit;

        } catch (BusinessRuleException $e) {
            // Erro de regra de negócio: mostra para o usuário
            $erro = $e->getMessage();
            require_once __DIR__ . '/../../views/usuarios/create.php';

        } catch (\Exception $e) {
            // Erro inesperado: não expõe detalhes técnicos
            $erro = 'Ocorreu um erro interno. Tente novamente mais tarde.';
            error_log('[ERRO SISTEMA] ' . $e->getMessage());
            require_once __DIR__ . '/../../views/usuarios/create.php';
        }
    }

    // ── Exibe um usuário ──
    public function show(int $id): void
    {
        try {
            $usuario = $this->service->buscarPorId($id);
            require_once __DIR__ . '/../../views/usuarios/show.php';

        } catch (BusinessRuleException $e) {
            $erro = $e->getMessage();
            require_once __DIR__ . '/../../views/error.php';
        }
    }

    // ── Exclui um usuário ──
    public function destroy(int $id): void
    {
        try {
            $this->service->excluir($id);
            header('Location: /usuarios?excluido=1');
            exit;

        } catch (BusinessRuleException $e) {
            $erro = $e->getMessage();
            require_once __DIR__ . '/../../views/error.php';
        }
    }
}
