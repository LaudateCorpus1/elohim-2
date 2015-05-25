$(document).ready(function () {
    $('#lightbox-userRegister').bindUserRegisterForm();
    $('#userLogin').bindUserLoginForm();
    $('#userEdit').bindUserEditForm();
    $('button.user-logout, a.user-logout').bind('click.logoutUser', function() {
        console.log('click');
        logoutUser();
    });
});

function logoutUser() {
    jQuery.ajax({
        url: '/api/user/logout',
        type: 'GET',
        success: function() {
            window.location = '/';
        },
        error: function() {
            //window.location = '/';
        }
    });
}

$.fn.bindUserLoginForm= function() {
    var form = this.find('form'),
        $username = form.find('input[name="username"]'),
        $password = form.find('input[name="password"]');

    var rules = {
        username: {
            required: true
        },
        password: {
            required: true
        }
    };

    var messages = {
        username: {
            required: 'Please enter your username'
        },
        password: {
            required: 'Please enter your password'
        }
    };

    $('#userLogin-submit').prop('disabled', false);

    $('#userLogin-submit').bind('click.loginUser', function(e) {
        e.preventDefault();

        validateForm(form, rules, messages);

        if (form.valid()) {
            var data = {
                username: $username.val(),
                password: $password.val()
            };

            form.find('.error-response').html('');

            jQuery.ajax({
                url: '/api/user/login',
                data: data,
                type: 'post',
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    if (data.success) {
                        //window.location = window.location;
                    } else {
                        var message = "";

                        switch (data.message) {
                            case 'INVALID_CREDENTIALS':
                                message = 'You have entered an invalid username and/or password.';
                                break;
                            case 'INVALID_PARAMETER_COUNT':
                                message = 'Please ensure your username and password are entered.';
                                break;
                            case 'ACCOUNT_INACTIVE':
                                message = 'This account is currently inactive. Please consult your email to activate your account.';
                                break;
                            case 'ACCOUNT_DISABLED':
                                message = 'This account is currently disabled. Please consult your email to confirm any actions required to enable your account.';
                                break;
                            case 'ACCOUNT_BANNED':
                                message = '<div class="ban_details"><p><strong>Your account has been banned.</strong></p>' +
                                    '<p><em>From:</em>' + convertToDate(data.details.startDate) + '</p>' +
                                    '<p><em>To:</em>' + convertToDate(data.details.endDate) + '</p>' +
                                    '<p><em>Reason:</em>' + data.details.banReason + '</p></div>';
                                break;
                            case 'UNKNOWN_ERROR':
                            default:
                                message = 'An unkown error occured. Please try again. If this issue continues, please contact the site administrator.';
                                break;
                        }

                        popupMessage('Login Failed', '<p>An error occured.</p>' + message);
                    }
                },
                error: function() {

                }
            });
        }
    });
};

$.fn.bindUserEditForm = function () {
    var form = this.find('form'),
        $password = form.find('input[name="password"]'),
        $passwordNew = form.find('input[name="passwordNew"]'),
        $passwordConfirm = form.find('input[name="passwordConfirm"]'),
        $timezone = form.find('select[name="timezone"]'),
        $email = form.find('input[name="email"]'),
        $emailConfirm = form.find('input[name="emailConfirm"]');

    var rules = {
        password: {
            required: true,
            minlength: 8
        },
        passwordNew: {
            minlength: 8
        },
        passwordConfirm: {
            equalTo: "#userEdit-passwordNew"
        },
        email: {
            email: true
        },
        emailConfirm: {
            equalTo: "#userEdit-email"
        }
    };

    var messages = {
        email: {
            email: 'Please enter a valid email address'
        },
        password: {
            required: 'Please enter current password',
            minlength: 'Password must be at least {0} characters in length'
            //passwordRequired: "Current password required"
        },
        passwordNew: {
            minlength: 'Password must be at least {0} characters in length'
        },
        passwordConfirm: {
            equalTo: "Please confirm your password"
        },
        emailConfirm: {
            equalTo: "Please confirm your email address"
        }
    };

    $('#userEdit-submit').prop('disabled', false);

    $('#userEdit-submit').bind('click.editUser', function (e) {
        e.preventDefault();

        validateForm(form, rules, messages);

        if (form.valid()) {
            var data = {
                password: $password.val(),
                passwordNew: $passwordNew.val(),
                passwordConfirm: $passwordConfirm.val(),
                timezone: $timezone.val(),
                email: $email.val(),
                emailConfirm: $emailConfirm.val()
            };

            form.find('.error-response').html('');

            jQuery.ajax({
                url: '/api/user/edit',
                data: data,
                type: 'post',
                dataType: 'JSON',
                success: function(data) {

                }
            })
        }
    });
};

