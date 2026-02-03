@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
/* Enhanced styles for PNG show view */
.job-details-container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,.1);
    padding: 25px;
    margin-bottom: 25px;
}

.job-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f0f0f0;
}

.job-title {
    font-size: 24px;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.action-buttons {
    display: flex;
    gap: 12px;
}

.btn-custom {
    border-radius: 6px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    text-decoration: none;
    border: none;
}

.btn-custom i {
    margin-right: 8px;
}

.btn-back {
    background-color: #6c757d;
    color: white;
}

.btn-back:hover {
    background-color: #5a6268;
    color: white;
}

.btn-edit {
    background-color: #007bff;
    color: white;
}

.btn-edit:hover {
    background-color: #0056b3;
    color: white;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
}

.btn-delete:hover {
    background-color: #c82333;
    color: white;
}

.btn-view {
    background-color: #17a2b8;
    color: white;
    padding: 6px 12px;
    font-size: 12px;
}

.btn-view:hover {
    background-color: #138496;
    color: white;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.detail-section {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    border-left: 4px solid #007bff;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #2c3e50;
    display: flex;
    align-items: center;
}

.section-title i {
    margin-right: 10px;
    color: #007bff;
}

.info-row {
    display: flex;
    margin-bottom: 15px;
    align-items: flex-start;
}

.info-label {
    width: 150px;
    font-weight: 600;
    color: #495057;
    margin-right: 15px;
    flex-shrink: 0;
}

.info-value {
    flex: 1;
    color: #212529;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-online { 
    background-color: #d4edda; 
    color: #155724; 
    border: 1px solid #c3e6cb;
}

.status-tapping { 
    background-color: #fff3cd; 
    color: #856404; 
    border: 1px solid #ffeaa7;
}

.status-pending { 
    background-color: #f8d7da; 
    color: #721c24; 
    border: 1px solid #f5c6cb;
}

.status-reported { 
    background-color: #d1ecf1; 
    color: #0c5460; 
    border: 1px solid #bee5eb;
}

.status-completed {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.measurements-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.measurements-table th,
.measurements-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
}

.measurements-table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #495057;
}

.measurements-table tr:hover {
    background-color: #f8f9fa;
}

.measurement-category-section {
    margin-bottom: 25px;
}

.measurement-category-title {
    font-size: 16px;
    font-weight: 600;
    color: #495057;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid #e9ecef;
}

.measurement-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.measurement-item {
    background-color: white;
    padding: 15px;
    border-radius: 6px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.measurement-item:hover {
    border-color: #007bff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,123,255,0.15);
}

.measurement-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
    font-size: 14px;
}

.measurement-value {
    color: #212529;
    font-size: 16px;
}

.calculated-field {
    background-color: #e3f2fd;
    border-color: #1976d2;
}

.calculated-field .measurement-value {
    color: #1976d2;
    font-weight: 600;
}

.file-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    padding: 12px;
    background-color: white;
    border-radius: 6px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.file-item:hover {
    border-color: #007bff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,123,255,0.15);
}

.file-icon {
    margin-right: 15px;
    font-size: 24px;
    width: 40px;
    text-align: center;
}

.file-name {
    flex: 1;
    font-weight: 500;
}

.no-data-message {
    color: #6c757d;
    font-style: italic;
    text-align: center;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 6px;
}

.total-highlight {
    background-color: #e3f2fd;
    font-weight: 600;
    color: #1976d2;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .job-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .details-grid {
        grid-template-columns: 1fr;
    }
    
    .measurement-grid {
        grid-template-columns: 1fr;
    }
    
    .info-row {
        flex-direction: column;
    }
    
    .info-label {
        width: 100%;
        margin-bottom: 5px;
    }
    
    .measurements-table {
        font-size: 14px;
    }
    
    .measurements-table th,
    .measurements-table td {
        padding: 8px 10px;
    }
}

.address-display {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 12px;
    font-style: italic;
}
</style>
@endsection

