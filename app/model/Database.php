<?php

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            // Database.php em app/model/ precisa subir dois níveis para o config.ini
            $config = parse_ini_file(__DIR__ . '/../../config.ini', true);
            // database.sqlite está em app/, logo sobe um nível a partir de model/
            $dbPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . ($config['database']['path'] ?? 'database.sqlite');

            try {
                self::$instance = new PDO("sqlite:$dbPath");
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die(json_encode(['erro' => 'Falha na conexão com o banco de dados.']));
            }
        }
        return self::$instance;
    }

    private function __construct() {}
    private function __clone() {}
}