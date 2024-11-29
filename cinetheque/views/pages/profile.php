<?php include 'views/templates/header.php'; ?>

<div class="main-container">
    <div class="profile-container">
        <!-- En-tête du profil -->
        <div class="profile-header">
            <div class="profile-info">
                <div class="profile-avatar">
                    <img src="<?= $user['avatar'] ?? BASE_URL . '/public/img/default-avatar.png' ?>" alt="Avatar">
                </div>
                <div class="profile-details">
                    <h1><?= htmlspecialchars($user['username']) ?></h1>
                    <p>Membre depuis : <?= date('d/m/Y', strtotime($user['created_at'])) ?></p>
                </div>
            </div>
            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= count($favorites) ?></span>
                    <span class="stat-label">Films favoris</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= count($watchlist) ?></span>
                    <span class="stat-label">À voir</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= count($ratings) ?></span>
                    <span class="stat-label">Films notés</span>
                </div>
            </div>
        </div>

        <!-- Onglets -->
        <div class="profile-tabs">
            <button class="tab-btn active" data-tab="favorites">Favoris</button>
            <button class="tab-btn" data-tab="watchlist">À voir</button>
            <button class="tab-btn" data-tab="ratings">Notes</button>
            <button class="tab-btn" data-tab="history">Historique</button>
            <button class="tab-btn" data-tab="settings">Paramètres</button>
        </div>

        <!-- Contenu des onglets -->
        <div class="tab-content">
            <!-- Favoris -->
            <div class="tab-pane active" id="favorites">
                <div class="movie-grid">
                    <?php foreach ($favorites as $movie): ?>
                        <?php include 'views/templates/movie-card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- À voir -->
            <div class="tab-pane" id="watchlist">
                <div class="movie-grid">
                    <?php foreach ($watchlist as $movie): ?>
                        <?php include 'views/templates/movie-card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Notes -->
            <div class="tab-pane" id="ratings">
                <div class="ratings-list">
                    <?php foreach ($ratings as $rating): ?>
                        <div class="rating-item">
                            <img src="<?= TMDB_IMG_URL ?>/w92<?= $rating['movie_poster'] ?>" alt="">
                            <div class="rating-info">
                                <h3><?= $rating['movie_title'] ?></h3>
                                <div class="stars">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?= $i <= $rating['rating'] ? 'active' : '' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Historique -->
            <div class="tab-pane" id="history">
                <div class="history-list">
                    <?php foreach ($history as $item): ?>
                        <div class="history-item">
                            <img src="<?= TMDB_IMG_URL ?>/w92<?= $item['movie_poster'] ?>" alt="">
                            <div class="history-info">
                                <h3><?= $item['movie_title'] ?></h3>
                                <p>Vu le <?= date('d/m/Y', strtotime($item['viewed_at'])) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Paramètres -->
            <div class="tab-pane" id="settings">
                <form class="settings-form" method="POST" action="<?= BASE_URL ?>/profile/update" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Avatar</label>
                        <input type="file" name="avatar" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Nom d'utilisateur</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                    </div>
                    <div class="form-group">
                        <label>Nouveau mot de passe</label>
                        <input type="password" name="password">
                    </div>
                    <button type="submit" class="btn-primary">Sauvegarder</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'views/templates/footer.php'; ?> 