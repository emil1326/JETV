<?php

declare(strict_types=1);

class Database
{
    private static $instance;
    private $connexion;

    private function __construct(array $dbConfig, array $dbParams)
    {
        try {
            // connexion va contenir l'objet PDO
            $this->connexion = new PDO("mysql:host=" . $dbConfig["hostname"] . ";dbname=" . $dbConfig["database"], $dbConfig["username"], $dbConfig["password"], $dbParams);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    // Singleton
    public static function getInstance(): Database
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database(CONFIGURATIONS['database'], DB_PARAMS);
        }

        return self::$instance;
    }

    public function getPDO(): PDO
    {
        return $this->connexion;
    }
}
