@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-file-contract"></i>
        <span>Edit Legal Document</span>
    </div>
    <a href="{{ route('project-legal-documents.index') }}" class="back-button">Back to Documents</a>
</div>

<div class="form-container">
    <form action="{{ route('project-legal-documents.update', $projectLegalDocument->id) }}" method="POST" enctype="multipart/form-data" class="document-form">
        @csrf
        @method('PUT')
        
        <div class="form-header">
            <h2>Document Information</h2>
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
                <label for="project_id">Project <span class="required">*</span></label>
                <select name="project_id" id="project_id" class="form-control" required>
                    <option value="">Select Project</option>
                    @foreach ($projects as $id => $name)
                        <option value="{{ $id }}" {{ old('project_id', $projectLegalDocument->project_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="legal_document_type_id">Document Type <span class="required">*</span></label>
                <select name="legal_document_type_id" id="legal_document_type_id" class="form-control" required>
                    <option value="">Select Document Type</option>
                    @foreach ($documentTypes as $id => $name)
                        <option value="{{ $id }}" {{ old('legal_document_type_id', $projectLegalDocument->legal_document_type_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="issue_date">Issue Date</label>
                    <input type="date" name="issue_date" id="issue_date" class="form-control" value="{{ old('issue_date', $projectLegalDocument->issue_date ? $projectLegalDocument->issue_date->format('Y-m-d') : '') }}">
                </div>
                
                <div class="form-group">
                    <label for="validity_date">Validity Date</label>
                    <input type="date" name="validity_date" id="validity_date" class="form-control" value="{{ old('validity_date', $projectLegalDocument->validity_date ? $projectLegalDocument->validity_date->format('Y-m-d') : '') }}">
                </div>
            </div>
            
            <div class="form-group checkbox-group">
                <input type="checkbox" name="is_required" id="is_required" class="form-checkbox" value="1" {{ old('is_required', $projectLegalDocument->is_required) ? 'checked' : '' }}>
                <label for="is_required">This document is required for the project</label>
            </div>
            
            <div class="form-group file-group">
                <label for="document_file">Upload Document</label>
                
                @if($projectLegalDocument->document_file)
                    <div class="current-file">
                        <p>Current File: <strong>{{ basename($projectLegalDocument->document_file) }}</strong></p>
                        <a href="{{ route('project-legal-documents.download', $projectLegalDocument->id) }}" class="download-link">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                @endif
                
                <div class="file-input-wrapper">
                    <input type="file" name="document_file" id="document_file" class="file-input">
                    <label for="document_file" class="file-input-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span class="file-input-text">{{ $projectLegalDocument->document_file ? 'Replace file' : 'Choose a file' }}</span>
                    </label>
                    <span class="selected-file-name"></span>
                </div>
                <div class="file-help-text">Max file size: 10MB. Accepted formats: PDF, DOC, DOCX, JPG, PNG.</div>
            </div>
        </div>
        
        <div class="form-footer">
            <button type="submit" class="submit-btn">Update Document</button>
            <a href="{{ route('project-legal-documents.index') }}" class="cancel-btn">Cancel</a>
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

    .document-form {
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

    .form-row {
        display: flex;
        gap: 20px;
    }

    .form-row .form-group {
        flex: 1;
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

    .file-group {
        margin-top: 30px;
    }

    .current-file {
        background-color: #f9f9f9;
        padding: 10px 15px;
        border-radius: 4px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .download-link {
        color: #17a2b8;
        text-decoration: none;
    }

    .download-link i {
        margin-right: 5px;
    }

    .file-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .file-input {
        opacity: 0;
        position: absolute;
        width: 0.1px;
        height: 0.1px;
        overflow: hidden;
    }

    .file-input-label {
        background-color: #f0f0f0;
        color: #333;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        font-weight: normal;
    }

    .file-input-label i {
        margin-right: 5px;
    }

    .selected-file-name {
        margin-left: 10px;
        font-size: 14px;
        color: #666;
    }

    .file-help-text {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
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

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        
        .current-file {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .download-link {
            margin-top: 5px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // File input handling
        const fileInput = document.getElementById('document_file');
        const fileNameDisplay = document.querySelector('.selected-file-name');
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    fileNameDisplay.textContent = this.files[0].name;
                } else {
                    fileNameDisplay.textContent = '';
                }
            });
        }
        
        // Date validation
        const issueDateInput = document.getElementById('issue_date');
        const validityDateInput = document.getElementById('validity_date');
        
        if (validityDateInput && issueDateInput) {
            issueDateInput.addEventListener('change', function() {
                if (this.value) {
                    validityDateInput.min = this.value;
                }
            });
        }
    });
</script>
@endsection