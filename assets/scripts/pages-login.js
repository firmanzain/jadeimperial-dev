/**
 * @author Batch Themes Ltd.
 */
(function() {
    'use strict';

    $(function() {

        var config = $.localStorage.get('config');
        //$('body').attr('data-layout', config.layout);
        $('body').attr('data-palette', config.theme);

        var bg = '<div class="fullsize fullsize-medium"><img src="/assets/backgrounds/bg845.png" /></div>';
        $('.fullsize').remove();
        $('body').prepend(bg);

        var email = $('.login-page #email');
        email.floatingLabels({
            errorBlock: 'Masukkan username yang valid'
        });

        var password = $('.login-page #password');
        password.floatingLabels({
            errorBlock: 'Masukkan password yang valid',
            minLength: 4
        });
    });

})();
