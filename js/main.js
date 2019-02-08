     $(document).ready(function() {
       $('.toform').click(function(){
        $("html, body").animate({scrollTop: $("form").offset().top-300}, 1000);
        return false;
       });
     });




var slid, options = {
    wap: {
        mode: 'horizontal',
        minSlides: 1,
        maxSlides: 1,
        adaptiveHeight: false,
        touchEnabled: true,
        infiniteLoop: true,
        controls: true,
        pager: false,
        slideMargin: 0,
        auto: true,
        slideWidth: 238
    },
    web: {
        mode: 'horizontal',
        minSlides: 3,
        maxSlides: 3,
        adaptiveHeight: true,
        touchEnabled: true,
        infiniteLoop: true,
        controls: true,
        pager: true,
        slideMargin: 30,
        auto: true,
        slideWidth: 300
    }
};

$(document).ready(function () {
    $('.timer').each(function () {
        var clock;
        clock = $(this).FlipClock({autoStart: false});
        clock.setTime(3600);
        clock.setCountdown(true);
        clock.start();
    });
})

function slider(width) {
    if (width < 992) {
        $('.section__6 .wrapper ul li').css({
            'margin-bottom' : '0px'
        });
        slid.reloadSlider(options.wap);
    } else {
               $('.section__6 .wrapper ul li').css({
            'margin-bottom' : '0px'
        });
        slid.reloadSlider(options.web);
    }
};
$(window).load(function () {
    slid = $('.bxslider').bxSlider();
});
$(window).load(function () {
    slider(window.innerWidth);
});
$(window).resize(function () {
    slider(window.innerWidth);
});
