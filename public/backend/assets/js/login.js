$(document).ready(function () {
    $(".pass_showhide").click(function () {
        $(this).toggleClass("fa-eye-slash fa-eye");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $('#loginForm').validate({
        rules: {
            email: {
                required: true,
                email: true,
                emailCheck: true
            },
            password: {required: true}
        },
        messages: {
            email: {
                required: "Please enter email.",
                email: "Please enter a valid email address.",
                emailCheck: "Please enter a valid email address."
            },
            password: {
                required: "Please enter password."
            }
        }
    });
});



$(document).on('submit', '#loginForm', function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    let form = $(this);

    let btnHtml = $('#loginBtn').html();

    console.log($('meta[name="csrf-token"]').attr('content'));
    if (form.valid()) {
        buttonDisabled('#loginBtn');
        $.ajax({
            method: 'POST',
            url: globalSiteUrl + "/admin/login/authenticate",
            data: form.serialize() + '&_token=' + $('meta[name="csrf-token"]').attr('content'),                        success: function (response) {
                buttonEnabled('#loginBtn', btnHtml);
                if (response.status === 200){
                    // return response;
              
               
                    if(response.message.segment != null){
                     
                  
                        window.location.href = globalSiteUrl + "/admin/"+response.message.segment;
                        return;
                    }
                  
                    window.location.href = globalSiteUrl + "/admin/dashboard";
                }else {
                    $('#idAlertErrorMsg').show()
                    $('#idScriptErrorMsg').html(response.message)
                }
            }
        });
    }
});
