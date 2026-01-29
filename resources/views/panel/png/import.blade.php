@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="breadcrumb">
            <a href="{{ route('png.index') }}">PNG Tracker</a>
            <span>/</span>
            <span>Import Data</span>
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">Import PNG Tracker Data</h1>

    <div class="content-card">
        {{-- Success Messages --}}
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Warning Messages --}}
        @if(session('warning'))
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('warning') }}
            </div>
        @endif

        {{-- Error Messages --}}
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-times-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-times-circle"></i>
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Import Errors (Detailed) --}}
        @if(session('import_errors'))
            <div class="alert alert-danger alert-detailed" role="alert">
                <div class="alert-header">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Import Completed with Errors</strong>
                    <button type="button" class="toggle-details" onclick="toggleErrorDetails()">
                        <span id="toggle-text">Show Details</span>
                        <i class="fas fa-chevron-down" id="toggle-icon"></i>
                    </button>
                </div>
                
                <div class="alert-summary">
                    {{ session('import_summary', 'Some records could not be imported due to data validation errors.') }}
                </div>
                
                <div class="error-details" id="error-details" style="display: none;">
                    <div class="error-list">
                        @foreach(session('import_errors') as $error)
                            <div class="error-item">
                                <i class="fas fa-times-circle error-icon"></i>
                                {{ $error }}
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="error-help">
                        <h5><i class="fas fa-lightbulb"></i> Common Solutions:</h5>
                        <ul>
                            <li><strong>Invalid connection status:</strong> Use one of: workable, not_workable, plb_done, pdt_pending, gc_pending, mmt_pending, conv_pending, comm, report_pending, bill_pending, bill_received, reported</li>
                            <li><strong>Invalid plan type:</strong> Use one of: apartment, bungalow, rowhouse, commercial, individual, farmhouse</li>
                            <li><strong>Date format issues:</strong> Use YYYY-MM-DD format (e.g., 2024-01-15)</li>
                            <li><strong>Text too long:</strong> Keep text fields under 255 characters</li>
                            <li><strong>Invalid numbers:</strong> Use only numeric values for measurement fields</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="import-section">
            <div class="import-instructions">
                <h3><i class="fas fa-info-circle"></i> Import Instructions</h3>
                <div class="instruction-content">
                    <p>Follow these guidelines to successfully import your PNG data:</p>
                    <ul>
                        <li><strong>File Format:</strong> Only Excel files (.xlsx, .xls) are supported</li>
                        <li><strong>Connection Status:</strong> Must be one of: workable, not_workable, plb_done, pdt_pending, gc_pending, mmt_pending, conv_pending, comm, report_pending, bill_pending, bill_received, reported</li>
                        <li><strong>Activity Type:</strong> Must be one of: domestic, commercial, riser_hadder, dma, welded, o&m</li>
                        <li><strong>Date Format:</strong> Use YYYY-MM-DD format (e.g., 2024-01-15)</li>
                        <li><strong>Numeric Fields:</strong> All measurement fields should contain only numbers (use 0 or leave blank for no data)</li>
                        <li><strong>Text Length:</strong> Keep text fields under 255 characters</li>
                        <li><strong>File Size:</strong> Maximum file size is 10MB</li>
                        <li><strong>Empty Cells:</strong> Leave cells blank if no data available (don't use ?, -, N/A)</li>
                    </ul>
                </div>
            </div>

            <div class="sample-download">
                <h3><i class="fas fa-download"></i> Download Sample Template</h3>
                <p>Download a sample Excel template with the correct column structure and valid data examples:</p>
                <a href="{{ route('png.download-template') }}" class="btn btn-outline-primary" download>
                    <i class="fas fa-file-excel"></i> Download Sample Template
                </a>
            </div>

            <div class="upload-form">
                <h3><i class="fas fa-upload"></i> Upload Excel File</h3>
                <form action="{{ route('png.import') }}" method="POST" enctype="multipart/form-data" id="import-form">
                    @csrf
                    
                    <div class="file-upload-area" id="file-upload-area">
                        <div class="upload-content">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <h4>Choose Excel File or Drag & Drop</h4>
                            <p>Select your PNG Excel file to import data</p>
                            <input type="file" name="excel_file" id="excel_file" accept=".xlsx,.xls" required>
                            <label for="excel_file" class="file-label">Choose File</label>
                        </div>
                        <div class="file-info" id="file-info" style="display: none;">
                            <div class="file-details">
                                <i class="fas fa-file-excel file-icon"></i>
                                <div class="file-text">
                                    <span class="file-name" id="file-name"></span>
                                    <span class="file-size" id="file-size"></span>
                                </div>
                                <button type="button" class="remove-file" id="remove-file">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="import-options">
                        <h4>Import Options</h4>
                        <div class="option-group">
                            <label class="option-label">
                                <input type="checkbox" name="skip_duplicates" value="1" checked>
                                <span class="checkmark"></span>
                                Skip duplicate records (based on Service Order No)
                            </label>
                        </div>
                        <div class="option-group">
                            <label class="option-label">
                                <input type="checkbox" name="update_duplicates" value="1">
                                <span class="checkmark"></span>
                                Update existing records if duplicates found
                            </label>
                        </div>
                        <div class="option-group">
                            <label class="option-label">
                                <input type="checkbox" name="validate_only" value="1">
                                <span class="checkmark"></span>
                                Validate only (check for errors without importing)
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="import-btn">
                            <i class="fas fa-upload"></i> Import Data
                        </button>
                        <a href="{{ route('png.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </form>
            </div>

            <div class="data-validation-guide">
                <h3><i class="fas fa-check-shield"></i> Data Validation Guide</h3>
                <div class="validation-grid">
                    <div class="validation-category">
                        <h4>Connection Status Values</h4>
                        <div class="value-list">
                            <span class="value-item valid">workable</span>
                            <span class="value-item valid">not_workable</span>
                            <span class="value-item valid">plb_done</span>
                            <span class="value-item valid">pdt_pending</span>
                            <span class="value-item valid">gc_pending</span>
                            <span class="value-item valid">mmt_pending</span>
                            <span class="value-item valid">conv_pending</span>
                            <span class="value-item valid">comm</span>
                            <span class="value-item valid">report_pending</span>
                            <span class="value-item valid">bill_pending</span>
                            <span class="value-item valid">bill_received</span>
                            <span class="value-item valid">reported</span>
                        </div>
                    </div>
                    
                    <div class="validation-category">
                        <h4>Plan Type Values</h4>
                        <div class="value-list">
                            <span class="value-item valid">domestic</span>
                            <span class="value-item valid">commercial</span>
                            <span class="value-item valid">riser_hadder</span>
                            <span class="value-item valid">dma</span>
                            <span class="value-item valid">welded</span>
                            <span class="value-item valid">o&m</span>
                        </div>
                        
                        {{--<h5>Also Accepted (Auto-converted):</h5>
                        <div class="value-list">
                            <span class="value-item auto-convert">bunglow → bungalow</span>
                            <span class="value-item auto-convert">villa → bungalow</span>
                            <span class="value-item auto-convert">flat → apartment</span>
                            <span class="value-item auto-convert">row house → rowhouse</span>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('excel_file');
    const fileUploadArea = document.getElementById('file-upload-area');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const removeFileBtn = document.getElementById('remove-file');
    const importForm = document.getElementById('import-form');
    const importBtn = document.getElementById('import-btn');

    // File input change handler
    fileInput.addEventListener('change', function(e) {
        handleFileSelect(e.target.files[0]);
    });

    // Drag and drop handlers
    fileUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        fileUploadArea.classList.add('drag-over');
    });

    fileUploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        fileUploadArea.classList.remove('drag-over');
    });

    fileUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        fileUploadArea.classList.remove('drag-over');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (validateFile(file)) {
                fileInput.files = files;
                handleFileSelect(file);
            }
        }
    });

    // Remove file handler
    removeFileBtn.addEventListener('click', function() {
        resetFileInput();
    });

    // Form submit handler
    importForm.addEventListener('submit', function(e) {
        if (!fileInput.files.length) {
            e.preventDefault();
            alert('Please select a file to import.');
            return;
        }

        // Show loading state
        const validateOnly = document.querySelector('input[name="validate_only"]:checked');
        if (validateOnly) {
            importBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Validating...';
        } else {
            importBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Importing...';
        }
        importBtn.disabled = true;
    });

    function handleFileSelect(file) {
        if (!file) return;

        if (validateFile(file)) {
            // Show file info
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            fileUploadArea.querySelector('.upload-content').style.display = 'none';
            fileInfo.style.display = 'block';
            fileUploadArea.classList.add('has-file');
        }
    }

    function validateFile(file) {
        // Check file type
        const allowedTypes = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel'
        ];
        
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid Excel file (.xlsx or .xls)');
            return false;
        }

        // Check file size (10MB limit)
        const maxSize = 10 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('File size must be less than 10MB');
            return false;
        }

        return true;
    }

    function resetFileInput() {
        fileInput.value = '';
        fileUploadArea.querySelector('.upload-content').style.display = 'block';
        fileInfo.style.display = 'none';
        fileUploadArea.classList.remove('has-file');
        
        // Reset button state
        importBtn.innerHTML = '<i class="fas fa-upload"></i> Import Data';
        importBtn.disabled = false;
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});

