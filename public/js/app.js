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

    jQuery.scrollSpeed = function (step, speed, easing) {

        var $document = $(document),
            $window = $(window),
            $body = $('html, body'),
            option = easing || 'default',
            root = 0,
            scroll = false,
            scrollY,
            scrollX,
            view;

        if (window.navigator.msPointerEnabled) return false;

        $window.on('mousewheel DOMMouseScroll', function (e) {

            var deltaY = e.originalEvent.wheelDeltaY,
                detail = e.originalEvent.detail;
            scrollY = $document.height() > $window.height();
            scrollX = $document.width() > $window.width();
            scroll = true;

            if (scrollY) {

                view = $window.height();

                if (deltaY < 0 || detail > 0) root = root + view >= $document.height() ? root : root += step;

                if (deltaY > 0 || detail < 0) root = root <= 0 ? 0 : root -= step;

                $body.stop().animate({

                    scrollTop: root

                }, speed, option, function () {

                    scroll = false;
                });
            }

            if (scrollX) {

                view = $window.width();

                if (deltaY < 0 || detail > 0) root = root + view >= $document.width() ? root : root += step;

                if (deltaY > 0 || detail < 0) root = root <= 0 ? 0 : root -= step;

                $body.stop().animate({

                    scrollLeft: root

                }, speed, option, function () {

                    scroll = false;
                });
            }

            return false;
        }).on('scroll', function () {

            if (scrollY && !scroll) root = $window.scrollTop();
            if (scrollX && !scroll) root = $window.scrollLeft();
        }).on('resize', function () {

            if (scrollY && !scroll) view = $window.height();
            if (scrollX && !scroll) view = $window.width();
        });
    };

    jQuery.easing.default = function (x, t, b, c, d) {

        return -c * ((t = t / d - 1) * t * t * t - 1) + b;
    };
    jQuery.scrollSpeed(100, 800);

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
