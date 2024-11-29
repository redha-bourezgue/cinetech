<?php include 'views/templates/header.php'; ?>

<div class="search-container">
    <h1>Résultats de recherche pour "<?= htmlspecialchars($query) ?>"</h1>

    <?php if (isset($results) && isset($results['results']) && !empty($results['results'])): ?>
        <p class="results-count">
            <?= $results['total_results'] ?> résultat(s) trouvé(s)
        </p>

        <div class="movie-grid">
            <?php foreach ($results['results'] as $movie): ?>
                <a href="<?= BASE_URL ?>/movie/details/<?= $movie['id'] ?>" class="movie-card">
                    <?php if ($movie['poster_path']): ?>
                        <img src="<?= TMDB_IMG_URL . $movie['poster_path'] ?>" 
                             alt="<?= htmlspecialchars($movie['title']) ?>"
                             class="movie-poster">
                    <?php else: ?>
                        <div class="no-poster">
                            <span>Pas d'affiche disponible</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="movie-info">
                        <h3 class="movie-title"><?= htmlspecialchars($movie['title']) ?></h3>
                        <div class="movie-meta">
                            <span class="movie-rating">★ <?= number_format($movie['vote_average'], 1) ?></span>
                            <?php if (!empty($movie['release_date'])): ?>
                                <span class="release-date">
                                    <?= date('Y', strtotime($movie['release_date'])) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($results['total_pages'] > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="<?= BASE_URL ?>/movie/search?query=<?= urlencode($query) ?>&page=<?= $page - 1 ?>" 
                       class="page-link">
                        &laquo; Précédent
                    </a>
                <?php endif; ?>

                <?php 
                $start = max(1, $page - 2);
                $end = min($results['total_pages'], $page + 2);
                for ($i = $start; $i <= $end; $i++): 
                ?>
                    <a href="<?= BASE_URL ?>/movie/search?query=<?= urlencode($query) ?>&page=<?= $i ?>" 
                       class="page-link <?= $i === $page ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $results['total_pages']): ?>
                    <a href="<?= BASE_URL ?>/movie/search?query=<?= urlencode($query) ?>&page=<?= $page + 1 ?>" 
                       class="page-link">
                        Suivant &raquo;
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="no-results">
            <p>Aucun résultat trouvé pour votre recherche.</p>
            <a href="<?= BASE_URL ?>" class="btn-back">Retour à l'accueil</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'views/templates/footer.php'; ?> 