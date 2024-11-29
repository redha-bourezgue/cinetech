document.addEventListener('DOMContentLoaded', function() {
    // Gestion des onglets
    const tabs = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Retirer la classe active de tous les onglets
            tabs.forEach(t => t.classList.remove('active'));
            tabPanes.forEach(p => p.classList.remove('active'));

            // Ajouter la classe active à l'onglet cliqué
            tab.classList.add('active');
            
            // Afficher le contenu correspondant
            const tabId = tab.dataset.tab;
            document.getElementById(tabId).classList.add('active');

            // Sauvegarder l'onglet actif dans localStorage
            localStorage.setItem('activeProfileTab', tabId);
        });
    });

    // Restaurer l'onglet actif au chargement
    const activeTab = localStorage.getItem('activeProfileTab');
    if (activeTab) {
        const tab = document.querySelector(`[data-tab="${activeTab}"]`);
        if (tab) tab.click();
    }

    // Prévisualisation de l'avatar
    const avatarInput = document.querySelector('input[name="avatar"]');
    const avatarPreview = document.querySelector('.profile-avatar img');

    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
}); 