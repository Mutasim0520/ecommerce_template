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
    $(".category_form").validate({
        rules: {
            catagory_name:{
                required:true,
                remote:{
                    url: '/checkCategory'
                }
            }
        },
        messages:{
            catagory_name:{
                remote:"Category already exist."
            }
        }
    });

});