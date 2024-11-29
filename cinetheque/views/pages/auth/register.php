<?php include 'views/templates/header.php'; ?>

<div class="auth-container">
    <div class="auth-box">
        <h1>Inscription</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/auth/register" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required 
                       minlength="3" maxlength="50"
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required minlength="8">
                <div class="password-strength">
                    <div class="password-strength-bar"></div>
                </div>
                <small class="form-text">
                    Le mot de passe doit contenir au moins 8 caractères, incluant des majuscules, 
                    des minuscules, des chiffres et des caractères spéciaux
                </small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn-primary">S'inscrire</button>
        </form>

        <div class="auth-links">
            <p>Déjà inscrit ? <a href="<?= BASE_URL ?>/auth/login">Se connecter</a></p>
        </div>
    </div>
</div>

<?php include 'views/templates/footer.php'; ?> 