@extends('admin.layout.login-app')
@section('content')
    <div class="container login-container d-flex justify-content-center align-items-center py-4">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-6 col-sm-8">
                <div class="text-center">
                    <a href="{{url('/')}}" class="d-inline-block mb-30px">
                        <img src="{{ url('/') }}/assets/img/logo.svg" alt="{{env('APP_NAME')}}" />
                    </a>
                    <h3 class="ff_blod mb-30px">Forgot Password</h3>
                </div>
                @include('admin.errors.javascript_message_error_success')
                @include('admin.errors.message_error_success')
                <form id="forgotPasswordForm">
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="position-relative">
                            <input type="text" name="email" id="email" class="form-control form-control-lg login-input"
                                   placeholder="Email Address"/>
                            <i class="fas fa-envelope inputIcon"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg mt-4" id="forgotPasswordBtn">Send Reset Password
                        Link<img class="r-btn-arrow" src="{{url('/')}}/backend/assets/images/r-btn-arrow.png" alt="Log In">
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('pagescript')
    <script>
        $(document).ready(function () {
            $('#forgotPasswordForm').validate({
                rules: {
                    email: {
                        required:true,
                        email: true,
                        emailCheck: true
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email.",
                        email: "Please enter a valid email address.",
                        emailCheck: "Please enter a valid email address."
                    }
                }
            });
        });

        $(document).on("submit", "#forgotPasswordForm", function (e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            if ($('#forgotPasswordForm').valid()) {
                let form = $(this);
                let btnHtml = $('#forgotPasswordBtn').html();
                buttonDisabled('#forgotPasswordBtn');
                $.ajax({
                    method: 'POST',
                    url: globalSiteUrl + "/admin/send-password-reset-link",
                    data: form.serialize(),
                    success: function (response) {
                        buttonEnabled('#forgotPasswordBtn', btnHtml);
                        if (response.status === 200) {
                            $('#idAlertErrorMsg').hide()
                            $('#idAlertSuccessMsg').show()
                            $('#idScriptSuccessMsg').html(response.message)
                            $('#email').val('');
                        } else {
                            $('#idAlertSuccessMsg').hide()
                            $('#idAlertErrorMsg').show()
                            $('#idScriptErrorMsg').html(response.message)
                        }
                    }
                });
                return false;
            }
        });
    </script>
@endsection
