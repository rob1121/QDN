'use strict';

$(function () {
    //NAV ACTIVE MENU---------------------------------------------------------
    $('.navbar li a[href="' + location.pathname + '"]').addClass('active');
    //nav dropdown style--------------------------------------
    $(".dropdown").on('mouseover', function () {
        $(this).addClass('open');
        $(this).children('a.dropdown-toggle').attr('aria-expanded', 'true');
    });
    $(".dropdown").on('mouseout', function () {
        $(this).removeClass('open');
        $(this).children('a.dropdown-toggle').attr('aria-expanded', 'false');
    });
    //waypoint nav-------------------------------------------
    var sticky = new Waypoint.Sticky({
        element: $('.navbar')[0],
        handler: function handler(direction) {

            if ($('.navbar').hasClass('stuck')) {

                $('.navbar').addClass('navbar-fixed-top');
                $('.navbar.stuck .container').removeClass('padder', 100);
            } else {

                $('.navbar').removeClass('navbar-fixed-top');
                $('.navbar').find('.container').addClass('padder', 100);
            }
        },
        offset: -1
    });
});
//smooth scrolling--------------------------------------------------------------------------------------------------
(function ($) {

    // tooltip js------------------------------------------------------------------------------------------------------
    $('[data-toggle="tooltip"]').tooltip();
    $(window).scroll(function () {
        var top = $('#toTop');
        if ($(this).scrollTop() != 0) {
            top.fadeIn();
        } else {
            top.fadeOut();
        }
    });

    // backto top js----------------------------------------------------------------------------------------------------
    $('#toTop').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
})(jQuery);
//# sourceMappingURL=app.js.map
