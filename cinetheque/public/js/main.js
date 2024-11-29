document.addEventListener('DOMContentLoaded', function() {
    // Gestion des clics sur les films
    const movieCards = document.querySelectorAll('.movie-card');
    movieCards.forEach(card => {
        card.addEventListener('click', function() {
            const movieId = this.dataset.movieId;
            if (movieId) {
                window.location.href = `${BASE_URL}/movie/details/${movieId}`;
            }
        });
    });

    // Amélioration de la barre de recherche
    const searchInput = document.querySelector('.search-form input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            // Vous pouvez ajouter ici une recherche en temps réel si vous le souhaitez
        });
    }
}); 