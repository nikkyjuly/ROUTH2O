<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/IUsuarioRepository.php';

class UsuarioRepository implements IUsuarioRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function save(array $dados): bool
    {
        if (isset($dados['id'])) {
            $stmt = $this->db->prepare("UPDATE Usuario SET nome = :nome, email = :email, objetivos = :obj, data_nascimento = :nasc, perfil = :perfil WHERE id = :id");
            $params = [
                ':id'     => $dados['id'],
                ':nome'   => $dados['nome'],
                ':email'  => $dados['email'],
                ':obj'    => $dados['objetivos'] ?? null,
                ':nasc'   => $dados['data_nascimento'] ?? null,
                ':perfil' => $dados['perfil'] ?? 'usuario',
                ':bio'    => $dados['bio'] ?? null
            ];
        } else {
            $stmt = $this->db->prepare("INSERT INTO Usuario (nome, email, senha, perfil, objetivos, data_nascimento) VALUES (:nome, :email, :senha, :perfil, :obj, :nasc)");
            $params = [
                ':nome'   => $dados['nome'],
                ':email'  => $dados['email'],
                ':senha'  => password_hash($dados['senha'], PASSWORD_BCRYPT),
                ':perfil' => $dados['perfil'] ?? 'usuario',
                ':obj'    => $dados['objetivos'] ?? null,
                ':nasc'   => $dados['data_nascimento'] ?? null,
                ':bio'    => $dados['bio'] ?? null
            ];
        }
        return $stmt->execute($params);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE id = ?");
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE email = ?");
        $stmt->execute([$email]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM Usuario WHERE id = ?");
        return $stmt->execute([$id]);
    }
}