// Toggle error details
function toggleErrorDetails() {
    const details = document.getElementById('error-details');
    const toggleText = document.getElementById('toggle-text');
    const toggleIcon = document.getElementById('toggle-icon');
    
    if (details.style.display === 'none') {
        details.style.display = 'block';
        toggleText.textContent = 'Hide Details';
        toggleIcon.className = 'fas fa-chevron-up';
    } else {
        details.style.display = 'none';
        toggleText.textContent = 'Show Details';
        toggleIcon.className = 'fas fa-chevron-down';
    }
}
</script>

<style>
/* Alert Styles */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 6px;
    position: relative;
}

.alert i {
    margin-right: 8px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-warning {
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeaa7;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert-detailed {
    padding: 0;
    overflow: hidden;
}

.alert-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background-color: rgba(0,0,0,0.05);
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.alert-summary {
    padding: 15px;
    font-weight: 500;
}

.toggle-details {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
}

.error-details {
    border-top: 1px solid rgba(0,0,0,0.1);
    background-color: rgba(0,0,0,0.02);
}

.error-list {
    max-height: 300px;
    overflow-y: auto;
    padding: 15px;
}

.error-item {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    padding: 8px 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
    font-family: 'Consolas', 'Monaco', monospace;
    font-size: 13px;
}

.error-item:last-child {
    border-bottom: none;
}

.error-icon {
    color: #dc3545;
    margin-top: 2px;
    flex-shrink: 0;
}

.error-help {
    padding: 15px;
    background-color: rgba(0,0,0,0.05);
    border-top: 1px solid rgba(0,0,0,0.1);
}

.error-help h5 {
    margin: 0 0 10px 0;
    color: #495057;
}

.error-help ul {
    margin: 0;
    padding-left: 20px;
}

.error-help li {
    margin-bottom: 5px;
    font-size: 13px;
}

/* Validation Guide Styles */
.data-validation-guide {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 25px;
}

.data-validation-guide h3 {
    margin-top: 0;
    margin-bottom: 20px;
    color: #495057;
    display: flex;
    align-items: center;
    gap: 10px;
}

.validation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
}

.validation-category h4 {
    margin-bottom: 15px;
    color: #495057;
    font-size: 16px;
}

.validation-category h5 {
    margin: 15px 0 10px 0;
    color: #6c757d;
    font-size: 14px;
}

.value-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 15px;
}

