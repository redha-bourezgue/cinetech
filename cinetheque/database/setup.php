<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";charset=utf8",
        DB_USER,
        DB_PASS
    );
    
    // Créer la base de données si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $pdo->exec("USE " . DB_NAME);
    
    // Lire et exécuter le fichier schema.sql
    $sql = file_get_contents(__DIR__ . '/schema.sql');
    $pdo->exec($sql);
    
    echo "Base de données et tables créées avec succès !\n";
} catch (PDOException $e) {
    die("Erreur lors de la création de la base de données : " . $e->getMessage());
} 