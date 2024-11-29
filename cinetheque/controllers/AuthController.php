<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->userModel->authenticate($email, $password)) {
                header('Location: ' . BASE_URL);
                exit;
            } else {
                $error = "Email ou mot de passe incorrect";
            }
        }
        require 'views/pages/auth/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if ($password !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas";
            } elseif ($this->userModel->createUser($username, $email, $password)) {
                header('Location: ' . BASE_URL . '/auth/login');
                exit;
            } else {
                $error = "Une erreur est survenue lors de l'inscription";
            }
        }
        require 'views/pages/auth/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL);
        exit;
    }
} 