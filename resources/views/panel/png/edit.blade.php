@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
/* ==========================================
   MODERN UI STYLES - PNG EDIT FORM
   Color Scheme: Modern Blue Theme
   ========================================== */

/* Validation Alert Box */
.validation-alert {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
    color: white;
    padding: 20px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
    box-shadow: 0 4px 15px rgba(238, 90, 90, 0.3);
    animation: slideDown 0.4s ease;
    position: relative;
}

.validation-alert::before {
    content: '\f071';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 40px;
    opacity: 0.2;
}

.validation-alert h4 {
    margin: 0 0 12px 0;
    font-size: 18px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
}

.validation-alert h4 i {
    font-size: 20px;
}

.validation-alert ul {
    margin: 0;
    padding-left: 20px;
    list-style: none;
}

.validation-alert ul li {
    padding: 6px 0;
    font-size: 14px;
    position: relative;
    padding-left: 20px;
}

.validation-alert ul li::before {
    content: '\f00d';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    left: 0;
    font-size: 12px;
}

.validation-alert .close-btn {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.validation-alert .close-btn:hover {
    background: rgba(255,255,255,0.4);
    transform: rotate(90deg);
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Success Alert */
.success-alert {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 18px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    animation: slideDown 0.4s ease;
    display: flex;
    align-items: center;
    gap: 12px;
}

.success-alert i {
    font-size: 24px;
}

.success-alert span {
    font-weight: 600;
    font-size: 15px;
}

/* Modern Form Card */
.form-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08), 0 2px 10px rgba(0,0,0,0.04);
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.05);
}

.form-header {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    padding: 24px 30px;
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 0.3px;
    position: relative;
    overflow: hidden;
}

.form-header::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.form-body {
    padding: 30px;
}

/* Modern Tabs */
.form-tabs {
    display: flex;
    gap: 8px;
    background: #f1f5f9;
    padding: 8px;
    border-radius: 16px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.form-tab {
    padding: 14px 24px;
    cursor: pointer;
    border: none;
    background: transparent;
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    color: #64748b;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.form-tab:hover {
    background: rgba(59, 130, 246, 0.08);
    color: #3b82f6;
}

.form-tab.active {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.35);
    transform: translateY(-1px);
}

.form-tab i {
    margin-right: 8px;
}

.tab-content {
    display: none;
    animation: fadeIn 0.4s ease;
}

.tab-content.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Form Section Title */
.form-section-title {
    font-size: 17px;
    font-weight: 700;
    margin: 28px 0 20px 0;
    color: #1e293b;
    padding-bottom: 12px;
    border-bottom: 2px solid #3b82f6;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-section-title i {
    color: #3b82f6;
}

/* Modern Form Controls */
.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    display: block;
    font-size: 14px;
}

.form-label .required {
    color: #ef4444;
    font-weight: 700;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #fff;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.form-control.is-invalid {
    border-color: #ef4444;
    background: #fef2f2;
}

.form-control.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
}

.invalid-feedback {
    color: #ef4444;
    font-size: 13px;
    margin-top: 6px;
    display: block;
    font-weight: 500;
}

/* Modern Form Row */
.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 10px;
}

/* Calculated Field */
.calculated-field {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 2px solid #e2e8f0;
    cursor: not-allowed;
}

/* Measurement Styles */
.measurement-group {
    background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    border: 1px solid #e2e8f0;
}

.measurement-category {
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.measurement-category h5 {
    margin-bottom: 20px;
    color: #1e293b;
    font-weight: 700;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.measurement-category h5 i {
    color: #3b82f6;
}

/* Documents Grid */
.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 30px;
}

.document-section {
    border: 2px dashed #cbd5e1;
    border-radius: 16px;
    padding: 24px;
    background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
    transition: all 0.3s ease;
}

.document-section:hover {
    border-color: #3b82f6;
    background: rgba(59, 130, 246, 0.02);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.document-header {
    display: flex;
    align-items: center;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e2e8f0;
}

.document-icon {
    font-size: 28px;
    margin-right: 12px;
    color: #3b82f6;
}

.document-header h5 {
    margin: 0;
    color: #1e293b;
    font-weight: 700;
    font-size: 15px;
}

.document-upload-area {
    position: relative;
    min-height: 130px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
}

.file-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    background: white;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    padding: 24px;
}

.file-upload-label:hover {
    border-color: #3b82f6;
    background: rgba(59, 130, 246, 0.02);
}

.file-upload-label i {
    font-size: 36px;
    color: #94a3b8;
    margin-bottom: 10px;
}

.file-upload-label span {
    font-weight: 600;
    color: #475569;
    margin-bottom: 6px;
}

.file-upload-label small {
    color: #94a3b8;
    font-size: 12px;
}

.file-preview {
    margin-top: 12px;
    max-height: 160px;
    overflow-y: auto;
}

.file-preview-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px 14px;
    margin-bottom: 6px;
}

.file-preview-item .file-name {
    flex: 1;
    font-size: 13px;
    color: #475569;
    margin-right: 10px;
    font-weight: 500;
}

.file-preview-item .file-size {
    font-size: 11px;
    color: #94a3b8;
    margin-right: 10px;
}

.file-preview-item .remove-file {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border: none;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 10px;
    transition: all 0.3s ease;
}

.file-preview-item .remove-file:hover {
    transform: scale(1.1);
}

