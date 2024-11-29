<?php
namespace App\Models;

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            // Vérifier si la base de données existe
            $temp = new \PDO(
                "mysql:host=".DB_HOST,
                DB_USER,
                DB_PASS
            );
            
            // Créer la base de données si elle n'existe pas
            $temp->exec("CREATE DATABASE IF NOT EXISTS ".DB_NAME);
            
            // Se connecter à la base de données
            $this->conn = new \PDO(
                "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        } catch(\PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
} 