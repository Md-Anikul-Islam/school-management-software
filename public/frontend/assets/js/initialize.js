$('.banner-carousel').owlCarousel({
    nav: false,
    dots: true,
    loop: true,
    autoplay: true,
    autoplayHoverPause: true,
    smartSpeed: 1000,
    autoplayTimeout: 6000,
    responsive:{
        0:{ items: 1 }
    }
});

$('.teacher-carousel').owlCarousel({
    loop: true,
    nav: true,
    dots: false,
    autoplay: true,
    autoplayHoverPause: true,
    margin:  30,
    smartSpeed: 1000,
    autoplayTimeout: 6000,
    navText:['<i class="lni lni-arrow-left"></i>', '<i class="lni lni-arrow-right"></i>'],
    responsive:{
        0:{
            items:1,
            nav:false,
            autoWidth:true,
        },
        576:{
            items:2,
        },
        992:{
            items:4,
        }
    }
});


$('.event-carousel').owlCarousel({
    margin:  30,
    smartSpeed: 1000,
    dots: false,
    responsive:{
        0:{
            autoWidth:true,
        },
        992:{
            items:3,
        }
    }
});


$('.recent-carousel').owlCarousel({
    nav: true,
    dots: false,
    autoplay: true,
    autoplayHoverPause: true,
    margin: 30,
    smartSpeed: 1000,
    autoplayTimeout: 6000,
    navText:['<i class="lni lni-arrow-left"></i>', '<i class="lni lni-arrow-right"></i>'],
    responsive:{
        0:{
            nav:false,
            autoWidth:true,
        },
        768:{
            items:2,
        },
        992:{
            items:3,
        }
    }
});