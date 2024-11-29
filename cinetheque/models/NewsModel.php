<?php

class NewsModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getLatestNews($limit = 6) {
        // Pour l'instant, retournons des données factices
        return [
            [
                'title' => 'Les sorties de la semaine',
                'content' => 'Découvrez les nouveaux films à l\'affiche cette semaine...',
                'image' => BASE_URL . '/public/img/news/default.jpg',
                'category' => 'Sorties',
                'published_at' => date('Y-m-d H:i:s')
            ],
            // Ajoutez d'autres articles factices ici
        ];
    }
} 