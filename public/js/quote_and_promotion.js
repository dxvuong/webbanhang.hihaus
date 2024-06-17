$(document).ready(function () {
    // gửi yêu cầu
    $("#form-quote-and-promotion .btn-submit").click(function(){
        var formStatus = $("#form-quote-and-promotion").validate({
            rules: {
                phone: "required",
                name: "required",
            },
            messages:{
                phone: "Enter your phone number.",
                name: "Enter your name.",
            },
            onfocusout: false,
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    validator.errorList[0].element.focus();
                }
            }
        }).form();
        if(true == formStatus){
            popup_load_on();
            var form_data = new FormData($("#form-quote-and-promotion")[0]);
            $.ajax({
                url: "/bao-gia/gui",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (result) {
                    popup_load_off();
                    if(result.status == 'true'){
                        $('.contact-error').html(`<p class="text-success">${result.message}</p>`)
                        $('#form-quote-and-promotion').trigger("reset");
                    }else{
                        $('.contact-error').html(`<p style="color: red">${result.message}</p>`)
                    }
                }
            });
        }
    });

    //modal
    $("#form-quote-and-promotion-modal .btn-submit").click(function(){
        var formStatus = $("#form-quote-and-promotion-modal").validate({
            rules: {
                phone: "required",
                name: "required",
            },
            messages:{
                phone: "Enter your phone number.",
                name: "Enter your name.",
            },
            onfocusout: false,
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    validator.errorList[0].element.focus();
                }
            }
        }).form();
        if(true == formStatus){
            popup_load_on();
            var form_data = new FormData($("#form-quote-and-promotion-modal")[0]);
            $.ajax({
                url: "/bao-gia/gui",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (result) {
                    popup_load_off();
                    if(result.status == 'true'){
                        $('.quote-and-promotion-error').html(`<p class="text-success">${result.message}</p>`)
                        $('#form-quote-and-promotion-modal').trigger("reset");
                    }else{
                        $('.quote-and-promotion-error').html(`<p style="color: red">${result.message}</p>`)
                    }
                }
            });
        }
    });
});