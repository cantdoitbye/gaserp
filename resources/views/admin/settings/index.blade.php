@extends('admin.layout.admin-app')
@section('title', 'Settings')

@section('content')
<div class="container-fluid">
    <div class="px-4 py-4">
        <div class="d-sm-flex justify-content-between mb-3 mc-flex">
            <h2 class="page-title"> Settings </h2>
        </div>
        <form action="{{ route('admin.settings.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Logo Upload -->
            <div class="form-group">
                <label for="logo">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control">
                @if(isset($settings->logo))
                    <img src="{{ asset('storage/app/public/' . $settings->logo) }}" alt="Logo" width="100">
                @endif
            </div>

            <!-- Contact Details -->
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone Number" value="{{ old('phone', $settings->phone ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Whatsapp Number</label>
                <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control" placeholder="Enter Whatsapp Number" value="{{ old('whatsapp_number', $settings->whatsapp_number ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ old('email', $settings->email ?? '') }}" required>
            </div>

            <!-- Social Media Handles -->
            <div class="form-group">
                <label for="facebook">Facebook</label>
                <input type="text" name="facebook" id="facebook" class="form-control" value="{{ old('facebook', $settings->facebook ?? '') }}" placeholder="Enter Facebook Handle">
            </div>

            <div class="form-group">
                <label for="twitter">Twitter</label>
                <input type="text" name="twitter" id="twitter" class="form-control" value="{{ old('twitter', $settings->twitter ?? '') }}" placeholder="Enter Twitter Handle">
            </div>

            <div class="form-group">
                <label for="instagram">Instagram</label>
                <input type="text" name="instagram" id="instagram" class="form-control" value="{{ old('instagram', $settings->instagram ?? '') }}" placeholder="Enter Instagram Handle">
            </div>

            <!-- Background Image for Hero Section -->
            <div class="form-group">
                <label for="hero_background">Hero Section Background Image</label>
                <input type="file" name="hero_background" id="hero_background" class="form-control">
                @if(isset($settings->hero_background))
                    <img src="{{ asset('uploads/' . $settings->hero_background) }}" alt="Hero Background" width="100">
                @endif
            </div>

            <!-- Texts for Hero Section -->
            <div class="form-group">
                <label for="hero_title">Hero Section Title</label>
                <input type="text" name="hero_title" id="hero_title" class="form-control" value="{{ old('hero_title', $settings->hero_title ?? '') }}" placeholder="Enter Hero Section Title" required>
            </div>

            <div class="form-group">
                <label for="hero_title">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $settings->address ?? '') }}" placeholder="Enter Address" required>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('pagescript')
<script>   
</script>
@endsection
