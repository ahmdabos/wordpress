(function( $ ) {
    'use strict';
    jQuery( document ).ready(function() {
        var messages = {
            form_name: 'Please enter your name',
            form_email: {
                required: "Please provide an email address",
                email: "Please enter valid email address"
            },
            form_subject: "Please enter your subject",
            form_message: "Please enter your message",
            form_captcha:"Please enter captcha"
        };

        jQuery("#form").validate({
            rules: {
                form_name: "required",
                form_email: {
                    required: true,
                    email: true
                },
                form_subject: "required",
                form_message: "required",
                form_captcha: "required",
            },
            messages
        });
    });

})( jQuery );