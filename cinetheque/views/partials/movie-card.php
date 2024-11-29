<div class="movie-card">
    <a href="<?= BASE_URL ?>/movie/details/<?= $movie['id'] ?>">
        <div class="movie-poster">
            <?php if ($movie['poster_path']): ?>
                <img src="<?= htmlspecialchars($movie['poster_path'], ENT_QUOTES, 'UTF-8') ?>" 
                     alt="<?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>">
            <?php else: ?>
                <img src="<?= BASE_URL ?>/public/img/no-poster.jpg" 
                     alt="Pas d'affiche disponible">
            <?php endif; ?>
        </div>
        <div class="movie-info">
            <h3><?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?></h3>
            <div class="movie-meta">
                <?php if (!empty($movie['release_date'])): ?>
                    <span class="year"><?= htmlspecialchars($movie['release_date'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
                <span class="rating">
                    <i class="fas fa-star"></i>
                    <?= number_format($movie['vote_average'], 1) ?>
                </span>
            </div>
        </div>
    </a>
</div> 