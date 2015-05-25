/**
 * Created with JetBrains PhpStorm.
 * User: devolutionary
 * Date: 4/11/15
 * Time: 11:04 AM
 * To change this template use File | Settings | File Templates.
 */




function validateForm(form, rules, messages) {
    jQuery.extend(jQuery.validator.messages, {
        required: "Required field",
        remote: "Please fix this field.",
        email: "Please enter a valid email address",
        url: "Please enter a valid URL",
        date: "Please enter a valid date",
        dateISO: "Please enter a valid date (ISO)",
        number: "Please enter a valid number",
        digits: "Please enter only digits",
        creditcard: "Please enter a valid credit card number",
        equalTo: "Please enter the same value again",
        accept: "Please enter a value with a valid extension",
        maxlength: jQuery.validator.format("Please enter no more than {0} characters"),
        minlength: jQuery.validator.format("Please enter at least {0} characters"),
        rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long"),
        range: jQuery.validator.format("Please enter a value between {0} and {1}"),
        max: jQuery.validator.format("Please enter a value less than or equal to {0}"),
        min: jQuery.validator.format("Please enter a value greater than or equal to {0}")
    });

    form.validate({
        rules: rules,
        messages: messages,
        errorPlacement: function(error, element) {
            error.appendTo(form.find('div.error-response'));
        },
        errorClass: "form-error"
    });

    form.valid();
}

$.validator.addMethod(
    "regex",
    function(value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    },
    "Please check your input."
);

$.validator.addMethod(
    "passwordRequired",
    function(value, element, newpassword) {
        return $("#"+newpassword).val().length == 0 || value.length != 0;

    },
    "Current password required."
);