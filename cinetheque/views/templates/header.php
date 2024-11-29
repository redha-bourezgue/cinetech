<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinéthèque</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/search.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/error.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/auth.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/carousel.css">
    <script src="<?= BASE_URL ?>/public/js/auth.js" defer></script>
    <script src="<?= BASE_URL ?>/public/js/carousel.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="<?= BASE_URL ?>">Cinéthèque</a>
            </div>
            <ul>
                <li><a href="<?= BASE_URL ?>/">Accueil</a></li>
                <li><a href="<?= BASE_URL ?>/movies/top-rated">Les mieux notés</a></li>
                <li><a href="<?= BASE_URL ?>/movies/upcoming">À venir</a></li>
                <?php if(isset($_SESSION['user'])): ?>
                    <li><a href="<?= BASE_URL ?>/auth/profile">Mon Profil</a></li>
                    <li><a href="<?= BASE_URL ?>/auth/logout">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="<?= BASE_URL ?>/auth/login">Connexion</a></li>
                    <li><a href="<?= BASE_URL ?>/auth/register">Inscription</a></li>
                <?php endif; ?>
            </ul>
            <form action="<?= BASE_URL ?>/search" method="GET" class="search-form">
                <div class="search-input-container">
                    <input type="text" 
                           name="q" 
                           placeholder="Rechercher un film..." 
                           value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                           required
                           minlength="2">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </nav>
    </header>
    <main> 
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>