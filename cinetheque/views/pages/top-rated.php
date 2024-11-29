<?php include 'views/templates/header.php'; ?>

<div class="top-rated-container">
    <h1>Films les Mieux Notés</h1>

    <?php if (isset($movies) && isset($movies['results'])): ?>
        <div class="movie-grid">
            <?php foreach ($movies['results'] as $movie): ?>
                <a href="<?= BASE_URL ?>/movie/details/<?= $movie['id'] ?>" class="movie-card">
                    <?php if ($movie['poster_path']): ?>
                        <img src="<?= TMDB_IMG_URL . $movie['poster_path'] ?>" 
                             alt="<?= htmlspecialchars($movie['title']) ?>"
                             class="movie-poster">
                    <?php endif; ?>
                    <div class="movie-info">
                        <h3 class="movie-title"><?= htmlspecialchars($movie['title']) ?></h3>
                        <div class="movie-meta">
                            <span class="movie-rating">★ <?= number_format($movie['vote_average'], 1) ?></span>
                            <span class="vote-count">(<?= number_format($movie['vote_count']) ?> votes)</span>
                        </div>
                        <div class="release-date">
                            <?= date('Y', strtotime($movie['release_date'])) ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($movies['total_pages'])): ?>
            <div class="pagination">
                <?php 
                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $totalPages = $movies['total_pages'];
                $maxPages = min($totalPages, 10); // Limiter à 10 pages maximum
                ?>

                <?php if ($currentPage > 1): ?>
                    <a href="<?= BASE_URL ?>/movie/top-rated?page=<?= $currentPage - 1 ?>" class="page-link">
                        &laquo; Précédent
                    </a>
                <?php endif; ?>

                <?php for ($i = max(1, $currentPage - 2); $i <= min($maxPages, $currentPage + 2); $i++): ?>
                    <a href="<?= BASE_URL ?>/movie/top-rated?page=<?= $i ?>" 
                       class="page-link <?= $i === $currentPage ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="<?= BASE_URL ?>/movie/top-rated?page=<?= $currentPage + 1 ?>" class="page-link">
                        Suivant &raquo;
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="error-message">
            <p>Aucun film trouvé.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'views/templates/footer.php'; ?> 