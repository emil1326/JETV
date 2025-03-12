<?php

declare(strict_types=1);

class Database
{
    private static $instance;
    private $connexion;

    // Le constructeur est privé
    // pour éviter la création hors de la classe
    private function __construct(array $dbConfig, array $dbParams)
    {
        try {
            // conn va contenir l'objet PDO
            $this->connexion = new PDO("mysql:host=" . $dbConfig["hostname"] . ";dbname=" . $dbConfig["database"], $dbConfig["username"], $dbConfig["password"], $dbParams);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    // Fonction statique car nous n'appellons
    // pas le constructeur directement
    public static function getInstance(array $dbConfig, array $dbParams): Database
    {
        if (is_null(self::$instance)) {
            // La variable statique contiendra l'instance de Database
            // C'est ici que le constructeur est appelé
            self::$instance = new Database($dbConfig, $dbParams);
        }
        // Retourne la variable statique, donc toujours le même objet
        return self::$instance;
    }

    public function getPDO(): PDO
    {
        return $this->connexion;
    }
}
