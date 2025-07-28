@extends('panel.layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-png-tracker.css') }}">
<style>
    /* Additional styles for improved job details page */
    .job-details-container {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0,0,0,.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .job-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .btn-custom {
        border-radius: 4px;
        padding: 8px 15px;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    
    .btn-custom i {
        margin-right: 8px;
    }
    
    .btn-back {
        background-color: #6c757d;
        color: white;
    }
    
    .btn-edit {
        background-color: #007bff;
        color: white;
    }
    
    .btn-delete {
        background-color: #dc3545;
        color: white;
    }
    
    .btn-view {
        background-color: #17a2b8;
        color: white;
        padding: 4px 8px;
        font-size: 12px;
    }
    
    .job-info-row {
        display: flex;
        margin-bottom: 12px;
    }
    
    .job-info-label {
        width: 170px;
        font-weight: 600;
        color: #555;
    }
    
    .job-info-value {
        flex: 1;
    }
    
    .badge-custom {
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: 500;
        font-size: 12px;
    }
    
    .pending-badge {
        background-color: #ffc107;
        color: #212529;
    }
    
    .processed-badge {
        background-color: #17a2b8;
        color: white;
    }
    
    .paid-badge {
        background-color: #28a745;
        color: white;
    }
    
    .locked-badge {
        background-color: #dc3545;
        color: white;
    }
    
    .section-title {
        font-size: 16px;
        font-weight: 600;
        margin: 25px 0 15px 0;
        padding-bottom: 8px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .details-section {
        margin-bottom: 20px;
    }
    
    .file-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .file-icon {
        margin-right: 10px;
        font-size: 18px;
    }
    
    .file-name {
        flex: 1;
    }
    
    .no-data-message {
        color: #6c757d;
        font-style: italic;
    }
    
    /* List items styling */
    .detail-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    
    .detail-list li {
        padding: 8px 0;
        display: flex;
        align-items: center;
    }
    
    .detail-list li:not(:last-child) {
        border-bottom: 1px solid #f0f0f0;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .job-info-row {
            flex-direction: column;
        }
        
        .job-info-label {
            width: 100%;
            margin-bottom: 5px;
        }
    }
</style>
@endsection

@section('content')
<div class="main-container">
    <div class="header">
        <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search...">
        </div>
        <div class="header-icons">
            <i class="fas fa-bell header-icon"></i>
            <i class="fas fa-question-circle header-icon"></i>
            <div class="user-avatar">{{ Auth::user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <div class="dashboard-title">PE/PNG Job Details</div>

    <div class="job-details-container">
        <!-- Action Buttons -->
        <div class="job-header">
            <a href="{{ route('pe-png.index') }}" class="btn-custom btn-back">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <div class="action-buttons">
                <a href="{{ route('pe-png.edit', $pePng) }}" class="btn-custom btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('pe-png.destroy', $pePng) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-custom btn-delete" onclick="return confirm('Are you sure you want to delete this job?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Job Basic Information -->
        <div class="job-info-row">
            <div class="job-info-label">Job Order:</div>
            <div class="job-info-value">{{ $pePng->job_order_number }}</div>
        </div>
        
        <div class="job-info-row">
            <div class="job-info-label">Category:</div>
            <div class="job-info-value">{{ ucfirst($pePng->category) }}</div>
        </div>
        
        <div class="job-info-row">
            <div class="job-info-label">Plumbing Date:</div>
            <div class="job-info-value">{{ $pePng->plumbing_date->format('d-m-Y') }}</div>
        </div>
        
        <div class="job-info-row">
            <div class="job-info-label">Plumber:</div>
            <div class="job-info-value">{{ $pePng->plumber ? $pePng->plumber->name : 'N/A' }}</div>
        </div>
        
        <div class="job-info-row">
            <div class="job-info-label">GC Date:</div>
            <div class="job-info-value">{{ $pePng->gc_date ? $pePng->gc_date->format('d-m-Y') : 'N/A' }}</div>
        </div>
        
        <div class="job-info-row">
            <div class="job-info-label">MMT Date:</div>
            <div class="job-info-value">{{ $pePng->mmt_date ? $pePng->mmt_date->format('d-m-Y') : 'N/A' }}</div>
        </div>
        
        <div class="job-info-row">
            <div class="job-info-label">Bill RA No:</div>
            <div class="job-info-value">{{ $pePng->bill_ra_no ?? 'N/A' }}</div>
        </div>
        
        <div class="job-info-row">
            <div class="job-info-label">PLB Bill Status:</div>
            <div class="job-info-value">
                <span class="badge-custom {{ 
                    $pePng->plb_bill_status == 'pending' ? 'pending-badge' : 
                    ($pePng->plb_bill_status == 'processed' ? 'processed-badge' : 
                    ($pePng->plb_bill_status == 'paid' ? 'paid-badge' : 
                    ($pePng->plb_bill_status == 'locked' ? 'locked-badge' : ''))) 
                }}">
                    {{ ucfirst($pePng->plb_bill_status) }}
                </span>
            </div>
        </div>
        
        <div class="job-info-row">
            <div class="job-info-label">SLA Days:</div>
            <div class="job-info-value">{{ $pePng->sla_days ?? 'N/A' }}</div>
        </div>
        
        <div class="job-info-row">
            <div class="job-info-label">PE DPR:</div>
            <div class="job-info-value">{{ $pePng->pe_dpr ?? 'N/A' }}</div>
        </div>
        
        <div class="job-info-row">
            <div class="job-info-label">Created At:</div>
            <div class="job-info-value">{{ $pePng->created_at->format('d-m-Y H:i') }}</div>
        </div>
        
        <!-- Remarks Section -->
        <div class="section-title">Remarks</div>
        <div class="details-section">
            {{ $pePng->remarks ?? 'No remarks available.' }}
        </div>
        
        <!-- Site Visit Details -->
        <div class="section-title">Site Visit Details</div>
<div class="details-section">
   @if(!empty($siteVisits))
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siteVisits as $index => $visit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $visit['date'] ?? 'N/A' }}</td>
                    <td>{{ $visit['remarks'] ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="no-data">No site visit details available.</div>
@endif
</div>
        <!-- Uploaded Files -->
        <div class="section-title">Uploaded Files</div>
        <div class="details-section">
            @if($pePng->scan_copy_path || $pePng->autocad_drawing_path)
                <ul class="detail-list">
                    @if($pePng->scan_copy_path)
                        <li class="file-item">
                            <i class="fas fa-file-alt file-icon text-primary"></i>
                            <span class="file-name">Scan Copy</span>
                            <a href="{{ asset('storage/' . $pePng->scan_copy_path) }}" target="_blank" class="btn-custom btn-view">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </li>
                    @endif
                    @if($pePng->autocad_drawing_path)
                        <li class="file-item">
                            <i class="fas fa-drafting-compass file-icon text-info"></i>
                            <span class="file-name">AutoCAD Drawing</span>
                            <a href="{{ asset('storage/' . $pePng->autocad_drawing_path) }}" target="_blank" class="btn-custom btn-view">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </li>
                    @endif
                </ul>
            @else
                <p class="no-data-message">No files uploaded.</p>
            @endif
        </div>
        
        <!-- Consumption Details -->
       <div class="section-title">Consumption Details</div>
<div class="details-section">
    @if(is_array($pePng->consumption_details) && count($pePng->consumption_details) > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalAmount = 0; @endphp
                    @foreach($pePng->consumption_details as $index => $item)
                        @php
                            $quantity = isset($item['quantity']) && is_numeric($item['quantity']) ? floatval($item['quantity']) : 0;
                            $rate = isset($item['rate']) && is_numeric($item['rate']) ? floatval($item['rate']) : 0;
                            $amount = $quantity * $rate;
                            $totalAmount += $amount;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ isset($item['item']) ? $item['item'] : 'N/A' }}</td>
                            <td>{{ $quantity }}</td>
                            <td>{{ isset($item['unit']) ? $item['unit'] : 'N/A' }}</td>
                            <td>{{ number_format($rate, 2) }}</td>
                            <td>{{ number_format($amount, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="font-weight-bold">
                        <td colspan="5" class="text-right">Total:</td>
                        <td>{{ number_format($totalAmount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <p class="no-data-message">No consumption details available.</p>
    @endif
</div>
    </div>
</div>
@endsection