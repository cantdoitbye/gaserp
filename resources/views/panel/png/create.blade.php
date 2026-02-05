@extends('panel.layouts.app')

@section('title', 'Add New PNG Job')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
/* ==========================================
   MODERN UI STYLES - PNG CREATE FORM
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

.document-info {
    text-align: center;
}

.form-file-info {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 6px;
}

/* Auto-calculation styling */
.measurement-input {
    transition: background-color 0.3s ease;
}

.measurement-input:focus {
    background-color: #fff3cd;
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    color: #1e293b;
    font-weight: 700;
}

.section-header::before {
    content: "📏";
    margin-right: 8px;
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

    <h1 class="page-title">Add New PNG Job</h1>

    <div class="form-card">
        <div class="form-header">
            New PNG Job Order Details - Excel Fields Layout
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

            {{-- Client-side Validation Alert (Hidden by default) --}}
            <div class="validation-alert" id="clientValidationAlert" style="display: none;">
                <button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
                <h4><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h4>
                <ul id="clientValidationErrors"></ul>
            </div>

            <form action="{{ route('png.store') }}" method="POST" enctype="multipart/form-data" id="pngCreateForm" novalidate>
                @csrf
                
                <!-- Modern Form Tabs -->
                <div class="form-tabs">
                    <button type="button" class="form-tab active" onclick="showTab('basic-info')">
                        <i class="fas fa-info-circle"></i> Basic Information
                    </button>
                    <button type="button" class="form-tab" onclick="showTab('location-details')">
                        <i class="fas fa-map-marker-alt"></i> Location & Details
                    </button>
                    <button type="button" class="form-tab" onclick="showTab('technical-info')">
                        <i class="fas fa-cogs"></i> Technical Information
                    </button>
                    <button type="button" class="form-tab" onclick="showTab('measurements')">
                        <i class="fas fa-ruler-combined"></i> Measurements & Fittings
                    </button>
                    <button type="button" class="form-tab" onclick="showTab('files-documents')">
                        <i class="fas fa-folder-open"></i> Files & Documents
                    </button>
                </div>

                <!-- Basic Information Tab -->
                <div id="basic-info" class="tab-content active">
                    <div class="form-section-title">Basic Information</div>
                    
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
                            <label class="form-label">PO Number</label>
                            <input type="text" name="po_number" class="form-control @error('po_number') is-invalid @enderror" value="{{ old('po_number') }}">
                            @error('po_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Service Order No <span class="required">*</span></label>
                            <input type="text" name="service_order_no" class="form-control @error('service_order_no') is-invalid @enderror" value="{{ old('service_order_no') }}" required>
                            @error('service_order_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Agreement Date <span class="required">*</span></label>
                            <input type="text" name="agreement_date" class="form-control datepicker-input @error('agreement_date') is-invalid @enderror" value="{{ old('agreement_date') }}" placeholder="dd-mm-yyyy" required>
                            @error('agreement_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Booking By</label>
                            <select name="booking_by" class="form-control @error('booking_by') is-invalid @enderror">
                                <option value="">Select Booking Method</option>
                                @foreach(\App\Models\Png::getBookingByOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('booking_by') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('booking_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Start Date</label>
                            <input type="text" name="start_date" class="form-control datepicker-input @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" placeholder="dd-mm-yyyy">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Activity Type</label>
                            <select name="plan_type" class="form-control @error('plan_type') is-invalid @enderror">
                                <option value="">Select Activity Type</option>
                                @foreach(\App\Models\Png::getPlanTypeOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('plan_type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('plan_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Customer Name <span class="required">*</span></label>
                            <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Customer No</label>
                            <input type="text" name="customer_no" class="form-control @error('customer_no') is-invalid @enderror" value="{{ old('customer_no') }}">
                            @error('customer_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Application No</label>
                            <input type="text" name="application_no" class="form-control @error('application_no') is-invalid @enderror" value="{{ old('application_no') }}">
                            @error('application_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Notification Numbers</label>
                            <input type="text" name="notification_numbers" class="form-control @error('notification_numbers') is-invalid @enderror" value="{{ old('notification_numbers') }}">
                            @error('notification_numbers')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Location & Details Tab -->
                <div id="location-details" class="tab-content">
                    <div class="form-section-title">Location & Customer Details</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">House No</label>
                            <input type="text" name="house_no" class="form-control @error('house_no') is-invalid @enderror" value="{{ old('house_no') }}">
                            @error('house_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Customer Contact No</label>
                            <input type="text" name="customer_contact_no" class="form-control @error('customer_contact_no') is-invalid @enderror" value="{{ old('customer_contact_no') }}">
                            @error('customer_contact_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Street 1</label>
                            <input type="text" name="street_1" class="form-control @error('street_1') is-invalid @enderror" value="{{ old('street_1') }}">
                            @error('street_1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Street 2</label>
                            <input type="text" name="street_2" class="form-control @error('street_2') is-invalid @enderror" value="{{ old('street_2') }}">
                            @error('street_2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Street 3</label>
                            <input type="text" name="street_3" class="form-control @error('street_3') is-invalid @enderror" value="{{ old('street_3') }}">
                            @error('street_3')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Street 4</label>
                            <input type="text" name="street_4" class="form-control @error('street_4') is-invalid @enderror" value="{{ old('street_4') }}">
                            @error('street_4')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Geyser Point</label>
                            <input type="number" name="geyser_point" class="form-control @error('geyser_point') is-invalid @enderror" value="{{ old('geyser_point') }}">
                            @error('geyser_point')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Extra Kitchen</label>
                            <input type="number" name="extra_kitchen" class="form-control @error('extra_kitchen') is-invalid @enderror" value="{{ old('extra_kitchen') }}">
                            @error('extra_kitchen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">SLA Days</label>
                            <input type="number" name="sla_days" class="form-control @error('sla_days') is-invalid @enderror" value="{{ old('sla_days') }}">
                            @error('sla_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Connections Status</label>
                            <select name="connections_status" class="form-control @error('connections_status') is-invalid @enderror">
                                <option value="">Select Status</option>
                                @foreach(\App\Models\Png::getConnectionsStatusOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('connections_status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('connections_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Technical Information Tab -->
                {{-- <div id="technical-info" class="tab-content">
                    <div class="form-section-title">Technical Information & Dates</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">PLB Name</label>
                            <input type="text" name="plb_name" class="form-control @error('plb_name') is-invalid @enderror" value="{{ old('plb_name') }}">
                            @error('plb_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">PLB Date</label>
                            <input type="date" name="plb_date" class="form-control @error('plb_date') is-invalid @enderror" value="{{ old('plb_date') }}">
                            @error('plb_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">PPT Date</label>
                            <input type="date" name="pdt_date" class="form-control @error('pdt_date') is-invalid @enderror" value="{{ old('pdt_date') }}">
                            @error('pdt_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">PPT TPI</label>
                            <input type="text" name="pdt_tpi" class="form-control @error('pdt_tpi') is-invalid @enderror" value="{{ old('pdt_tpi') }}">
                            @error('pdt_tpi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">GC Date</label>
                            <input type="date" name="gc_date" class="form-control @error('gc_date') is-invalid @enderror" value="{{ old('gc_date') }}">
                            @error('gc_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">GC TPI</label>
                            <input type="text" name="gc_tpi" class="form-control @error('gc_tpi') is-invalid @enderror" value="{{ old('gc_tpi') }}">
                            @error('gc_tpi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">MMT Date</label>
                            <input type="date" name="mmt_date" class="form-control @error('mmt_date') is-invalid @enderror" value="{{ old('mmt_date') }}">
                            @error('mmt_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">MMT TPI</label>
                            <input type="text" name="mmt_tpi" class="form-control @error('mmt_tpi') is-invalid @enderror" value="{{ old('mmt_tpi') }}">
                            @error('mmt_tpi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Conversion Date</label>
                            <input type="date" name="conversion_date" class="form-control @error('conversion_date') is-invalid @enderror" value="{{ old('conversion_date') }}">
                            @error('conversion_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Conversion Technician</label>
                            <input type="text" name="conversion_technician" class="form-control @error('conversion_technician') is-invalid @enderror" value="{{ old('conversion_technician') }}">
                            @error('conversion_technician')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Conversion Payment</label>
                            <input type="number" step="0.01" name="conversion_payment" class="form-control @error('conversion_payment') is-invalid @enderror" value="{{ old('conversion_payment') }}">
                            @error('conversion_payment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Meter Number</label>
                            <input type="text" name="meter_number" class="form-control @error('meter_number') is-invalid @enderror" value="{{ old('meter_number') }}">
                            @error('meter_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Meter Reading</label>
                            <input type="number" step="0.01" name="meter_reading" class="form-control @error('meter_reading') is-invalid @enderror" value="{{ old('meter_reading') }}">
                            @error('meter_reading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Plumber</label>
                            <input type="text" name="plumber" class="form-control @error('plumber') is-invalid @enderror" value="{{ old('plumber') }}">
                            @error('plumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Witnesses Name & Date</label>
                            <input type="text" name="witnesses_name_date" class="form-control @error('witnesses_name_date') is-invalid @enderror" value="{{ old('witnesses_name_date') }}">
                            @error('witnesses_name_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Witnesses Name & Date 2</label>
                            <input type="text" name="witnesses_name_date_2" class="form-control @error('witnesses_name_date_2') is-invalid @enderror" value="{{ old('witnesses_name_date_2') }}">
                            @error('witnesses_name_date_2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Reported</label>
                            <select name="reported" class="form-control @error('reported') is-invalid @enderror">
                                <option value="">Select Status</option>
                                @foreach(\App\Models\Png::getReportedOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('reported') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('reported')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Date of Report</label>
                            <input type="date" name="date_of_report" class="form-control @error('date_of_report') is-invalid @enderror" value="{{ old('date_of_report') }}">
                            @error('date_of_report')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">Current Remarks</label>
                            <textarea name="current_remarks" rows="3" class="form-control @error('current_remarks') is-invalid @enderror">{{ old('current_remarks') }}</textarea>
                            @error('current_remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">Previous Remarks</label>
                            <textarea name="previous_remarks" rows="3" class="form-control @error('previous_remarks') is-invalid @enderror">{{ old('previous_remarks') }}</textarea>
                            @error('previous_remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div> --}}

                <!-- Technical Information Tab with Multi-Step -->
<div id="technical-info" class="tab-content">
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
                        <option value="workable" {{ old('connections_status') == 'workable' ? 'selected' : '' }}>Workable</option>
                        <option value="not_workable" {{ old('connections_status') == 'not_workable' ? 'selected' : '' }}>Not Workable</option>
                        <option value="plb_done" {{ old('connections_status') == 'plb_done' ? 'selected' : '' }}>PLB Done</option>
                        <option value="pdt_pending" {{ old('connections_status') == 'pdt_pending' ? 'selected' : '' }}>PPT Pending</option>
                        <option value="gc_pending" {{ old('connections_status') == 'gc_pending' ? 'selected' : '' }}>GC Pending</option>
                        <option value="mmt_pending" {{ old('connections_status') == 'mmt_pending' ? 'selected' : '' }}>MMT Pending</option>
                        <option value="conv_pending" {{ old('connections_status') == 'conv_pending' ? 'selected' : '' }}>Conversion Pending</option>
                        <option value="comm" {{ old('connections_status') == 'comm' ? 'selected' : '' }}>Commissioned</option>
                        <option value="bill_pending" {{ old('connections_status') == 'bill_pending' ? 'selected' : '' }}>Bill Pending</option>
                        <option value="bill_received" {{ old('connections_status') == 'bill_received' ? 'selected' : '' }}>Bill Received</option>
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
                    <input type="checkbox" id="plb_applicable" name="plb_applicable" value="1" onchange="togglePlbFields()">
                    <label for="plb_applicable" class="checkbox-label">PLB Applicable</label>
                </div>
            </div>

            <!-- PLB Fields (Initially Hidden) -->
            <div id="plb_fields" class="conditional-fields" style="display: none;">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">PLB Name</label>
                        <input type="text" name="plb_name" class="form-control @error('plb_name') is-invalid @enderror" value="{{ old('plb_name') }}">
                        @error('plb_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">PLB Date</label>
                        <input type="text" name="plb_date" class="form-control datepicker-input @error('plb_date') is-invalid @enderror" value="{{ old('plb_date') }}" placeholder="dd-mm-yyyy">
                        @error('plb_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Witness By</label>
                    <input type="text" name="plb_witness_by" class="form-control @error('plb_witness_by') is-invalid @enderror" value="{{ old('plb_witness_by') }}">
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
                    <input type="checkbox" id="pdt_applicable" name="pdt_applicable" value="1" onchange="togglePdtFields()">
                    <label for="pdt_applicable" class="checkbox-label">PPT Applicable</label>
                </div>
            </div>

            <!-- PPT Fields (Initially Hidden) -->
            <div id="pdt_fields" class="conditional-fields" style="display: none;">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">PPT Date</label>
                        <input type="text" name="pdt_date" class="form-control datepicker-input @error('pdt_date') is-invalid @enderror" value="{{ old('pdt_date') }}" placeholder="dd-mm-yyyy">
                        @error('pdt_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">PPT TPI</label>
                        <input type="text" name="pdt_tpi" class="form-control @error('pdt_tpi') is-invalid @enderror" value="{{ old('pdt_tpi') }}">
                        @error('pdt_tpi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Witness By</label>
                    <input type="text" name="pdt_witness_by" class="form-control @error('pdt_witness_by') is-invalid @enderror" value="{{ old('pdt_witness_by') }}">
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
                    <input type="checkbox" id="gc_applicable" name="gc_applicable" value="1" onchange="toggleGcFields()">
                    <label for="gc_applicable" class="checkbox-label">GC Applicable</label>
                </div>
            </div>

            <!-- GC Fields (Initially Hidden) -->
            <div id="gc_fields" class="conditional-fields" style="display: none;">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">GC Date</label>
                        <input type="text" name="gc_date" class="form-control datepicker-input @error('gc_date') is-invalid @enderror" value="{{ old('gc_date') }}" placeholder="dd-mm-yyyy">
                        @error('gc_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">GC TPI</label>
                        <input type="text" name="gc_tpi" class="form-control @error('gc_tpi') is-invalid @enderror" value="{{ old('gc_tpi') }}">
                        @error('gc_tpi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Witness By</label>
                    <input type="text" name="ground_connections_witness_by" class="form-control @error('ground_connections_witness_by') is-invalid @enderror" value="{{ old('ground_connections_witness_by') }}">
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
                    <input type="checkbox" id="mmt_applicable" name="mmt_applicable" value="1" onchange="toggleMmtFields()">
                    <label for="mmt_applicable" class="checkbox-label">MMT Applicable</label>
                </div>
            </div>

            <!-- MMT Fields (Initially Hidden) -->
            <div id="mmt_fields" class="conditional-fields" style="display: none;">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">MMT Date</label>
                        <input type="text" name="mmt_date" class="form-control datepicker-input @error('mmt_date') is-invalid @enderror" value="{{ old('mmt_date') }}" placeholder="dd-mm-yyyy">
                        @error('mmt_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">MMT TPI</label>
                        <input type="text" name="mmt_tpi" class="form-control @error('mmt_tpi') is-invalid @enderror" value="{{ old('mmt_tpi') }}">
                        @error('mmt_tpi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Witness By</label>
                    <input type="text" name="mmt_witness_by" class="form-control @error('mmt_witness_by') is-invalid @enderror" value="{{ old('mmt_witness_by') }}">
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
                <label class="form-label">Conversion Status <span class="required">*</span></label>
                <select name="conversion_status" class="form-control @error('conversion_status') is-invalid @enderror" onchange="toggleConversionFields()" required>
                    <option value="">Select Status</option>
                    <option value="pending" {{ old('conversion_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('conversion_status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="conv_done" {{ old('conversion_status') == 'conv_done' ? 'selected' : '' }}>Conv Done</option>
                    <option value="comm" {{ old('conversion_status') == 'comm' ? 'selected' : '' }}>Done</option>
                </select>
                @error('conversion_status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Conversion Done Fields (Only visible when status is "done") -->
            <div id="conversion_done_fields" class="conditional-fields" style="display: none;">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Conversion Technician Name <span class="required">*</span></label>
                        <input type="text" name="conversion_technician_name" class="form-control @error('conversion_technician_name') is-invalid @enderror" value="{{ old('conversion_technician_name') }}">
                        @error('conversion_technician_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Conversion Date <span class="required">*</span></label>
                        <input type="text" name="conversion_date" class="form-control datepicker-input @error('conversion_date') is-invalid @enderror" value="{{ old('conversion_date') }}" placeholder="dd-mm-yyyy">
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
                    <input type="text" name="meter_number" class="form-control @error('meter_number') is-invalid @enderror" value="{{ old('meter_number') }}">
                    @error('meter_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Meter Reading</label>
                    <input type="number" step="0.01" name="meter_reading" class="form-control @error('meter_reading') is-invalid @enderror" value="{{ old('meter_reading') }}">
                    @error('meter_reading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                
                <div class="form-group">
                    <label class="form-label">RA Bill No</label>
                    <input type="text" name="ra_bill_no" class="form-control @error('ra_bill_no') is-invalid @enderror" value="{{ old('ra_bill_no') }}">
                    @error('ra_bill_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3">{{ old('remarks') }}</textarea>
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

                <!-- Measurements & Fittings Tab -->
                <div id="measurements" class="tab-content">
                    <div class="form-section-title">Measurements & Fittings (Excel Fields)</div>
                    
                    <!-- GI (Galvanized Iron) Measurements Section -->
                    <div class="measurement-category">
                        <h5 class="section-header">GI (Galvanized Iron) Measurements</h5>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">GI Guard to Main Valve 1/2"</label>
                                <input type="number" step="0.01" name="gi_guard_to_main_valve_half_inch" class="form-control measurement-input" value="{{ old('gi_guard_to_main_valve_half_inch') }}" onchange="calculateTotalGi()">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">GI Main Valve to Meter 1/2"</label>
                                <input type="number" step="0.01" name="gi_main_valve_to_meter_half_inch" class="form-control measurement-input" value="{{ old('gi_main_valve_to_meter_half_inch') }}" onchange="calculateTotalGi()">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">GI Meter to Geyser 1/2"</label>
                                <input type="number" step="0.01" name="gi_meter_to_geyser_half_inch" class="form-control measurement-input" value="{{ old('gi_meter_to_geyser_half_inch') }}" onchange="calculateTotalGi()">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">GI Geyser Point 1/2"</label>
                                <input type="number" step="0.01" name="gi_geyser_point_half_inch" class="form-control measurement-input" value="{{ old('gi_geyser_point_half_inch') }}" onchange="calculateTotalGi()">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Extra Kitchen Point</label>
                                <input type="number" step="0.01" name="extra_kitchen_point" class="form-control measurement-input" value="{{ old('extra_kitchen_point') }}" onchange="calculateTotalGi()">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Total GI</label>
                                <input type="number" step="0.01" name="total_gi" id="total_gi" class="form-control calculated-field" value="{{ old('total_gi') }}" readonly>
                                <small class="form-text text-muted">Auto-calculated from above fields</small>
                            </div>
                        </div>
                    </div>

                    <!-- Regulators and Components Section -->
                    <div class="measurement-category">
                        <h5 class="section-header">Regulators and Components</h5>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">High Press 1.6 Reg</label>
                                <input type="number" name="high_press_1_6_reg" class="form-control" value="{{ old('high_press_1_6_reg') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Low Press 2.5 Reg</label>
                                <input type="number" name="low_press_2_5_reg" class="form-control" value="{{ old('low_press_2_5_reg') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Reg Qty</label>
                                <input type="number" name="reg_qty" class="form-control" value="{{ old('reg_qty') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Gas Tap</label>
                                <input type="number" name="gas_tap" class="form-control" value="{{ old('gas_tap') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Valve 1/2"</label>
                                <input type="number" name="valve_half_inch" class="form-control" value="{{ old('valve_half_inch') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">GI Coupling 1/2"</label>
                                <input type="number" name="gi_coupling_half_inch" class="form-control" value="{{ old('gi_coupling_half_inch') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">GI Elbow 1/2"</label>
                                <input type="number" name="gi_elbow_half_inch" class="form-control" value="{{ old('gi_elbow_half_inch') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Clamp 1/2"</label>
                                <input type="number" name="clamp_half_inch" class="form-control" value="{{ old('clamp_half_inch') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">GI Tee 1/2"</label>
                                <input type="number" name="gi_tee_half_inch" class="form-control" value="{{ old('gi_tee_half_inch') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Anaconda</label>
                                <input type="number" name="anaconda" class="form-control" value="{{ old('anaconda') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Pipe and Excavation Section -->
                    <div class="measurement-category">
                        <h5 class="section-header">Pipe and Excavation</h5>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Open Cut 20mm</label>
                                <input type="number" step="0.01" name="open_cut_20mm" class="form-control pipe-input" value="{{ old('open_cut_20mm') }}" onchange="calculateTotalMdpe()">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Boring 20mm</label>
                                <input type="number" step="0.01" name="boring_20mm" class="form-control pipe-input" value="{{ old('boring_20mm') }}" onchange="calculateTotalMdpe()">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Total MDPE Pipe 20mm</label>
                                <input type="number" step="0.01" name="total_mdpe_pipe_20mm" id="total_mdpe_pipe_20mm" class="form-control calculated-field" value="{{ old('total_mdpe_pipe_20mm') }}" readonly>
                                <small class="form-text text-muted">Auto-calculated (Open Cut + Boring)</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Tee 20mm</label>
                                <input type="number" name="tee_20mm" class="form-control" value="{{ old('tee_20mm') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">RCC Guard 20mm</label>
                                <input type="number" name="rcc_guard_20mm" class="form-control" value="{{ old('rcc_guard_20mm') }}">
                            </div>
                        </div>
                    </div>

                    <!-- GF (Gas Fittings) Components Section -->
                    <div class="measurement-category">
                        <h5 class="section-header">GF (Gas Fittings) Components</h5>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">GF Coupler 20mm</label>
                                <input type="number" name="gf_coupler_20mm" class="form-control" value="{{ old('gf_coupler_20mm') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">GF Saddle 32x20mm</label>
                                <input type="number" name="gf_saddle_32x20mm" class="form-control" value="{{ old('gf_saddle_32x20mm') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">GF Saddle 63x20mm</label>
                                <input type="number" name="gf_saddle_63x20mm" class="form-control" value="{{ old('gf_saddle_63x20mm') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">GF Saddle 63x32mm</label>
                                <input type="number" name="gf_saddle_63x32mm" class="form-control" value="{{ old('gf_saddle_63x32mm') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">GF Saddle 125x32</label>
                                <input type="number" name="gf_saddle_125x32" class="form-control" value="{{ old('gf_saddle_125x32') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">GF Saddle 90x20mm</label>
                                <input type="number" name="gf_saddle_90x20mm" class="form-control" value="{{ old('gf_saddle_90x20mm') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">GF Reducer 32x20mm</label>
                                <input type="number" name="gf_reducer_32x20mm" class="form-control" value="{{ old('gf_reducer_32x20mm') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Administrative Section -->
                    <div class="measurement-category">
                        <h5 class="section-header">Administrative & Claims</h5>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">NEPL Claim</label>
                                <input type="text" name="nepl_claim" class="form-control" value="{{ old('nepl_claim') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Offline Drawing</label>
                                <select name="offline_drawing" class="form-control">
                                    <option value="">Select Status</option>
                                    @foreach(\App\Models\Png::getOfflineDrawingOptions() as $key => $value)
                                        <option value="{{ $key }}" {{ old('offline_drawing') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">GC Done By</label>
                                <input type="text" name="gc_done_by" class="form-control" value="{{ old('gc_done_by') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">V Lookup</label>
                                <input type="text" name="v_lookup" class="form-control" value="{{ old('v_lookup') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">RA Bill No</label>
                                <input type="text" name="ra_bill_no" class="form-control" value="{{ old('ra_bill_no') }}">
                            </div>
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
                            <div class="document-upload-area">
                                <input type="file" name="job_cards[]" id="job_cards" class="file-input" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                <label for="job_cards" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose Job Card Files</span>
                                    <small>Multiple files allowed</small>
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
                            <div class="document-upload-area">
                                <input type="file" name="autocad_dwg[]" id="autocad_dwg" class="file-input" multiple accept=".dwg,.dxf,.pdf">
                                <label for="autocad_dwg" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose AutoCad Files</span>
                                    <small>Multiple files allowed</small>
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
                            <div class="document-upload-area">
                                <input type="file" name="site_visit_reports[]" id="site_visit_reports" class="file-input" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                <label for="site_visit_reports" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose Report Files</span>
                                    <small>Multiple files allowed</small>
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
                            <input type="file" name="scan_copy" class="form-control-file @error('scan_copy') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-file-info">Accepted formats: PDF, JPG, PNG (max: 5MB)</div>
                            @error('scan_copy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Certificate</label>
                            <input type="file" name="certificate" class="form-control-file @error('certificate') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-file-info">Accepted formats: PDF, JPG, PNG (max: 5MB)</div>
                            @error('certificate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">Other Documents</label>
                            <input type="file" name="other_documents[]" class="form-control-file @error('other_documents.*') is-invalid @enderror" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <div class="form-file-info">Multiple files allowed. Accepted formats: PDF, DOC, DOCX, JPG, PNG (max: 5MB each)</div>
                            @error('other_documents.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">General Remarks</label>
                            <textarea name="remarks" rows="4" class="form-control @error('remarks') is-invalid @enderror" placeholder="Add any additional remarks or notes">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-actions" style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{ route('png.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <div style="display: flex; gap: 10px;">
                        <button type="button" id="createNextBtn" class="btn btn-primary" onclick="handleCreateNext()">
                            <span id="btnText">Next</span>
                            <i id="btnIcon" class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tab names in order for navigation
    const tabOrder = ['basic-info', 'location-details', 'technical-info', 'measurements', 'files-documents'];
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
            // Validate current tab before switching (unless moving backwards)
            const targetIndex = tabOrder.indexOf(tabName);
            if (targetIndex > currentTabIndex) {
                const errors = validateCurrentTab();
                if (errors.length > 0) {
                    showClientValidationErrors(errors);
                    return;
                }
            }
            hideClientValidationErrors();

            targetTab.classList.add('active');
            console.log('Successfully activated tab:', tabName);
        } else {
            console.error(`Tab with ID '${tabName}' not found`);
            // List all available tab content IDs for debugging
            const allTabContents = document.querySelectorAll('.tab-content');
            const availableIds = Array.from(allTabContents).map(tab => tab.id).filter(id => id);
            console.log('Available tab IDs:', availableIds);
            return;
        }
        
        // Find and activate the correct tab button
        tabs.forEach(tab => {
            if (tab.getAttribute('onclick')?.includes(tabName)) {
                tab.classList.add('active');
            }
        });

        // Update current tab index
        currentTabIndex = tabOrder.indexOf(tabName);
        if (currentTabIndex === -1) currentTabIndex = 0;
        
        // Update button text based on current tab
        updateButtonState();
    }

    // Update the button text and action based on current tab
    function updateButtonState() {
        const btnText = document.getElementById('btnText');
        const btnIcon = document.getElementById('btnIcon');
        const createNextBtn = document.getElementById('createNextBtn');
        
        if (!btnText || !btnIcon || !createNextBtn) return;
        
        if (currentTabIndex === tabOrder.length - 1) {
            // Last tab - show "Create PNG Job" with save icon
            btnText.textContent = 'Create PNG Job';
            btnIcon.className = 'fas fa-save';
            createNextBtn.onclick = function() { submitForm(); };
        } else {
            // Other tabs - show "Next" with arrow icon
            btnText.textContent = 'Next';
            btnIcon.className = 'fas fa-arrow-right';
            createNextBtn.onclick = function() { handleCreateNext(); };
        }
    }

    // Define required fields for each tab
    const tabValidationRules = {
        'basic-info': [
            { name: 'service_order_no', label: 'Service Order No' },
            { name: 'customer_name', label: 'Customer Name' },
            { name: 'agreement_date', label: 'Agreement Date' }
        ],
        'location-details': [], // No required fields
        'technical-info': [
            { name: 'conversion_status', label: 'Conversion Status' }
        ],
        'measurements': [], // No required fields
        'files-documents': [] // No required fields
    };

    // Validate current tab fields
    function validateCurrentTab() {
        const currentTabName = tabOrder[currentTabIndex];
        const rules = tabValidationRules[currentTabName] || [];
        const errors = [];

        rules.forEach(rule => {
            const field = document.querySelector('input[name="' + rule.name + '"], select[name="' + rule.name + '"], textarea[name="' + rule.name + '"]');
            
            if (field) {
                const value = field.value ? field.value.trim() : '';
                
                if (!value || value === '') {
                    errors.push(rule.label + ' is required');
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            }
        });

        return errors;
    }

    // Show client-side validation errors
    function showClientValidationErrors(errors) {
        const alertBox = document.getElementById('clientValidationAlert');
        const errorList = document.getElementById('clientValidationErrors');
        
        if (!alertBox || !errorList) return;
        
        errorList.innerHTML = '';
        errors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });
        
        alertBox.style.display = 'block';
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Hide client-side validation errors
    function hideClientValidationErrors() {
        const alertBox = document.getElementById('clientValidationAlert');
        if (alertBox) {
            alertBox.style.display = 'none';
        }
    }

    // Handle Next button click
    function handleCreateNext() {
        console.log('handleCreateNext called');
        console.log('Current tab index:', currentTabIndex);
        
        // Validate current tab first
        const errors = validateCurrentTab();
        console.log('Errors found:', errors);
        
        if (errors.length > 0) {
            // Show errors and stay on current tab
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
            // Go back to first tab with errors
            showTab('basic-info');
            return;
        }
        
        const form = document.getElementById('pngCreateForm');
        if (form) {
            form.submit();
        }
    }

    function calculateTotalGi() {
        const fields = [
            'gi_guard_to_main_valve_half_inch',
            'gi_main_valve_to_meter_half_inch',
            'gi_meter_to_geyser_half_inch',
            'gi_geyser_point_half_inch',
            'extra_kitchen_point'
        ];
        
        let total = 0;
        fields.forEach(function(fieldName) {
            const field = document.querySelector(`input[name="${fieldName}"]`);
            if (field && field.value) {
                total += parseFloat(field.value) || 0;
            }
        });
        
        document.getElementById('total_gi').value = total.toFixed(2);
    }

    function calculateTotalMdpe() {
        const openCut = parseFloat(document.querySelector('input[name="open_cut_20mm"]').value) || 0;
        const boring = parseFloat(document.querySelector('input[name="boring_20mm"]').value) || 0;
        
        document.getElementById('total_mdpe_pipe_20mm').value = (openCut + boring).toFixed(2);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize file upload handlers
        initializeFileUploads();
    });

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

    // File Remove Functionality (using event delegation for dynamically added elements)
    document.addEventListener('click', function(event) {
        if (event.target.closest('.remove-file')) {
            event.target.closest('.file-preview-item').remove();
        }
    });

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
        
        // Check for required fields
        const customerNameField = form.querySelector('input[name="customer_name"]');
        if (!customerNameField || !customerNameField.value.trim()) {
            console.error('Customer name field is required but empty!');
        }
        
        // Don't prevent submission, just log for debugging
        return true;
    }


    // Multi-Step Navigation Functions
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

function showToast(message, type = 'success') {
    // Inject styles dynamically if not present
    if (!document.getElementById('toast-notification-styles')) {
        const style = document.createElement('style');
        style.id = 'toast-notification-styles';
        style.textContent = `
            .toast-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #ffffff;
                border-left: 5px solid #28a745;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                padding: 16px 24px;
                border-radius: 8px;
                z-index: 9999;
                display: flex;
                align-items: center;
                gap: 15px;
                animation: slideIn 0.3s ease-out;
                min-width: 320px;
                font-family: 'Segoe UI', sans-serif;
            }
            .toast-notification.error {
                border-left-color: #dc3545;
            }
            .toast-icon {
                font-size: 24px;
                color: #28a745;
            }
            .toast-notification.error .toast-icon {
                color: #dc3545;
            }
            .toast-message {
                font-size: 14px;
                font-weight: 500;
                color: #333;
                flex: 1;
            }
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }

    // Remove existing toasts
    const existing = document.querySelectorAll('.toast-notification');
    existing.forEach(t => t.remove());

    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    toast.innerHTML = `
        <i class="fas ${icon} toast-icon"></i>
        <div class="toast-message">${message}</div>
        <button onclick="this.parentElement.remove()" style="background:none;border:none;margin-left:10px;cursor:pointer;font-size:18px;color:#999;transition:color 0.2s;">&times;</button>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.5s ease';
        setTimeout(() => toast.remove(), 500);
    }, 5000);
}

function completeTechnicalInfo() {
    const conversionStatus = document.querySelector('select[name="conversion_status"]');
    
    if (!conversionStatus || !conversionStatus.value) {
        showToast('Please select a Conversion Status', 'error');
        if(conversionStatus) conversionStatus.classList.add('is-invalid');
        return;
    }
    
    // Remove invalid class
    conversionStatus.classList.remove('is-invalid');

    // Show modern toast instead of native alert
    showToast('Technical Information completed! You can now proceed to other tabs.', 'success');
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
    
    if (['conv_done', 'comm'].includes(statusSelect.value)) {
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

    // Initialize Flatpickr for date inputs
    flatpickr(".datepicker-input", {
        dateFormat: "Y-m-d", // Value sent to server
        altInput: true,      // Show a different format to user
        altFormat: "d-m-Y",  // Format shown to user
        allowInput: true
    });
});
</script>
@endsection