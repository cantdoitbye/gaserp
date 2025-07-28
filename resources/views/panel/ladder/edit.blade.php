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
    justify-content: space-between;
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

.existing-file {
    background: #e9ecef;
    color: #495057;
    padding: 8px 12px;
    border-radius: 4px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.existing-file a {
    color: #007bff;
    text-decoration: none;
    font-size: 13px;
}

.existing-file a:hover {
    text-decoration: underline;
}

.existing-files-list {
    margin-bottom: 15px;
}

.existing-files-title {
    font-weight: 500;
    margin-bottom: 10px;
    color: #495057;
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

    <h1 class="page-title">Edit Ladder Job</h1>

    <div class="form-card">
        <div class="form-header">
            Edit Ladder Job Order Details - #{{ $ladder->id }}
        </div>
        <div class="form-body">

            @if(session('success'))
                <div class="alert alert-success" role="alert" style="margin: 15px 0; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; color: #155724;">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert" style="margin: 15px 0; padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; color: #721c24;">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('ladder.update', $ladder->id) }}" method="POST" enctype="multipart/form-data" onsubmit="debugFormSubmission(event)">
                @csrf
                @method('PUT')
                
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
                            <input type="date" name="agreement_date" class="form-control @error('agreement_date') is-invalid @enderror" value="{{ old('agreement_date', $ladder->agreement_date ? $ladder->agreement_date->format('Y-m-d') : '') }}">
                            @error('agreement_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Customer No</label>
                            <input type="text" name="customer_no" class="form-control @error('customer_no') is-invalid @enderror" value="{{ old('customer_no', $ladder->customer_no) }}">
                            @error('customer_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Order No</label>
                            <input type="text" name="service_order_no" class="form-control @error('service_order_no') is-invalid @enderror" value="{{ old('service_order_no', $ladder->service_order_no) }}">
                            @error('service_order_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Application No</label>
                            <input type="text" name="application_no" class="form-control @error('application_no') is-invalid @enderror" value="{{ old('application_no', $ladder->application_no) }}">
                            @error('application_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Name <span class="required">*</span></label>
                            <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name', $ladder->customer_name) }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Contact No</label>
                            <input type="text" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror" value="{{ old('contact_no', $ladder->contact_no) }}">
                            @error('contact_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $ladder->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Area</label>
                            <textarea name="area" rows="2" class="form-control @error('area') is-invalid @enderror">{{ old('area', $ladder->area) }}</textarea>

                            {{-- <select name="area" class="form-control @error('area') is-invalid @enderror">
                                <option value="">Select Area</option>
                                @foreach(\App\Models\Ladder::getAreaOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('area', $ladder->area) == $key ? 'selected' : '' }}>
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
                                    <option value="{{ $key }}" {{ old('scheme', $ladder->scheme) == $key ? 'selected' : '' }}>
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
                <div id="technical-details" class="tab-content">
                    <div class="form-section-title">Technical Information (Excel Layout)</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Connections Status</label>
                            <select name="connections_status" class="form-control @error('connections_status') is-invalid @enderror">
                                <option value="">Select Status</option>
                                @foreach(\App\Models\Ladder::getConnectionsStatusOptions() as $key => $value)
                                    <option value="{{ $key }}" {{ old('connections_status', $ladder->connections_status) == $key ? 'selected' : '' }}>
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
                            <input type="text" name="plumber_name" class="form-control @error('plumber_name') is-invalid @enderror" value="{{ old('plumber_name', $ladder->plb_name) }}">
                            @error('plumber_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Plumbing Date</label>
                            <input type="date" name="plumbing_date" class="form-control @error('plumbing_date') is-invalid @enderror" value="{{ old('plumbing_date', $ladder->plb_date ? $ladder->plb_date->format('Y-m-d') : '') }}">
                            @error('plumbing_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">PPT Date</label>
                            <input type="date" name="pdt_date" class="form-control @error('pdt_date') is-invalid @enderror" value="{{ old('pdt_date', $ladder->pdt_date ? $ladder->pdt_date->format('Y-m-d') : '') }}">
                            @error('pdt_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">PPT Witness By</label>
                            <input type="text" name="pdt_witness_by" class="form-control @error('pdt_witness_by') is-invalid @enderror" value="{{ old('pdt_witness_by', $ladder->pdt_witness_by) }}">
                            @error('pdt_witness_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Ground Connections Date</label>
                            <input type="date" name="ground_connections_date" class="form-control @error('ground_connections_date') is-invalid @enderror" value="{{ old('ground_connections_date', $ladder->ground_connections_date ? $ladder->ground_connections_date->format('Y-m-d') : '') }}">
                            @error('ground_connections_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Ground Connections Witness By</label>
                            <input type="text" name="ground_connections_witness_by" class="form-control @error('ground_connections_witness_by') is-invalid @enderror" value="{{ old('ground_connections_witness_by', $ladder->ground_connections_witness_by) }}">
                            @error('ground_connections_witness_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Isolation Name</label>
                            <input type="text" name="isolation_name" class="form-control @error('isolation_name') is-invalid @enderror" value="{{ old('isolation_name', $ladder->isolation_name) }}">
                            @error('isolation_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">MMT Date</label>
                            <input type="date" name="mmt_date" class="form-control @error('mmt_date') is-invalid @enderror" value="{{ old('mmt_date', $ladder->mmt_date ? $ladder->mmt_date->format('Y-m-d') : '') }}">
                            @error('mmt_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">MMT Witness By</label>
                            <input type="text" name="mmt_witness_by" class="form-control @error('mmt_witness_by') is-invalid @enderror" value="{{ old('mmt_witness_by', $ladder->mmt_witness_by) }}">
                            @error('mmt_witness_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Conversion Technician Name</label>
                            <input type="text" name="conversion_technician_name" class="form-control @error('conversion_technician_name') is-invalid @enderror" value="{{ old('conversion_technician_name', $ladder->conversion_technician_name) }}">
                            @error('conversion_technician_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Conversion Date</label>
                            <input type="date" name="conversion_date" class="form-control @error('conversion_date') is-invalid @enderror" value="{{ old('conversion_date', $ladder->conversion_date ? $ladder->conversion_date->format('Y-m-d') : '') }}">
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
                                    <option value="{{ $key }}" {{ old('conversion_status', $ladder->conversion_status) == $key ? 'selected' : '' }}>
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
                            <input type="date" name="report_submission_date" class="form-control @error('report_submission_date') is-invalid @enderror" value="{{ old('report_submission_date', $ladder->report_submission_date ? $ladder->report_submission_date->format('Y-m-d') : '') }}">
                            @error('report_submission_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Meter Number</label>
                            <input type="text" name="meter_number" class="form-control @error('meter_number') is-invalid @enderror" value="{{ old('meter_number', $ladder->meter_number) }}">
                            @error('meter_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">RA Bill No</label>
                            <input type="text" name="ra_bill_no" class="form-control @error('ra_bill_no') is-invalid @enderror" value="{{ old('ra_bill_no', $ladder->ra_bill_no) }}">
                            @error('ra_bill_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $ladder->remarks) }}</textarea>
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
                                    <option value="{{ $key }}" {{ old('ladder_type', $ladder->ladder_type) == $key ? 'selected' : '' }}>
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
                                @if($ladder->measurementType)
                                    <option value="{{ $ladder->measurementType->id }}" selected>
                                        {{ $ladder->measurementType->name }}
                                    </option>
                                @endif
                            </select>
                            @error('ladder_measurement_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div id="measurement-fields-container" style="{{ $ladder->measurements_data ? 'display: block;' : 'display: none;' }}">
                        <!-- Dynamic measurement fields will be loaded here -->
                        @if($ladder->measurements_data && $ladder->measurementType)
                            <div class="measurement-category" id="current-measurements-display">
                                <h5>Current Measurements</h5>
                                <div class="form-row">
                                    @php
                                        // Group measurements by category based on field names
                                        $giMeasurements = [];
                                        $fittings = [];
                                        $other = [];
                                        
                                        foreach($ladder->measurements_data as $key => $value) {
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
                            <button type="button" class="btn btn-info" onclick="window.open('{{ route('ladder-measurement-types.index') }}', '_blank')">
                                <i class="fas fa-cog"></i> Manage Measurement Types
                            </button>
                            @if($ladder->measurements_data)
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
                            
                            @if($ladder->job_cards_paths && count($ladder->job_cards_paths) > 0)
                                <div class="existing-files-list">
                                    <div class="existing-files-title">Existing Files:</div>
                                    @foreach($ladder->job_cards_paths as $file)
                                        <div class="existing-file">
                                            <a href="{{ Storage::url($file['path']) }}" target="_blank">{{ $file['name'] ?? 'File' }}</a>
                                            <small>{{ isset($file['size']) ? number_format($file['size']/1024, 2) . ' KB' : '' }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="document-upload-area">
                                <input type="file" name="job_cards[]" id="job_cards" class="file-input" multiple accept=".pdf,.jpg,.jpeg,.ladder,.doc,.docx">
                                <label for="job_cards" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose New Job Card Files</span>
                                    <small>Multiple files allowed (will be added to existing)</small>
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
                            
                            @if($ladder->autocad_dwg_paths && count($ladder->autocad_dwg_paths) > 0)
                                <div class="existing-files-list">
                                    <div class="existing-files-title">Existing Files:</div>
                                    @foreach($ladder->autocad_dwg_paths as $file)
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
                            
                            @if($ladder->site_visit_reports_paths && count($ladder->site_visit_reports_paths) > 0)
                                <div class="existing-files-list">
                                    <div class="existing-files-title">Existing Files:</div>
                                    @foreach($ladder->site_visit_reports_paths as $file)
                                        <div class="existing-file">
                                            <a href="{{ Storage::url($file['path']) }}" target="_blank">{{ $file['name'] ?? 'File' }}</a>
                                            <small>{{ isset($file['size']) ? number_format($file['size']/1024, 2) . ' KB' : '' }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="document-upload-area">
                                <input type="file" name="site_visit_reports[]" id="site_visit_reports" class="file-input" multiple accept=".pdf,.jpg,.jpeg,.ladder,.doc,.docx">
                                <label for="site_visit_reports" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose New Report Files</span>
                                    <small>Multiple files allowed (will be added to existing)</small>
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
                            @if($ladder->scan_copy_path)
                                <div class="existing-file">
                                    <a href="{{ Storage::url($ladder->scan_copy_path) }}" target="_blank">View Current Scan Copy</a>
                                </div>
                            @endif
                            <input type="file" name="scan_copy" class="form-control-file @error('scan_copy') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.ladder">
                            <div class="form-file-info">Accepted formats: PDF, JPG, Ladder (max: 5MB) - Upload new file to replace existing</div>
                            @error('scan_copy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Certificate</label>
                            @if($ladder->certificate_path)
                                <div class="existing-file">
                                    <a href="{{ Storage::url($ladder->certificate_path) }}" target="_blank">View Current Certificate</a>
                                </div>
                            @endif
                            <input type="file" name="certificate" class="form-control-file @error('certificate') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.ladder">
                            <div class="form-file-info">Accepted formats: PDF, JPG, Ladder (max: 5MB) - Upload new file to replace existing</div>
                            @error('certificate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">Other Documents</label>
                            @if($ladder->other_documents_paths && count($ladder->other_documents_paths) > 0)
                                <div class="existing-files-list">
                                    <div class="existing-files-title">Existing Files:</div>
                                    @foreach($ladder->other_documents_paths as $file)
                                        <div class="existing-file">
                                            <a href="{{ Storage::url($file['path']) }}" target="_blank">{{ $file['name'] ?? 'File' }}</a>
                                            <small>{{ isset($file['size']) ? number_format($file['size']/1024, 2) . ' KB' : '' }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <input type="file" name="other_documents[]" class="form-control-file @error('other_documents.*') is-invalid @enderror" multiple accept=".pdf,.jpg,.jpeg,.ladder,.doc,.docx">
                            <div class="form-file-info">Multiple files allowed. Accepted formats: PDF, DOC, DOCX, JPG, Ladder (max: 5MB each) - New files will be added to existing</div>
                            @error('other_documents.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group-full">
                            <label class="form-label">Additional Documents</label>
                            @if($ladder->additional_documents && count($ladder->additional_documents) > 0)
                                <div class="existing-files-list">
                                    <div class="existing-files-title">Existing Files:</div>
                                    @foreach($ladder->additional_documents as $file)
                                        <div class="existing-file">
                                            <a href="{{ Storage::url($file['path']) }}" target="_blank">{{ $file['name'] ?? 'File' }}</a>
                                            <small>{{ isset($file['size']) ? number_format($file['size']/1024, 2) . ' KB' : '' }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <input type="file" name="additional_documents[]" class="form-control-file @error('additional_documents.*') is-invalid @enderror" multiple accept=".pdf,.jpg,.jpeg,.ladder,.doc,.docx">
                            <div class="form-file-info">Multiple files allowed. Accepted formats: PDF, DOC, DOCX, JPG, Ladder (max: 5MB each) - New files will be added to existing</div>
                            @error('additional_documents.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('ladder.index') }}" class="btn btn-secondary">Cancel</a>
                    <a href="{{ route('ladder.show', $ladder->id) }}" class="btn btn-info">View Details</a>
                    <button type="submit" class="btn btn-primary">Update Ladder Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Store existing measurements data for later use
    const existingMeasurements = @json($ladder->measurements_data ?? []);
    
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
        const currentMeasurementTypeId = '{{ $ladder->ladder_measurement_type_id }}';
        
        // Clear existing options except the currently selected one
        measurementTypeSelect.innerHTML = '<option value="">Select Measurement Type</option>';
        
        if (!ladderType) {
            return;
        }

        // Fetch measurement types for selected Ladder type
        fetch(`{{ route('ladder.measurement-types.by-type') }}?ladder_type=${ladderType}`)
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
        // Load measurement types if Ladder type is already selected
        const ladderType = document.getElementById('ladder_type').value;
        if (ladderType) {
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
        const currentMeasurements = @json($ladder->measurements_data ?? []);
        
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
</script>
@endsection