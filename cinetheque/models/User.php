<?php
namespace App\Models;

use PDO;
use PDOException;

class User {
    private $db;

    public function __construct() {
        $this->db = \App\Core\Database::getInstance()->getConnection();
    }

    public function createUser($username, $email, $password) {
        try {
            // Vérifier si l'email existe déjà
            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                return false; // Email déjà utilisé
            }

            // Vérifier si le nom d'utilisateur existe déjà
            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                return false; // Nom d'utilisateur déjà utilisé
            }

            // Hasher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insérer le nouvel utilisateur
            $stmt = $this->db->prepare(
                "INSERT INTO users (username, email, password, created_at) 
                 VALUES (?, ?, ?, NOW())"
            );
            
            $stmt->execute([$username, $email, $hashedPassword]);
            return true;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function authenticate($email, $password) {
        try {
            $stmt = $this->db->prepare(
                "SELECT id, username, password 
                 FROM users 
                 WHERE email = ?"
            );
            
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Stocker les informations de l'utilisateur en session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                return true;
            }

            return false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getUserById($id) {
        try {
            $stmt = $this->db->prepare(
                "SELECT id, username, email, created_at 
                 FROM users 
                 WHERE id = ?"
            );
            
            $stmt->execute([$id]);
            return $stmt->fetch();

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function updateProfile($userId, $data) {
        try {
            $updates = [];
            $params = [];

            if (!empty($data['username'])) {
                $updates[] = "username = ?";
                $params[] = $data['username'];
            }

            if (!empty($data['email'])) {
                $updates[] = "email = ?";
                $params[] = $data['email'];
            }

            if (!empty($data['password'])) {
                $updates[] = "password = ?";
                $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            if (empty($updates)) {
                return false;
            }

            $params[] = $userId;
            $sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE id = ?";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
} 