.existing-file {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    color: #475569;
    padding: 10px 14px;
    border-radius: 8px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.existing-file a {
    color: #3b82f6;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}

.existing-file a:hover {
    text-decoration: underline;
}

.existing-files-list {
    margin-bottom: 16px;
}

.existing-files-title {
    font-weight: 600;
    margin-bottom: 12px;
    color: #475569;
    font-size: 14px;
}

.document-info {
    text-align: center;
}

.form-file-info {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 6px;
}

/* Modern Step Progress */
.step-progress {
    display: flex;
    justify-content: space-between;
    margin-bottom: 35px;
    padding: 0 10px;
}

.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    flex: 1;
}

.step-item:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 18px;
    left: 55%;
    width: 85%;
    height: 3px;
    background: linear-gradient(90deg, #e2e8f0 0%, #e2e8f0 100%);
    z-index: 0;
    border-radius: 2px;
}

.step-item.active:not(:last-child)::after {
    background: linear-gradient(90deg, #3b82f6 0%, #60a5fa 100%);
}

.step-item.completed:not(:last-child)::after {
    background: linear-gradient(90deg, #22c55e 0%, #4ade80 100%);
}

.step-number {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    margin-bottom: 8px;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.step-item.active .step-number {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    transform: scale(1.1);
}

.step-item.completed .step-number {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4);
}

.step-label {
    font-size: 12px;
    font-weight: 600;
    color: #94a3b8;
    text-align: center;
}

.step-item.active .step-label {
    color: #3b82f6;
    font-weight: 700;
}

.step-item.completed .step-label {
    color: #22c55e;
}

/* Multi-Step Container */
.multi-step-container {
    background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 16px;
    padding: 28px;
    margin-top: 24px;
    border: 1px solid #e2e8f0;
}

.step-content {
    display: none;
    animation: fadeIn 0.4s ease;
}

.step-content.active {
    display: block;
}

.step-content h4 {
    color: #1e293b;
    margin-bottom: 24px;
    padding-bottom: 14px;
    border-bottom: 2px solid #3b82f6;
    font-weight: 700;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.step-content h4 i {
    color: #3b82f6;
}

/* Conditional Fields */
.conditional-fields {
    margin-top: 18px;
    padding: 20px;
    background: white;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.checkbox-group {
    display: flex;
    align-items: baseline;
    margin-bottom: 18px;
    padding: 12px 16px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 10px;
}

.checkbox-group input[type="checkbox"] {
    margin-right: 12px;
    transform: scale(1.3);
    cursor: pointer;
    accent-color: #3b82f6;
}

.checkbox-label {
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    margin-bottom: 0;
    font-size: 15px;
}

/* Step Navigation */
.step-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 35px;
    padding-top: 24px;
    border-top: 2px solid #e2e8f0;
    gap: 15px;
}

.step-navigation button:only-child {
    margin-left: auto;
}

/* Modern Buttons */
.btn {
    padding: 12px 28px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
}

.btn-secondary {
    background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(100, 116, 139, 0.3);
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4);
}

.btn-success {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
}

.btn-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
}

.btn-info:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
}

/* Submit Button */
.form-actions {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 2px solid #e2e8f0;
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.btn-submit {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    padding: 16px 40px;
    font-size: 16px;
    font-weight: 700;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    box-shadow: 0 6px 25px rgba(59, 130, 246, 0.35);
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 35px rgba(59, 130, 246, 0.45);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-cancel {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    color: #64748b;
    padding: 16px 30px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #e2e8f0;
    color: #475569;
}

/* Page Title */
.page-title {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-title::before {
    content: '';
    width: 5px;
    height: 32px;
    background: linear-gradient(180deg, #3b82f6 0%, #60a5fa 100%);
    border-radius: 3px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-tabs {
        flex-direction: column;
    }
    
    .form-tab {
        text-align: center;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .step-progress {
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .step-item:not(:last-child)::after {
        display: none;
    }
}
</style>
@endsection

@section('content')
<div class="main-container">

    <h1 class="page-title">Edit PNG Job</h1>

    <div class="form-card">
        <div class="form-header">
            Edit PNG Job Order Details - #{{ $png->id }}
        </div>
        <div class="form-body">

            {{-- Modern Success Alert --}}
            @if(session('success'))
                <div class="success-alert" id="successAlert">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="close-btn" onclick="this.parentElement.style.display='none'" style="margin-left: auto;">&times;</button>
                </div>
            @endif

            {{-- Modern Validation Error Alert Box --}}
            @if($errors->any())
                <div class="validation-alert" id="validationAlert">
                    <button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
                    <h4><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h4>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Client-side Validation Alert (Hidden by default) --}}
            <div class="validation-alert" id="clientValidationAlert" style="display: none;">
                <button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
                <h4><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h4>
                <ul id="clientValidationErrors"></ul>
            </div>

            {{-- Session Error Alert --}}
            @if(session('error'))
                <div class="validation-alert" id="errorAlert">
                    <button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
                    <h4><i class="fas fa-times-circle"></i> Error</h4>
                    <ul>
                        <li>{{ session('error') }}</li>
                    </ul>
                </div>
            @endif

            <form action="{{ route('png.update', $png->id) }}" method="POST" enctype="multipart/form-data" id="pngEditForm">
                @csrf
                @method('PUT')
                
                <!-- Modern Form Tabs -->
                <div class="form-tabs">
                    <button type="button" class="form-tab active" onclick="showTab('basic-info')">
                        <i class="fas fa-info-circle"></i> Basic Information
                    </button>
                    <button type="button" class="form-tab" onclick="showTab('technical-details')">
                        <i class="fas fa-cogs"></i> Technical Information
                    </button>
                    <button type="button" class="form-tab" onclick="showTab('measurements')">
                        <i class="fas fa-ruler-combined"></i> Dynamic Measurements
                    </button>
                    <button type="button" class="form-tab" onclick="showTab('files-documents')">
                        <i class="fas fa-folder-open"></i> Files & Documents
                    </button>
                </div>

                <!-- Basic Information Tab -->
                <div id="basic-info" class="tab-content active">
                    <div class="form-section-title">Basic Information (Excel Layout)</div>
                    
                    <div class="form-row">

                            <div class="form-group">
    <label class="form-label">Project</label>
    <select name="project_id" class="form-control @error('project_id') is-invalid @enderror">
        <option value="">Select Project</option>
        @foreach(\App\Models\Project::all() as $project)
            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                {{ $project->name }}
            </option>
        @endforeach
    </select>
    @error('project_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                        <div class="form-group">
                            <label class="form-label">Agreement Date</label>
                            <input type="date" name="agreement_date" class="form-control @error('agreement_date') is-invalid @enderror" value="{{ old('agreement_date', $png->agreement_date ? $png->agreement_date->format('Y-m-d') : '') }}">
                            @error('agreement_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Customer No</label>
                            <input type="text" name="customer_no" class="form-control @error('customer_no') is-invalid @enderror" value="{{ old('customer_no', $png->customer_no) }}">
                            @error('customer_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Order No</label>
                            <input type="text" name="service_order_no" class="form-control @error('service_order_no') is-invalid @enderror" value="{{ old('service_order_no', $png->service_order_no) }}">
                            @error('service_order_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Application No</label>
                            <input type="text" name="application_no" class="form-control @error('application_no') is-invalid @enderror" value="{{ old('application_no', $png->application_no) }}">
                            @error('application_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Name <span class="required">*</span></label>
                            <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name', $png->customer_name) }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Contact No</label>
                            <input type="text" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror" value="{{ old('contact_no', $png->contact_no) }}">
                            @error('contact_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $png->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Area</label>
                            <textarea name="area" rows="2" class="form-control @error('area') is-invalid @enderror">{{ old('area', $png->area) }}</textarea>

                            {{-- <select name="area" class="form-control @error('area') is-invalid @enderror">
                                <option value="">Select Area</option>
                                @foreach(\App\Models\Png::getAreaOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('area', $png->area) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select> --}}
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Scheme</label>
                            <select name="scheme" class="form-control @error('scheme') is-invalid @enderror">
                                <option value="">Select Scheme</option>
                                @foreach(\App\Models\Png::getSchemeOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('scheme', $png->scheme) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('scheme')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Technical Information Tab -->
                {{-- <div id="technical-details" class="tab-content">
                    <div class="form-section-title">Technical Information (Excel Layout)</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Connections Status</label>
                            <select name="connections_status" class="form-control @error('connections_status') is-invalid @enderror">
                                <option value="">Select Status</option>
                                @foreach(\App\Models\Png::getConnectionsStatusOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('connections_status', $png->connections_status) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('connections_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Plumber Name</label>
                            <input type="text" name="plumber_name" class="form-control @error('plumber_name') is-invalid @enderror" value="{{ old('plumber_name', $png->plb_name) }}">
                            @error('plumber_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Plumbing Date</label>
                            <input type="date" name="plumbing_date" class="form-control @error('plumbing_date') is-invalid @enderror" value="{{ old('plumbing_date', $png->plb_date ? $png->plb_date->format('Y-m-d') : '') }}">
                            @error('plumbing_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">PPT Date</label>
                            <input type="date" name="pdt_date" class="form-control @error('pdt_date') is-invalid @enderror" value="{{ old('pdt_date', $png->pdt_date ? $png->pdt_date->format('Y-m-d') : '') }}">
                            @error('pdt_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">PPT Witness By</label>
                            <input type="text" name="pdt_witness_by" class="form-control @error('pdt_witness_by') is-invalid @enderror" value="{{ old('pdt_witness_by', $png->pdt_witness_by) }}">
                            @error('pdt_witness_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Ground Connections Date</label>
                            <input type="date" name="ground_connections_date" class="form-control @error('ground_connections_date') is-invalid @enderror" value="{{ old('ground_connections_date', $png->ground_connections_date ? $png->ground_connections_date->format('Y-m-d') : '') }}">
                            @error('ground_connections_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Ground Connections Witness By</label>
                            <input type="text" name="ground_connections_witness_by" class="form-control @error('ground_connections_witness_by') is-invalid @enderror" value="{{ old('ground_connections_witness_by', $png->ground_connections_witness_by) }}">
                            @error('ground_connections_witness_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Isolation Name</label>
                            <input type="text" name="isolation_name" class="form-control @error('isolation_name') is-invalid @enderror" value="{{ old('isolation_name', $png->isolation_name) }}">
                            @error('isolation_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">MMT Date</label>
                            <input type="date" name="mmt_date" class="form-control @error('mmt_date') is-invalid @enderror" value="{{ old('mmt_date', $png->mmt_date ? $png->mmt_date->format('Y-m-d') : '') }}">
                            @error('mmt_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">MMT Witness By</label>
                            <input type="text" name="mmt_witness_by" class="form-control @error('mmt_witness_by') is-invalid @enderror" value="{{ old('mmt_witness_by', $png->mmt_witness_by) }}">
                            @error('mmt_witness_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Conversion Technician Name</label>
                            <input type="text" name="conversion_technician_name" class="form-control @error('conversion_technician_name') is-invalid @enderror" value="{{ old('conversion_technician_name', $png->conversion_technician_name) }}">
                            @error('conversion_technician_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Conversion Date</label>
                            <input type="date" name="conversion_date" class="form-control @error('conversion_date') is-invalid @enderror" value="{{ old('conversion_date', $png->conversion_date ? $png->conversion_date->format('Y-m-d') : '') }}">
                            @error('conversion_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Conversion Status</label>
                            <select name="conversion_status" class="form-control @error('conversion_status') is-invalid @enderror">
                                <option value="">Select Status</option>
                                @foreach(\App\Models\Png::getConversionStatusOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('conversion_status', $png->conversion_status) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('conversion_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Report Submission Date</label>
                            <input type="date" name="report_submission_date" class="form-control @error('report_submission_date') is-invalid @enderror" value="{{ old('report_submission_date', $png->report_submission_date ? $png->report_submission_date->format('Y-m-d') : '') }}">
                            @error('report_submission_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Meter Number</label>
                            <input type="text" name="meter_number" class="form-control @error('meter_number') is-invalid @enderror" value="{{ old('meter_number', $png->meter_number) }}">
                            @error('meter_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">RA Bill No</label>
                            <input type="text" name="ra_bill_no" class="form-control @error('ra_bill_no') is-invalid @enderror" value="{{ old('ra_bill_no', $png->ra_bill_no) }}">
                            @error('ra_bill_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $png->remarks) }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div> --}}

                <div id="technical-details" class="tab-content">
    <div class="form-section-title">Technical Information - Multi Step Process</div>
    
    <!-- Step Progress Indicator -->
    <div class="step-progress">
        <div class="step-item active" data-step="1">
            <div class="step-number">1</div>
            <div class="step-label">Connection</div>
        </div>
        <div class="step-item" data-step="2">
            <div class="step-number">2</div>
            <div class="step-label">PLB</div>
        </div>
        <div class="step-item" data-step="3">
            <div class="step-number">3</div>
            <div class="step-label">PPT</div>
        </div>
        <div class="step-item" data-step="4">
            <div class="step-number">4</div>
            <div class="step-label">GC</div>
        </div>
        <div class="step-item" data-step="5">
            <div class="step-number">5</div>
            <div class="step-label">MMT</div>
        </div>
        <div class="step-item" data-step="6">
            <div class="step-number">6</div>
            <div class="step-label">Conversion</div>
        </div>
    </div>

    <!-- Step Content Container -->
    <div class="multi-step-container">
        
        <!-- Step 1: Connection Information -->
        <div id="step-1" class="step-content active">
            <h4>Connection Information</h4>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Connections Status</label>
                    <select name="connections_status" class="form-control @error('connections_status') is-invalid @enderror">
                        <option value="">Select Status</option>
                        <option value="workable" {{ old('connections_status', $png->connections_status) == 'workable' ? 'selected' : '' }}>Workable</option>
                        <option value="not_workable" {{ old('connections_status', $png->connections_status) == 'not_workable' ? 'selected' : '' }}>Not Workable</option>
                        <option value="plb_done" {{ old('connections_status', $png->connections_status) == 'plb_done' ? 'selected' : '' }}>PLB Done</option>
                        <option value="pdt_pending" {{ old('connections_status', $png->connections_status) == 'pdt_pending' ? 'selected' : '' }}>PPT Pending</option>
                        <option value="gc_pending" {{ old('connections_status', $png->connections_status) == 'gc_pending' ? 'selected' : '' }}>GC Pending</option>
                        <option value="mmt_pending" {{ old('connections_status', $png->connections_status) == 'mmt_pending' ? 'selected' : '' }}>MMT Pending</option>
                        <option value="conv_pending" {{ old('connections_status', $png->connections_status) == 'conv_pending' ? 'selected' : '' }}>Conversion Pending</option>
                        <option value="comm" {{ old('connections_status', $png->connections_status) == 'comm' ? 'selected' : '' }}>Commissioned</option>
                        <option value="bill_pending" {{ old('connections_status', $png->connections_status) == 'bill_pending' ? 'selected' : '' }}>Bill Pending</option>
                        <option value="bill_received" {{ old('connections_status', $png->connections_status) == 'bill_received' ? 'selected' : '' }}>Bill Received</option>
                    </select>
                    @error('connections_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="step-navigation">
                <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next: PLB</button>
            </div>
        </div>

        <!-- Step 2: PLB Information -->
        <div id="step-2" class="step-content">
            <h4>PLB (Plumbing) Information</h4>
            
            <!-- PLB Applicable Checkbox -->
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="plb_applicable" name="plb_applicable" value="1" 
                           {{ ($png->plb_name || $png->plb_date) ? 'checked' : '' }} 
                           onchange="togglePlbFields()">
                    <label for="plb_applicable" class="checkbox-label">PLB Applicable</label>
                </div>
            </div>

            <!-- PLB Fields -->
            <div id="plb_fields" class="conditional-fields" style="display: {{ ($png->plb_name || $png->plb_date) ? 'block' : 'none' }};">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">PLB Name</label>
                        <input type="text" name="plb_name" class="form-control @error('plb_name') is-invalid @enderror" 
                               value="{{ old('plb_name', $png->plb_name) }}">
                        @error('plb_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">PLB Date</label>
                        <input type="date" name="plb_date" class="form-control @error('plb_date') is-invalid @enderror" 
                               value="{{ old('plb_date', $png->plb_date ? $png->plb_date->format('Y-m-d') : '') }}">
                        @error('plb_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Witness By</label>
                    <input type="text" name="plb_witness_by" class="form-control @error('plb_witness_by') is-invalid @enderror" 
                           value="{{ old('plb_witness_by', $png->plb_witness_by ?? '') }}">
                    @error('plb_witness_by')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="step-navigation">
                <button type="button" class="btn btn-secondary" onclick="prevStep(1)">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next: PPT</button>
            </div>
        </div>

        <!-- Step 3: PPT Information -->
        <div id="step-3" class="step-content">
            <h4>PPT (Pipe Pneumatic Testing) Information</h4>
            
            <!-- PPT Applicable Checkbox -->
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="pdt_applicable" name="pdt_applicable" value="1" 
                           {{ ($png->pdt_date || $png->pdt_tpi) ? 'checked' : '' }} 
                           onchange="togglePdtFields()">
                    <label for="pdt_applicable" class="checkbox-label">PPT Applicable</label>
                </div>
            </div>

            <!-- PPT Fields -->
            <div id="pdt_fields" class="conditional-fields" style="display: {{ ($png->pdt_date || $png->pdt_tpi) ? 'block' : 'none' }};">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">PPT Date</label>
                        <input type="date" name="pdt_date" class="form-control @error('pdt_date') is-invalid @enderror" 
                               value="{{ old('pdt_date', $png->pdt_date ? $png->pdt_date->format('Y-m-d') : '') }}">
                        @error('pdt_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">PPT TPI</label>
                        <input type="text" name="pdt_tpi" class="form-control @error('pdt_tpi') is-invalid @enderror" 
                               value="{{ old('pdt_tpi', $png->pdt_tpi) }}">
                        @error('pdt_tpi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Witness By</label>
                    <input type="text" name="pdt_witness_by" class="form-control @error('pdt_witness_by') is-invalid @enderror" 
                           value="{{ old('pdt_witness_by', $png->pdt_witness_by ?? '') }}">
                    @error('pdt_witness_by')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="step-navigation">
                <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep(4)">Next: GC</button>
            </div>
        </div>

        <!-- Step 4: GC Information -->
        <div id="step-4" class="step-content">
            <h4>GC (Ground Connection) Information</h4>
            
            <!-- GC Applicable Checkbox -->
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="gc_applicable" name="gc_applicable" value="1" 
                           {{ ($png->gc_date || $png->gc_tpi) ? 'checked' : '' }} 
                           onchange="toggleGcFields()">
                    <label for="gc_applicable" class="checkbox-label">GC Applicable</label>
                </div>
            </div>

            <!-- GC Fields -->
            <div id="gc_fields" class="conditional-fields" style="display: {{ ($png->gc_date || $png->gc_tpi) ? 'block' : 'none' }};">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">GC Date</label>
                        <input type="date" name="gc_date" class="form-control @error('gc_date') is-invalid @enderror" 
                               value="{{ old('gc_date', $png->gc_date ? $png->gc_date->format('Y-m-d') : '') }}">
                        @error('gc_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">GC TPI</label>
                        <input type="text" name="gc_tpi" class="form-control @error('gc_tpi') is-invalid @enderror" 
                               value="{{ old('gc_tpi', $png->gc_tpi) }}">
                        @error('gc_tpi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Witness By</label>
                    <input type="text" name="ground_connections_witness_by" class="form-control @error('ground_connections_witness_by') is-invalid @enderror" 
                           value="{{ old('ground_connections_witness_by', $png->ground_connections_witness_by) }}">
                    @error('ground_connections_witness_by')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="step-navigation">
                <button type="button" class="btn btn-secondary" onclick="prevStep(3)">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep(5)">Next: MMT</button>
            </div>
        </div>

        <!-- Step 5: MMT Information -->
        <div id="step-5" class="step-content">
            <h4>MMT (Meter Management Test) Information</h4>
            
            <!-- MMT Applicable Checkbox -->
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="mmt_applicable" name="mmt_applicable" value="1" 
                           {{ ($png->mmt_date || $png->mmt_tpi) ? 'checked' : '' }} 
                           onchange="toggleMmtFields()">
                    <label for="mmt_applicable" class="checkbox-label">MMT Applicable</label>
                </div>
            </div>

            <!-- MMT Fields -->
            <div id="mmt_fields" class="conditional-fields" style="display: {{ ($png->mmt_date || $png->mmt_tpi) ? 'block' : 'none' }};">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">MMT Date</label>
                        <input type="date" name="mmt_date" class="form-control @error('mmt_date') is-invalid @enderror" 
                               value="{{ old('mmt_date', $png->mmt_date ? $png->mmt_date->format('Y-m-d') : '') }}">
                        @error('mmt_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">MMT TPI</label>
                        <input type="text" name="mmt_tpi" class="form-control @error('mmt_tpi') is-invalid @enderror" 
                               value="{{ old('mmt_tpi', $png->mmt_tpi) }}">
                        @error('mmt_tpi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Witness By</label>
                    <input type="text" name="mmt_witness_by" class="form-control @error('mmt_witness_by') is-invalid @enderror" 
                           value="{{ old('mmt_witness_by', $png->mmt_witness_by) }}">
                    @error('mmt_witness_by')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="step-navigation">
                <button type="button" class="btn btn-secondary" onclick="prevStep(4)">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep(6)">Next: Conversion</button>
            </div>
        </div>

        <!-- Step 6: Conversion Information -->
        <div id="step-6" class="step-content">
            <h4>Conversion Information</h4>
            
            <div class="form-group">
                <label class="form-label">Conversion Status</label>
                <select name="conversion_status" class="form-control @error('conversion_status') is-invalid @enderror" onchange="toggleConversionFields()">
                    <option value="">Select Status</option>
                    <option value="pending" {{ old('conversion_status', $png->conversion_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('conversion_status', $png->conversion_status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="conv_done" {{ old('conversion_status', $png->conversion_status) == 'conv_done' ? 'selected' : '' }}>Conv Done</option>
                    <option value="comm" {{ old('conversion_status', $png->conversion_status) == 'comm' ? 'selected' : '' }}>Done</option>
                </select>
                @error('conversion_status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Conversion Done Fields (Only visible when status is "done") -->
            <div id="conversion_done_fields" class="conditional-fields" style="display: {{ old('conversion_status', $png->conversion_status) == 'done' ? 'block' : 'none' }};">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Conversion Technician Name <span class="required">*</span></label>
                        <input type="text" name="conversion_technician_name" class="form-control @error('conversion_technician_name') is-invalid @enderror" 
                               value="{{ old('conversion_technician_name', $png->conversion_technician_name) }}">
                        @error('conversion_technician_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Conversion Date <span class="required">*</span></label>
                        <input type="date" name="conversion_date" class="form-control @error('conversion_date') is-invalid @enderror" 
                               value="{{ old('conversion_date', $png->conversion_date ? $png->conversion_date->format('Y-m-d') : '') }}">
                        @error('conversion_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Technical Fields -->
            <div class="form-section-title" style="margin-top: 30px;">Additional Information</div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Meter Number</label>
                    <input type="text" name="meter_number" class="form-control @error('meter_number') is-invalid @enderror" 
                           value="{{ old('meter_number', $png->meter_number) }}">
                    @error('meter_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Meter Reading</label>
                    <input type="number" step="0.01" name="meter_reading" class="form-control @error('meter_reading') is-invalid @enderror" 
                           value="{{ old('meter_reading', $png->meter_reading) }}">
                    @error('meter_reading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">                
                <div class="form-group">
                    <label class="form-label">RA Bill No</label>
                    <input type="text" name="ra_bill_no" class="form-control @error('ra_bill_no') is-invalid @enderror" 
                           value="{{ old('ra_bill_no', $png->ra_bill_no) }}">
                    @error('ra_bill_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3">{{ old('remarks', $png->remarks) }}</textarea>
                @error('remarks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="step-navigation">
                <button type="button" class="btn btn-secondary" onclick="prevStep(5)">Previous</button>
                <button type="button" class="btn btn-success" onclick="completeTechnicalInfo()">Complete Technical Info</button>
            </div>
        </div>
    </div>
</div>

                <!-- Dynamic Measurements Tab -->
                <div id="measurements" class="tab-content">
                    <div class="form-section-title">Dynamic Measurements & Fittings</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">PNG Type</label>
                            <select name="png_type" id="png_type" class="form-control @error('png_type') is-invalid @enderror" onchange="loadMeasurementTypes()">
                                <option value="">Select PNG Type</option>
                                @foreach(\App\Models\PngMeasurementType::getPngTypeOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('png_type', $png->png_type) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('png_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Measurement Type</label>
                            <select name="png_measurement_type_id" id="measurement_type" class="form-control @error('png_measurement_type_id') is-invalid @enderror" onchange="loadMeasurementFields()">
                                <option value="">Select Measurement Type</option>
                                @if($png->measurementType)
                                    <option value="{{ $png->measurementType->id }}" selected>
                                        {{ $png->measurementType->name }}
                                    </option>
                                @endif
                            </select>
                            @error('png_measurement_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div id="measurement-fields-container" style="{{ $png->measurements_data ? 'display: block;' : 'display: none;' }}">
                        <!-- Dynamic measurement fields will be loaded here -->
                        @if($png->measurements_data && $png->measurementType)
                            <div class="measurement-category" id="current-measurements-display">
                                <h5>Current Measurements</h5>
                                <div class="form-row">
                                    @php
                                        // Group measurements by category based on field names
                                        $giMeasurements = [];
                                        $fittings = [];
                                        $other = [];
                                        
                                        foreach($png->measurements_data as $key => $value) {
                                            if (str_contains(strtolower($key), 'gi_') || str_contains(strtolower($key), 'gi ') || str_contains(strtolower($key), 'total')) {
                                                $giMeasurements[$key] = $value;
                                            } elseif (str_contains(strtolower($key), 'valve') || str_contains(strtolower($key), 'coupling') || str_contains(strtolower($key), 'fitting')) {
                                                $fittings[$key] = $value;
                                            } else {
                                                $other[$key] = $value;
                                            }
                                        }
                                    @endphp
                                    
                                    @if(count($giMeasurements) > 0)
                                        @foreach($giMeasurements as $key => $value)
                                            <div class="form-group">
                                                <label class="form-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                <input type="text" name="measurements[{{ $key }}]" class="form-control measurement-input" value="{{ $value }}" data-field-name="{{ $key }}">
                                            </div>
                                        @endforeach
                                    @endif
                                    
                                    @if(count($other) > 0)
                                        @foreach($other as $key => $value)
                                            <div class="form-group">
                                                <label class="form-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                <input type="text" name="measurements[{{ $key }}]" class="form-control measurement-input" value="{{ $value }}" data-field-name="{{ $key }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                @if(count($fittings) > 0)
                                    <h5 style="margin-top: 20px;">Fittings</h5>
                                    <div class="form-row">
                                        @foreach($fittings as $key => $value)
                                            <div class="form-group">
                                                <label class="form-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                <input type="text" name="measurements[{{ $key }}]" class="form-control measurement-input" value="{{ $value }}" data-field-name="{{ $key }}">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <small class="text-info">These measurements are editable. Change the measurement type above to load different measurement fields.</small>
                            </div>
                        @endif
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <button type="button" class="btn btn-info" onclick="window.open('{{ route('png-measurement-types.index') }}', '_blank')">
                                <i class="fas fa-cog"></i> Manage Measurement Types
                            </button>
                            @if($png->measurements_data)
                                <button type="button" class="btn btn-secondary ml-2" onclick="resetToCurrentMeasurements()">
                                    <i class="fas fa-undo"></i> Reset to Current Values
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Files & Documents Tab -->
                <div id="files-documents" class="tab-content">
                    <div class="form-section-title">Files & Documents</div>
                    
                    <div class="documents-grid">
                        <!-- Job Cards Section -->
                        <div class="document-section">
                            <div class="document-header">
                                <i class="fas fa-id-card document-icon"></i>
                                <h5>Job Cards</h5>
                            </div>
                            
                            @php
                                $files = is_string($png->job_cards_paths)
                                    ? json_decode($png->job_cards_paths, true)
                                    : $png->job_cards_paths;
                            @endphp

                            @if(!empty($files) && is_array($files))
                                <div class="existing-files-list">
                                    <div class="existing-files-title">Existing Files:</div>

                                    @foreach($files as $file)
                                        <div class="existing-file">
                                            <a href="{{ Storage::url($file['path']) }}" target="_blank">
                                                {{ $file['name'] ?? 'File' }}
                                            </a>
                                            <small>
                                                {{ isset($file['size']) ? number_format($file['size'] / 1024, 2) . ' KB' : '' }}
                                            </small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="document-upload-area">
                                <input type="file" name="job_cards[]" id="job_cards" class="file-input" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                <label for="job_cards" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose New Job Card Files</span>
                                    <small>Multiple files allowed (will be added to existing)</small>
                                </label>
                                <div class="file-preview" id="job_cards_preview"></div>
                            </div>
                            <div class="document-info">
                                <small class="text-muted">Accepted formats: PDF, JPG, PNG, DOC, DOCX (max: 5MB each)</small>
                            </div>
                        </div>

                        <!-- AutoCad DWG Section -->
                        <div class="document-section">
                            <div class="document-header">
                                <i class="fas fa-drafting-compass document-icon"></i>
                                <h5>AutoCad DWG</h5>
                            </div>
                            
                            @if($png->autocad_dwg_paths && count($png->autocad_dwg_paths) > 0)
                                <div class="existing-files-list">
                                    <div class="existing-files-title">Existing Files:</div>
                                    @foreach($png->autocad_dwg_paths as $file)
                                        <div class="existing-file">
                                            <a href="{{ Storage::url($file['path']) }}" target="_blank">{{ $file['name'] ?? 'File' }}</a>
                                            <small>{{ isset($file['size']) ? number_format($file['size']/1024, 2) . ' KB' : '' }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="document-upload-area">
                                <input type="file" name="autocad_dwg[]" id="autocad_dwg" class="file-input" multiple accept=".dwg,.dxf,.pdf">
                                <label for="autocad_dwg" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose New AutoCad Files</span>
                                    <small>Multiple files allowed (will be added to existing)</small>
                                </label>
                                <div class="file-preview" id="autocad_dwg_preview"></div>
                            </div>
                            <div class="document-info">
                                <small class="text-muted">Accepted formats: DWG, DXF, PDF (max: 10MB each)</small>
                            </div>
                        </div>

                        <!-- Site Visit Reports Section -->
                        <div class="document-section">
                            <div class="document-header">
                                <i class="fas fa-clipboard-list document-icon"></i>
                                <h5>Site Visit Reports</h5>
                            </div>
                            
                            @if($png->site_visit_reports_paths && count($png->site_visit_reports_paths) > 0)
                                <div class="existing-files-list">
                                    <div class="existing-files-title">Existing Files:</div>
                                    @foreach($png->site_visit_reports_paths as $file)
                                        <div class="existing-file">
                                            <a href="{{ Storage::url($file['path']) }}" target="_blank">{{ $file['name'] ?? 'File' }}</a>
                                            <small>{{ isset($file['size']) ? number_format($file['size']/1024, 2) . ' KB' : '' }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="document-upload-area">
                                <input type="file" name="site_visit_reports[]" id="site_visit_reports" class="file-input" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                <label for="site_visit_reports" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose New Report Files</span>
                                    <small>Multiple files allowed (will be added to existing)</small>
                                </label>
                                <div class="file-preview" id="site_visit_reports_preview"></div>
                            </div>
                            <div class="document-info">
                                <small class="text-muted">Accepted formats: PDF, JPG, PNG, DOC, DOCX (max: 5MB each)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Documents Section -->
                    <div class="form-section-title" style="margin-top: 30px;">Additional Documents</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Scan Copy</label>
                            @if($png->scan_copy_path)
                                <div class="existing-file">
                                    <a href="{{ Storage::url($png->scan_copy_path) }}" target="_blank">View Current Scan Copy</a>
                                </div>
                            @endif
                            <input type="file" name="scan_copy" class="form-control-file @error('scan_copy') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-file-info">Accepted formats: PDF, JPG, PNG (max: 5MB) - Upload new file to replace existing</div>
                            @error('scan_copy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Certificate</label>
                            @if($png->certificate_path)
                                <div class="existing-file">
                                    <a href="{{ Storage::url($png->certificate_path) }}" target="_blank">View Current Certificate</a>
                                </div>
                            @endif
                            <input type="file" name="certificate" class="form-control-file @error('certificate') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-file-info">Accepted formats: PDF, JPG, PNG (max: 5MB) - Upload new file to replace existing</div>
                            @error('certificate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">Other Documents</label>
                            @if($png->other_documents_paths && count($png->other_documents_paths) > 0)
                                <div class="existing-files-list">
                                    <div class="existing-files-title">Existing Files:</div>
                                    @foreach($png->other_documents_paths as $file)
                                        <div class="existing-file">
                                            <a href="{{ Storage::url($file['path']) }}" target="_blank">{{ $file['name'] ?? 'File' }}</a>
                                            <small>{{ isset($file['size']) ? number_format($file['size']/1024, 2) . ' KB' : '' }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <input type="file" name="other_documents[]" class="form-control-file @error('other_documents.*') is-invalid @enderror" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <div class="form-file-info">Multiple files allowed. Accepted formats: PDF, DOC, DOCX, JPG, PNG (max: 5MB each) - New files will be added to existing</div>
                            @error('other_documents.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">Additional Documents</label>
                            @php
    $files = is_string($png->additional_documents)
        ? json_decode($png->additional_documents, true)
        : $png->additional_documents;
@endphp

@if(is_array($files) && count($files))
    <div class="existing-files-list">
        <div class="existing-files-title">Existing Files:</div>

        @foreach($files as $file)
            @php
                // handle different storage formats
                $path = is_array($file)
                    ? ($file['path'] ?? $file['file'] ?? null)
                    : $file;
            @endphp

            @if($path)
                <div class="existing-file">
                    <a href="{{ Storage::url($path) }}" target="_blank">
                        {{ basename($path) }}
                    </a>

                    @if(is_array($file) && isset($file['size']))
                        <small>{{ number_format($file['size'] / 1024, 2) }} KB</small>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
@endif


                            <input type="file" name="additional_documents[]" class="form-control-file @error('additional_documents.*') is-invalid @enderror" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <div class="form-file-info">Multiple files allowed. Accepted formats: PDF, DOC, DOCX, JPG, PNG (max: 5MB each) - New files will be added to existing</div>
                            @error('additional_documents.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-actions" style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{ route('png.show', $png->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                    <div style="display: flex; gap: 10px;">
                        <button type="button" id="updateNextBtn" class="btn btn-primary" onclick="handleUpdateNext()">
                            <span id="btnText">Update & Next</span>
                            <i id="btnIcon" class="fas fa-arrow-right"></i>
                        </button>
                        <a href="{{ route('png.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Store existing measurements data for later use
    const existingMeasurements = @json($png->measurements_data ?? []);
    
    // Tab names in order for navigation
    const tabOrder = ['basic-info', 'technical-details', 'measurements', 'files-documents'];
    let currentTabIndex = 0;

    function showTab(tabName) {
        console.log('Attempting to show tab:', tabName);
        
        // Hide all tab contents
        const tabContents = document.querySelectorAll('.tab-content');
        console.log('Found tab contents:', tabContents.length);
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Remove active class from all tabs
        const tabs = document.querySelectorAll('.form-tab');
        tabs.forEach(tab => tab.classList.remove('active'));
        
        // Show selected tab content
        const targetTab = document.getElementById(tabName);
        console.log('Target tab element:', targetTab);
        
        if (targetTab) {
            targetTab.classList.add('active');
            console.log('Successfully activated tab:', tabName);
            
            // Update current tab index
            currentTabIndex = tabOrder.indexOf(tabName);
            if (currentTabIndex === -1) currentTabIndex = 0;
            
            // Update button state based on current tab
            updateButtonState();
        } else {
            console.error(`Tab with ID '${tabName}' not found`);
            // List all available tab content IDs for debugging
            const allTabContents = document.querySelectorAll('.tab-content');
            const availableIds = Array.from(allTabContents).map(tab => tab.id).filter(id => id);
            console.log('Available tab IDs:', availableIds);
            return;
        }
        
        // Add active class to clicked tab button
        const allTabButtons = document.querySelectorAll('.form-tab');
        allTabButtons.forEach((btn, index) => {
            if (index === currentTabIndex) {
                btn.classList.add('active');
            }
        });
    }

    // Update button text and icon based on current tab
    function updateButtonState() {
        const btnText = document.getElementById('btnText');
        const btnIcon = document.getElementById('btnIcon');
        const updateNextBtn = document.getElementById('updateNextBtn');
        
        if (currentTabIndex === tabOrder.length - 1) {
            // Last tab - show "Update PNG" with save icon
            btnText.textContent = 'Update PNG';
            btnIcon.className = 'fas fa-save';
            updateNextBtn.onclick = function() { submitForm(); };
        } else {
            // Other tabs - show "Update & Next" with arrow icon
            btnText.textContent = 'Update & Next';
            btnIcon.className = 'fas fa-arrow-right';
            updateNextBtn.onclick = function() { handleUpdateNext(); };
        }
    }

    // Define required fields for each tab
    const tabValidationRules = {
        'basic-info': [
            { name: 'service_order_no', label: 'Order No' },
            { name: 'customer_name', label: 'Customer Name' },
            { name: 'agreement_date', label: 'Agreement Date' }
        ],
        'technical-details': [], // No required fields in technical tab
        'measurements': [], // No required fields in measurements tab
        'files-documents': [] // No required fields in files tab
    };

    // Validate current tab fields
    function validateCurrentTab() {
        const currentTabName = tabOrder[currentTabIndex];
        const rules = tabValidationRules[currentTabName] || [];
        const errors = [];

        console.log('Validating tab:', currentTabName);
        console.log('Rules:', rules);

        rules.forEach(rule => {
            const field = document.querySelector('input[name="' + rule.name + '"], select[name="' + rule.name + '"], textarea[name="' + rule.name + '"]');
            console.log('Looking for field:', rule.name, 'Found:', field);
            
            if (field) {
                const value = field.value ? field.value.trim() : '';
                console.log('Field value:', value);
                
                if (!value || value === '') {
                    errors.push(rule.label + ' is required');
                    field.classList.add('is-invalid');
                    console.log('Field is invalid:', rule.name);
                } else {
                    field.classList.remove('is-invalid');
                    console.log('Field is valid:', rule.name);
                }
            } else {
                console.warn('Field not found:', rule.name);
            }
        });

        console.log('Validation errors:', errors);
        return errors;
    }

    // Show client-side validation errors
    function showClientValidationErrors(errors) {
        const alertBox = document.getElementById('clientValidationAlert');
        const errorList = document.getElementById('clientValidationErrors');
        
        // Clear previous errors
        errorList.innerHTML = '';
        
        // Add new errors
        errors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });
        
        // Show the alert box
        alertBox.style.display = 'block';
        
        // Scroll to the alert box
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Hide client-side validation errors
    function hideClientValidationErrors() {
        const alertBox = document.getElementById('clientValidationAlert');
        alertBox.style.display = 'none';
    }

    // Handle Update & Next button click
    function handleUpdateNext() {
        console.log('handleUpdateNext called');
        console.log('Current tab index:', currentTabIndex);
        
        // Validate current tab first
        const errors = validateCurrentTab();
        console.log('Errors found:', errors);
        
        if (errors.length > 0) {
            // Show errors and stay on current tab
            console.log('Showing validation errors');
            showClientValidationErrors(errors);
            return;
        }
        
        // Hide any previous validation errors
        hideClientValidationErrors();
        
        // Move to next tab if not on last tab
        if (currentTabIndex < tabOrder.length - 1) {
            const nextTabName = tabOrder[currentTabIndex + 1];
            console.log('Moving to next tab:', nextTabName);
            showTab(nextTabName);
            
            // Scroll to form top smoothly
            document.querySelector('.form-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            // On last tab, submit the form
            console.log('On last tab, submitting form');
            submitForm();
        }
    }

    // Submit the form
    function submitForm() {
        // Validate all tabs before submitting
        let allErrors = [];
        
        tabOrder.forEach((tabName, index) => {
            const rules = tabValidationRules[tabName] || [];
            rules.forEach(rule => {
                const field = document.querySelector(`[name="${rule.name}"]`);
                if (field) {
                    const value = field.value.trim();
                    if (!value) {
                        allErrors.push(`${rule.label} is required`);
                        field.classList.add('is-invalid');
                    }
                }
            });
        });
        
        if (allErrors.length > 0) {
            showClientValidationErrors(allErrors);
            return;
        }
        
        const form = document.getElementById('pngEditForm');
        if (form) {
            form.submit();
        }
    }

    function loadMeasurementTypes() {
        const pngType = document.getElementById('png_type').value;
        const measurementTypeSelect = document.getElementById('measurement_type');
        const currentMeasurementTypeId = '{{ $png->png_measurement_type_id }}';
        
        // Clear existing options except the currently selected one
        measurementTypeSelect.innerHTML = '<option value="">Select Measurement Type</option>';
        
        if (!pngType) {
            return;
        }

        // Fetch measurement types for selected PNG type
        fetch(`{{ route('png-measurement-types.get-by-png-type') }}?png_type=${pngType}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.id;
                    option.textContent = type.name;
                    if (type.description) {
                        option.title = type.description;
                    }
                    // Keep the current measurement type selected
                    if (type.id == currentMeasurementTypeId) {
                        option.selected = true;
                    }
                    measurementTypeSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading measurement types:', error);
            });
    }

    function loadMeasurementFields() {
        const measurementTypeId = document.getElementById('measurement_type').value;
        const container = document.getElementById('measurement-fields-container');
        
        if (!measurementTypeId) {
            // If no measurement type selected, show current measurements if they exist
            const currentDisplay = document.getElementById('current-measurements-display');
            if (currentDisplay) {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
            return;
        }

        // Fetch measurement fields for selected type
        fetch(`{{ url('admin/png-measurement-types') }}/${measurementTypeId}/fields`)
            .then(response => response.json())
            .then(data => {
                const fields = data.fields;
                let html = '';
                
                // Group fields by category
                const categories = {};
                fields.forEach(field => {
                    const category = field.category || 'general';
                    if (!categories[category]) {
                        categories[category] = [];
                    }
                    categories[category].push(field);
                });

                // Generate HTML for each category with proper styling like create form
                Object.keys(categories).forEach(categoryName => {
                    const categoryDisplayName = categoryName.charAt(0).toUpperCase() + categoryName.slice(1).replace('_', ' ');
                    
                    html += `
                        <div class="measurement-category">
                            <h5>${categoryDisplayName}</h5>
                            <div class="form-row">
                    `;
                    
                    categories[categoryName].forEach(field => {
                        const isCalculated = field.calculated || false;
                        const isRequired = field.required || false;
                        const unit = field.unit ? ` (${field.unit})` : '';
                        const existingValue = existingMeasurements[field.name] || '';
                        
                        html += `
                            <div class="form-group">
                                <label class="form-label">
                                    ${field.label}${unit}
                                    ${isRequired ? '<span class="required">*</span>' : ''}
                                </label>
                        `;
                        
                        if (field.type === 'select') {
                            html += `<select name="measurements[${field.name}]" class="form-control ${isCalculated ? 'calculated-field' : ''}" ${isRequired ? 'required' : ''} ${isCalculated ? 'readonly' : ''}>`;
                            html += `<option value="">Select ${field.label}</option>`;
                            if (field.options) {
                                field.options.forEach(option => {
                                    const selected = option === existingValue ? 'selected' : '';
                                    html += `<option value="${option}" ${selected}>${option}</option>`;
                                });
                            }
                            html += `</select>`;
                        } else if (field.type === 'textarea') {
                            html += `<textarea name="measurements[${field.name}]" rows="3" class="form-control ${isCalculated ? 'calculated-field' : ''}" ${isRequired ? 'required' : ''} ${isCalculated ? 'readonly' : ''}>${existingValue}</textarea>`;
                        } else {
                            const inputType = field.type === 'decimal' || field.type === 'number' ? 'number' : 'text';
                            const step = field.type === 'decimal' ? 'step="0.01"' : '';
                            const readonlyAttr = isCalculated ? 'readonly' : '';
                            html += `<input type="${inputType}" name="measurements[${field.name}]" value="${existingValue}" class="form-control ${isCalculated ? 'calculated-field' : ''} measurement-input" ${step} ${isRequired ? 'required' : ''} ${readonlyAttr} data-category="${categoryName}" data-calculated="${isCalculated}">`;
                        }
                        
                        if (isCalculated) {
                            html += `<small class="form-text text-muted">This field is auto-calculated</small>`;
                        }
                        
                        html += `</div>`;
                    });
                    
                    html += `
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;
                container.style.display = 'block';
                
                // Add event listeners for calculations
                addCalculationListeners();
            })
            .catch(error => {
                console.error('Error loading measurement fields:', error);
            });
    }

    function addCalculationListeners() {
        const inputs = document.querySelectorAll('.measurement-input');
        inputs.forEach(input => {
            input.addEventListener('input', calculateTotals);
        });
    }

    function calculateTotals() {
        // Calculate category totals
        const categories = {};
        const inputs = document.querySelectorAll('.measurement-input[data-calculated="false"]');
        
        inputs.forEach(input => {
            const category = input.dataset.category;
            const value = parseFloat(input.value) || 0;
            
            if (!categories[category]) {
                categories[category] = 0;
            }
            categories[category] += value;
        });

        // Update calculated fields
        const calculatedInputs = document.querySelectorAll('.measurement-input[data-calculated="true"]');
        calculatedInputs.forEach(input => {
            const category = input.dataset.category;
            if (categories[category] !== undefined) {
                input.value = categories[category].toFixed(2);
            }
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Load measurement types if PNG type is already selected
        const pngType = document.getElementById('png_type').value;
        if (pngType) {
            loadMeasurementTypes();
            
            // If measurement type is also selected, load the fields
            setTimeout(() => {
                const measurementTypeId = document.getElementById('measurement_type').value;
                if (measurementTypeId) {
                    loadMeasurementFields();
                } else {
                    // Add event listeners to existing measurement inputs if no specific type is selected
                    addCalculationListenersToExisting();
                }
            }, 500);
        } else {
            // Add event listeners to existing measurement inputs
            addCalculationListenersToExisting();
        }

        // Initialize file upload handlers
        initializeFileUploads();
    });

    function addCalculationListenersToExisting() {
        // Add event listeners to existing measurement inputs
        const existingInputs = document.querySelectorAll('.measurement-input');
        existingInputs.forEach(input => {
            input.addEventListener('input', function() {
                // Basic calculation logic for existing measurements
                console.log('Measurement changed:', input.dataset.fieldName, input.value);
                // You can add specific calculation logic here if needed
            });
        });
    }

    function resetToCurrentMeasurements() {
        const container = document.getElementById('measurement-fields-container');
        const currentMeasurements = @json($png->measurements_data ?? []);
        
        // Group measurements by category based on field names
        const giMeasurements = {};
        const fittings = {};
        const other = {};
        
        Object.keys(currentMeasurements).forEach(key => {
            const value = currentMeasurements[key];
            if (key.toLowerCase().includes('gi_') || key.toLowerCase().includes('gi ') || key.toLowerCase().includes('total')) {
                giMeasurements[key] = value;
            } else if (key.toLowerCase().includes('valve') || key.toLowerCase().includes('coupling') || key.toLowerCase().includes('fitting')) {
                fittings[key] = value;
            } else {
                other[key] = value;
            }
        });
        
        let html = `
            <div class="measurement-category" id="current-measurements-display">
                <h5>GI Measurements</h5>
                <div class="form-row">
        `;
        
        // Add GI measurements
        Object.keys(giMeasurements).forEach(key => {
            const value = giMeasurements[key];
            const label = key.charAt(0).toUpperCase() + key.slice(1).replace('_', ' ');
            
            html += `
                <div class="form-group">
                    <label class="form-label">${label}</label>
                    <input type="text" name="measurements[${key}]" class="form-control measurement-input" value="${value}" data-field-name="${key}">
                </div>
            `;
        });
        
        // Add other measurements
        Object.keys(other).forEach(key => {
            const value = other[key];
            const label = key.charAt(0).toUpperCase() + key.slice(1).replace('_', ' ');
            
            html += `
                <div class="form-group">
                    <label class="form-label">${label}</label>
                    <input type="text" name="measurements[${key}]" class="form-control measurement-input" value="${value}" data-field-name="${key}">
                </div>
            `;
        });
        
        html += `</div>`;
        
        // Add fittings section if there are any
        if (Object.keys(fittings).length > 0) {
            html += `
                <h5 style="margin-top: 20px;">Fittings</h5>
                <div class="form-row">
            `;
            
            Object.keys(fittings).forEach(key => {
                const value = fittings[key];
                const label = key.charAt(0).toUpperCase() + key.slice(1).replace('_', ' ');
                
                html += `
                    <div class="form-group">
                        <label class="form-label">${label}</label>
                        <input type="text" name="measurements[${key}]" class="form-control measurement-input" value="${value}" data-field-name="${key}">
                    </div>
                `;
            });
            
            html += `</div>`;
        }
        
        html += `
                <small class="text-info">These measurements are editable. Change the measurement type above to load different measurement fields.</small>
            </div>
        `;
        
        container.innerHTML = html;
        container.style.display = 'block';
        
        // Clear the measurement type selection
        document.getElementById('measurement_type').value = '';
        
        // Add event listeners
        addCalculationListenersToExisting();
    }

    function initializeFileUploads() {
        const fileInputs = document.querySelectorAll('.file-input');
        
        fileInputs.forEach(input => {
            input.addEventListener('change', function(e) {
                const files = e.target.files;
                const previewContainer = document.getElementById(input.id + '_preview');
                
                if (previewContainer) {
                    updateFilePreview(files, previewContainer);
                }
            });
        });
    }

    function updateFilePreview(files, container) {
        container.innerHTML = '';
        
        Array.from(files).forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-preview-item';
            
            fileItem.innerHTML = `
                <div class="file-name">${file.name}</div>
                <div class="file-size">${formatFileSize(file.size)}</div>
                <button type="button" class="remove-file" onclick="removeFileFromPreview(this, ${index})">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            container.appendChild(fileItem);
        });
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function removeFileFromPreview(button, index) {
        const fileItem = button.closest('.file-preview-item');
        fileItem.remove();
        
        // Note: Removing individual files from input requires special handling
        // For now, we just remove the preview item
    }

    function debugFormSubmission(event) {
        console.log('Form is being submitted...');
        
        // Check if form is valid
        const form = event.target;
        const formData = new FormData(form);
        
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);
        
        // Log all form data
        console.log('Form data:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ':', value);
        }
        
        // Don't prevent submission, just log for debugging
        return true;
    }

    function nextStep(stepNumber) {
    // Hide current step
    document.querySelectorAll('.step-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Show next step
    document.getElementById('step-' + stepNumber).classList.add('active');
    
    // Update progress indicator
    updateStepProgress(stepNumber);
}

function prevStep(stepNumber) {
    // Hide current step
    document.querySelectorAll('.step-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Show previous step
    document.getElementById('step-' + stepNumber).classList.add('active');
    
    // Update progress indicator
    updateStepProgress(stepNumber);
}

function updateStepProgress(activeStep) {
    document.querySelectorAll('.step-item').forEach((item, index) => {
        const stepNum = index + 1;
        item.classList.remove('active', 'completed');
        
        if (stepNum === activeStep) {
            item.classList.add('active');
        } else if (stepNum < activeStep) {
            item.classList.add('completed');
        }
    });
}

function completeTechnicalInfo() {
    alert('Technical Information completed! You can now proceed to other tabs.');
}

// Toggle Functions for Conditional Fields
function togglePlbFields() {
    const checkbox = document.getElementById('plb_applicable');
    const fields = document.getElementById('plb_fields');
    
    if (checkbox.checked) {
        fields.style.display = 'block';
    } else {
        fields.style.display = 'none';
        // Clear fields when hidden
        fields.querySelectorAll('input').forEach(input => input.value = '');
    }
}

function togglePdtFields() {
    const checkbox = document.getElementById('pdt_applicable');
    const fields = document.getElementById('pdt_fields');
    
    if (checkbox.checked) {
        fields.style.display = 'block';
    } else {
        fields.style.display = 'none';
        // Clear fields when hidden
        fields.querySelectorAll('input').forEach(input => input.value = '');
    }
}

function toggleGcFields() {
    const checkbox = document.getElementById('gc_applicable');
    const fields = document.getElementById('gc_fields');
    
    if (checkbox.checked) {
        fields.style.display = 'block';
    } else {
        fields.style.display = 'none';
        // Clear fields when hidden
        fields.querySelectorAll('input').forEach(input => input.value = '');
    }
}

function toggleMmtFields() {
    const checkbox = document.getElementById('mmt_applicable');
    const fields = document.getElementById('mmt_fields');
    
    if (checkbox.checked) {
        fields.style.display = 'block';
    } else {
        fields.style.display = 'none';
        // Clear fields when hidden
        fields.querySelectorAll('input').forEach(input => input.value = '');
    }
}

function toggleConversionFields() {
    const statusSelect = document.querySelector('select[name="conversion_status"]');
    const conversionFields = document.getElementById('conversion_done_fields');
    
    if (statusSelect.value === 'done') {
        conversionFields.style.display = 'block';
        // Make fields required when visible
        conversionFields.querySelectorAll('input[name="conversion_technician_name"], input[name="conversion_date"]').forEach(input => {
            input.setAttribute('required', 'required');
        });
    } else {
        conversionFields.style.display = 'none';
        // Remove required attribute and clear values when hidden
        conversionFields.querySelectorAll('input').forEach(input => {
            input.removeAttribute('required');
            input.value = '';
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial step
    updateStepProgress(1);
    
    // Check existing values and toggle fields accordingly
    if (document.getElementById('plb_applicable').checked) {
        togglePlbFields();
    }
    if (document.getElementById('pdt_applicable').checked) {
        togglePdtFields();
    }
    if (document.getElementById('gc_applicable').checked) {
        toggleGcFields();
    }
    if (document.getElementById('mmt_applicable').checked) {
        toggleMmtFields();
    }
    
    // Check conversion status
    toggleConversionFields();
});
</script>
@endsection
