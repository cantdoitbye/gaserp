@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-tools"></i>
        <span>Edit Service Type</span>
    </div>
    <a href="{{ route('service-types.index') }}" class="back-button">Back to Service Types</a>
</div>

<div class="content-container">
    <div class="form-container">
        <form action="{{ route('service-types.update', $serviceType->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Service Type Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $serviceType->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Enter a unique name for the service type (e.g., installation, repair, etc.)</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save"></i> Update Service Type
                </button>
                <a href="{{ route('service-types.index') }}" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    .desk-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .desk-title {
        display: flex;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
    }

    .desk-title i {
        font-size: 24px;
        margin-right: 10px;
        color: #e31e24;
    }

    .back-button {
        background-color: #f0f0f0;
        color: #333;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }

    .back-button:hover {
        background-color: #e0e0e0;
    }

    .content-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 20px;
    }

    .form-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #e31e24;
        outline: none;
        box-shadow: 0 0 0 2px rgba(227, 30, 36, 0.2);
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }

    .form-text {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .btn {
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        border: none;
        transition: background-color 0.2s;
    }

    .btn i {
        margin-right: 5px;
    }

    .btn-save {
        background-color: #28a745;
        color: white;
    }

    .btn-cancel {
        background-color: #f0f0f0;
        color: #333;
    }

    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
            gap: 10px;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection