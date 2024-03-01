// Attend que le contenu DOM de la page soit complètement chargé avant d'exécuter le script.
document.addEventListener('DOMContentLoaded', function () {
    // Récupère le montant du don depuis le session storage 
    const montantDon = sessionStorage.getItem('montantDon');
    
    // Sélectionne l'élément HTML qui contient les données-clés de Stripe.
    const stripeDataElement = document.getElementById('stripe-data');
    
    // Extrait la clé publique de Stripe et le secret client depuis les attributs de l'élément.
    const stripePublicKey = stripeDataElement.getAttribute('data-stripe-key');
    const clientSecret = stripeDataElement.getAttribute('data-client-secret');

    // Initialise Stripe avec la clé publique fournie.
    const stripe = Stripe(stripePublicKey);
    
    // Crée une instance de Stripe Elements, une collection d'éléments d'interface utilisateur pour le formulaire de paiement.
    const elements = stripe.elements();
    
    // Crée un élément de carte personnalisé avec des styles spécifiques.
    const card = elements.create('card', {
        style: {
            base: {
                color: '#fff',
                fontWeight: '500',
                fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
                fontSize: '16px',
                fontSmoothing: 'antialiased',
                ':-webkit-autofill': { color: '#fce883' },
                '::placeholder': { color: '#87BBFD' },
            },
            invalid: {
                iconColor: '#FFC7EE',
                color: '#FFC7EE',
            },
        },
    });
    
    // Montage de l'élément de carte dans le conteneur HTML avec l'ID 'card-element'.
    card.mount('#card-element');

    // Écoute les changements sur l'élément de carte pour afficher les erreurs de validation de carte.
    card.addEventListener('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Gestion du clic sur le bouton de soumission du paiement.
    const paymentButton = document.getElementById('submit-payment');
    if (paymentButton) { // Vérifie si le bouton de paiement existe.
        paymentButton.addEventListener('click', function(event) {
            event.preventDefault(); // Empêche la soumission classique du formulaire.

            // Lance le processus de paiement avec Stripe.
            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    // Ici, on pourrait ajouter des détails de facturation supplémentaires si nécessaire.
                }
            }).then(function(result) {
                if (result.error) {
                    // Affiche les erreurs de paiement à l'utilisateur.
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Gère le succès du paiement, par exemple en redirigeant l'utilisateur vers une page de confirmation.
                    if (result.paymentIntent.status === 'succeeded') {
                        console.log('Paiement réussi !');
                        window.location.href = '/dons/succes';
                    }
                }
            });
        });
    }
});
