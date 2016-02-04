document.createElement('header');
document.createElement('nav');
document.createElement('aside');
document.createElement('section');
document.createElement('footer');

jQuery(window).scroll(function () {
    if (jQuery(window).scrollTop() == 0) {
        jQuery('#scrollToTop').fadeOut("fast");
    } else {
        if (jQuery('#scrollToTop').length == 0) {
            jQuery('body').append('<div id="scrollToTop">' +
                '<a href="#">Retour en haut</a>' +
                '</div>');
        }
        jQuery('#scrollToTop a').fadeIn("fast");
    }
});

$(document).ready(function () {



    anti_ie7();



    $("#owl-slider").owlCarousel({

        navigation: true,
        pagination: true,
        responsive: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true,
        navigationText: ["&lt;", "&gt;"],
        transitionStyle: false, // Effets disponibles : "fade", "backSlider", "goDown", "fadeUp"
        autoPlay: 3000,
        stopOnHover: true
    });

    jQuery('#scrollToTop a').live('click', function (event) {
        event.preventDefault();
        jQuery('html,body').animate({
            scrollTop: 0
        }, 'slow');
        return false;
    });
});