$.fn.bindUserRegisterForm = function () {
    var form = this.find('form'),
        $username = form.find('input[name="username"]'),
        $password = form.find('input[name="password"]'),
        $email = form.find('input[name="email"]');

    form[0].reset();

    var rules = {
        username: {
            required: true,
            minlength: 3,
            regex: "^[a-z0-9 ._-]{3,}$"
        },
        password: {
            required: true,
            minlength: 8
        },
        passwordConfirm: {
            equalTo: "#userRegister-password"
        },
        email: {
            required: true,
            email: true
        },
        emailConfirm: {
            equalTo: "#userRegister-email"
        },
        termsOfUse: "required",
        ageConfirm: "required"
    };

    var messages = {
        username: {
            required: 'Please enter a username',
            minlength: 'Username must be at least {0} characters in length',
            regex: 'Please use only numbers, letters, spaces, periods, dashes, and underscores for your username'
        },
        email: {
            required: 'Please enter your email address',
            email: 'Please enter a valid email address'
        },
        password: {
            required: 'Please enter a password',
            minlength: 'Password must be at least {0} characters in length'
        },
        passwordConfirm: {
           equalTo: "Please confirm your password"
        },
        emailConfirm: {
            equalTo: "Please confirm your email address"
        },
        termsOfUse: {
            "required": "You must agree to the Terms of Use"
        },
        ageConfirm: {
            "required": "You must be at least 18 years old to register"
        }
    };

    validateForm(form, rules, messages);

    $('#userRegister-submit').prop('disabled', false);

    $('#userRegister-submit').bind('click.registerUser', function (e) {
        e.preventDefault();
        if (form.valid()) {
            var data = {
                username: $username.val(),
                password: $password.val(),
                email: $email.val()
            };

            form.find('.error-response').html('');
            form.find('#userRegister-submit').prop('disabled', true);

            jQuery.ajax({
                url: '/api/user/register',
                data: data,
                type: 'post',
                dataType: 'JSON',
                success: function(data) {
                    form.find('#userRegister-submit').prop('disabled', false);
                    if (data.success) {

                    } else {
                        var error;
                        switch(data.message) {
                            case "EMAIL_ADDRESS_IN_USE":
                                error = "The email address you have entered is already in use.";
                                break;
                            case "USERNAME_IN_USE":
                                error = "The username you have entered is already in use.";
                                break;
                            case "INVALID_PARAMETER_COUNT":
                                error = "Your registration form is not complete. Please try again.";
                                break;
                            case "INVALID_USERNAME_CHARACTERS_OR_LENGTH":
                                error = "Your username is invalid.";
                                break;
                            case "INVALID_PASSWORD_LENGTH":
                                error = "Your username is too short. Please make it at least 8 characters.";
                                break;
                            case "INVALID_EMAIL_ADDRESS":
                                error = "Your email address is invalid.";
                                break;
                            case "ERROR_CREATING_USER":
                            default:
                                error = "An unknown error has occurred. Please try again.";
                                break;
                        }
                        form.find('.error-response').html('<div class="ajax-error">' + error + '</div>');
                    }
                },
                error: function() {
                    form.find('#userRegister-submit').prop('disabled', true);
                    form.find('.error-response').html('<div class="ajax-error">An unknown error has occurred. Please try again.</div>');
                }
            });
        }
    });
};


