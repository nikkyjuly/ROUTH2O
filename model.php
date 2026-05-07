<?php

/**
 * model.php
 * Responsabilidade: única camada que fala com a tabela 'alunos'.
 * Usa PDO + Prepared Statements (proteção contra SQL Injection).
 */

class AlunoModel
{
    // ── Propriedades privadas (encapsulamento) ──────────────────────────────
    private string $nome;
    private int    $idade;
    private string $curso;

    // ── Getters ────────────────────────────────────────────────────────────
    public function getNome(): string  { return $this->nome;  }
    public function getIdade(): int    { return $this->idade; }
    public function getCurso(): string { return $this->curso; }

    // ── Setters ────────────────────────────────────────────────────────────
    public function setNome(string $nome): void
    {
        $this->nome = trim($nome);
    }

    public function setIdade(int $idade): void
    {
        $this->idade = $idade;
    }

    public function setCurso(string $curso): void
    {
        $this->curso = trim($curso);
    }

    // ── Persistência ───────────────────────────────────────────────────────
    /**
     * Abre conexão PDO com o SQLite e insere o aluno na tabela.
     * Prepared Statement garante segurança contra SQL Injection.
     */
    public function save(): void
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare(
            "INSERT INTO alunos (nome, idade, curso) VALUES (:nome, :idade, :curso)"
        );

        $stmt->bindValue(':nome',  $this->nome,  PDO::PARAM_STR);
        $stmt->bindValue(':idade', $this->idade, PDO::PARAM_INT);
        $stmt->bindValue(':curso', $this->curso, PDO::PARAM_STR);

        $stmt->execute();
    }
}
