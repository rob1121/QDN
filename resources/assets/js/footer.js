//smooth scrolling--------------------------------------------------------------------------------------------------
( function($) {


// tooltip js------------------------------------------------------------------------------------------------------
$('[data-toggle="tooltip"]').tooltip();
$(window).scroll(function() {
    var top = $('#toTop');
    if ($(this).scrollTop() != 0) {
        top.fadeIn();
    } else {
        top.fadeOut();
    }
});

// backto top js----------------------------------------------------------------------------------------------------
$('#toTop').click(function() {
    $("html, body").animate({
        scrollTop: 0
    }, 600);
    return false;
});
} )(jQuery);


