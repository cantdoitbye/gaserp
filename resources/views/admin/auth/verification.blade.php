@extends('admin.layout.login-app')
@section('content')
    <div class="container login-container d-flex justify-content-center align-items-center py-4">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-6 col-sm-8">
                <div class="text-center">
                    <a href="{{url('/')}}" class="d-inline-block mb-30px">
                        <img src="{{ url('/') }}/assets/img/logo.svg" alt="{{env('APP_NAME')}}" />
                    </a>
                    <h3 class="ff_blod mb-30px">Verify Your Account</h3>
                </div>
                @include('admin.errors.javascript_message_error_success')
                @include('admin.errors.message_error_success')
                <form id="codeVerificationForm">
                    @csrf
                    <input type="hidden" name="timezone" id="timezone">
                    <div class="form-group">
                        <label>Verification Code</label>
                        <div class="position-relative">
                            <input type="text" name="otp_code" id="otp_code"
                                   class="form-control form-control-lg login-input"
                                   placeholder="Enter Verification Code"/>
                            <i class="fas fa-envelope inputIcon"></i>
                        </div>
                    </div>
                    <div class="r-link-grp">
                        <div class="form-group text-left">
                            <a href="javascript:;" id="resendOTP" class="ff_book text-underline">Resend verification code</a>
                        </div>
                        <div class="form-group text-right">
                            <a href="{{url('/admin')}}" class="ff_book text-underline">Login?</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg mt-4" id="codeVerificationBtn">Verify<img
                            class="r-btn-arrow" src="{{url('/')}}/backend/assets/images/r-btn-arrow.png" alt="Log In"></button>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="user_id" value="{{$user_id}}">
@endsection
@section('pagescript')
    <script src="{{ asset('backend/assets/js/jstz.min.js') }}?v={{ version() }}" type="text/javascript"></script>
    <script src="{{ asset('backend/assets/js/verification.js') }}?v={{ version() }}" type="text/javascript"></script>
@endsection
