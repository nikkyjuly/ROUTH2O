<?php

class UsuarioService
{
    // Dependência injetada via construtor — Service não instancia o Repository!
    public function __construct(private IUsuarioRepository $repository) {}

    // ── Cadastrar novo usuário ──
    public function cadastrar(string $nome, string $email, string $senha, string $perfil = 'usuario'): void
    {
        // Regra 1: e-mail não pode estar em uso
        if ($this->repository->findByEmail($email) !== null) {
            throw new BusinessRuleException("O e-mail '{$email}' já está cadastrado no sistema.");
        }

        // Regra 2: senha deve ter ao menos 8 caracteres
        if (strlen($senha) < 8) {
            throw new BusinessRuleException('A senha deve ter no mínimo 8 caracteres.');
        }

        // Regra 3: perfil deve ser válido
        $perfisValidos = ['usuario', 'admin'];
        if (!in_array($perfil, $perfisValidos, true)) {
            throw new BusinessRuleException("Perfil '{$perfil}' inválido. Use: " . implode(', ', $perfisValidos));
        }

        $usuario = new Usuario();
        $usuario->setNome(trim($nome));
        $usuario->setEmail(strtolower(trim($email)));
        $usuario->setSenha(password_hash($senha, PASSWORD_BCRYPT));
        $usuario->setPerfil($perfil);

        $this->repository->save($usuario);
    }

    // ── Buscar usuário por ID ──
    public function buscarPorId(int $id): Usuario
    {
        $usuario = $this->repository->find($id);

        if ($usuario === null) {
            throw new BusinessRuleException("Usuário com ID {$id} não encontrado.");
        }

        return $usuario;
    }

    // ── Excluir usuário ──
    public function excluir(int $id): void
    {
        $usuario = $this->repository->find($id);

        if ($usuario === null) {
            throw new BusinessRuleException("Usuário com ID {$id} não encontrado para exclusão.");
        }

        // Regra: não é possível excluir o único admin do sistema
        if ($usuario->getPerfil() === 'admin') {
            throw new BusinessRuleException('Não é permitido excluir um administrador do sistema.');
        }

        $this->repository->delete($id);
    }
}
