document.addEventListener('DOMContentLoaded', function() {
    // Initialisation de la galerie photos avec Fancybox
    Fancybox.bind('[data-fancybox="gallery"]', {
        loop: true,
        buttons: [
            "zoom",
            "slideShow",
            "fullScreen",
            "close"
        ],
        animationEffect: "fade"
    });

    // Système de notation
    const stars = document.querySelectorAll('.stars i');
    let userRating = document.querySelector('.stars').dataset.userRating || 0;

    stars.forEach((star, index) => {
        // Hover effect
        star.addEventListener('mouseover', () => {
            updateStars(index + 1, 'hover');
        });

        star.addEventListener('mouseout', () => {
            updateStars(userRating, 'active');
        });

        // Click to rate
        star.addEventListener('click', async () => {
            const rating = index + 1;
            try {
                const response = await submitRating(rating);
                if (response.success) {
                    userRating = rating;
                    updateStars(rating, 'active');
                    showNotification('Votre note a été enregistrée !', 'success');
                }
            } catch (error) {
                showNotification('Erreur lors de l\'enregistrement de la note', 'error');
            }
        });
    });

    // Gestion des boutons d'action (favoris, watchlist)
    const actionButtons = document.querySelectorAll('.btn-action');
    actionButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const action = this.classList.contains('watchlist-btn') ? 'watchlist' : 'favorite';
            const movieId = this.dataset.id;

            try {
                const response = await fetch(`${BASE_URL}/movies/${action}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ movie_id: movieId })
                });

                if (response.ok) {
                    this.classList.toggle('active');
                    const actionText = action === 'watchlist' ? 'watchlist' : 'favoris';
                    const actionState = this.classList.contains('active') ? 'ajouté aux' : 'retiré des';
                    showNotification(`Film ${actionState} ${actionText}`, 'success');
                }
            } catch (error) {
                showNotification('Une erreur est survenue', 'error');
            }
        });
    });

    // Carrousel des films similaires
    new Swiper('.movie-carousel', {
        slidesPerView: 'auto',
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            320: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            480: {
                slidesPerView: 3,
                spaceBetween: 15
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 20
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 20
            }
        }
    });

    // Voir plus de casting
    const castButton = document.querySelector('.btn-more-cast');
    if (castButton) {
        castButton.addEventListener('click', async () => {
            try {
                const movieId = window.location.pathname.split('/').pop();
                const response = await fetch(`${BASE_URL}/api/movies/${movieId}/cast`);
                const data = await response.json();
                
                if (data.success) {
                    updateCastGrid(data.cast);
                    castButton.style.display = 'none';
                }
            } catch (error) {
                showNotification('Erreur lors du chargement du casting', 'error');
            }
        });
    }
});

// Fonctions utilitaires
function updateStars(rating, className) {
    document.querySelectorAll('.stars i').forEach((star, index) => {
        star.classList.toggle(className, index < rating);
    });
}

async function submitRating(rating) {
    const movieId = document.querySelector('.stars').dataset.movieId;
    const response = await fetch(`${BASE_URL}/api/movies/rate`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            movie_id: movieId,
            rating: rating
        })
    });
    return await response.json();
}

function updateCastGrid(cast) {
    const castGrid = document.querySelector('.cast-grid');
    const newCastHTML = cast.map(actor => `
        <div class="cast-card">
            <img src="${actor.profile_path ? TMDB_IMG_URL + '/w185' + actor.profile_path : BASE_URL + '/public/img/default-avatar.png'}" 
                 alt="${actor.name}">
            <div class="cast-info">
                <h3>${actor.name}</h3>
                <p>${actor.character}</p>
            </div>
        </div>
    `).join('');
    castGrid.innerHTML = newCastHTML;
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);
    
    setTimeout(() => notification.classList.add('show'), 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
} 