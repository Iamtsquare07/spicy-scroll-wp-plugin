jQuery(document).ready(function($) {
    $(window).scroll(function() {
        var scrollPercent = 100 * $(window).scrollTop() / ($(document).height() - $(window).height());
        $('#scroll-progress').css('width', scrollPercent + '%');
    });
});
