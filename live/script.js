// script.js
document.getElementById('open-menu').addEventListener('click', function() {
    document.getElementById('side-menu').classList.add('open');
});

document.getElementById('close-menu').addEventListener('click', function() {
    document.getElementById('side-menu').classList.remove('open');
});

// Fonction pour enregistrer un clic via une requête POST à clics.php
function registerClick(event, liveId, liveTitle) {
    event.preventDefault();  // Empêcher la redirection immédiate

    // Créer un objet FormData pour envoyer les données
    var formData = new FormData();
    formData.append('live_id', liveId);
    formData.append('live_name', liveTitle);

    // Envoyer une requête POST à clics.php
    fetch('clics.php', {
        method: 'POST',
        body: formData
    }).then(function(response) {
        // Une fois le clic enregistré, rediriger vers la page du live
        window.location.href = 'live.php?id=' + liveId;
    }).catch(function(error) {
        console.error('Erreur lors de l\'enregistrement du clic:', error);
        // Rediriger malgré l'erreur
        window.location.href = 'live.php?id=' + liveId;
    });
}