.value-item {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    font-family: 'Consolas', 'Monaco', monospace;
}

.value-item.valid {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.value-item.auto-convert {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

/* Import Section Styles */
.import-section {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.import-instructions,
.sample-download,
.upload-form,
.data-validation-guide {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 25px;
}

.import-instructions h3,
.sample-download h3,
.upload-form h3 {
    margin-top: 0;
    margin-bottom: 15px;
    color: #495057;
    display: flex;
    align-items: center;
    gap: 10px;
}

.instruction-content ul {
    margin: 15px 0;
    padding-left: 20px;
}

.instruction-content li {
    margin-bottom: 8px;
    line-height: 1.5;
}

.file-upload-area {
    border: 2px dashed #ced4da;
    border-radius: 8px;
    padding: 40px 20px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    margin-bottom: 20px;
}

.file-upload-area:hover,
.file-upload-area.drag-over {
    border-color: #007bff;
    background-color: rgba(0, 123, 255, 0.05);
}

.file-upload-area.has-file {
    border-color: #28a745;
    background-color: rgba(40, 167, 69, 0.05);
}

.upload-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.upload-icon {
    font-size: 48px;
    color: #6c757d;
}

.upload-content h4 {
    margin: 0;
    color: #495057;
}

.upload-content p {
    margin: 0;
    color: #6c757d;
}

#excel_file {
    display: none;
}

.file-label {
    background: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.file-label:hover {
    background: #0056b3;
}

.file-info {
    display: flex;
    justify-content: center;
}

.file-details {
    display: flex;
    align-items: center;
    gap: 15px;
    background: white;
    padding: 15px 20px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.file-icon {
    font-size: 24px;
    color: #28a745;
}

.file-text {
    display: flex;
    flex-direction: column;
}

.file-name {
    font-weight: 600;
    color: #495057;
}

.file-size {
    font-size: 12px;
    color: #6c757d;
}

.remove-file {
    background: #dc3545;
    color: white;
    border: none;
    width: 24px;
    height: 24px;
    border-radius: 50%;
}
@endsection
