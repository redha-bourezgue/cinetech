document.addEventListener('DOMContentLoaded', function() {
    // Validation du formulaire d'inscription
    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        const password = registerForm.querySelector('#password');
        const confirmPassword = registerForm.querySelector('#confirm_password');
        const username = registerForm.querySelector('#username');
        const email = registerForm.querySelector('#email');
        const strengthBar = document.querySelector('.password-strength-bar');

        // Validation du mot de passe en temps réel
        password.addEventListener('input', function() {
            const strength = checkPasswordStrength(this.value);
            updatePasswordStrengthBar(strength);
        });

        // Vérification de la correspondance des mots de passe
        confirmPassword.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.setCustomValidity('Les mots de passe ne correspondent pas');
            } else {
                this.setCustomValidity('');
            }
        });

        // Validation du nom d'utilisateur (uniquement lettres, chiffres et underscore)
        username.addEventListener('input', function() {
            const isValid = /^[a-zA-Z0-9_]{3,20}$/.test(this.value);
            if (!isValid) {
                this.setCustomValidity('Le nom d\'utilisateur doit contenir entre 3 et 20 caractères (lettres, chiffres et underscore uniquement)');
            } else {
                this.setCustomValidity('');
            }
        });

        // Validation de l'email
        email.addEventListener('input', function() {
            const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
            if (!isValid) {
                this.setCustomValidity('Veuillez entrer une adresse email valide');
            } else {
                this.setCustomValidity('');
            }
        });

        // Validation finale avant envoi
        registerForm.addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                showFormErrors(this);
            }
        });
    }

    // Fonctions utilitaires
    function checkPasswordStrength(password) {
        let strength = 0;
        
        // Longueur minimale
        if (password.length >= 8) strength++;
        
        // Contient des chiffres
        if (/\d/.test(password)) strength++;
        
        // Contient des lettres minuscules et majuscules
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        
        // Contient des caractères spéciaux
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        return strength;
    }

    function updatePasswordStrengthBar(strength) {
        const strengthBar = document.querySelector('.password-strength-bar');
        if (!strengthBar) return;

        strengthBar.className = 'password-strength-bar';
        
        if (strength >= 4) {
            strengthBar.classList.add('strength-strong');
        } else if (strength >= 2) {
            strengthBar.classList.add('strength-medium');
        } else {
            strengthBar.classList.add('strength-weak');
        }
    }

    function showFormErrors(form) {
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            if (!input.validity.valid) {
                const formGroup = input.closest('.form-group');
                if (formGroup) {
                    const errorDiv = formGroup.querySelector('.error-message') || document.createElement('div');
                    errorDiv.className = 'error-message';
                    errorDiv.textContent = input.validationMessage;
                    if (!formGroup.querySelector('.error-message')) {
                        formGroup.appendChild(errorDiv);
                    }
                }
            }
        });
    }
}); 