@extends('layouts.app')

@section('title', 'Add New PNG Job')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="page-title">
            <h1>Add New PNG Job</h1>
            <p>Create a new PNG job with detailed measurements and information</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('png.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <form action="{{ route('png.store') }}" method="POST" enctype="multipart/form-data" class="form-container">
        @csrf
        
        <div class="form-tabs">
            <div class="tab-nav">
                <button type="button" class="tab-btn active" onclick="showTab('basic-info')">Basic Information</button>
                <button type="button" class="tab-btn" onclick="showTab('location-details')">Location & Details</button>
                <button type="button" class="tab-btn" onclick="showTab('technical-info')">Technical Information</button>
                <button type="button" class="tab-btn" onclick="showTab('measurements')">Measurements & Fittings</button>
                <button type="button" class="tab-btn" onclick="showTab('files-documents')">Files & Documents</button>
            </div>

            <!-- Basic Information Tab -->
            <div id="basic-info" class="tab-content active">
                <div class="form-section-title">Basic Information</div>
                
                <div class="form-row">
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
                <div class="form-section-title">Measurements & Fittings</div>
                
                <!-- GI (Galvanized Iron) Measurements Section -->
                <div class="measurement-section">
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
                        </div>
                    </div>
                </div>

                <!-- Regulators and Components Section -->
                <div class="measurement-section">
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
                <div class="measurement-section">
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
                <div class="measurement-section">
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
                <div class="measurement-section">
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
                    <!-- Scan Copy Section -->
                    <div class="document-section">
                        <div class="document-header">
                            <i class="fas fa-file-pdf document-icon"></i>
                            <h5>Scan Copy</h5>
                        </div>
                        <div class="file-upload-area">
                            <input type="file" name="scan_copy" id="scan_copy" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                            <label for="scan_copy" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose Scan Copy</span>
                            </label>
                        </div>
                    </div>

                    <!-- AutoCAD Drawing Section -->
                    <div class="document-section">
                        <div class="document-header">
                            <i class="fas fa-drafting-compass document-icon"></i>
                            <h5>AutoCAD Drawing</h5>
                        </div>
                        <div class="file-upload-area">
                            <input type="file" name="autocad_drawing" id="autocad_drawing" class="file-input" accept=".dwg,.dxf,.pdf">
                            <label for="autocad_drawing" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose AutoCAD File</span>
                            </label>
                        </div>
                    </div>

                    <!-- Certificate Section -->
                    <div class="document-section">
                        <div class="document-header">
                            <i class="fas fa-certificate document-icon"></i>
                            <h5>Certificate</h5>
                        </div>
                        <div class="file-upload-area">
                            <input type="file" name="certificate" id="certificate" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                            <label for="certificate" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose Certificate</span>
                            </label>
                        </div>
                    </div>

                    <!-- Job Cards Section -->
                    <div class="document-section">
                        <div class="document-header">
                            <i class="fas fa-id-card document-icon"></i>
                            <h5>Job Cards</h5>
                        </div>
                        <div class="file-upload-area">
                            <input type="file" name="job_cards[]" id="job_cards" class="file-input" multiple accept=".pdf,.jpg,.jpeg,.png">
                            <label for="job_cards" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose Job Cards (Multiple)</span>
                            </label>
                        </div>
                    </div>

                    <!-- AutoCAD DWG Files Section -->
                    <div class="document-section">
                        <div class="document-header">
                            <i class="fas fa-file-code document-icon"></i>
                            <h5>AutoCAD DWG Files</h5>
                        </div>
                        <div class="file-upload-area">
                            <input type="file" name="autocad_dwg[]" id="autocad_dwg" class="file-input" multiple accept=".dwg,.dxf">
                            <label for="autocad_dwg" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose DWG Files (Multiple)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Site Visit Reports Section -->
                    <div class="document-section">
                        <div class="document-header">
                            <i class="fas fa-clipboard-list document-icon"></i>
                            <h5>Site Visit Reports</h5>
                        </div>
                        <div class="file-upload-area">
                            <input type="file" name="site_visit_reports[]" id="site_visit_reports" class="file-input" multiple accept=".pdf,.doc,.docx">
                            <label for="site_visit_reports" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose Reports (Multiple)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Other Documents Section -->
                    <div class="document-section">
                        <div class="document-header">
                            <i class="fas fa-folder document-icon"></i>
                            <h5>Other Documents</h5>
                        </div>
                        <div class="file-upload-area">
                            <input type="file" name="other_documents[]" id="other_documents" class="file-input" multiple>
                            <label for="other_documents" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose Other Files (Multiple)</span>
                            </label>
                        </div>
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
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create PNG Job
            </button>
            <a href="{{ route('png.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

<!-- JavaScript for form functionality -->
<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(function(content) {
        content.classList.remove('active');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-btn').forEach(function(btn) {
        btn.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById(tabName).classList.add('active');
    
    // Add active class to clicked tab button
    event.target.classList.add('active');
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

// File upload preview functionality
document.querySelectorAll('.file-input').forEach(function(input) {
    input.addEventListener('change', function() {
        const label = input.nextElementSibling;
        const span = label.querySelector('span');
        
        if (input.files.length > 0) {
            if (input.multiple) {
                span.textContent = `${input.files.length} file(s) selected`;
            } else {
                span.textContent = input.files[0].name;
            }
            label.classList.add('file-selected');
        } else {
            span.textContent = span.getAttribute('data-original') || 'Choose file';
            label.classList.remove('file-selected');
        }
    });
});
</script>

<style>
.form-container {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-tabs .tab-nav {
    display: flex;
    border-bottom: 2px solid #e9ecef;
    margin-bottom: 20px;
}
</style>
</body>
</html>