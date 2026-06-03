<?php

require_once __DIR__ . '/Database.php';

echo "Iniciando migração do banco de dados...\n";

$db = Database::getConnection();

$sql = "
    CREATE TABLE IF NOT EXISTS Usuario (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        senha TEXT NOT NULL,
        data_nascimento TEXT,
        objetivos TEXT,
        bio TEXT, -- Adicionado campo bio
        perfil TEXT DEFAULT 'usuario'
    );

    CREATE TABLE IF NOT EXISTS Foto_Usuario (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuario_id INTEGER NOT NULL,
        url_foto TEXT NOT NULL,
        data_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT EXISTS Treino (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuario_id INTEGER NOT NULL,
        data_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
        distancia_km REAL DEFAULT 0.00,
        inclinacao_pct REAL DEFAULT 0.00,
        alerta_hidratacao_disparado BOOLEAN DEFAULT 0,
        status TEXT,
        FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT EXISTS Dados_GPS (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        treino_id INTEGER NOT NULL,
        latitude REAL NOT NULL,
        longitude REAL NOT NULL,
        momento DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (treino_id) REFERENCES Treino(id) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT EXISTS Curiosidade_Diaria (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        data_exibicao DATE UNIQUE NOT NULL,
        conteudo TEXT NOT NULL
    );
";

$db->exec($sql);
echo "Tabelas criadas com sucesso!\n";