<?php include 'views/templates/header.php'; ?>

<div class="movie-backdrop" style="background-image: url('<?= TMDB_IMG_URL ?>/original<?= $movie['backdrop_path'] ?>')">
    <div class="backdrop-overlay"></div>
</div>

<div class="main-container movie-details-page">
    <div class="movie-header">
        <div class="poster-container">
            <img src="<?= TMDB_IMG_URL ?>/w500<?= $movie['poster_path'] ?>" 
                 alt="<?= $movie['title'] ?>" 
                 class="movie-poster">
            
            <div class="action-buttons">
                <button class="btn-action watchlist-btn <?= $inWatchlist ? 'active' : '' ?>" data-id="<?= $movie['id'] ?>">
                    <i class="fas fa-bookmark"></i>
                    <span>À voir</span>
                </button>
                <button class="btn-action favorite-btn <?= $isFavorite ? 'active' : '' ?>" data-id="<?= $movie['id'] ?>">
                    <i class="fas fa-heart"></i>
                    <span>Favoris</span>
                </button>
            </div>
        </div>

        <div class="movie-info">
            <h1><?= $movie['title'] ?></h1>
            
            <div class="movie-meta">
                <span class="release-date"><?= date('d/m/Y', strtotime($movie['release_date'])) ?></span>
                <span class="duration"><?= $movie['runtime'] ?> min</span>
                <span class="genres"><?= implode(', ', array_column($movie['genres'], 'name')) ?></span>
            </div>

            <div class="ratings-container">
                <div class="press-rating">
                    <div class="rating-circle">
                        <span class="rating-value"><?= number_format($movie['vote_average'], 1) ?></span>
                    </div>
                    <span class="rating-label">Presse</span>
                </div>
                <div class="public-rating">
                    <div class="rating-circle">
                        <span class="rating-value"><?= number_format($movie['popularity'], 1) ?></span>
                    </div>
                    <span class="rating-label">Public</span>
                </div>
                <div class="user-rating">
                    <div class="stars" data-movie-id="<?= $movie['id'] ?>">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?= $userRating >= $i ? 'active' : '' ?>" data-rating="<?= $i ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-label">Votre note</span>
                </div>
            </div>

            <div class="synopsis">
                <h2>Synopsis et détails</h2>
                <p><?= $movie['overview'] ?></p>
            </div>

            <div class="movie-crew">
                <div class="crew-item">
                    <span class="crew-role">De</span>
                    <span class="crew-names"><?= implode(', ', array_column($directors, 'name')) ?></span>
                </div>
                <div class="crew-item">
                    <span class="crew-role">Avec</span>
                    <span class="crew-names"><?= implode(', ', array_column(array_slice($cast, 0, 3), 'name')) ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="movie-content">
        <!-- Bande-annonce -->
        <?php if ($trailer): ?>
        <section class="trailer-section">
            <h2>Bande-annonce</h2>
            <div class="video-container">
                <iframe src="https://www.youtube.com/embed/<?= $trailer['key'] ?>" 
                        frameborder="0" 
                        allowfullscreen></iframe>
            </div>
        </section>
        <?php endif; ?>

        <!-- Casting -->
        <section class="cast-section">
            <h2>Casting</h2>
            <div class="cast-grid">
                <?php foreach(array_slice($cast, 0, 12) as $actor): ?>
                    <div class="cast-card">
                        <img src="<?= TMDB_IMG_URL ?>/w185<?= $actor['profile_path'] ?>" 
                             alt="<?= $actor['name'] ?>"
                             onerror="this.src='<?= BASE_URL ?>/public/img/default-avatar.png'">
                        <div class="cast-info">
                            <h3><?= $actor['name'] ?></h3>
                            <p><?= $actor['character'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($cast) > 12): ?>
                <button class="btn-more-cast">Voir tout le casting</button>
            <?php endif; ?>
        </section>

        <!-- Photos -->
        <section class="photos-section">
            <h2>Photos</h2>
            <div class="photos-grid">
                <?php foreach(array_slice($images, 0, 6) as $image): ?>
                    <a href="<?= TMDB_IMG_URL ?>/original<?= $image['file_path'] ?>" class="photo-item" data-fancybox="gallery">
                        <img src="<?= TMDB_IMG_URL ?>/w300<?= $image['file_path'] ?>" alt="Photo du film">
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Films similaires -->
        <section class="similar-section">
            <h2>Films similaires</h2>
            <div class="movie-carousel">
                <?php foreach($similarMovies as $similar): ?>
                    <!-- Structure de carte de film similaire -->
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</div>

<?php include 'views/templates/footer.php'; ?> 