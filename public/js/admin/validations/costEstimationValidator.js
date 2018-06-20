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
    $(".cost_estimation_form").validate({
        rules: {
            website:{
                required:true,
                remote:{
                    url: '/checkWebsite'
                }
            }
        },
        messages:{
            website:{
                remote:"Record already exist."
            }
        }
    });

});