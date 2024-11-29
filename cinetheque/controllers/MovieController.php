<?php
namespace App\Controllers;

use App\Models\Movie;

class MovieController {
    private $movieModel;

    public function __construct() {
        $this->movieModel = new Movie();
    }

    public function index() {
        try {
            $featured = $this->movieModel->getFeaturedMovies();
            $nowPlaying = $this->movieModel->getNowPlaying();
            $upcoming = $this->movieModel->getUpcoming();
            require 'views/pages/movies/index.php';
        } catch (\Exception $e) {
            error_log($e->getMessage());
            require 'views/errors/500.php';
        }
    }

    public function details($id) {
        try {
            // Récupérer les détails du film
            $movie = $this->movieModel->getMovieDetails($id);
            
            if (!$movie) {
                require 'views/errors/404.php';
                return;
            }
            
            // Récupérer les crédits (équipe et casting)
            $credits = $this->movieModel->getMovieCredits($id);
            
            // Séparer les réalisateurs et le casting
            $directors = array_filter($credits['crew'] ?? [], function($person) {
                return $person['job'] === 'Director';
            });
            
            $cast = $credits['cast'] ?? [];
            
            // Récupérer la bande-annonce
            $videos = $this->movieModel->getMovieVideos($id);
            $trailer = null;
            foreach ($videos['results'] ?? [] as $video) {
                if ($video['type'] === 'Trailer' && $video['site'] === 'YouTube') {
                    $trailer = $video;
                    break;
                }
            }
            
            // Récupérer les images
            $images = $this->movieModel->getMovieImages($id);
            
            // Récupérer les films similaires
            $similarMovies = $this->movieModel->getSimilarMovies($id);
            
            // Récupérer la note de l'utilisateur si connecté
            $userRating = 0;
            if (isset($_SESSION['user_id'])) {
                $userRating = $this->movieModel->getUserRating($_SESSION['user_id'], $id);
            }
            
            // Vérifier si le film est dans les favoris/watchlist de l'utilisateur
            $isFavorite = false;
            $inWatchlist = false;
            if (isset($_SESSION['user_id'])) {
                $isFavorite = $this->movieModel->isInFavorites($_SESSION['user_id'], $id);
                $inWatchlist = $this->movieModel->isInWatchlist($_SESSION['user_id'], $id);
            }

            // Charger la vue avec toutes les données
            require 'views/pages/movies/details.php';
        } catch (\Exception $e) {
            // Log l'erreur
            error_log($e->getMessage());
            // Rediriger vers une page d'erreur
            require 'views/errors/500.php';
        }
    }

    public function search() {
        try {
            $query = $_GET['q'] ?? '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

            if (empty($query)) {
                header('Location: ' . BASE_URL);
                exit;
            }

            $movies = $this->movieModel->searchMovies($query, $page);
            
            // Pour le débogage
            if (empty($movies['results'])) {
                error_log("Aucun résultat trouvé pour la recherche : " . $query);
            }

            require 'views/pages/movies/search.php';
        } catch (\Exception $e) {
            error_log("Erreur de recherche : " . $e->getMessage());
            require 'views/errors/500.php';
        }
    }

    public function topRated() {
        try {
            $page = $_GET['page'] ?? 1;
            $movies = $this->movieModel->getTopRatedMovies($page);
            require 'views/pages/movies/top-rated.php';
        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo "Une erreur est survenue lors du chargement des films les mieux notés.";
        }
    }

    public function upcoming() {
        try {
            $page = $_GET['page'] ?? 1;
            $movies = $this->movieModel->getUpcomingMovies($page);
            
            // Charger la vue
            require 'views/pages/movies/upcoming.php';
        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo "Une erreur est survenue lors du chargement des films à venir.";
        }
    }
} 