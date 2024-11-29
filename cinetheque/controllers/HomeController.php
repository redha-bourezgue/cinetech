<?php

class HomeController {
    private $movieModel;
    private $newsModel;

    public function __construct() {
        $this->movieModel = new MovieModel();
        $this->newsModel = new NewsModel();
    }

    public function index() {
        // Films à la une (featured)
        $featuredMovies = $this->movieModel->getFeaturedMovies();

        // Films à l'affiche
        $nowPlaying = $this->movieModel->getNowPlayingMovies();

        // Films à venir
        $upcomingMovies = $this->movieModel->getUpcomingMovies();

        // Actualités
        $news = $this->newsModel->getLatestNews();

        // Charger la vue avec les données
        require_once 'views/pages/home.php';
    }
} 