jQuery(document).ready(function($) {
    $('.flormar-slider').slick({
        infinite: true,
        speed: 300,
        slidesToShow: 4, // 4 товари на десктопі
        slidesToScroll: 1,
        prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button"><i class="slick-custom-arrow-left"></i></button>',
        nextArrow: '<button class="slick-next slick-arrow" aria-label="Next" type="button"><i class="slick-custom-arrow-right"></i></button>',
        responsive: [
            {
                breakpoint: 768, // < 768px => 2 товари
                settings: {
                    slidesToShow: 2
                }
            }
        ]
    });
});
