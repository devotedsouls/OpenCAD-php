/* .validate - Jquery Validation PLugin - More examples and documentation at https://github.com/jzaefferer/jquery-validation */
  
var FormsValidation = function () {

    return {
        init: function () {

            /* Configurations.php Form Validations */
            $('#configurations-form-validation').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function (error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function (e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function (e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); // e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    sitename: {
                        required: true,
                        maxlength: 40
                    },
                    sitedesc: {
                        required: true,
                        maxlength: 60
                    },
                    emailfromname: {
                        required: true,
                        maxlength: 60
                    },
                    adminemail: {
                        required: true,
                        email: true,
                        maxlength: 254
                    },
                    webroot: {
                        required: true
                    },
                    home_page: {
                        required: true
                    },
                    login_page: {
                        required: true
                    },
                    date_format: {
                        required: true
                    }
                },
                messages: {
                    adminemail: 'Please type an e-mail address!'
                }
            });

           
        }
    };
}();