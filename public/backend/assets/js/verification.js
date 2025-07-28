var tz = jstz.determine();
var tzname = tz.name();
$("#timezone").val(tzname);

$(document).ready(function () {
    $('#codeVerificationForm').validate({
        rules: {
            otp_code: {
                required: {
                    depends: function () {
                        $(this).val($(this).val().replace(/\s+/g, " "));
                        return true;
                    }
                },
                number: true,
            }
        },
        messages: {
            otp_code: {
                required: 'Verification code is required',
                number: "Please enter number only",
            },
        }
    });
});

$(document).on('keyup', '#otp_code', function () {
    if ($("#otp_code").val().length == 4) {
        $("#codeVerificationBtn").trigger('click');
    }
});

$(document).on("submit", "#codeVerificationForm", function (e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    let form = $(this);
    if (form.valid()) {
        let btnHtml = $('#codeVerificationBtn').html();
        buttonDisabled('#codeVerificationBtn');
        $.ajax({
            method: 'post',
            url: globalSiteUrl + '/admin/verify-verification-code',
            data: form.serialize(),
            success: function (response) {
                renewToken();
                $('.alert').hide()
                buttonEnabled('#codeVerificationBtn', btnHtml);
                if (response.status === 200) {
                    window.location.href = globalSiteUrl + "/admin/dashboard";
                } else {
                    $('#idAlertErrorMsg').show()
                    $('#idScriptErrorMsg').html(response.message)
                }
            }
        });
    }
    return false;
});

$(document).on('click', '#resendOTP', function () {
    let user_id = $('#user_id').val();
    $.get(globalSiteUrl + '/admin/resend-verification-code', {user_id: user_id}, function (response) {
        $('.alert').hide()
        renewToken();
        if (response.status === 200) {
            $('#otp_code').val('');
            $('#idAlertSuccessMsg').show();
            $('#idScriptSuccessMsg').html(response.message);
        } else {
            $('#idAlertErrorMsg').show()
            $('#idScriptErrorMsg').html(response.message)
        }
    });
})


function renewToken() {
    var csrfUrl = globalSiteUrl + '/admin/refresh_csrf';
    $.get(csrfUrl, function (data) {
        $('meta[name="csrf-token"]').attr('content', data);
    });
    return true;
}
