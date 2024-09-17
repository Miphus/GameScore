<?php
class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $host = 'localhost'; // eller din databasserver
        $db   = 'gamescore'; // ditt databasnamn
        $user = 'root'; // din databasanvändare
        $pass = ''; // ditt databaslösenord
        $charset = 'utf8mb4';

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
