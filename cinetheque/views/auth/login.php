<?php include 'views/templates/header.php'; ?>

<div class="auth-container">
    <div class="auth-box">
        <h2>Connexion</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/auth/login" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-primary">Se connecter</button>
        </form>

        <p class="auth-links">
            Pas encore de compte ? <a href="<?= BASE_URL ?>/auth/register">S'inscrire</a>
        </p>
    </div>
</div>

<?php include 'views/templates/footer.php'; ?> 