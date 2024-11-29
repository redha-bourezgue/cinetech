// Fonction utilitaire pour les requêtes AJAX
async function fetchAPI(url, method = 'POST', data = null) {
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: data ? JSON.stringify(data) : null
        });

        if (!response.ok) {
            throw new Error('Erreur réseau');
        }

        return await response.json();
    } catch (error) {
        console.error('Erreur:', error);
        throw error;
    }
}

// Gestion des favoris
async function toggleFavorite(movieId) {
    try {
        const button = document.querySelector(`.favorite-btn[data-movie-id="${movieId}"]`);
        const isFavorite = button.classList.contains('active');
        const url = isFavorite ? '/movies/favorite/remove' : '/movies/favorite/add';

        const response = await fetchAPI(url, 'POST', { movie_id: movieId });

        if (response.success) {
            button.classList.toggle('active');
            // Mettre à jour l'icône
            const icon = button.querySelector('i');
            icon.classList.toggle('fas');
            icon.classList.toggle('far');
        }
    } catch (error) {
        showNotification('Erreur lors de la mise à jour des favoris', 'error');
    }
}

// Gestion des notes
async function rateMovie(movieId, rating) {
    try {
        const response = await fetchAPI('/movies/rate', 'POST', {
            movie_id: movieId,
            rating: rating
        });

        if (response.success) {
            // Mettre à jour l'affichage des étoiles
            updateStarsDisplay(movieId, rating);
            showNotification('Note enregistrée !', 'success');
        }
    } catch (error) {
        showNotification('Erreur lors de l\'enregistrement de la note', 'error');
    }
}

// Gestion de la watchlist
async function toggleWatchlist(movieId) {
    try {
        const button = document.querySelector(`.watchlist-btn[data-movie-id="${movieId}"]`);
        const isInWatchlist = button.classList.contains('active');
        const url = isInWatchlist ? '/movies/watchlist/remove' : '/movies/watchlist/add';

        const response = await fetchAPI(url, 'POST', { movie_id: movieId });

        if (response.success) {
            button.classList.toggle('active');
            // Mettre à jour le texte du bouton
            button.textContent = isInWatchlist ? 'Ajouter à la watchlist' : 'Retirer de la watchlist';
        }
    } catch (error) {
        showNotification('Erreur lors de la mise à jour de la watchlist', 'error');
    }
}

// Système de notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Animation d'entrée
    setTimeout(() => notification.classList.add('show'), 10);

    // Suppression automatique
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Mise à jour de l'affichage des étoiles
function updateStarsDisplay(movieId, rating) {
    const starsContainer = document.querySelector(`.stars[data-movie-id="${movieId}"]`);
    const stars = starsContainer.querySelectorAll('i');

    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}

// Initialisation des événements
document.addEventListener('DOMContentLoaded', function() {
    // Favoris
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', () => toggleFavorite(btn.dataset.movieId));
    });

    // Notes
    document.querySelectorAll('.stars i').forEach(star => {
        star.addEventListener('click', () => {
            const movieId = star.closest('.stars').dataset.movieId;
            const rating = parseInt(star.dataset.rating);
            rateMovie(movieId, rating);
        });
    });

    // Watchlist
    document.querySelectorAll('.watchlist-btn').forEach(btn => {
        btn.addEventListener('click', () => toggleWatchlist(btn.dataset.movieId));
    });
}); 