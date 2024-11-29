<?php include 'views/templates/header.php'; ?>

<div class="main-container">
    <div class="search-header">
        <h1>Résultats pour "<?= htmlspecialchars($_GET['q'] ?? '') ?>"</h1>
        
        <!-- Formulaire de recherche avec les filtres -->
        <form action="<?= BASE_URL ?>/search" method="GET" class="search-form">
            <div class="search-bar">
                <input type="text" 
                       name="q" 
                       value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" 
                       placeholder="Rechercher un film..."
                       required>
                <button type="submit">
                    <i class="fas fa-search"></i>
                    Rechercher
                </button>
            </div>
        </form>
    </div>

    <?php if (empty($movies['results'])): ?>
        <div class="no-results">
            <p>Aucun résultat trouvé pour votre recherche.</p>
            <a href="<?= BASE_URL ?>" class="btn-primary">Retour à l'accueil</a>
        </div>
    <?php else: ?>
        <div class="movie-grid">
            <?php foreach ($movies['results'] as $movie): ?>
                <?php include 'views/partials/movie-card.php'; ?>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($movies['total_pages'] > 1): ?>
            <div class="pagination">
                <?php if ($movies['page'] > 1): ?>
                    <a href="?q=<?= urlencode($_GET['q']) ?>&page=<?= $movies['page'] - 1 ?>" 
                       class="btn-page">Page précédente</a>
                <?php endif; ?>

                <span class="page-info">
                    Page <?= $movies['page'] ?> sur <?= $movies['total_pages'] ?>
                </span>

                <?php if ($movies['page'] < $movies['total_pages']): ?>
                    <a href="?q=<?= urlencode($_GET['q']) ?>&page=<?= $movies['page'] + 1 ?>" 
                       class="btn-page">Page suivante</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include 'views/templates/footer.php'; ?> 