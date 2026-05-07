-- Execute este script no seu banco MySQL antes de rodar o projeto

CREATE DATABASE IF NOT EXISTS nome_do_banco
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE nome_do_banco;

CREATE TABLE IF NOT EXISTS usuarios (
    id      INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    nome    VARCHAR(120)    NOT NULL,
    email   VARCHAR(180)    NOT NULL UNIQUE,
    senha   VARCHAR(255)    NOT NULL,           -- hash bcrypt
    perfil  ENUM('usuario','admin') NOT NULL DEFAULT 'usuario',
    criado_em TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
