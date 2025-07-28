@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="breadcrumb">
            <a href="{{ route('pe-tracker.index') }}">PE Tracker</a>
            <span>/</span>
            <span>Import Data</span>
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">Import PE Tracker Data</h1>

    <div class="content-card">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="import-section">
            <div class="import-instructions">
                <h3><i class="fas fa-info-circle"></i> Import Instructions</h3>
                <div class="instruction-content">
                    <p>Follow these guidelines to successfully import your PE Tracker data:</p>
                    <ul>
                        <li><strong>File Format:</strong> Only Excel files (.xlsx, .xls) are supported</li>
                        <li><strong>Required Columns:</strong> Date, Site Names, and Activity are mandatory</li>
                        <li><strong>Date Format:</strong> Use DD-MM-YYYY format (e.g., 29-May-24 or 29-05-2024)</li>
                        <li><strong>Activity Values:</strong> Must be one of: LAYING, COMMISSIONING, EXCAVATION, FLUSHING, JOINT, SR INSTALLATION</li>
                        <li><strong>Numeric Fields:</strong> All measurement fields should contain only numbers (use 0 or leave blank for no data)</li>
                        <li><strong>File Size:</strong> Maximum file size is 10MB</li>
                        <li><strong>First Row:</strong> Should contain column headers matching the expected format</li>
                    </ul>
                </div>
            </div>

            <div class="sample-download">
                <h3><i class="fas fa-download"></i> Download Sample Template</h3>
                <p>Download a sample Excel template with the correct column structure:</p>
                <a href="{{ asset('samples/pe-tracker-template.xlsx') }}" class="btn btn-outline-primary" download>
                    <i class="fas fa-file-excel"></i> Download Sample Template
                </a>
            </div>

            <div class="upload-form">
                <h3><i class="fas fa-upload"></i> Upload Excel File</h3>
                <form action="{{ route('pe-tracker.import') }}" method="POST" enctype="multipart/form-data" id="import-form">
                    @csrf
                    
                    <div class="file-upload-area" id="file-upload-area">
                        <div class="upload-content">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <h4>Choose Excel File or Drag & Drop</h4>
                            <p>Select your PE Tracker Excel file to import data</p>
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
                                Skip duplicate records (based on Date, DPR No, and Site Names)
                            </label>
                        </div>
                        <div class="option-group">
                            <label class="option-label">
                                <input type="checkbox" name="update_existing" value="1">
                                <span class="checkmark"></span>
                                Update existing records if duplicates found
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="import-btn">
                            <i class="fas fa-upload"></i> Import Data
                        </button>
                        <a href="{{ route('pe-tracker.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </form>
            </div>

            <div class="expected-columns">
                <h3><i class="fas fa-list"></i> Expected Column Structure</h3>
                <div class="columns-grid">
                    <div class="column-category">
                        <h4>Basic Information</h4>
                        <ul>
                            <li>Date <span class="required-mark">*</span></li>
                            <li>DPR No</li>
                            <li>Site Names <span class="required-mark">*</span></li>
                            <li>Activity <span class="required-mark">*</span></li>
                            <li>Mukadam Name</li>
                            <li>Supervisor</li>
                            <li>TPI Name</li>
                            <li>RA Bill No</li>
                        </ul>
                    </div>
                    <div class="column-category">
                        <h4>Laying Measurements</h4>
                        <ul>
                            <li>32 MM Laying Open Cut</li>
                            <li>63 MM Laying Open Cut</li>
                            <li>90 MM Laying Open Cut</li>
                            <li>125 MM Laying Open Cut</li>
                            <li>32 MM Manual Boring</li>
                            <li>63 MM Manual Boring</li>
                            <li>90 MM Manual Boring</li>
                            <li>125 MM Manual Boring</li>
                        </ul>
                    </div>
                    <div class="column-category">
                        <h4>Additional Work</h4>
                        <ul>
                            <li>Breaking Hard Rock</li>
                            <li>Excavation Beyond 2M</li>
                            <li>RCC Cutting/Breaking</li>
                            <li>PCC Cutting/Breaking</li>
                            <li>Installation Work</li>
                            <li>Pipe Fittings</li>
                            <li>Testing Data</li>
                            <li>And many more...</li>
                        </ul>
                    </div>
                </div>
                <p class="column-note">
                    <span class="required-mark">*</span> Required fields. 
                    All other fields are optional and can be left blank if no data is available.
                </p>
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
        importBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Importing...';
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
</script>

<style>
.import-section {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.import-instructions,
.sample-download,
.upload-form,
.expected-columns {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 25px;
}

.import-instructions h3,
.sample-download h3,
.upload-form h3,
.expected-columns h3 {
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
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.import-options {
    margin-bottom: 20px;
}

.import-options h4 {
    margin-bottom: 15px;
    color: #495057;
}

.option-group {
    margin-bottom: 10px;
}

.option-label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-weight: 500;
    color: #495057;
}

.columns-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.column-category h4 {
    margin-bottom: 10px;
    color: #495057;
    font-size: 16px;
}

.column-category ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.column-category li {
    padding: 5px 0;
    border-bottom: 1px solid #dee2e6;
    font-size: 14px;
}

.column-category li:last-child {
    border-bottom: none;
}

.required-mark {
    color: #dc3545;
    font-weight: bold;
}

.column-note {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    padding: 10px;
    border-radius: 4px;
    font-size: 14px;
    color: #856404;
}

.alert-danger {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .file-upload-area {
        padding: 30px 15px;
    }
    
    .upload-icon {
        font-size: 36px;
    }
    
    .columns-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection