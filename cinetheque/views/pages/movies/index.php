<?php include 'views/templates/header.php'; ?>

<!-- Carrousel des films en vedette -->
<div class="featured-carousel">
    <div class="carousel-container">
        <?php foreach ($featured['results'] as $index => $movie): ?>
            <div class="carousel-slide <?= $index === 0 ? 'active' : '' ?>" 
                 style="background-image: url('https://image.tmdb.org/t/p/original<?= $movie['backdrop_path'] ?>')">
                <div class="carousel-content">
                    <h2><?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <p class="movie-overview"><?= htmlspecialchars($movie['overview'], ENT_QUOTES, 'UTF-8') ?></p>
                    <div class="movie-meta">
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            <?= number_format($movie['vote_average'], 1) ?>
                        </span>
                        <?php if (!empty($movie['release_date'])): ?>
                            <span class="year"><?= date('Y', strtotime($movie['release_date'])) ?></span>
                        <?php endif; ?>
                    </div>
                    <a href="<?= BASE_URL ?>/movie/details/<?= $movie['id'] ?>" class="btn-primary">
                        Plus d'infos
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        
        <!-- Boutons de navigation -->
        <button class="carousel-btn prev">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="carousel-btn next">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <!-- Indicateurs -->
        <div class="carousel-indicators">
            <?php foreach ($featured['results'] as $index => $movie): ?>
                <button class="indicator <?= $index === 0 ? 'active' : '' ?>" 
                        data-slide="<?= $index ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="main-container">
    <!-- Films à l'affiche -->
    <section class="movie-section">
        <h2 class="section-title">Films à l'affiche</h2>
        <div class="movie-grid">
            <?php foreach ($nowPlaying['results'] as $movie): ?>
                <div class="movie-card">
                    <a href="<?= BASE_URL ?>/movie/details/<?= $movie['id'] ?>">
                        <div class="movie-poster">
                            <?php if ($movie['poster_path']): ?>
                                <img src="https://image.tmdb.org/t/p/w500<?= $movie['poster_path'] ?>" 
                                     alt="<?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <img src="<?= BASE_URL ?>/public/img/no-poster.jpg" 
                                     alt="Pas d'affiche disponible"
                                     loading="lazy">
                            <?php endif; ?>
                        </div>
                        <div class="movie-info">
                            <h3><?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <?php if (!empty($movie['release_date'])): ?>
                                <span class="year"><?= date('Y', strtotime($movie['release_date'])) ?></span>
                            <?php endif; ?>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <?= number_format($movie['vote_average'], 1) ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Prochainement -->
    <section class="movie-section">
        <h2 class="section-title">Prochainement</h2>
        <div class="movie-grid">
            <?php foreach ($upcoming['results'] as $movie): ?>
                <div class="movie-card">
                    <a href="<?= BASE_URL ?>/movie/details/<?= $movie['id'] ?>">
                        <div class="movie-poster">
                            <?php if ($movie['poster_path']): ?>
                                <img src="https://image.tmdb.org/t/p/w500<?= $movie['poster_path'] ?>" 
                                     alt="<?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <img src="<?= BASE_URL ?>/public/img/no-poster.jpg" 
                                     alt="Pas d'affiche disponible"
                                     loading="lazy">
                            <?php endif; ?>
                        </div>
                        <div class="movie-info">
                            <h3><?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <?php if (!empty($movie['release_date'])): ?>
                                <span class="release-date"><?= date('d/m/Y', strtotime($movie['release_date'])) ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<?php include 'views/templates/footer.php'; ?> 