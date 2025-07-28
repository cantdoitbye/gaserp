@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-file-alt"></i>
        <span>Edit Document Type</span>
    </div>
    <a href="{{ route('legal-document-types.index') }}" class="back-button">Back to Document Types</a>
</div>

<div class="form-container">
    <form action="{{ route('legal-document-types.update', $legalDocumentType->id) }}" method="POST" class="document-type-form">
        @csrf
        @method('PUT')
        
        <div class="form-header">
            <h2>Document Type Information</h2>
        </div>
        
        <div class="form-body">
            @if ($errors->any())
                <div class="alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="form-group">
                <label for="name">Document Type Name <span class="required">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $legalDocumentType->name) }}" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $legalDocumentType->description) }}</textarea>
            </div>
            
            <div class="form-group checkbox-group">
                <input type="checkbox" name="requires_expiry" id="requires_expiry" class="form-checkbox" value="1" {{ old('requires_expiry', $legalDocumentType->requires_expiry) ? 'checked' : '' }}>
                <label for="requires_expiry">This document type requires expiry date</label>
            </div>
        </div>
        
        <div class="form-footer">
            <button type="submit" class="submit-btn">Update Document Type</button>
            <a href="{{ route('legal-document-types.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
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
    
    .form-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .document-type-form {
        width: 100%;
    }
    
    .form-header {
        padding: 20px;
        background-color: #f5f5f5;
        border-bottom: 1px solid #eee;
    }
    
    .form-header h2 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }
    
    .form-body {
        padding: 20px;
    }
    
    .alert-danger {
        background-color: #fff5f5;
        color: #e31e24;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
    }
    
    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
        color: #333;
    }
    
    .required {
        color: #e31e24;
    }
    
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .checkbox-group {
        display: flex;
        align-items: center;
    }
    
    .form-checkbox {
        margin-right: 10px;
    }
    
    .form-footer {
        padding: 20px;
        background-color: #f5f5f5;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    
    .submit-btn {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .cancel-btn {
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ddd;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }
</style>
@endsection