<?php
require_once 'vendor/autoload.php';
require_once 'config/config.php';

// Démarrer la session
session_start();

// Récupérer l'URL demandée
$request = $_SERVER['REQUEST_URI'];
$basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
$request = str_replace($basePath, '', $request);

// Nettoyer l'URL des paramètres GET
$requestPath = parse_url($request, PHP_URL_PATH);

// Router basique
try {
    // Routes définies
    switch ($requestPath) {
        case '/':
        case '':
            $controller = new App\Controllers\MovieController();
            $controller->index();
            break;

        case '/search':
            $controller = new App\Controllers\MovieController();
            $controller->search();
            break;

        case '/movies/top-rated':
            $controller = new App\Controllers\MovieController();
            $controller->topRated();
            break;

        case '/movies/upcoming':
            $controller = new App\Controllers\MovieController();
            $controller->upcoming();
            break;

        case '/auth/login':
            $controller = new App\Controllers\AuthController();
            $controller->login();
            break;

        case '/auth/register':
            $controller = new App\Controllers\AuthController();
            $controller->register();
            break;

        case '/auth/logout':
            $controller = new App\Controllers\AuthController();
            $controller->logout();
            break;

        default:
            // Vérifier si c'est une route de détails de film
            if (preg_match('/^\/movie\/details\/(\d+)$/', $requestPath, $matches)) {
                $movieId = $matches[1];
                $controller = new App\Controllers\MovieController();
                $controller->details($movieId);
                break;
            }

            // Si aucune route ne correspond
            header("HTTP/1.0 404 Not Found");
            require 'views/errors/404.php';
            break;
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    header("HTTP/1.0 500 Internal Server Error");
    require 'views/errors/500.php';
}
