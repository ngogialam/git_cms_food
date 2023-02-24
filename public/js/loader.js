jQuery(document).ready(function($) {

    // loader
    var loader = function() {
        setTimeout(function() {
            if ($('#loader').length > 0) {
                $('#loader').removeClass('show');
            }
        }, 1);
    };
    loader();

    $('body').on('click', "button[type='submit']", function() {
        $('#loader').addClass('show');
    });

});