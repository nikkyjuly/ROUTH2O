<?php

class Database
{
    private static ?PDO $instance = null;

    // Construtor privado: ninguém instancia esta classe diretamente
    private function __construct() {}

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $config = parse_ini_file(__DIR__ . '/../config.ini', true);

            if (!$config || !isset($config['database'])) {
                throw new RuntimeException('Arquivo config.ini não encontrado ou inválido.');
            }

            $db   = $config['database'];
            $dsn  = "mysql:host={$db['host']};port={$db['port']};dbname={$db['dbname']};charset={$db['charset']}";

            self::$instance = new PDO($dsn, $db['username'], $db['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }

        return self::$instance;
    }
}
