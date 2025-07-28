@extends('admin.layout.login-app')
@section('content')
    <div class="container login-container d-flex justify-content-center align-items-center py-4">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-6 col-sm-8">
                <div class="text-center">
                    <a href="{{url('/')}}" class="d-inline-block mb-30px">
                        <img src="{{url('/')}}/assets/images/logo.svg" alt="{{env('APP_NAME')}}"/>
                    </a>
                    <h3 class="ff_blod mb-30px">Forgot Password</h3>
                </div>
                @include('admin.errors.message_error_success')
                @include('admin.errors.javascript_message_error_success')
                <form id="resetPasswordForm">
                    @csrf
                    <input type="hidden" name="token" value="{{$token}}">
                    <div class="form-group">
                        <label>New Password</label>
                        <div class="position-relative">
                            <input type="password" name="password" id="new_password"
                                   class="form-control form-control-lg login-input"
                                   placeholder="New Password"/>
                            <i class="fas fa-lock pass_showhide inputIcon" toggle="#new_password"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Re-Enter New Password</label>
                        <div class="position-relative">
                            <input type="password" name="password_confirmation" id="re_password"
                                   class="form-control form-control-lg login-input"
                                   placeholder="Re-Enter New Password"/>
                            <i class="fas fa-lock pass_showhide inputIcon" toggle="#re_password"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg mt-4" id="resetPasswordBtn">Log
                        In<img class="r-btn-arrow" src="{{url('/')}}/assets/images/r-btn-arrow.png" alt="Log In">
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('pagescript')
    <script>

        $.validator.addMethod("special_password", function (value, element) {
            return this.optional(element) || /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[a-zA-Z0-9!@#$%&*]+$/gm.test(value);
        }, "Password must be combination of capital, small, special character and  numeric.");

        $(document).ready(function () {

            $(".pass_showhide").click(function () {
                $(this).toggleClass("fa-lock-open");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            $('#resetPasswordForm').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8,
                        special_password: true,
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 8,
                        special_password: true,
                        equalTo: "#new_password",

                    }
                },
                messages: {
                    password: {
                        required: 'Enter new password.'
                    },
                    password_confirmation: {
                        required: 'Enter confirm password.',
                        equalTo: "The password confirmation does not match."
                    }
                }
            });
        });

        $(document).on('submit', '#resetPasswordForm', function (e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            if ($('#resetPasswordForm').valid()) {
                var form = $(this);
                var btnHtml = $('#resetPasswordBtn').html();
                buttonDisabled('#resetPasswordBtn');
                $.ajax({
                    method: 'POST',
                    url: globalSiteUrl + "/admin/password/update",
                    data: form.serialize(),
                    success: function (response) {
                        buttonEnabled('#resetPasswordBtn', btnHtml);
                        if (response.status === 200) {
                            window.location.href = globalSiteUrl;
                        } else if (response.status === 201) {
                            window.location.href = globalSiteUrl + '/password-reset/success';
                        } else {
                            $('#idAlertSuccessMsg').hide()
                            $('#idAlertErrorMsg').show()
                            $('#idScriptErrorMsg').html(response.message)
                        }
                    }
                });
                return false;
            }
        })
    </script>
@endsection
