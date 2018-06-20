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
    $("#new-section").validate({
        rules: {
            showcase_name:{
                required:true,
                remote:{
                    url: '/checkShowcase'
                }
            }
        },
        messages:{
            showcase_name:{
                remote:"showcase already exist."
            }
        }
    });

});