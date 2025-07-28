@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-file-contract"></i>
        <span>Add New Legal Document</span>
    </div>
    <a href="{{ route('project-legal-documents.index') }}" class="back-button">Back to Documents</a>
</div>

<div class="form-container">
    <form action="{{ route('project-legal-documents.store') }}" method="POST" enctype="multipart/form-data" class="document-form">
        @csrf
        
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
    @if(isset($project))
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <div class="form-control-static">
            <strong>{{ $project->name }}</strong>
            <small class="text-muted">(Contract: {{ $project->contract_number ?: 'Not specified' }})</small>
        </div>
    @else
        <select name="project_id" id="project_id" class="form-control" required>
            <option value="">Select Project</option>
            @foreach ($projects as $id => $name)
                <option value="{{ $id }}" {{ (old('project_id') == $id || (isset($preSelectedProjectId) && $preSelectedProjectId == $id)) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    @endif
</div>
            
        <div class="form-group">
    <label for="legal_document_type_id">Document Type <span class="required">*</span></label>
    <select name="legal_document_type_id" id="legal_document_type_id" class="form-control" required>
        <option value="">Select Document Type</option>
        @foreach ($documentTypes as $documentType)
            <option value="{{ $documentType->id }}" {{ old('legal_document_type_id') == $documentType->id ? 'selected' : '' }}>
                {{ $documentType->name }}
                @if(isset($project) && $project->isDocumentTypeRequired($documentType->id))
                    <span class="document-required-tag">(Required)</span>
                @endif
            </option>
        @endforeach
    </select>
    
    @if(isset($project) && $project->requiredDocumentTypes->count() > 0)
        <div class="document-type-hint">
            <i class="fas fa-info-circle"></i>
            Only document types marked as required for this project are shown.
        </div>
    @endif
</div>

@if(isset($project))
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        You are adding a document to project <strong>{{ $project->name }}</strong>. 
        @if($project->requiredDocumentTypes->count() > 0)
            This project has {{ $project->requiredDocumentTypes->count() }} required document types.
        @else
            This project does not have any required document types yet. All document types are available for selection.
        @endif
    </div>
@endif
            <div class="form-row">
                <div class="form-group">
                    <label for="issue_date">Issue Date</label>
                    <input type="date" name="issue_date" id="issue_date" class="form-control" value="{{ old('issue_date') }}">
                </div>
                
                <div class="form-group">
                    <label for="validity_date">Validity Date</label>
                    <input type="date" name="validity_date" id="validity_date" class="form-control" value="{{ old('validity_date') }}">
                </div>
            </div>


            <div class="form-row">
    <div class="form-group">
        <label for="license_number">License/Policy Number</label>
        <input type="text" name="license_number" id="license_number" class="form-control" value="{{ old('license_number') }}">
        <small class="form-text text-muted">Enter the license or policy number for this document</small>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="application_date">Application Date</label>
        <input type="date" name="application_date" id="application_date" class="form-control" value="{{ old('application_date') }}">
        <small class="form-text text-muted">Date when the license/document was applied for</small>
    </div>
    
    <div class="form-group">
        <label for="issue_date">Issue Date</label>
        <input type="date" name="issue_date" id="issue_date" class="form-control" value="{{ old('issue_date') }}">
        <small class="form-text text-muted">Date when the license/document was issued</small>
    </div>
</div>
            
<div class="form-row">
    <div class="form-group">
        <label for="validity_date">Validity/Expiry Date</label>
        <input type="date" name="validity_date" id="validity_date" class="form-control" value="{{ old('validity_date') }}">
        <small class="form-text text-muted">Date when the license/document expires</small>
    </div>

    <div class="form-group">
        <label for="reapply_date">Reapplication Date</label>
        <input type="date" name="reapply_date" id="reapply_date" class="form-control" value="{{ old('reapply_date') }}">
        <small class="form-text text-muted">Date when this document should be reapplied for (before or after expiry)</small>
    </div>
</div>

<div class="form-group">
    <label for="reapplication_status">Reapplication Status</label>
    <select name="reapplication_status" id="reapplication_status" class="form-control">
        <option value="">Not Applicable</option>
        <option value="not_required" {{ old('reapplication_status') == 'not_required' ? 'selected' : '' }}>Not Required</option>
        <option value="to_be_applied" {{ old('reapplication_status') == 'to_be_applied' ? 'selected' : '' }}>To Be Applied</option>
        <option value="in_process" {{ old('reapplication_status') == 'in_process' ? 'selected' : '' }}>In Process</option>
        <option value="completed" {{ old('reapplication_status') == 'completed' ? 'selected' : '' }}>Completed</option>
    </select>
    <small class="form-text text-muted">Current status of document reapplication process (if applicable)</small>
</div>
            
            <div class="form-group checkbox-group">
                <input type="checkbox" name="is_required" id="is_required" class="form-checkbox" value="1" {{ old('is_required', 1) ? 'checked' : '' }}>
                <label for="is_required">This document is required for the project</label>
            </div>
            
            <div class="form-group file-group">
                <label for="document_file">Upload Document</label>
                <div class="file-input-wrapper">
                    <input type="file" name="document_file" id="document_file" class="file-input">
                    <label for="document_file" class="file-input-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span class="file-input-text">Choose a file</span>
                    </label>
                    <span class="selected-file-name"></span>
                </div>
                <div class="file-help-text">Max file size: 10MB. Accepted formats: PDF, DOC, DOCX, JPG, PNG.</div>
            </div>
        </div>
        
        <div class="form-footer">
            <button type="submit" class="submit-btn">Save Document</button>
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
    }


    .form-control-static {
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .document-required-tag {
        font-style: italic;
        color: #e31e24;
    }
    
    .document-type-hint {
        margin-top: 5px;
        font-size: 12px;
        color: #666;
    }
    
    .document-type-hint i {
        margin-right: 5px;
        color: #17a2b8;
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


       const projectSelect = document.getElementById('project_id');
    const documentTypeSelect = document.getElementById('legal_document_type_id');
    
    if (projectSelect) {
        projectSelect.addEventListener('change', function() {
            const projectId = this.value;
            
            if (projectId) {
                // Clear current options except the first one
                while (documentTypeSelect.options.length > 1) {
                    documentTypeSelect.remove(1);
                }
                
                // Show loading indicator
                documentTypeSelect.disabled = true;
                const firstOption = documentTypeSelect.options[0];
                firstOption.text = "Loading document types...";
                
                // Fetch required document types for the selected project
                fetch(`/api/projects/${projectId}/required-document-types`)
                    .then(response => response.json())
                    .then(data => {
                        // Reset first option
                        firstOption.text = "Select Document Type";
                        documentTypeSelect.disabled = false;
                        
                        if (data.success && data.documentTypes.length > 0) {
                            // Add options for each document type
                            data.documentTypes.forEach(docType => {
                                const option = document.createElement('option');
                                option.value = docType.id;
                                option.textContent = docType.name + " (Required)";
                                documentTypeSelect.appendChild(option);
                            });
                            
                            // Add a hint about document types
                            const hintContainer = document.createElement('div');
                            hintContainer.className = 'document-type-hint';
                            hintContainer.innerHTML = '<i class="fas fa-info-circle"></i> Only document types marked as required for this project are shown.';
                            
                            // Find parent of select and append hint if not already present
                            const selectParent = documentTypeSelect.parentElement;
                            const existingHint = selectParent.querySelector('.document-type-hint');
                            
                            if (!existingHint) {
                                selectParent.appendChild(hintContainer);
                            }
                        } else {
                            // If no required document types, fetch all document types
                            fetch('/api/document-types')
                                .then(response => response.json())
                                .then(allData => {
                                    if (allData.success && allData.documentTypes.length > 0) {
                                        allData.documentTypes.forEach(docType => {
                                            const option = document.createElement('option');
                                            option.value = docType.id;
                                            option.textContent = docType.name;
                                            documentTypeSelect.appendChild(option);
                                        });
                                    } else {
                                        // Add a message if no document types at all
                                        const option = document.createElement('option');
                                        option.disabled = true;
                                        option.textContent = "No document types available";
                                        documentTypeSelect.appendChild(option);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error fetching all document types:', error);
                                    firstOption.text = "Error loading document types";
                                });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching document types:', error);
                        firstOption.text = "Error loading document types";
                        documentTypeSelect.disabled = false;
                    });
            }
        });
        
        // Auto-trigger change event if project is pre-selected
        if (projectSelect.value) {
            // Trigger after a slight delay to ensure DOM is ready
            setTimeout(() => {
                const event = new Event('change');
                projectSelect.dispatchEvent(event);
            }, 100);
        }
    }
    });
</script>
@endsection