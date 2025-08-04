@extends('panel.layouts.app')

@section('title', 'Add New PNG Job')

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

.document-info {
    text-align: center;
}

.form-file-info {
    font-size: 12px;
    color: #6c757d;
    margin-top: 5px;
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
    color: #495057;
    font-weight: 600;
}

.section-header::before {
    content: "📏";
    margin-right: 8px;
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

    <h1 class="page-title">Add New PNG Job</h1>

    <div class="form-card">
        <div class="form-header">
            New PNG Job Order Details - Excel Fields Layout
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

            <form action="{{ route('png.store') }}" method="POST" enctype="multipart/form-data" onsubmit="debugFormSubmission(event)">
                @csrf
                
                <!-- Form Tabs -->
                <div class="form-tabs">
                    <button type="button" class="form-tab active" onclick="showTab('basic-info')">Basic Information</button>
                    <button type="button" class="form-tab" onclick="showTab('location-details')">Location & Details</button>
                    <button type="button" class="form-tab" onclick="showTab('technical-info')">Technical Information</button>
                    <button type="button" class="form-tab" onclick="showTab('measurements')">Measurements & Fittings</button>
                    <button type="button" class="form-tab" onclick="showTab('files-documents')">Files & Documents</button>
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
                            <input type="date" name="agreement_date" class="form-control @error('agreement_date') is-invalid @enderror" value="{{ old('agreement_date') }}" required>
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
                            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Plan Type</label>
                            <select name="plan_type" class="form-control @error('plan_type') is-invalid @enderror">
                                <option value="">Select Plan Type</option>
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
                <div id="technical-info" class="tab-content">
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
                            <label class="form-label">PDT Date</label>
                            <input type="date" name="pdt_date" class="form-control @error('pdt_date') is-invalid @enderror" value="{{ old('pdt_date') }}">
                            @error('pdt_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">PDT TPI</label>
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
                
                <div class="form-actions">
                    <a href="{{ route('png.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create PNG Job</button>
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

    function removeFileFromPreview(button, index) {
        const fileItem = button.closest('.file-preview-item');
        fileItem.remove();
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
        const customerNameField = form.querySelector('input[name="customer_name"]');
        if (!customerNameField || !customerNameField.value.trim()) {
            console.error('Customer name field is required but empty!');
        }
        
        // Don't prevent submission, just log for debugging
        return true;
    }
</script>
@endsection