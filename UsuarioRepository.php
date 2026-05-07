<?php

class UsuarioRepository implements IUsuarioRepository
{
    public function __construct(private PDO $pdo) {}

    // ── Salva (INSERT ou UPDATE) ──
    public function save(Usuario $usuario): bool
    {
        if ($usuario->getId() === null) {
            // INSERT
            $stmt = $this->pdo->prepare(
                'INSERT INTO usuarios (nome, email, senha, perfil) VALUES (:nome, :email, :senha, :perfil)'
            );
        } else {
            // UPDATE
            $stmt = $this->pdo->prepare(
                'UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, perfil = :perfil WHERE id = :id'
            );
            $stmt->bindValue(':id', $usuario->getId(), PDO::PARAM_INT);
        }

        $stmt->bindValue(':nome',   $usuario->getNome());
        $stmt->bindValue(':email',  $usuario->getEmail());
        $stmt->bindValue(':senha',  $usuario->getSenha());
        $stmt->bindValue(':perfil', $usuario->getPerfil());

        return $stmt->execute();
    }

    // ── Busca por ID ──
    public function find(int $id): ?Usuario
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE id = :id LIMIT 1');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();
        return $row ? $this->hydrate($row) : null;
    }

    // ── Busca por e-mail ──
    public function findByEmail(string $email): ?Usuario
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch();
        return $row ? $this->hydrate($row) : null;
    }

    // ── Delete ──
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // ── Converte array do banco → objeto Usuario ──
    private function hydrate(array $row): Usuario
    {
        $usuario = new Usuario();
        $usuario->setId((int) $row['id']);
        $usuario->setNome($row['nome']);
        $usuario->setEmail($row['email']);
        $usuario->setSenha($row['senha']);
        $usuario->setPerfil($row['perfil']);
        return $usuario;
    }
}
