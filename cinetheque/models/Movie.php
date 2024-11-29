<?php
namespace App\Models;

use App\Core\Database;

class Movie {
    private $db;
    private $table = 'movies';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getMovieDetails($movieId) {
        $url = "https://api.themoviedb.org/3/movie/{$movieId}";
        $params = [
            'api_key' => TMDB_API_KEY,
            'language' => 'fr-FR',
            'append_to_response' => 'videos,images'
        ];

        return $this->makeApiRequest($url, $params);
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
        return array_slice($response['results'] ?? [], 0, $limit);
    }

    public function getFeaturedMovies() {
        try {
            $url = "https://api.themoviedb.org/3/movie/popular";
            $params = [
                'api_key' => TMDB_API_KEY,
                'language' => 'fr-FR',
                'page' => 1,
                'region' => 'FR'
            ];

            $response = $this->makeApiRequest($url, $params);
            
            if (!$response) {
                return ['results' => []];
            }

            // On ne prend que les 5 premiers films
            $response['results'] = array_slice($response['results'], 0, 5);

            foreach ($response['results'] as &$movie) {
                $movie = $this->formatMovieData($movie);
            }

            return $response;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return ['results' => []];
        }
    }

    public function getNowPlayingMovies($limit = 10) {
        $url = "https://api.themoviedb.org/3/movie/now_playing";
        $params = [
            'api_key' => TMDB_API_KEY,
            'language' => 'fr-FR',
            'region' => 'FR',
            'page' => 1
        ];

        $response = $this->makeApiRequest($url, $params);
        return array_slice($response['results'] ?? [], 0, $limit);
    }

    public function getUpcomingMovies($page = 1) {
        $url = "https://api.themoviedb.org/3/movie/upcoming";
        $params = [
            'api_key' => TMDB_API_KEY,
            'language' => 'fr-FR',
            'page' => $page,
            'region' => 'FR'
        ];

        $response = $this->makeApiRequest($url, $params);

        if (!$response) {
            return [
                'results' => [],
                'total_pages' => 0,
                'total_results' => 0,
                'page' => 1
            ];
        }

        $results = [];
        foreach ($response['results'] as $movie) {
            $results[] = $this->formatMovieData($movie);
        }

        return [
            'results' => $results,
            'total_pages' => $response['total_pages'],
            'page' => $response['page']
        ];
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

    public function searchMovies($query, $page = 1) {
        try {
            $url = "https://api.themoviedb.org/3/search/movie";
            $params = [
                'api_key' => TMDB_API_KEY,
                'language' => 'fr-FR',
                'query' => $query,
                'page' => $page,
                'include_adult' => false,
                'region' => 'FR'
            ];

            // Débogage
            error_log("URL de recherche : " . $url . '?' . http_build_query($params));

            // Construire l'URL avec les paramètres
            $fullUrl = $url . '?' . http_build_query($params);

            // Faire la requête à l'API
            $response = file_get_contents($fullUrl);
            
            if ($response === false) {
                throw new \Exception("Erreur lors de la requête à l'API TMDB");
            }

            $data = json_decode($response, true);

            if (!$data || !isset($data['results'])) {
                return [
                    'results' => [],
                    'total_pages' => 0,
                    'total_results' => 0,
                    'page' => 1,
                    'query' => $query
                ];
            }

            // Formater les résultats
            foreach ($data['results'] as &$movie) {
                // Ajouter le chemin complet des images
                $movie['poster_path'] = $movie['poster_path'] 
                    ? TMDB_IMG_URL . '/w500' . $movie['poster_path']
                    : BASE_URL . '/public/img/no-poster.jpg';

                // Formater la date de sortie
                if (!empty($movie['release_date'])) {
                    $date = new \DateTime($movie['release_date']);
                    $movie['release_date'] = $date->format('d/m/Y');
                } else {
                    $movie['release_date'] = 'Date inconnue';
                }

                // Arrondir la note
                $movie['vote_average'] = number_format($movie['vote_average'], 1);
            }

            return [
                'results' => $data['results'],
                'total_pages' => $data['total_pages'],
                'total_results' => $data['total_results'],
                'page' => $data['page'],
                'query' => $query
            ];

        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [
                'results' => [],
                'total_pages' => 0,
                'total_results' => 0,
                'page' => 1,
                'query' => $query
            ];
        }
    }

    public function getTopRatedMovies($page = 1) {
        $url = "https://api.themoviedb.org/3/movie/top_rated";
        $params = [
            'api_key' => TMDB_API_KEY,
            'language' => 'fr-FR',
            'page' => $page,
            'region' => 'FR'
        ];

        $response = $this->makeApiRequest($url, $params);
        return $response ?? ['results' => [], 'total_pages' => 0];
    }

    public function getNowPlaying($page = 1) {
        try {
            $url = "https://api.themoviedb.org/3/movie/now_playing";
            $params = [
                'api_key' => TMDB_API_KEY,
                'language' => 'fr-FR',
                'page' => $page,
                'region' => 'FR'
            ];

            $response = $this->makeApiRequest($url, $params);

            if (!$response) {
                return [
                    'results' => [],
                    'total_pages' => 0,
                    'page' => 1
                ];
            }

            // Formater les résultats
            foreach ($response['results'] as &$movie) {
                $movie = $this->formatMovieData($movie);
            }

            return $response;

        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [
                'results' => [],
                'total_pages' => 0,
                'page' => 1
            ];
        }
    }

    public function getUpcoming($page = 1) {
        try {
            $url = "https://api.themoviedb.org/3/movie/upcoming";
            $params = [
                'api_key' => TMDB_API_KEY,
                'language' => 'fr-FR',
                'page' => $page,
                'region' => 'FR'
            ];

            $response = $this->makeApiRequest($url, $params);

            if (!$response) {
                return [
                    'results' => [],
                    'total_pages' => 0,
                    'page' => 1
                ];
            }

            // Formater les résultats
            foreach ($response['results'] as &$movie) {
                $movie = $this->formatMovieData($movie);
            }

            return $response;

        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [
                'results' => [],
                'total_pages' => 0,
                'page' => 1
            ];
        }
    }

    private function formatMovieData($movie) {
        return [
            'id' => $movie['id'],
            'title' => $movie['title'],
            'poster_path' => $movie['poster_path'],
            'backdrop_path' => $movie['backdrop_path'],
            'release_date' => $movie['release_date'] ?? null,
            'vote_average' => $movie['vote_average'] ?? 0,
            'overview' => $movie['overview'] ?? '',
            'genre_ids' => $movie['genre_ids'] ?? []
        ];
    }

    private function makeApiRequest($url, $params = []) {
        try {
            $fullUrl = $url . '?' . http_build_query($params);
            
            $opts = [
                'http' => [
                    'method' => 'GET',
                    'header' => [
                        'Accept: application/json',
                        'User-Agent: Cinethèque/1.0'
                    ]
                ]
            ];
            
            $context = stream_context_create($opts);
            $response = file_get_contents($fullUrl, false, $context);
            
            if ($response === false) {
                throw new \Exception("Erreur lors de la requête à l'API TMDB");
            }
            
            return json_decode($response, true);
            
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }
} 