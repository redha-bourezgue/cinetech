<?php include 'views/templates/header.php'; ?>

<div class="hero-section">
    <div class="hero-slider">
        <?php foreach ($featuredMovies as $movie): ?>
            <div class="hero-slide" style="background-image: url('<?= TMDB_IMG_URL ?>/original<?= $movie['backdrop_path'] ?>')">
                <div class="hero-content">
                    <h1><?= $movie['title'] ?></h1>
                    <p><?= substr($movie['overview'], 0, 200) ?>...</p>
                    <div class="hero-buttons">
                        <a href="<?= BASE_URL ?>/movie/details/<?= $movie['id'] ?>" class="btn-primary">
                            <i class="fas fa-info-circle"></i> Plus d'infos
                        </a>
                        <button class="btn-secondary add-watchlist" data-id="<?= $movie['id'] ?>">
                            <i class="fas fa-bookmark"></i> À voir
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="main-container">
    <!-- Section À l'affiche -->
    <section class="movie-section">
        <div class="section-header">
            <h2>À l'affiche cette semaine</h2>
            <a href="<?= BASE_URL ?>/movies/in-theaters" class="see-all">Voir tout</a>
        </div>
        <div class="movie-carousel">
            <?php foreach ($nowPlaying as $movie): ?>
                <div class="movie-card">
                    <div class="movie-poster-container">
                        <img src="<?= TMDB_IMG_URL ?>/w500<?= $movie['poster_path'] ?>" 
                             alt="<?= $movie['title'] ?>" 
                             class="movie-poster">
                        <div class="movie-card-overlay">
                            <div class="movie-rating">
                                <span class="press-rating">
                                    <i class="fas fa-newspaper"></i> <?= number_format($movie['vote_average'], 1) ?>
                                </span>
                                <span class="public-rating">
                                    <i class="fas fa-users"></i> <?= number_format($movie['popularity'], 1) ?>
                                </span>
                            </div>
                            <a href="<?= BASE_URL ?>/movie/details/<?= $movie['id'] ?>" class="btn-more">
                                En savoir plus
                            </a>
                        </div>
                    </div>
                    <div class="movie-info">
                        <h3 class="movie-title"><?= $movie['title'] ?></h3>
                        <div class="movie-meta">
                            <span class="duration"><?= $movie['runtime'] ?> min</span>
                            <span class="genre"><?= $movie['genres'][0]['name'] ?? '' ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section Prochainement -->
    <section class="movie-section">
        <div class="section-header">
            <h2>Prochainement</h2>
            <a href="<?= BASE_URL ?>/movies/upcoming" class="see-all">Voir tout</a>
        </div>
        <div class="movie-carousel">
            <?php foreach ($upcomingMovies as $movie): ?>
                <div class="movie-card">
                    <div class="movie-poster-container">
                        <img src="<?= TMDB_IMG_URL ?>/w500<?= $movie['poster_path'] ?>" 
                             alt="<?= $movie['title'] ?>" 
                             class="movie-poster">
                        <div class="movie-card-overlay">
                            <div class="movie-rating">
                                <span class="press-rating">
                                    <i class="fas fa-newspaper"></i> <?= number_format($movie['vote_average'], 1) ?>
                                </span>
                                <span class="public-rating">
                                    <i class="fas fa-users"></i> <?= number_format($movie['popularity'], 1) ?>
                                </span>
                            </div>
                            <a href="<?= BASE_URL ?>/movie/details/<?= $movie['id'] ?>" class="btn-more">
                                En savoir plus
                            </a>
                        </div>
                    </div>
                    <div class="movie-info">
                        <h3 class="movie-title"><?= $movie['title'] ?></h3>
                        <div class="movie-meta">
                            <span class="duration"><?= $movie['runtime'] ?> min</span>
                            <span class="genre"><?= $movie['genres'][0]['name'] ?? '' ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section News -->
    <section class="news-section">
        <div class="section-header">
            <h2>Actualités cinéma</h2>
            <a href="<?= BASE_URL ?>/news" class="see-all">Toutes les news</a>
        </div>
        <div class="news-grid">
            <?php foreach ($news as $article): ?>
                <article class="news-card">
                    <img src="<?= $article['image'] ?>" alt="<?= $article['title'] ?>">
                    <div class="news-content">
                        <span class="news-category"><?= $article['category'] ?></span>
                        <h3><?= $article['title'] ?></h3>
                        <p><?= substr($article['content'], 0, 100) ?>...</p>
                        <span class="news-date"><?= $article['published_at'] ?></span>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<?php include 'views/templates/footer.php'; ?> 