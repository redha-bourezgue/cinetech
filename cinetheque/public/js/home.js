document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du slider héro
    const heroSlider = new Swiper('.hero-slider', {
        slidesPerView: 1,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        pagination: {
            el: '.hero-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.hero-next',
            prevEl: '.hero-prev',
        }
    });

    // Initialisation des carrousels de films
    const movieCarousels = document.querySelectorAll('.movie-carousel');
    movieCarousels.forEach(carousel => {
        new Swiper(carousel, {
            slidesPerView: 'auto',
            spaceBetween: 20,
            navigation: {
                nextEl: carousel.querySelector('.carousel-next'),
                prevEl: carousel.querySelector('.carousel-prev'),
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
    });

    // Animation au scroll
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observer les sections
    document.querySelectorAll('.movie-section, .news-section').forEach(section => {
        observer.observe(section);
    });

    // Lazy loading des images
    const lazyImages = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });

    lazyImages.forEach(img => imageObserver.observe(img));
});

// Gestion des favoris et de la watchlist
document.querySelectorAll('.add-watchlist, .favorite-btn').forEach(button => {
    button.addEventListener('click', async function(e) {
        e.preventDefault();
        const movieId = this.dataset.id;
        const action = this.classList.contains('add-watchlist') ? 'watchlist' : 'favorite';
        
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
                showNotification(
                    action === 'watchlist' 
                        ? 'Film ajouté à votre watchlist' 
                        : 'Film ajouté à vos favoris',
                    'success'
                );
            }
        } catch (error) {
            showNotification('Une erreur est survenue', 'error');
        }
    });
});

// Fonction de notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
} 