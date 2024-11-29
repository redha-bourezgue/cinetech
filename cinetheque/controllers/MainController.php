<?php
namespace App\Controllers;

class MainController {
    public function getTmdbData($endpoint) {
        $url = TMDB_API_URL . $endpoint . '?api_key=' . TMDB_API_KEY . '&language=fr-FR';
        $response = file_get_contents($url);
        return json_decode($response, true);
    }

    public function getImageUrl($path) {
        return TMDB_IMG_URL . $path;
    }
} 