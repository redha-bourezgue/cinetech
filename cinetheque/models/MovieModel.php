<?php

class MovieModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getFavorites($userId) {
        $query = "SELECT m.* FROM favorites f 
                 JOIN movies m ON f.movie_id = m.id 
                 WHERE f.user_id = ? 
                 ORDER BY f.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWatchlist($userId) {
        $query = "SELECT m.* FROM watchlist w 
                 JOIN movies m ON w.movie_id = m.id 
                 WHERE w.user_id = ? 
                 ORDER BY w.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserRatings($userId) {
        $query = "SELECT m.*, r.rating, r.created_at as rated_at 
                 FROM ratings r 
                 JOIN movies m ON r.movie_id = m.id 
                 WHERE r.user_id = ? 
                 ORDER BY r.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getViewingHistory($userId) {
        $query = "SELECT m.*, h.viewed_at 
                 FROM viewing_history h 
                 JOIN movies m ON h.movie_id = m.id 
                 WHERE h.user_id = ? 
                 ORDER BY h.viewed_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToFavorites($userId, $movieId) {
        $query = "INSERT INTO favorites (user_id, movie_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId, $movieId]);
    }

    public function removeFromFavorites($userId, $movieId) {
        $query = "DELETE FROM favorites WHERE user_id = ? AND movie_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId, $movieId]);
    }

    public function addToWatchlist($userId, $movieId) {
        $query = "INSERT INTO watchlist (user_id, movie_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId, $movieId]);
    }

    public function removeFromWatchlist($userId, $movieId) {
        $query = "DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId, $movieId]);
    }

    public function addRating($userId, $movieId, $rating) {
        $query = "INSERT INTO ratings (user_id, movie_id, rating) 
                 VALUES (?, ?, ?) 
                 ON DUPLICATE KEY UPDATE rating = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId, $movieId, $rating, $rating]);
    }

    public function addToHistory($userId, $movieId) {
        $query = "INSERT INTO viewing_history (user_id, movie_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId, $movieId]);
    }

    public function getFeaturedMovies($limit = 5) {
        // Récupérer les films populaires depuis TMDB
        $url = "https://api.themoviedb.org/3/movie/popular";
        $params = [
            'api_key' => TMDB_API_KEY,
            'language' => 'fr-FR',
            'page' => 1
        ];

        $response = $this->makeApiRequest($url, $params);
        
        if ($response && isset($response['results'])) {
            // Prendre seulement les films avec backdrop_path
            $movies = array_filter($response['results'], function($movie) {
                return !empty($movie['backdrop_path']);
            });

            // Limiter le nombre de résultats
            return array_slice($movies, 0, $limit);
        }

        return [];
    }

    public function getNowPlayingMovies($limit = 10) {
        $url = "https://api.themoviedb.org/3/movie/now_playing";
        $params = [
            'api_key' => TMDB_API_KEY,
            'language' => 'fr-FR',
            'page' => 1,
            'region' => 'FR'
        ];

        $response = $this->makeApiRequest($url, $params);
        
        if ($response && isset($response['results'])) {
            return array_slice($response['results'], 0, $limit);
        }

        return [];
    }

    public function getUpcomingMovies($limit = 10) {
        $url = "https://api.themoviedb.org/3/movie/upcoming";
        $params = [
            'api_key' => TMDB_API_KEY,
            'language' => 'fr-FR',
            'page' => 1,
            'region' => 'FR'
        ];

        $response = $this->makeApiRequest($url, $params);
        
        if ($response && isset($response['results'])) {
            return array_slice($response['results'], 0, $limit);
        }

        return [];
    }

    private function makeApiRequest($url, $params = []) {
        $url = $url . '?' . http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function getMovieCredits($movieId) {
        $url = "https://api.themoviedb.org/3/movie/{$movieId}/credits";
        $params = [
            'api_key' => TMDB_API_KEY,
            'language' => 'fr-FR'
        ];

        return $this->makeApiRequest($url, $params);
    }

    public function getMovieVideos($movieId) {
        $url = "https://api.themoviedb.org/3/movie/{$movieId}/videos";
        $params = [
            'api_key' => TMDB_API_KEY,
            'language' => 'fr-FR'
        ];

        return $this->makeApiRequest($url, $params);
    }

    public function getMovieImages($movieId) {
        $url = "https://api.themoviedb.org/3/movie/{$movieId}/images";
        $params = [
            'api_key' => TMDB_API_KEY,
            'language' => 'fr-FR',
            'include_image_language' => 'fr,null'
        ];

        $response = $this->makeApiRequest($url, $params);
        return $response['backdrops'] ?? [];
    }

    public function getSimilarMovies($movieId, $limit = 10) {
        $url = "https://api.themoviedb.org/3/movie/{$movieId}/similar";
        $params = [
            'api_key' => TMDB_API_KEY,
            'language' => 'fr-FR',
            'page' => 1
        ];

        $response = $this->makeApiRequest($url, $params);
        
        if ($response && isset($response['results'])) {
            return array_slice($response['results'], 0, $limit);
        }

        return [];
    }

    public function getUserRating($userId, $movieId) {
        $stmt = $this->db->prepare("SELECT rating FROM ratings WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetchColumn() ?: 0;
    }

    public function isInFavorites($userId, $movieId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM favorites WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetchColumn() > 0;
    }

    public function isInWatchlist($userId, $movieId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM watchlist WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetchColumn() > 0;
    }
} 