@section('content')
<div class="main-container">
   <div class="top-bar">
        <div class="search-box">
            {{-- <i class="fas fa-search"></i> --}}
            {{-- <input type="text" placeholder="Search PNG tracker records..."> --}}
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <div class="job-details-container">
        <!-- Header with Actions -->
        <div class="job-header">
            <h1 class="job-title">PNG Job Details - #{{ $png->id }}</h1>
            <div class="action-buttons">
                <a href="{{ route('png.index') }}" class="btn-custom btn-back">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <a href="{{ route('png.edit', $png) }}" class="btn-custom btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('png.destroy', $png) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-custom btn-delete" onclick="return confirm('Are you sure you want to delete this PNG job?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Basic Information Grid -->
        <div class="details-grid">
            <!-- Order Information -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-file-alt"></i>
                    Order Information
                </div>
                <div class="info-row">
                    <div class="info-label">Service Order No:</div>
                    <div class="info-value"><strong>{{ $png->service_order_no ?? 'N/A' }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Customer No:</div>
                    <div class="info-value">{{ $png->customer_no ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Application No:</div>
                    <div class="info-value">{{ $png->application_no ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Agreement Date:</div>
                    <div class="info-value">{{ $png->agreement_date ? $png->agreement_date->format('d-m-Y') : 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Area:</div>
                    <div class="info-value">{{ $png->area ? ucfirst($png->area) : 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Scheme:</div>
                    <div class="info-value">{{ $png->scheme ? ucfirst($png->scheme) : 'N/A' }}</div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-user"></i>
                    Customer Information
                </div>
                <div class="info-row">
                    <div class="info-label">Customer Name:</div>
                    <div class="info-value"><strong>{{ $png->customer_name }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Contact Number:</div>
                    <div class="info-value">{{ $png->contact_no ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Address:</div>
                    <div class="info-value">
                        <div class="address-display">
                            {{ $png->address ?: 'No address provided' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Information -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-tasks"></i>
                    Status Information
                </div>
                <div class="info-row">
                    <div class="info-label">Connections Status:</div>
                    <div class="info-value">
                        @if($png->connections_status)
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $png->connections_status)) }}">
                                {{ ucfirst(str_replace('_', ' ', $png->connections_status)) }}
                            </span>
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Conversion Status:</div>
                    <div class="info-value">
                        @if($png->conversion_status)
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $png->conversion_status)) }}">
                                {{ ucfirst(str_replace('_', ' ', $png->conversion_status)) }}
                            </span>
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">PNG Type:</div>
                    <div class="info-value">{{ $png->png_type ? ucfirst($png->png_type) : 'N/A' }}</div>
                </div>
                @if($png->measurementType)
                    <div class="info-row">
                        <div class="info-label">Measurement Type:</div>
                        <div class="info-value">{{ $png->measurementType->name }}</div>
                    </div>
                @endif
            </div>

            <!-- Technical Personnel -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-users"></i>
                    Technical Personnel
                </div>
                <div class="info-row">
                    <div class="info-label">Plumber Name:</div>
                    <div class="info-value">{{ $png->plb_name ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">PPT Witness By:</div>
                    <div class="info-value">{{ $png->pdt_witness_by ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Ground Connections Witness By:</div>
                    <div class="info-value">{{ $png->ground_connections_witness_by ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">MMT Witness By:</div>
                    <div class="info-value">{{ $png->mmt_witness_by ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Conversion Technician:</div>
                    <div class="info-value">{{ $png->conversion_technician_name ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Isolation Name:</div>
                    <div class="info-value">{{ $png->isolation_name ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Important Dates Section -->
        <div class="detail-section" style="margin-bottom: 25px;">
            <div class="section-title">
                <i class="fas fa-calendar"></i>
                Important Dates
            </div>
            <div class="details-grid">
                <div>
                    <div class="info-row">
                        <div class="info-label">Plumbing Date:</div>
                        <div class="info-value">{{ $png->plb_date ? $png->plb_date->format('d-m-Y') : 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">PPT Date:</div>
                        <div class="info-value">{{ $png->pdt_date ? $png->pdt_date->format('d-m-Y') : 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Ground Connections Date:</div>
                        <div class="info-value">{{ $png->ground_connections_date ? $png->ground_connections_date->format('d-m-Y') : 'N/A' }}</div>
                    </div>
                </div>
                <div>
                    <div class="info-row">
                        <div class="info-label">MMT Date:</div>
                        <div class="info-value">{{ $png->mmt_date ? $png->mmt_date->format('d-m-Y') : 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Conversion Date:</div>
                        <div class="info-value">{{ $png->conversion_date ? $png->conversion_date->format('d-m-Y') : 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Report Submission Date:</div>
                        <div class="info-value">{{ $png->report_submission_date ? $png->report_submission_date->format('d-m-Y') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technical Details -->
        <div class="detail-section" style="margin-bottom: 25px;">
            <div class="section-title">
                <i class="fas fa-cogs"></i>
                Technical Details
            </div>
            <div class="info-row">
                <div class="info-label">Meter Number:</div>
                <div class="info-value">{{ $png->meter_number ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">RA Bill No:</div>
                <div class="info-value">{{ $png->ra_bill_no ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Remarks:</div>
                <div class="info-value">
                    <div style="background-color: white; padding: 12px; border-radius: 6px; border: 1px solid #e9ecef;">
                        {{ $png->remarks ?: 'No remarks available.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic Measurements & Fittings -->
        @if($png->measurements_data && count($png->measurements_data) > 0)
            <div class="detail-section" style="margin-bottom: 25px;">
                <div class="section-title">
                    <i class="fas fa-ruler"></i>
                    Dynamic Measurements & Fittings
                    @if($png->measurementType)
                        <span style="font-size: 14px; font-weight: 400; color: #6c757d; margin-left: 10px;">
                            ({{ $png->measurementType->name }})
                        </span>
                    @endif
                </div>
                
                @php
                    // Group measurements by category if measurement type exists
                    $groupedMeasurements = [];
                    $measurementFields = [];
                    
                    if ($png->measurementType && $png->measurementType->measurement_fields) {
                        $measurementFields = $png->measurementType->measurement_fields;
                        
                        // Create a lookup for field metadata
                        $fieldsLookup = [];
                        foreach ($measurementFields as $field) {
                            $fieldsLookup[$field['name']] = $field;
                        }
                        
                        // Group by category
                        foreach ($png->measurements_data as $key => $value) {
                            $fieldInfo = $fieldsLookup[$key] ?? null;
                            $category = $fieldInfo['category'] ?? 'general';
                            
                            if (!isset($groupedMeasurements[$category])) {
                                $groupedMeasurements[$category] = [];
                            }
                            
                            $groupedMeasurements[$category][$key] = [
                                'value' => $value,
                                'label' => $fieldInfo['label'] ?? ucfirst(str_replace('_', ' ', $key)),
                                'unit' => $fieldInfo['unit'] ?? null,
                                'calculated' => $fieldInfo['calculated'] ?? false,
                                'type' => $fieldInfo['type'] ?? 'text'
                            ];
                        }
                    } else {
                        // If no measurement type, group by field name patterns
                        foreach ($png->measurements_data as $key => $value) {
                            $category = 'general';
                            
                            if (str_contains(strtolower($key), 'gi_') || str_contains(strtolower($key), 'gi ') || str_contains(strtolower($key), 'total')) {
                                $category = 'gi_measurements';
                            } elseif (str_contains(strtolower($key), 'valve') || str_contains(strtolower($key), 'coupling') || str_contains(strtolower($key), 'fitting')) {
                                $category = 'fittings';
                            }
                            
                            if (!isset($groupedMeasurements[$category])) {
                                $groupedMeasurements[$category] = [];
                            }
                            
                            $groupedMeasurements[$category][$key] = [
                                'value' => $value,
                                'label' => ucfirst(str_replace('_', ' ', $key)),
                                'unit' => null,
                                'calculated' => false,
                                'type' => 'text'
                            ];
                        }
                    }
                @endphp
                
                @foreach($groupedMeasurements as $category => $measurements)
                    <div class="measurement-category-section">
                        <div class="measurement-category-title">
                            {{ ucfirst(str_replace('_', ' ', $category)) }}
                        </div>
                        <div class="measurement-grid">
                            @foreach($measurements as $key => $measurement)
                                <div class="measurement-item {{ $measurement['calculated'] ? 'calculated-field' : '' }}">
                                    <div class="measurement-label">
                                        {{ $measurement['label'] }}
                                        @if($measurement['unit'])
                                            <span style="color: #6c757d; font-weight: 400;">
                                                ({{ $measurement['unit'] }})
                                            </span>
                                        @endif
                                        @if($measurement['calculated'])
                                            <i class="fas fa-calculator" style="color: #1976d2; margin-left: 5px;" title="Auto-calculated"></i>
                                        @endif
                                    </div>
                                    <div class="measurement-value">
                                        @if(is_numeric($measurement['value']) && $measurement['type'] === 'decimal')
                                            {{ number_format($measurement['value'], 2) }}
                                        @else
                                            {{ $measurement['value'] ?: 'N/A' }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="detail-section" style="margin-bottom: 25px;">
                <div class="section-title">
                    <i class="fas fa-ruler"></i>
                    Measurements & Fittings
                </div>
                <p class="no-data-message">No measurements data available.</p>
            </div>
        @endif

        <!-- Uploaded Files -->
        <div class="detail-section" style="margin-bottom: 25px;">
            <div class="section-title">
                <i class="fas fa-paperclip"></i>
                Uploaded Files
            </div>
            @php
                $hasFiles = false;
                $filesSections = [
                    'scan_copy_path' => ['label' => 'Scan Copy', 'icon' => 'file-alt', 'color' => 'primary'],
                    'autocad_drawing_path' => ['label' => 'AutoCAD Drawing', 'icon' => 'drafting-compass', 'color' => 'info'],
                    'certificate_path' => ['label' => 'Certificate', 'icon' => 'certificate', 'color' => 'success'],
                ];
                
                $multipleFileSections = [
                    'job_cards_paths' => ['label' => 'Job Cards', 'icon' => 'id-card', 'color' => 'warning'],
                    'autocad_dwg_paths' => ['label' => 'AutoCAD DWG Files', 'icon' => 'drafting-compass', 'color' => 'info'],
                    'site_visit_reports_paths' => ['label' => 'Site Visit Reports', 'icon' => 'clipboard-list', 'color' => 'secondary'],
                    'other_documents_paths' => ['label' => 'Other Documents', 'icon' => 'file', 'color' => 'secondary'],
                    'additional_documents' => ['label' => 'Additional Documents', 'icon' => 'file-plus', 'color' => 'secondary'],
                ];
            @endphp
            
            {{-- Single Files --}}
            @foreach($filesSections as $field => $config)
                @if($png->$field)
                    @php $hasFiles = true; @endphp
                    <div class="file-item">
                        <i class="fas fa-{{ $config['icon'] }} file-icon text-{{ $config['color'] }}"></i>
                        <span class="file-name">{{ $config['label'] }}</span>
                        <a href="{{ Storage::url($png->$field) }}" target="_blank" class="btn-custom btn-view">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </div>
                @endif
            @endforeach
            
            {{-- Multiple Files --}}
            @php
                $files = is_string($png->$field)
                    ? json_decode($png->$field, true)
                    : $png->$field;
            @endphp

            @if(is_array($files) && count($files) > 0)
                @php $hasFiles = true; @endphp

                @foreach($files as $index => $file)
                    <div class="file-item">
                        <i class="fas fa-{{ $config['icon'] }} file-icon text-{{ $config['color'] }}"></i>

                        <span class="file-name">
                            {{ $config['label'] }}
                            {{ count($files) > 1 ? '(' . ($index + 1) . ')' : '' }}

                            @if(isset($file['name']))
                                - {{ $file['name'] }}
                            @endif
                        </span>

                        <a href="{{ Storage::url($file['path']) }}" target="_blank" class="btn-custom btn-view">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </div>
                @endforeach
            @endif
            
            @if(!$hasFiles)
                <p class="no-data-message">No files uploaded.</p>
            @endif
        </div>

        <!-- System Information -->
        <div class="detail-section">
            <div class="section-title">
                <i class="fas fa-info-circle"></i>
                System Information
            </div>
            <div class="info-row">
                <div class="info-label">Record ID:</div>
                <div class="info-value"><strong>#{{ $png->id }}</strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">Created At:</div>
                <div class="info-value">{{ $png->created_at->format('d-m-Y H:i:s') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Last Updated:</div>
                <div class="info-value">{{ $png->updated_at->format('d-m-Y H:i:s') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection