@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
.form-tabs {
    display: flex;
    border-bottom: 1px solid #ddd;
    margin-bottom: 20px;
}
.form-tab {
    padding: 10px 20px;
    cursor: pointer;
    border: none;
    background: #f8f9fa;
    border-bottom: 3px solid transparent;
}
.form-tab.active {
    background: white;
    border-bottom-color: #007bff;
    color: #007bff;
}
.tab-content {
    display: none;
}
.tab-content.active {
    display: block;
}
.form-section-title {
    font-size: 16px;
    font-weight: 600;
    margin: 20px 0 15px 0;
    color: #333;
    border-bottom: 1px solid #eee;
    padding-bottom: 5px;
}
.calculated-field {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
}
.measurement-group {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 15px;
}
.measurement-category {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    background-color: #f8f9fa;
}
.measurement-category h5 {
    margin-bottom: 15px;
    color: #495057;
    font-weight: 600;
}

/* Files & Documents Styles */
.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.document-section {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 20px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.document-section:hover {
    border-color: #007bff;
    background: rgba(0, 123, 255, 0.05);
}

.document-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #dee2e6;
}

.document-icon {
    font-size: 24px;
    margin-right: 10px;
    color: #007bff;
}

.document-header h5 {
    margin: 0;
    color: #495057;
    font-weight: 600;
}

.document-upload-area {
    position: relative;
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
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
    border: 2px dashed #ced4da;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    padding: 20px;
}

.file-upload-label:hover {
    border-color: #007bff;
    background: rgba(0, 123, 255, 0.05);
}

.file-upload-label i {
    font-size: 32px;
    color: #6c757d;
    margin-bottom: 8px;
}

.file-upload-label span {
    font-weight: 500;
    color: #495057;
    margin-bottom: 4px;
}

.file-upload-label small {
    color: #6c757d;
    font-size: 12px;
}

.file-preview {
    margin-top: 10px;
    max-height: 150px;
    overflow-y: auto;
}

.file-preview-item {
    display: flex;
    align-items: center;
    justify-content: between;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 8px 12px;
    margin-bottom: 5px;
}

.file-preview-item .file-name {
    flex: 1;
    font-size: 13px;
    color: #495057;
    margin-right: 10px;
}

.file-preview-item .file-size {
    font-size: 11px;
    color: #6c757d;
    margin-right: 10px;
}

.file-preview-item .remove-file {
    background: #dc3545;
    color: white;
    border: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 10px;
}

.document-info {
    text-align: center;
}

.form-file-info {
    font-size: 12px;
    color: #6c757d;
    margin-top: 5px;
}
</style>
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="search-box"></div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">Add New Ladder Job</h1>

    <div class="form-card">
        <div class="form-header">
            New Ladder Job Order Details
        </div>
        <div class="form-body">

            @if(session('success'))
                <div class="alert alert-success" role="alert" style="margin: 15px 0; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; color: #155724;">
                    <strong>Success!</strong> {{ session('success') }}
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
                                <input type="file" name="job_cards[]" id="job_cards" class="file-input" multiple accept=".pdf,.jpg,.jpeg,.ladder,.doc,.docx">
                                <label for="job_cards" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose Job Card Files</span>
                                    <small>Multiple files allowed</small>
                                </label>
                                <div class="file-preview" id="job_cards_preview"></div>
                            </div>
                            <div class="document-info">
                                <small class="text-muted">Accepted formats: PDF, JPG, Ladder, DOC, DOCX (max: 5MB each)</small>
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
                                <input type="file" name="site_visit_reports[]" id="site_visit_reports" class="file-input" multiple accept=".pdf,.jpg,.jpeg,.ladder,.doc,.docx">
                                <label for="site_visit_reports" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose Report Files</span>
                                    <small>Multiple files allowed</small>
                                </label>
                                <div class="file-preview" id="site_visit_reports_preview"></div>
                            </div>
                            <div class="document-info">
                                <small class="text-muted">Accepted formats: PDF, JPG, Ladder, DOC, DOCX (max: 5MB each)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Documents Section -->
                    <div class="form-section-title" style="margin-top: 30px;">Additional Documents</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Scan Copy</label>
                            <input type="file" name="scan_copy" class="form-control-file @error('scan_copy') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.ladder">
                            <div class="form-file-info">Accepted formats: PDF, JPG, Ladder (max: 5MB)</div>
                            @error('scan_copy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Certificate</label>
                            <input type="file" name="certificate" class="form-control-file @error('certificate') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.ladder">
                            <div class="form-file-info">Accepted formats: PDF, JPG, Ladder (max: 5MB)</div>
                            @error('certificate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">Other Documents</label>
                            <input type="file" name="other_documents[]" class="form-control-file @error('other_documents.*') is-invalid @enderror" multiple accept=".pdf,.jpg,.jpeg,.ladder,.doc,.docx">
                            <div class="form-file-info">Multiple files allowed. Accepted formats: PDF, DOC, DOCX, JPG, Ladder (max: 5MB each)</div>
                            @error('other_documents.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert" style="margin: 15px 0; padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; color: #721c24;">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('ladder.store') }}" method="POST" enctype="multipart/form-data" onsubmit="debugFormSubmission(event)">
                @csrf
                
                <!-- Form Tabs -->
                <div class="form-tabs">
                    <button type="button" class="form-tab active" onclick="showTab('basic-info')">Basic Information</button>
                    <button type="button" class="form-tab" onclick="showTab('technical-details')">Technical Information</button>
                    <button type="button" class="form-tab" onclick="showTab('measurements')">Dynamic Measurements</button>
                    <button type="button" class="form-tab" onclick="showTab('files-documents')">Files & Documents</button>
                </div>

                <!-- Basic Information Tab -->
                <div id="basic-info" class="tab-content active">
                    <div class="form-section-title">Basic Information (Excel Layout)</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Agreement Date</label>
                            <input type="date" name="agreement_date" class="form-control @error('agreement_date') is-invalid @enderror" value="{{ old('agreement_date') }}">
                            @error('agreement_date')
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
                            <label class="form-label">Order No</label>
                            <input type="text" name="service_order_no" class="form-control @error('service_order_no') is-invalid @enderror" value="{{ old('service_order_no') }}">
                            @error('service_order_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Application No</label>
                            <input type="text" name="application_no" class="form-control @error('application_no') is-invalid @enderror" value="{{ old('application_no') }}">
                            @error('application_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Name <span class="required">*</span></label>
                            <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Contact No</label>
                            <input type="text" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror" value="{{ old('contact_no') }}">
                            @error('contact_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Area</label>
                            <textarea name="area" rows="3" class="form-control @error('area') is-invalid @enderror">{{ old('area') }}</textarea>

                            {{-- <select name="area" class="form-control @error('area') is-invalid @enderror">
                                <option value="">Select Area</option>
                                @foreach(\App\Models\Ladder::getAreaOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('area') == $key ? 'selected' : '' }}>
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
                                @foreach(\App\Models\Ladder::getSchemeOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('scheme') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('scheme')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        {{-- <div class="form-group">
                            <label class="form-label">Geyser Points</label>
                            <input type="number" name="geyser" class="form-control @error('geyser') is-invalid @enderror" value="{{ old('geyser', 0) }}" min="0">
                            @error('geyser')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Kitchen Points</label>
                            <input type="number" name="kitchen" class="form-control @error('kitchen') is-invalid @enderror" value="{{ old('kitchen', 0) }}" min="0">
                            @error('kitchen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                    </div>

                    <div class="form-row">
                        {{-- <div class="form-group">
                            <label class="form-label">Target SLA Days</label>
                            <input type="number" name="sla_days" class="form-control @error('sla_days') is-invalid @enderror" value="{{ old('sla_days') }}" min="0" placeholder="e.g., 30">
                            <small class="form-text text-muted">Target number of days for completion from agreement date</small>
                            @error('sla_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Days Since Agreement</label>
                            <input type="text" id="calculated_sla_days" class="form-control" readonly placeholder="Will be calculated automatically">
                            <small class="form-text text-muted">Automatically calculated from agreement date</small>
                        </div> --}}
                    </div>
                </div>

                <!-- Technical Information Tab -->
                <div id="technical-details" class="tab-content">
                    <div class="form-section-title">Technical Information (Excel Layout)</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Connections Status</label>
                            <select name="connections_status" class="form-control @error('connections_status') is-invalid @enderror">
                                <option value="">Select Status</option>
                                @foreach(\App\Models\Ladder::getConnectionsStatusOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('connections_status') == $key ? 'selected' : '' }}>
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
                            <input type="text" name="plumber_name" class="form-control @error('plumber_name') is-invalid @enderror" value="{{ old('plumber_name') }}">
                            @error('plumber_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Plumbing Date</label>
                            <input type="date" name="plumbing_date" class="form-control @error('plumbing_date') is-invalid @enderror" value="{{ old('plumbing_date') }}">
                            @error('plumbing_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">PPT Date</label>
                            <input type="date" name="pdt_date" class="form-control @error('pdt_date') is-invalid @enderror" value="{{ old('pdt_date') }}">
                            @error('pdt_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">PPT Witness By</label>
                            <input type="text" name="pdt_witness_by" class="form-control @error('pdt_witness_by') is-invalid @enderror" value="{{ old('pdt_witness_by') }}">
                            @error('pdt_witness_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Ground Connections Date</label>
                            <input type="date" name="ground_connections_date" class="form-control @error('ground_connections_date') is-invalid @enderror" value="{{ old('ground_connections_date') }}">
                            @error('ground_connections_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Ground Connections Witness By</label>
                            <input type="text" name="ground_connections_witness_by" class="form-control @error('ground_connections_witness_by') is-invalid @enderror" value="{{ old('ground_connections_witness_by') }}">
                            @error('ground_connections_witness_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Isolation Name</label>
                            <input type="text" name="isolation_name" class="form-control @error('isolation_name') is-invalid @enderror" value="{{ old('isolation_name') }}">
                            @error('isolation_name')
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
                            <label class="form-label">MMT Witness By</label>
                            <input type="text" name="mmt_witness_by" class="form-control @error('mmt_witness_by') is-invalid @enderror" value="{{ old('mmt_witness_by') }}">
                            @error('mmt_witness_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Conversion Technician Name</label>
                            <input type="text" name="conversion_technician_name" class="form-control @error('conversion_technician_name') is-invalid @enderror" value="{{ old('conversion_technician_name') }}">
                            @error('conversion_technician_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Conversion Date</label>
                            <input type="date" name="conversion_date" class="form-control @error('conversion_date') is-invalid @enderror" value="{{ old('conversion_date') }}">
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
                                @foreach(\App\Models\Ladder::getConversionStatusOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('conversion_status') == $key ? 'selected' : '' }}>
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
                            <input type="date" name="report_submission_date" class="form-control @error('report_submission_date') is-invalid @enderror" value="{{ old('report_submission_date') }}">
                            @error('report_submission_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Meter Number</label>
                            <input type="text" name="meter_number" class="form-control @error('meter_number') is-invalid @enderror" value="{{ old('meter_number') }}">
                            @error('meter_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">RA Bill No</label>
                            <input type="text" name="ra_bill_no" class="form-control @error('ra_bill_no') is-invalid @enderror" value="{{ old('ra_bill_no') }}">
                            @error('ra_bill_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Dynamic Measurements Tab -->
                <div id="measurements" class="tab-content">
                    <div class="form-section-title">Dynamic Measurements & Fittings</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Ladder Type <span class="required">*</span></label>
                            <select name="ladder_type" id="ladder_type" class="form-control @error('ladder_type') is-invalid @enderror" onchange="loadMeasurementTypes()" required>
                                <option value="">Select Ladder Type</option>
                                @foreach(\App\Models\PngMeasurementType::getHadderTypeOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('ladder_type') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ladder_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Measurement Type <span class="required">*</span></label>
                            <select name="ladder_measurement_type_id" id="measurement_type" class="form-control @error('ladder_measurement_type_id') is-invalid @enderror" onchange="loadMeasurementFields()" required>
                                <option value="">Select Measurement Type</option>
                            </select>
                            @error('ladder_measurement_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div id="measurement-fields-container" style="display: none;">
                        <!-- Dynamic measurement fields will be loaded here -->
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <button type="button" class="btn btn-info" onclick="window.open('{{ route('ladder-measurement-types.index') }}', '_blank')">
                                <i class="fas fa-cog"></i> Manage Measurement Types
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('ladder.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Ladder Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
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
        } else {
            console.error(`Tab with ID '${tabName}' not found`);
            // List all available tab content IDs for debugging
            const allTabContents = document.querySelectorAll('.tab-content');
            const availableIds = Array.from(allTabContents).map(tab => tab.id).filter(id => id);
            console.log('Available tab IDs:', availableIds);
            return;
        }
        
        // Add active class to clicked tab
        if (event && event.target) {
            event.target.classList.add('active');
        }
    }

    function loadMeasurementTypes() {
        const ladderType = document.getElementById('ladder_type').value;
        const measurementTypeSelect = document.getElementById('measurement_type');
        
        // Clear existing options
        measurementTypeSelect.innerHTML = '<option value="">Select Measurement Type</option>';
        
        if (!ladderType) {
            return;
        }

        // Fetch measurement types for selected Ladder type
        fetch(`{{ route('ladder-measurement-types.by-type') }}?ladder_type=${ladderType}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.id;
                    option.textContent = type.name;
                    if (type.description) {
                        option.title = type.description;
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
            container.style.display = 'none';
            return;
        }

        // Fetch measurement fields for selected type
        fetch(`{{ url('admin/ladder-measurement-types') }}/${measurementTypeId}/fields`)
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

                // Generate HTML for each category
                Object.keys(categories).forEach(categoryName => {
                    html += `
                        <div class="measurement-category">
                            <h5>${categoryName.charAt(0).toUpperCase() + categoryName.slice(1).replace('_', ' ')}</h5>
                            <div class="form-row">
                    `;
                    
                    categories[categoryName].forEach(field => {
                        const isCalculated = field.calculated || false;
                        const isRequired = field.required || false;
                        const unit = field.unit ? ` (${field.unit})` : '';
                        
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
                                    html += `<option value="${option}">${option}</option>`;
                                });
                            }
                            html += `</select>`;
                        } else if (field.type === 'textarea') {
                            html += `<textarea name="measurements[${field.name}]" rows="3" class="form-control ${isCalculated ? 'calculated-field' : ''}" ${isRequired ? 'required' : ''} ${isCalculated ? 'readonly' : ''}></textarea>`;
                        } else {
                            const inputType = field.type === 'decimal' || field.type === 'number' ? 'number' : 'text';
                            const step = field.type === 'decimal' ? '0.01' : '';
                            html += `<input type="${inputType}" name="measurements[${field.name}]" class="form-control ${isCalculated ? 'calculated-field' : ''} measurement-input" ${step ? `step="${step}"` : ''} ${isRequired ? 'required' : ''} ${isCalculated ? 'readonly' : ''} data-category="${categoryName}" data-calculated="${isCalculated}">`;
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
        // Load measurement types if Ladder type is already selected
        const ladderType = document.getElementById('ladder_type').value;
        if (ladderType) {
            loadMeasurementTypes();
        }

        // Initialize file upload handlers
        initializeFileUploads();
        
        // Initialize SLA calculation
        initializeSlaCalculation();
    });

    function initializeSlaCalculation() {
        const agreementDateInput = document.querySelector('input[name="agreement_date"]');
        const calculatedSlaField = document.getElementById('calculated_sla_days');
        
        if (agreementDateInput && calculatedSlaField) {
            // Calculate on page load if date exists
            calculateSladagen();
            
            // Recalculate when agreement date changes
            agreementDateInput.addEventListener('change', calculateSlaagen);
        }
    }

    function calculateSlaagen() {
        const agreementDateInput = document.querySelector('input[name="agreement_date"]');
        const calculatedSlaField = document.getElementById('calculated_sla_days');
        
        if (!agreementDateInput || !calculatedSlaField) return;
        
        const agreementDate = agreementDateInput.value;
        if (!agreementDate) {
            calculatedSlaField.value = '';
            return;
        }
        
        // Calculate days difference from agreement date to today
        const agreement = new Date(agreementDate);
        const today = new Date();
        
        // Reset time to start of day for accurate day calculation
        agreement.setHours(0, 0, 0, 0);
        today.setHours(0, 0, 0, 0);
        
        const diffTime = today - agreement;
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
        
        calculatedSlaField.value = diffDays + ' days';
        
        // Add visual feedback based on target SLA
        const targetSlaInput = document.querySelector('input[name="sla_days"]');
        if (targetSlaInput && targetSlaInput.value) {
            const targetSla = parseInt(targetSlaInput.value);
            if (diffDays <= targetSla) {
                calculatedSlaField.style.color = '#28a745'; // Green
                calculatedSlaField.style.fontWeight = '500';
            } else {
                calculatedSlaField.style.color = '#dc3545'; // Red
                calculatedSlaField.style.fontWeight = '500';
            }
        }
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
        
        // Check for required fields
        const nameField = form.querySelector('input[name="name"]');
        if (!nameField || !nameField.value.trim()) {
            console.error('Name field is required but empty!');
        }
        
        // Don't prevent submission, just log for debugging
        return true;
    }
</script>
@endsection