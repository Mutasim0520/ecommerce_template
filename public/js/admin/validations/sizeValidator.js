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
    $("#sizeForm").validate({
        rules: {
            size:{
                required:true,
                remote:{
                    url: '/checkSize'
                }
            }
        },
        messages:{
            size:{
                remote:"size already exist."
            }
        }
    });

});