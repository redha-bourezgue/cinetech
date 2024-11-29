<?php include 'views/templates/header.php'; ?>

<div class="main-container">
    <h1 class="page-title">Films les mieux notés</h1>
    
    <div class="movie-grid">
        <?php foreach ($movies['results'] as $movie): ?>
            <?php if ($movie['poster_path']): ?>
                <a href="<?= BASE_URL ?>/movie/details/<?= $movie['id'] ?>" class="movie-card">
                    <div class="poster-container">
                        <img src="<?= TMDB_IMG_URL ?>/w500<?= $movie['poster_path'] ?>" 
                             alt="<?= htmlspecialchars($movie['title']) ?>"
                             class="movie-poster"
                             loading="lazy">
                    </div>
                    <div class="movie-info">
                        <h2 class="movie-title"><?= htmlspecialchars($movie['title']) ?></h2>
                        <div class="movie-meta">
                            <span class="release-date">
                                <?= date('Y', strtotime($movie['release_date'])) ?>
                            </span>
                            <span class="movie-rating">
                                <i class="fas fa-star"></i>
                                <?= number_format($movie['vote_average'], 1) ?>
                            </span>
                        </div>
                    </div>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <?php include 'views/templates/pagination.php'; ?>
</div>

<?php include 'views/templates/footer.php'; ?> 