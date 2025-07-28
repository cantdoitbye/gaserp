
<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Page') | Admin Panel</title>
    @include('admin.layout.css')
    <?php
    $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName();
  
    $routeArray = ['admin.profile', 'admin.password.change', 'admin.profile.edit'];

    ?>

    <style>

         body{
            font-family: "Poppins";
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <?php

$lister_request_count = \App\Models\User::count();
$lister_count = \App\Models\User::count();
$customer_count = \App\Models\User::count();
$admin = \Auth::guard('admin')->user();



?>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary d-lg-none">
    <a href="{{url('admin/dashboard')}}" class="navbar-brand">
        <img src="{{url('/')}}/uploads/ alt="{{env('APP_NAME')}}" style="color:#fff;"/>
    </a>

    <!-- Sidebar Toggle-->
    <div class="nav-icon-btn ml-auto" id="sidebarToggle">
        <span></span><span></span><span></span><span></span>
    </div>
    {{-- <button class="btn btn-link btn-sm ml-auto order-1 order-lg-0" id="sidebarToggle" href="#"><i
            class="fas fa-bars"></i></button> --}}
</nav>
<div id="layoutSidenav">
    @include('admin.layout.left-sidebar')
    <div id="layoutSidenav_content">
        <main>
            @yield('content')
        </main>
    @include('admin.layout.footer')
    <!-- Small modal -->
    </div>
    @include('admin.layout.modals')
</div>
<div id="pageLoader">
    <div class="cv-spinner">
        <span class="lg-spinner"></span>
    </div>
</div>
<style>
    #pageLoader{
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height:100%;
        display: none;
        background: rgba(0,0,0,0.6);
    }
    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .lg-spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }
    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }
    .select2-result-repository__avatar img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 2px;
    }
    .select2-result-repository__avatar {
        float: left;
        width: 50px;
        margin-right: 10px;
    }
    .left-side-heading{
        font-size:18px;
        font-weight:400px;
        padding-left:12px;
        padding-top:27px;

    }
</style>

@include('admin.layout.script')
</body>
</html>
