<?php include 'views/templates/header.php'; ?>

<div class="main-container">
    <div class="page-header">
        <h1>Films les mieux notés</h1>
    </div>

    <div class="movie-grid">
        <?php foreach ($movies['results'] as $movie): ?>
            <?php include 'views/partials/movie-card.php'; ?>
        <?php endforeach; ?>
    </div>

    <?php if ($movies['total_pages'] > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="btn-page">Page précédente</a>
            <?php endif; ?>

            <span class="page-info">Page <?= $page ?> sur <?= $movies['total_pages'] ?></span>

            <?php if ($page < $movies['total_pages']): ?>
                <a href="?page=<?= $page + 1 ?>" class="btn-page">Page suivante</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'views/templates/footer.php'; ?> 