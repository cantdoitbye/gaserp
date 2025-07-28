@extends('admin.layout.login-app')
@section('content')
@push('pagecss')
<style>
    .signinBtn {
        border-radius: 5px;
        background-color: #e31e24 !important; /* Red color for button */
        border-color: #e31e24 !important;
        width: 100%;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .signinBtn:hover {
        background-color: #c51a1f !important; /* Slightly darker red on hover */
        border-color: #c51a1f !important;
    }
    
    .login-container {
        min-height: 100vh;
    }
    
    .company-logo {
        width: 150px;
        height: auto;
        margin-bottom: 20px;
    }
    
    .loginTxt {
        color: #555;
        font-size: 16px;
    }
    
    .form-control-lg.login-input {
        height: calc(1.5em + 1rem + 8px);
        border-radius: 5px;
        border: 1px solid #ddd;
    }
    
    .form-control-lg.login-input:focus {
        border-color: #e31e24;
        box-shadow: 0 0 0 0.2rem rgba(227, 30, 36, 0.25);
    }
    
    .pass_showhide {
        cursor: pointer;
    }
    
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: none;
    }
    
    label {
        font-weight: 500;
        color: #333;
    }


</style>

@endpush



    <div class="container login-container d-flex justify-content-center align-items-center py-4">
        <div class="row justify-content-center w-100">
            <div class="col-lg-6 col-md-6 col-sm-8">
                <div class="card">
                    <div class="card-body">
                <div class="text-center">
                    <a href="{{url('/')}}" class="d-inline-block mb-30px">
                        <img src="{{ url('/') }}/panel/logo.jpeg" alt="{{env('APP_NAME')}}" class="company-logo" style="  width: 300px;"/>
                    </a>
                    <p class=" mb-30px loginTxt">Please fill in your unique admin login details below</p>
                </div>
               
                @include('admin.errors.javascript_message_error_success')
                @include('admin.errors.message_error_success')
                <form id="loginForm" >
                    @csrf
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="position-relative">
                            <input type="text" name="email" class="form-control form-control-lg login-input"
                                   placeholder="Email Address"/>
                            {{-- <i class="fas fa-envelope inputIcon"></i> --}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="position-relative">

                            <input type="password" name="password" id="password" class="form-control form-control-lg login-input"
                                   placeholder="Password"/>
                            <i class="fas fa-eye-slash pass_showhide inputIcon" toggle="#password"></i>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <a href="{{url('admin/forgot-password')}}" class="loginTxt">Forgot your password?</a>
                    </div>
                    <div class="position-relative">
                    <button type="submit" class="btn btn-primary signinBtn " id="loginBtn" style="background-color: #e31e24 !important; width: 100%; border-radius: 5px;
                    ">Sign In
                        {{-- <img class="r-btn-arrow" src="{{url('/')}}/backend/assets/images/r-btn-arrow.png" alt="Log In"> --}}
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
@section('pagescript')
    <script src="{{ asset('backend/assets/js/login.js') }}" type="text/javascript"></script>
@endsection
