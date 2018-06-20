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
    $("#create-admin").validate({
        rules: {
            email:{
                required:true,
                remote:{
                    url: '/checkEmail'
                }
            },
            password:{
                required:true,
                minlength:6
            },
            password_confirmation:{
                required:true,
                minlength:6,
                equalTo:"#password"
            }
        },
        messages:{
            email:{
                remote:"email already exist."
            },
            password:{

            },
            password_confirmation:{
                equalTo:"password did not match",
            }

        }
    });

});