//Carousel Animation

document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('carousel');
    let items = Array.from(carousel.getElementsByClassName('carousel-img-container')); // Converti directement en array
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');

    // Marquez le premier élément comme sélectionné par défaut si aucun n'est sélectionné
    if (!carousel.querySelector('.selected')) {
        items[0].classList.add('selected');
    }

    // Fonction pour mettre à jour les positions du carousel
    function updateCarouselPositions() {
        const selected = carousel.querySelector('.selected');
        const selectedIndex = items.indexOf(selected);

        // Pour chaque élément du tableau 'items', applique des classes CSS en fonction de sa position par rapport à l'élément sélectionné
        items.forEach((item, index) => {
            item.classList.remove('selected', 'prev', 'next', 'hideLeft', 'hideRight', 'prevLeftSecond', 'nextRightSecond');
            
            if (index === selectedIndex) {
                item.classList.add('selected');
            } else if (index === selectedIndex - 1 || index === selectedIndex + items.length - 1) {
                item.classList.add('prev');
            } else if (index === selectedIndex + 1 || index === selectedIndex - items.length + 1) {
                item.classList.add('next');
            } else if (index === selectedIndex - 2 || index === selectedIndex + items.length - 2) {
                item.classList.add('prevLeftSecond');
            } else if (index === selectedIndex + 2 || index === selectedIndex - items.length + 2) {
                item.classList.add('nextRightSecond');
            } else if (index < selectedIndex) {
                item.classList.add('hideLeft');
            } else {
                item.classList.add('hideRight');
            }
        });
    }

    // Écouteur d'événement pour le bouton précédent
    prevButton.addEventListener('click', () => {
        const selectedIndex = items.indexOf(carousel.querySelector('.selected'));
        const prevIndex = (selectedIndex - 1 + items.length) % items.length; 
        items[selectedIndex].classList.remove('selected');
        items[prevIndex].classList.add('selected');
        updateCarouselPositions();
    });

    // Écouteur d'événement pour le bouton suivant
    nextButton.addEventListener('click', () => {
        const selectedIndex = items.indexOf(carousel.querySelector('.selected'));
        const nextIndex = (selectedIndex + 1) % items.length; 
        items[selectedIndex].classList.remove('selected');
        items[nextIndex].classList.add('selected');
        updateCarouselPositions();
    });

    // Initialisation des positions
    updateCarouselPositions();

    //Menu Burger

    // Ajouter l'écouteur d'événements au bouton du menu burger
    document.addEventListener('click', function(e) {
    let links = document.querySelector('.navLinks');
    let burgerMenuButton = document.querySelector('.burger-menu');

    // Vérifie si le clic n'était ni sur le burger-menu ni sur un descendant de navLinks
    if (!burgerMenuButton.contains(e.target) && !links.contains(e.target)) {
        // Si navLinks est actif, le désactiver et afficher le burger-menu
        if (links.classList.contains('active')) {
            links.classList.remove('active');
            burgerMenuButton.style.display = 'block';
        }
    }
    });

    //Bouton de dons cliquable
    let donsButton = document.querySelector('.donButton');
    donsButton.addEventListener('click', function() {
        window.location.href = '/dons'; 
    });

})


// Menu Burger

function toggleMenu() {
    let links = document.querySelector('.navLinks');
    links.classList.toggle('active');
    // Ajuste la visibilité du bouton burger en fonction de l'état du menu
    document.querySelector('.burger-menu').style.display = links.classList.contains('active') ? 'none' : 'block';
    };

    //Toggle Aside
    document.addEventListener('click', function(e) {
    // Ajouter l'écouteur d'événements au bouton aside
        let asideToggleButton = document.querySelector('.aside-toggle');
        if (asideToggleButton) {
            asideToggleButton.addEventListener('touchstart', toggleAside);
            asideToggleButton.addEventListener('click', toggleAside); // Pour la compatibilité avec le clic
        }
    });

    
// Aside cliquable

function toggleAside() {

    let aside = document.querySelector('.aside');

    if (aside.style.display === "block") {
        aside.style.display = "none";
    } else {
        aside.style.display = "block";
    }
}



