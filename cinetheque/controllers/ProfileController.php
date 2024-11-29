<?php

class ProfileController {
    private $userModel;
    private $movieModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->movieModel = new MovieModel();
    }

    public function index() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        
        // Récupérer les données de l'utilisateur
        $user = $this->userModel->getUserById($userId);
        $favorites = $this->movieModel->getFavorites($userId);
        $watchlist = $this->movieModel->getWatchlist($userId);
        $ratings = $this->movieModel->getUserRatings($userId);
        $history = $this->movieModel->getViewingHistory($userId);

        // Charger la vue
        require_once 'views/pages/profile.php';
    }

    public function update() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $data = [];

        // Traiter l'avatar
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
            $avatar = $this->handleAvatarUpload($_FILES['avatar']);
            if ($avatar) {
                $data['avatar'] = $avatar;
            }
        }

        // Mettre à jour les informations
        if (!empty($_POST['username'])) {
            $data['username'] = $_POST['username'];
        }
        if (!empty($_POST['email'])) {
            $data['email'] = $_POST['email'];
        }
        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        if (!empty($data)) {
            $this->userModel->updateUser($userId, $data);
        }

        header('Location: ' . BASE_URL . '/profile');
        exit;
    }

    private function handleAvatarUpload($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $uploadDir = 'public/uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = uniqid() . '_' . $file['name'];
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename;
        }

        return false;
    }
} 