// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    // Sélection de du calendrier via l'ID
    let calendarElt = document.querySelector("#calendar");
    // Récupération des données des événements stockées dans l'attribut 'data-events' 
    // et conversion de ces données JSON en objet JavaScript.
    let eventsData = JSON.parse(calendarElt.getAttribute('data-events'));

    // Initialisation de l'instance FullCalendar avec l'élément sélectionné et un objet de configuration.
    let calendar = new FullCalendar.Calendar(calendarElt, {
        // Définition du calendrier en tant que vue mensuelle.
        initialView: 'dayGridMonth',
        // Paramétrage de la localisation du calendrier en français.
        locale: 'fr',
        // Configuration de la barre d'outils du calendrier
        headerToolbar: {
            start: 'dayGridMonth,timeGridWeek', // Boutons pour changer entre la vue mensuelle et la vue hebdomadaire.
            center: 'title', // Position du titre au centre.
            end: 'prev,next today' // Boutons pour naviguer entre les mois et revenir au mois courant.
        },
        // Génération des événements du calendrier en mappant les données JSON récupérées,
        // et transformation de chaque événement en un format compatible avec FullCalendar.
        events: eventsData.map(function(event) {
            // Retour d'un objet représentant un événement avec des propriétés personnalisées.
            return {
                id: event.id, 
                title: event.titre_calendrier, 
                start: event.debut_calendrier, 
                end: event.fin_calendrier || event.debut_calendrier, 
                description: event.description_calendrier, 
                backgroundColor: event.couleur_fond_calendrier, 
                borderColor: event.couleur_bordure_calendrier, 
                textColor: event.couleur_texte_calendrier, 
                placesDisponibles: event.places_disponibles_calendrier,
            };
        }),
        eventClick: function(info) {
            const startTime = info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const endTime = info.event.end ? info.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : 'Non spécifié';

            // Définir le contenu du modal
            const modalBody = `
                <p><strong>Débute à</strong> ${startTime} heures</p>
                <p><strong>Termine à</strong> ${endTime} heures</p>
                <p><strong>Description:</strong> ${info.event.extendedProps.description}</p>
                <p><strong>Places disponibles:</strong> ${info.event.extendedProps.placesDisponibles}</p>`
                ;

            document.querySelector('#eventDetailsModal .modal-header').innerHTML = `
            <h5 class="modal-title">${info.event.title}</h5>`
            ;
            

            // Insérer le contenu dans le modal
            document.querySelector('#eventDetailsModal .modal-body').innerHTML = modalBody;

            // Afficher le modal
            const eventDetailsModal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
            
            eventDetailsModal.show();


            // Obtenir le bouton "Réserver" et ajouter un gestionnaire de clic
            const btnReserver = document.getElementById('btnReserver');
            btnReserver.onclick = function() {
                // Rediriger l'utilisateur vers la page de formulaire de réservation
                // avec l'ID de l'événement en tant que paramètre d'URL
                window.location.href = `/formulaires/evenementiel/new?eventId=${info.event.id}`;
            };
        },
        // ... vos autres options ...
    });
    
    calendar.render();
});

