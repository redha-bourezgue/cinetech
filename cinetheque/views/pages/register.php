<?php include 'views/templates/header.php'; ?>

<div class="main-container">
    <div class="auth-container">
        <h1 class="auth-title">Inscription</h1>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/auth/register" method="POST" class="auth-form">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>

            <button type="submit" class="auth-button">S'inscrire</button>
        </form>

        <p class="auth-link">
            Déjà un compte ? 
            <a href="<?= BASE_URL ?>/auth/login">Se connecter</a>
        </p>
    </div>
</div>

<?php include 'views/templates/footer.php'; ?> 