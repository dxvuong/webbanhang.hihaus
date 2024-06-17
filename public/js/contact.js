$(document).ready(function () {
    // gửi yêu cầu
    $("#form-contact .btn-submit").click(function(){
        var formStatus = $("#form-contact").validate({
            rules: {
                name: "required",
                phone: "required",
            },
            messages:{
                name: "Enter your name.",
                phone: "Enter your phone number.",
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
            var form_data = new FormData($("#form-contact")[0]);
            $.ajax({
                url: "/lien-he/gui",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (result) {
                    popup_load_off();
                    if(result.status == 'true'){
                        $('.contact-error').html(`<p class="text-success">${result.message}</p>`)
                        $('#form-contact').trigger("reset");
                    }else{
                        $('.contact-error').html(`<p style="color: red">${result.message}</p>`)
                    }
                }
            });
        }
    });
});