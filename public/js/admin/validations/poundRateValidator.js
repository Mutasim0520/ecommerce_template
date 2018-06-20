$(document).ready(function () {
    $.validator.setDefaults({
        errorClass: 'help-block',
        highlight:function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight:function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });
    $("#gbp_rate_form").validate({
        rules: {
            min:{
                required:true,
                remote:{
                    url: '/checkGBPlower'
                }
            }
        },
        messages:{
            min:{
                remote:"This limit already exist."
            }
        }
    });

});