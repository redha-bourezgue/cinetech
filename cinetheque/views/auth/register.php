<?php include 'views/templates/header.php'; ?>

<div class="auth-container">
    <div class="auth-box">
        <h2>Inscription</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/auth/register" method="POST">
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
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn-primary">S'inscrire</button>
        </form>

        <p class="auth-links">
            Déjà un compte ? <a href="<?= BASE_URL ?>/auth/login">Se connecter</a>
        </p>
    </div>
</div>

<?php include 'views/templates/footer.php'; ?> 