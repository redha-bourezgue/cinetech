<?php

// Routes pour le profil
$router->get('/profile', 'ProfileController@index', 'AuthMiddleware');
$router->post('/profile/update', 'ProfileController@update', 'AuthMiddleware');

// Routes pour les favoris
$router->post('/movies/favorite/add', 'MovieController@addToFavorites', 'AuthMiddleware');
$router->post('/movies/favorite/remove', 'MovieController@removeFromFavorites');

// Routes pour la watchlist
$router->post('/movies/watchlist/add', 'MovieController@addToWatchlist');
$router->post('/movies/watchlist/remove', 'MovieController@removeFromWatchlist');

// Routes pour les notes
$router->post('/movies/rate', 'MovieController@rateMovie');

// Routes pour l'historique
$router->post('/movies/history/add', 'MovieController@addToHistory'); 