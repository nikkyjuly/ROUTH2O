<?php

/**
 * migration.php
 * Execute uma única vez: php migration.php
 * Cria o arquivo database.sqlite e a tabela alunos.
 */

class Migration
{
    private PDO $pdo;

    public function __construct()
    {
        // Cria (ou abre) o arquivo SQLite na mesma pasta
        $this->pdo = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function run(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS alunos (
                    id     INTEGER PRIMARY KEY AUTOINCREMENT,
                    nome   TEXT,
                    idade  INTEGER,
                    curso  TEXT
                )";

        $this->pdo->exec($sql);

        echo "✅ Migração concluída! Arquivo database.sqlite criado e tabela 'alunos' pronta." . PHP_EOL;
    }
}

// ── Ponto de execução ──
$migration = new Migration();
$migration->run();
