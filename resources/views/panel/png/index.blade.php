{{-- panel/png/index.blade.php --}}
@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
/* Report Section Styles */
.report-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 25px;
    border-radius: 10px;
    margin-bottom: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.report-title {
    color: white;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.report-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 8px;
    padding: 15px 20px;
    min-width: 140px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #4CAF50, #8BC34A);
    border-radius: 8px 8px 0 0;
}

.stat-card.workable::before { background: linear-gradient(90deg, #4CAF50, #8BC34A); }
.stat-card.remarkable::before { background: linear-gradient(90deg, #FF9800, #FFC107); }
.stat-card.plb-done::before { background: linear-gradient(90deg, #2196F3, #03A9F4); }
.stat-card.pdt-pending::before { background: linear-gradient(90deg, #FF5722, #FF6F00); }
.stat-card.gc-pending::before { background: linear-gradient(90deg, #9C27B0, #E91E63); }
.stat-card.mmt-pending::before { background: linear-gradient(90deg, #607D8B, #78909C); }
.stat-card.conv-pending::before { background: linear-gradient(90deg, #795548, #8D6E63); }
.stat-card.comm-done::before { background: linear-gradient(90deg, #009688, #26A69A); }
.stat-card.report-pending::before { background: linear-gradient(90deg, #CDDC39, #D4E157); }
.stat-card.bill-pending::before { background: linear-gradient(90deg, #F44336, #E57373); }
.stat-card.bill-received::before { background: linear-gradient(90deg, #4CAF50, #66BB6A); }

.stat-label {
    font-size: 12px;
    color: #666;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    line-height: 1.2;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #333;
    margin-bottom: 5px;
}

.stat-percentage {
    font-size: 11px;
    color: #888;
    font-weight: 500;
}

.total-count {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: 2px solid rgba(255,255,255,0.3);
}

.total-count::before {
    background: linear-gradient(90deg, #FFD700, #FFA500);
}

.total-count .stat-label {
    color: rgba(255,255,255,0.9);
}

.total-count .stat-value {
    color: white;
    font-size: 32px;
}

.total-count .stat-percentage {
    color: rgba(255,255,255,0.8);
}

/* Filter Section */
.filter-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid #e9ecef;
}

.filter-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #333;
}

.filter-row {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    min-width: 150px;
}

.filter-group label {
    font-size: 12px;
    font-weight: 600;
    color: #555;
    margin-bottom: 5px;
}

.filter-input, .filter-select {
    padding: 8px 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 13px;
}

.filter-input:focus, .filter-select:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

/* Table Section Headers */
.table-section {
    margin-bottom: 30px;
}

.table-section-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 15px;
    padding: 10px 15px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 8px;
    text-align: center;
}

/* Table styles */
.table-responsive {
    overflow-x: auto;
    white-space: nowrap;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th, .data-table td {
    min-width: 120px;
    padding: 8px;
    border: 1px solid #ddd;
    font-size: 12px;
    vertical-align: top;
    text-align: center;
}

.data-table th {
    background-color: #ffd966;
    font-weight: 600;
    position: sticky;
    top: 0;
    z-index: 10;
    color: black;
}

.data-table .basic-info-header {
    background-color: #ffd966;
}

.data-table .technical-info-header {
    background-color: #d9ead3;
}

/* Status badges */
.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
}

.status-workable { background-color: #d4edda; color: #155724; }
.status-remarkable { background-color: #fff3cd; color: #856404; }
.status-plb-done { background-color: #cce7ff; color: #004085; }
.status-pdt-pending { background-color: #f8d7da; color: #721c24; }
.status-gc-pending { background-color: #e2e3e5; color: #383d41; }
.status-mmt-pending { background-color: #e7e1ec; color: #6f42c1; }
.status-conv-pending { background-color: #ffeaa7; color: #856404; }
.status-comm { background-color: #d1ecf1; color: #0c5460; }
.status-report-pending { background-color: #ffeaa7; color: #856404; }
.status-bill-pending { background-color: #f8d7da; color: #721c24; }
.status-bill-received { background-color: #d4edda; color: #155724; }

.status-conv-done { background-color: #d4edda; color: #155724; }

.area-badge {
    background-color: #e3f2fd;
    color: #1976d2;
    padding: 3px 8px;
    border-radius: 10px;
    font-size: 10px;
}

/* Action buttons styling */
.action-buttons {
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    border: 1px solid transparent;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    transition: all 0.15s ease-in-out;
}

.btn i {
    margin-right: 5px;
}

.btn-primary { background-color: #007bff; border-color: #007bff; color: white; }
.btn-success { background-color: #28a745; border-color: #28a745; color: white; }
.btn-secondary { background-color: #6c757d; border-color: #6c757d; color: white; }
.btn-info { background-color: #17a2b8; border-color: #17a2b8; color: white; }

/* Action icons styling */
.action-icons {
    display: flex;
    gap: 5px;
    justify-content: center;
}

.action-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 12px;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.icon-info { background-color: #17a2b8; color: white; }
.icon-info:hover { background-color: #138496; color: white; }
.icon-edit { background-color: #ffc107; color: #212529; }
.icon-edit:hover { background-color: #e0a800; color: #212529; }
.icon-delete { background-color: #dc3545; color: white; }
.icon-delete:hover { background-color: #c82333; color: white; }

/* Responsive Design */
@media (max-width: 768px) {
    .report-stats {
        flex-direction: column;
        align-items: center;
    }
    
    .stat-card {
        width: 100%;
        max-width: 300px;
    }
    
    .filter-row {
        flex-direction: column;
    }
    
    .data-table th, .data-table td {
        min-width: 100px;
        font-size: 11px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}

.select-item, #select-all {
    transform: scale(1.2);
    margin: 0;
}

#delete-selected-btn {
    background-color: #dc3545;
    border-color: #dc3545;
    transition: all 0.2s ease;
}

#delete-selected-btn:hover {
    background-color: #c82333;
    border-color: #bd2130;
    transform: translateY(-1px);
}

.header-search-container {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.header-title {
    font-weight: 600;
    font-size: 12px;
    white-space: nowrap;
}

/* Highlight selected rows */
tr:has(.select-item:checked) {
    background-color: #fff3cd !important;
}

tr:has(.select-item:checked):hover {
    background-color: #ffeaa7 !important;
}

/* Checkbox column styling */
th:first-child, td:first-child {
    position: sticky;
    left: 0;
    background-color: inherit;
    z-index: 5;
}

th:first-child {
    z-index: 15;
}

/* Improve checkbox visibility */
.select-item:checked {
    accent-color: #007bff;
}

#select-all:indeterminate {
    accent-color: #ffc107;
}

/* Mobile responsiveness for checkboxes */
@media (max-width: 768px) {
    .select-item, #select-all {
        transform: scale(1.5);
    }
    
    #delete-selected-btn {
        width: 100%;
        justify-content: center;
        margin-top: 10px;
    }
}
</style>
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="search-box">
            {{-- Global search can be added here --}}
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="content-card">
        <div class="filter-section">
            <div class="filter-title">Search & Filter Options</div>
            <div class="filter-row">
                <div class="filter-group">
                    <label for="filter_contact_numbers">Contact Numbers</label>
                    <input type="text" name="contact_no_filter" id="filter_contact_numbers" class="filter-input" 
                           value="{{ request('contact_no_filter') }}" placeholder="Search contact numbers...">
                </div>
                
                <div class="filter-group">
                    <label for="filter_locations">Locations</label>
                    <input type="text" name="address_filter" id="filter_locations" class="filter-input" 
                           value="{{ request('address_filter') }}" placeholder="Search locations...">
                </div>
                
                <div class="filter-group">
                    <label for="filter_plan_type">Activity Type</label>
                    <select name="plan_type" id="filter_plan_type" class="filter-select">
                        <option value="">-- All Activity Types --</option>
                        <option value="apartment" {{ request('plan_type') == 'domestic' ? 'selected' : '' }}>Domestic</option>
                        <option value="bungalow" {{ request('plan_type') == 'comercial' ? 'selected' : '' }}>Comercial </option>
                        <option value="rowhouse" {{ request('plan_type') == 'riser_hadder' ? 'selected' : '' }}>Riser-Hadder</option>
                        <option value="commercial" {{ request('plan_type') == 'dma' ? 'selected' : '' }}>DMA</option>
                        <option value="farmhouse" {{ request('plan_type') == 'welded' ? 'selected' : '' }}>Welded</option>
                        <option value="farmhouse" {{ request('plan_type') == 'o&m' ? 'selected' : '' }}>O&M</option>
                    </select>
                </div>

                
                <div class="filter-group">
                    <label for="filter_order_application">Order/Application/Notification</label>
                    <input type="text" name="order_application" id="filter_order_application" class="filter-input" 
                           value="{{ request('order_application') }}" placeholder="Search order/application...">
                </div>

                   <div class="filter-group" style=" gap: 10px;">
                    <button type="button" class="btn btn-primary" onclick="submitSearch()">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="clearAllFilters()">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>
            </div>

            {{-- <div class="filter-row">
             
            </div> --}}
        </div>
    </div>

    <h1 class="page-title">PNG Data Tracker</h1>

    <!-- Report Section -->
    <div class="report-section">
        <h2 class="report-title">PNG Jobs Report</h2>
        <div class="report-stats">
            <div class="stat-card total-count" onclick="filterByStatus('')">
                <div class="stat-label">Total Jobs</div>
                <div class="stat-value">{{ $statusCounts['total'] ?? 0 }}</div>
                <div class="stat-percentage">100%</div>
            </div>
            
            <div class="stat-card workable" onclick="filterByStatus('workable')">
                <div class="stat-label">Workable</div>
                <div class="stat-value">{{ $statusCounts['workable'] ?? 0 }}</div>
                <div class="stat-percentage">{{ $statusCounts['total'] > 0 ? round(($statusCounts['workable'] ?? 0) / $statusCounts['total'] * 100, 1) : 0 }}%</div>
            </div>
            
            <div class="stat-card remarkable" onclick="filterByStatus('not_workable')">
                <div class="stat-label">Remarkable</div>
                <div class="stat-value">{{ $statusCounts['not_workable'] ?? 0 }}</div>
                <div class="stat-percentage">{{ $statusCounts['total'] > 0 ? round(($statusCounts['not_workable'] ?? 0) / $statusCounts['total'] * 100, 1) : 0 }}%</div>
            </div>
            
            <div class="stat-card plb-done" onclick="filterByStatus('plb_done')">
                <div class="stat-label">PLB Done</div>
                <div class="stat-value">{{ $statusCounts['plb_done'] ?? 0 }}</div>
                <div class="stat-percentage">{{ $statusCounts['total'] > 0 ? round(($statusCounts['plb_done'] ?? 0) / $statusCounts['total'] * 100, 1) : 0 }}%</div>
            </div>
            
            <div class="stat-card pdt-pending" onclick="filterByStatus('pdt_pending')">
                <div class="stat-label">PPT Pending</div>
                <div class="stat-value">{{ $statusCounts['pdt_pending'] ?? 0 }}</div>
                <div class="stat-percentage">{{ $statusCounts['total'] > 0 ? round(($statusCounts['pdt_pending'] ?? 0) / $statusCounts['total'] * 100, 1) : 0 }}%</div>
            </div>
            
            <div class="stat-card gc-pending" onclick="filterByStatus('gc_pending')">
                <div class="stat-label">GC Pending</div>
                <div class="stat-value">{{ $statusCounts['gc_pending'] ?? 0 }}</div>
                <div class="stat-percentage">{{ $statusCounts['total'] > 0 ? round(($statusCounts['gc_pending'] ?? 0) / $statusCounts['total'] * 100, 1) : 0 }}%</div>
            </div>
            
            <div class="stat-card mmt-pending" onclick="filterByStatus('mmt_pending')">
                <div class="stat-label">MMT Pending</div>
                <div class="stat-value">{{ $statusCounts['mmt_pending'] ?? 0 }}</div>
                <div class="stat-percentage">{{ $statusCounts['total'] > 0 ? round(($statusCounts['mmt_pending'] ?? 0) / $statusCounts['total'] * 100, 1) : 0 }}%</div>
            </div>
            
            <div class="stat-card conv-pending" onclick="filterByStatus('conv_pending')">
                <div class="stat-label">Conv Pending</div>
                <div class="stat-value">{{ $statusCounts['conv_pending'] ?? 0 }}</div>
                <div class="stat-percentage">{{ $statusCounts['total'] > 0 ? round(($statusCounts['conv_pending'] ?? 0) / $statusCounts['total'] * 100, 1) : 0 }}%</div>
            </div>
            
            <div class="stat-card comm-done" onclick="filterByStatus('comm')">
                <div class="stat-label">Comm Done</div>
                <div class="stat-value">{{ $statusCounts['comm'] ?? 0 }}</div>
                <div class="stat-percentage">{{ $statusCounts['total'] > 0 ? round(($statusCounts['comm'] ?? 0) / $statusCounts['total'] * 100, 1) : 0 }}%</div>
            </div>
            
            <div class="stat-card report-pending" onclick="filterByStatus('report_pending')">
                <div class="stat-label">Report Pending</div>
                <div class="stat-value">{{ $statusCounts['report_pending'] ?? 0 }}</div>
                <div class="stat-percentage">{{ $statusCounts['total'] > 0 ? round(($statusCounts['report_pending'] ?? 0) / $statusCounts['total'] * 100, 1) : 0 }}%</div>
            </div>
            
            <div class="stat-card bill-pending" onclick="filterByStatus('bill_pending')">
                <div class="stat-label">Bill Pending</div>
                <div class="stat-value">{{ $statusCounts['bill_pending'] ?? 0 }}</div>
                <div class="stat-percentage">{{ $statusCounts['total'] > 0 ? round(($statusCounts['bill_pending'] ?? 0) / $statusCounts['total'] * 100, 1) : 0 }}%</div>
            </div>
            
            <div class="stat-card bill-received" onclick="filterByStatus('bill_received')">
                <div class="stat-label">Bill Received</div>
                <div class="stat-value">{{ $statusCounts['bill_received'] ?? 0 }}</div>
                <div class="stat-percentage">{{ $statusCounts['total'] > 0 ? round(($statusCounts['bill_received'] ?? 0) / $statusCounts['total'] * 100, 1) : 0 }}%</div>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="action-buttons">
            <a href="{{ route('png.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New PNG Job
            </a>
            <a href="{{ route('png.import.form') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Import Excel
            </a>
            <a href="{{ route('png.export') }}" class="btn btn-secondary">
                <i class="fas fa-download"></i> Export Data
            </a>
            <a href="{{ route('png-measurement-types.index') }}" class="btn btn-info">
                <i class="fas fa-cogs"></i> Manage Measurement Types
            </a>
            <button type="button" class="btn btn-secondary" onclick="clearAllFilters()">
                <i class="fas fa-times"></i> Clear All Filters
            </button>

              <button type="button" class="btn btn-danger" id="delete-selected-btn" onclick="deleteSelected()" style="display: none;">
                <i class="fas fa-trash-alt"></i> Delete Selected (<span id="selected-count">0</span>)
            </button>
        </div>

          {{-- Multiple Delete Form --}}
        <form id="bulk-delete-form" action="{{ route('png.bulk-delete') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="selected_ids" id="selected-ids">
        </form>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

         @if(session('warning'))
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('warning') }}
            </div>
        @endif

         @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Single Form for All Searches -->
        <form id="search-form" action="{{ route('png.index') }}" method="GET" style="display: none;">
            <!-- Top filter inputs (hidden) -->
            <input type="hidden" name="contact_no_filter" value="{{ request('contact_no_filter') }}">
            <input type="hidden" name="address_filter" value="{{ request('address_filter') }}">
            <input type="hidden" name="plan_type" value="{{ request('plan_type') }}">
            <input type="hidden" name="order_application" value="{{ request('order_application') }}">
            
            <!-- Inline search inputs (hidden, will be populated by JS) -->
            <input type="hidden" name="agreement_date_from" value="{{ request('agreement_date_from') }}">
            <input type="hidden" name="customer_no" value="{{ request('customer_no') }}">
            <input type="hidden" name="service_order_no" value="{{ request('service_order_no') }}">
            <input type="hidden" name="application_no" value="{{ request('application_no') }}">
            <input type="hidden" name="customer_name" value="{{ request('customer_name') }}">
            <input type="hidden" name="contact_no" value="{{ request('contact_no') }}">
            <input type="hidden" name="address" value="{{ request('address') }}">
            <input type="hidden" name="area" value="{{ request('area') }}">
            <input type="hidden" name="scheme" value="{{ request('scheme') }}">
            <input type="hidden" name="sla_days" value="{{ request('sla_days') }}">
            <input type="hidden" name="connections_status" value="{{ request('connections_status') }}">
            
            <!-- Sorting -->
            <input type="hidden" name="sort" value="{{ request('sort') }}">
            <input type="hidden" name="direction" value="{{ request('direction') }}">
        </form>

        <!-- Basic Information Table -->
        <div class="table-section">
            <div class="table-section-title">Basic Information</div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="basic-info-header" style="width: 50px;">
                                <div class="header-search-container">
                                    <div class="header-title">
                                        <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)" title="Select All">
                                    </div>
                                </div>
                            </th>
                            <!-- Agreement Date Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">
                                        <a href="{{ route('png.index', array_merge(request()->query(), ['sort' => 'agreement_date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="sort-link">
                                            Agreement Date
                                            @if(request('sort') === 'agreement_date')
                                                <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </div>
                                    <input type="date" name="agreement_date_from" class="header-search" 
                                           value="{{ request('agreement_date_from') }}" 
                                           placeholder="From" title="Date From"
                                           onchange="updateFormAndSubmit(this)">
                                </div>
                            </th>

                            <!-- Customer No Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Customer No</div>
                                    <input type="text" name="customer_no" class="header-search" 
                                           value="{{ request('customer_no') }}" 
                                           placeholder="Search..."
                                           oninput="handleSearch(this)">
                                </div>
                            </th>

                            <!-- Order No Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Order No</div>
                                    <input type="text" name="service_order_no" class="header-search" 
                                           value="{{ request('service_order_no') }}" 
                                           placeholder="Search..."
                                           oninput="handleSearch(this)">
                                </div>
                            </th>

                            <!-- Application No Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Application No</div>
                                    <input type="text" name="application_no" class="header-search" 
                                           value="{{ request('application_no') }}" 
                                           placeholder="Search..."
                                           oninput="handleSearch(this)">
                                </div>
                            </th>

                            <!-- Customer Name Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">
                                        <a href="{{ route('png.index', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="sort-link">
                                            Name
                                            @if(request('sort') === 'customer_name')
                                                <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </div>
                                    <input type="text" name="customer_name" class="header-search" 
                                           value="{{ request('customer_name') }}" 
                                           placeholder="Search name..."
                                           oninput="handleSearch(this)">
                                </div>
                            </th>

                            <!-- Contact No Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Contact No</div>
                                    <input type="text" name="contact_no" class="header-search" 
                                           value="{{ request('contact_no') }}" 
                                           placeholder="Search..."
                                           oninput="handleSearch(this)">
                                </div>
                            </th>

                            <!-- Address Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Address</div>
                                    <input type="text" name="address" class="header-search" 
                                           value="{{ request('address') }}" 
                                           placeholder="Search address..."
                                           oninput="handleSearch(this)">
                                </div>
                            </th>

                            <!-- Area Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">
                                        <a href="{{ route('png.index', array_merge(request()->query(), ['sort' => 'area', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="sort-link">
                                            Area
                                            @if(request('sort') === 'area')
                                                <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </div>
                                    <select name="area" class="header-select" onchange="updateFormAndSubmit(this)">
                                        <option value="">-- All --</option>
                                        @foreach(\App\Models\Png::getAreaOptions() as $key => $value)
                                            <option value="{{ $key }}" {{ request('area') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </th>

                            <!-- Scheme Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Scheme</div>
                                    <select name="scheme" class="header-select" onchange="updateFormAndSubmit(this)">
                                        <option value="">-- All --</option>
                                        @foreach(\App\Models\Png::getSchemeOptions() as $key => $value)
                                            <option value="{{ $key }}" {{ request('scheme') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </th>

                            <!-- SLA Days Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">SLA Days</div>
                                    <input type="text" name="sla_days" class="header-search" 
                                           value="{{ request('sla_days') }}" 
                                           placeholder="Search..."
                                           oninput="handleSearch(this)">
                                </div>
                            </th>

                            <!-- Actions Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Actions</div>
                                    <button type="button" class="clear-filters-btn" onclick="clearAllFilters()" title="Clear all filters">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pngs as $png)
                            <tr>
                                  <td style="text-align: center;">
            <input type="checkbox" class="select-item" value="{{ $png->id }}" onchange="updateDeleteButton()">
        </td>
                                <td>{{ $png->agreement_date ? $png->agreement_date->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $png->customer_no ?? 'N/A' }}</td>
                                <td>{{ $png->service_order_no ?? 'N/A' }}</td>
                                <td>{{ $png->application_no ?? 'N/A' }}</td>
                                <td><strong>{{ $png->customer_name }}</strong></td>
                                <td>{{ $png->customer_contact_no ?? 'N/A' }}</td>
                                <td title="{{ $png->address }}">{{ Str::limit($png->address, 25) }}</td>
                                <td>
                                    @if($png->area)
                                        <span class="area-badge">{{ ucfirst(str_replace('_', ' ', $png->area)) }}</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $png->scheme ? ucfirst(str_replace('_', ' ', $png->scheme)) : 'N/A' }}</td>
                                <td>
                                    @if($png->SlaCalculatedDays !== null)
                                        <span class="{{ $png->SlaCalculatedDays > 30 ? 'text-danger' : ($png->SlaCalculatedDays > 15 ? 'text-warning' : 'text-success') }}">
                                            {{ $png->SlaCalculatedDays }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                 <td>
            <div class="action-icons">
                <a href="{{ route('png.show', $png) }}" class="action-icon icon-info" title="View">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('png.edit', $png) }}" class="action-icon icon-edit" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('png.destroy', $png) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-icon icon-delete" title="Delete" 
                            onclick="return confirm('Are you sure you want to delete this PNG job?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" style="text-align: center; padding: 15px;">
                                    No PNG jobs found. 
                                    <a href="{{ route('png.create') }}">Create the first PNG job</a> or 
                                    <a href="{{ route('png.import.form') }}">import from Excel</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Technical Information Table -->
        <div class="table-section">
            <div class="table-section-title">Technical Information</div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="technical-info-header">Connections Status</th>
                            <th class="technical-info-header">Plumber Name</th>
                            <th class="technical-info-header">Plumbing Date</th>
                            <th class="technical-info-header">PPT Date</th>
                            <th class="technical-info-header">PPT Witness By</th>
                            <th class="technical-info-header">Ground Connections Date</th>
                            <th class="technical-info-header">Ground Connections Witness By</th>
                            <th class="technical-info-header">Mukkadam Name</th>
                            <th class="technical-info-header">MMT Date</th>
                            <th class="technical-info-header">MMT Witness By</th>
                            <th class="technical-info-header">Conversion Technician Name</th>
                            <th class="technical-info-header">Conversion Date</th>
                            <th class="technical-info-header">Conversion Status</th>
                            <th class="technical-info-header">Report Submission Date</th>
                            <th class="technical-info-header">Meter Number</th>
                            <th class="technical-info-header">RA-Bill No.</th>
                            <th class="technical-info-header">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pngs as $png)
                            <tr>
                                <td>
                                    @if($png->connections_status)
                                        <span class="status-badge status-{{ strtolower(str_replace(['_', ' '], '-', $png->connections_status)) }}">
                                            {{ ucfirst(str_replace('_', ' ', $png->connections_status)) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $png->plb_name ?? 'N/A' }}</td>
                                <td>{{ $png->plb_date ? $png->plb_date->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $png->pdt_date ? $png->pdt_date->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $png->pdt_witness_by ?? 'N/A' }}</td>
                                <td>{{ $png->ground_connections_date ? $png->ground_connections_date->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $png->ground_connections_witness_by ?? 'N/A' }}</td>
                                <td>{{ $png->isolation_name ?? 'N/A' }}</td>
                                <td>{{ $png->mmt_date ? $png->mmt_date->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $png->mmt_witness_by ?? 'N/A' }}</td>
                                <td>{{ $png->conversion_technician_name ?? 'N/A' }}</td>
                                <td>{{ $png->conversion_date ? $png->conversion_date->format('d-m-Y') : 'N/A' }}</td>
                                <td>
                                    @if($png->conversion_status)
                                        <span class="status-badge status-{{ strtolower(str_replace(['_', ' '], '-', $png->conversion_status)) }}">
                                            {{ ucfirst(str_replace('_', ' ', $png->conversion_status)) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $png->report_submission_date ? $png->report_submission_date->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $png->meter_number ?? 'N/A' }}</td>
                                <td>{{ $png->ra_bill_no ?? 'N/A' }}</td>
                                <td title="{{ $png->remarks }}">{{ Str::limit($png->remarks, 30) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" style="text-align: center; padding: 15px;">
                                    No technical information found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Billing Information Table (Static - Dev Phase) -->
        <div class="table-section">
            <div class="table-section-title">Billing Information</div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="billing-info-header">Plumber Bill</th>
                            <th class="billing-info-header">Client Bill Received</th>
                            <th class="billing-info-header">Mukkadam Bill</th>
                            <th class="billing-info-header">Conv Tech</th>
                        </tr>
                        <tr>
                            <th class="billing-status-header">Payable/Paid</th>
                            <th class="billing-status-header">Payable/Paid</th>
                            <th class="billing-status-header">Payable/Paid</th>
                            <th class="billing-status-header">Payable/Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pngs as $png)
                            <tr>
                                <td>
                                    <span class="billing-status payable">Payable</span>
                                    <div class="billing-amount">₹12,500</div>
                                </td>
                                <td>
                                    <span class="billing-status paid">Paid</span>
                                    <div class="billing-amount">₹45,000</div>
                                </td>
                                <td>
                                    <span class="billing-status payable">Payable</span>
                                    <div class="billing-amount">₹8,200</div>
                                </td>
                                <td>
                                    <span class="billing-status paid">Paid</span>
                                    <div class="billing-amount">₹15,800</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 15px;">
                                    <div class="dev-notice">
                                        <i class="fas fa-info-circle"></i>
                                        Billing information will be available when system goes live
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div style="margin-top: 15px; display: flex; justify-content: center;">
            {{ $pngs->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let searchTimeout;

    // Simple unified search function for all inputs
    function handleSearch(input) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            updateFormAndSubmit(input);
        }, 500);
    }

    // Update hidden form inputs and submit
    function updateFormAndSubmit(changedElement) {
        const form = document.getElementById('search-form');
        const hiddenInput = form.querySelector(`input[name="${changedElement.name}"]`);
        
        if (hiddenInput) {
            hiddenInput.value = changedElement.value;
        }
        
        form.submit();
    }

    function toggleSelectAll(selectAllCheckbox) {
    const itemCheckboxes = document.querySelectorAll('.select-item');
    itemCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateDeleteButton();
}

// Update delete button visibility and count
function updateDeleteButton() {
    const selectedCheckboxes = document.querySelectorAll('.select-item:checked');
    const deleteBtn = document.getElementById('delete-selected-btn');
    const countSpan = document.getElementById('selected-count');
    const selectAllCheckbox = document.getElementById('select-all');
    
    const selectedCount = selectedCheckboxes.length;
    const totalCheckboxes = document.querySelectorAll('.select-item').length;
    
    // Update delete button visibility and count
    if (selectedCount > 0) {
        deleteBtn.style.display = 'inline-flex';
        countSpan.textContent = selectedCount;
    } else {
        deleteBtn.style.display = 'none';
    }
    
    // Update select-all checkbox state
    if (selectedCount === 0) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = false;
    } else if (selectedCount === totalCheckboxes) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = true;
    } else {
        selectAllCheckbox.indeterminate = true;
    }
}

// Delete selected items
function deleteSelected() {
    const selectedCheckboxes = document.querySelectorAll('.select-item:checked');
    
    if (selectedCheckboxes.length === 0) {
        alert('Please select at least one item to delete.');
        return;
    }
    
    const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
    const confirmMessage = `Are you sure you want to delete ${selectedIds.length} PNG job(s)? This action cannot be undone.`;
    
    if (confirm(confirmMessage)) {
        document.getElementById('selected-ids').value = selectedIds.join(',');
        document.getElementById('bulk-delete-form').submit();
    }
}

// Clear selection when filters are applied
function clearSelection() {
    document.querySelectorAll('.select-item').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('select-all').checked = false;
    updateDeleteButton();
}

    // For immediate submission (dropdowns, dates)
    function submitSearch() {
        const form = document.getElementById('search-form');
        form.submit();
    }

    // Update top filters and submit
    function updateTopFiltersAndSubmit() {
        const form = document.getElementById('search-form');
        
        // Get values from top filter inputs
        const contactFilter = document.getElementById('filter_contact_numbers');
        const locationFilter = document.getElementById('filter_locations');
        const planTypeFilter = document.getElementById('filter_plan_type');
        const orderAppFilter = document.getElementById('filter_order_application');
        
        // Update hidden form inputs
        if (contactFilter) {
            const hiddenInput = form.querySelector('input[name="contact_no_filter"]');
            if (hiddenInput) hiddenInput.value = contactFilter.value;
        }
        
        if (locationFilter) {
            const hiddenInput = form.querySelector('input[name="address_filter"]');
            if (hiddenInput) hiddenInput.value = locationFilter.value;
        }
        
        if (planTypeFilter) {
            const hiddenInput = form.querySelector('input[name="plan_type"]');
            if (hiddenInput) hiddenInput.value = planTypeFilter.value;
        }
        
        if (orderAppFilter) {
            const hiddenInput = form.querySelector('input[name="order_application"]');
            if (hiddenInput) hiddenInput.value = orderAppFilter.value;
        }
        
        form.submit();
    }

    function clearAllFilters() {
        // Clear top filter section
        document.querySelectorAll('.filter-input, .filter-select').forEach(input => {
            if (input.type === 'text' || input.type === 'number') {
                input.value = '';
            } else if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            }
        });
        
        // Clear inline table header filters
        document.querySelectorAll('.header-search').forEach(input => {
            input.value = '';
        });
        
        document.querySelectorAll('.header-select').forEach(select => {
            select.selectedIndex = 0;
        });
        
        // Clear hidden form inputs
        const form = document.getElementById('search-form');
        form.querySelectorAll('input[type="hidden"]').forEach(input => {
            if (!input.name.includes('sort') && !input.name.includes('direction')) {
                input.value = '';
            }
        });
        
        form.submit();
    }

    function filterByStatus(status) {
        const form = document.getElementById('search-form');
        const hiddenInput = form.querySelector('input[name="connections_status"]');
        
        if (hiddenInput) {
            hiddenInput.value = status;
            form.submit();
        }
    }

    // Auto-submit form when top filters change
    document.addEventListener('DOMContentLoaded', function() {
        const topFilterInputs = document.querySelectorAll('.filter-input, .filter-select');
        
        topFilterInputs.forEach(input => {
            if (input.type === 'text' || input.type === 'number') {
                input.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        if (this.value.length >= 2 || this.value.length === 0) {
                            updateTopFiltersAndSubmit();
                        }
                    }, 500);
                });
            } else if (input.tagName === 'SELECT') {
                input.addEventListener('change', function() {
                    updateTopFiltersAndSubmit();
                });
            }
        });

        // Visual feedback for active filters
        updateFilterIndicators();
    });

    function updateFilterIndicators() {
        // Update top filter indicators
        const topInputs = document.querySelectorAll('.filter-input, .filter-select');
        topInputs.forEach(input => {
            if (input.value && input.value.trim() !== '') {
                input.style.borderColor = '#007bff';
                input.style.backgroundColor = '#e3f2fd';
            } else {
                input.style.borderColor = '#ddd';
                input.style.backgroundColor = 'white';
            }
        });
        
        // Update header filter indicators  
        const headerInputs = document.querySelectorAll('.header-search, .header-select');
        headerInputs.forEach(input => {
            if (input.value && input.value.trim() !== '') {
                input.style.borderColor = '#007bff';
                input.style.backgroundColor = '#e3f2fd';
            } else {
                input.style.borderColor = '#ccc';
                input.style.backgroundColor = 'white';
            }
        });
    }

    // Add table scrolling sync
    function syncTableScroll() {
        const basicTable = document.querySelector('.table-section:first-of-type .table-responsive');
        const techTable = document.querySelector('.table-section:last-of-type .table-responsive');
        
        if (basicTable && techTable) {
            basicTable.addEventListener('scroll', function() {
                techTable.scrollLeft = this.scrollLeft;
            });
            
            techTable.addEventListener('scroll', function() {
                basicTable.scrollLeft = this.scrollLeft;
            });
        }
    }

    // Initialize everything
    document.addEventListener('DOMContentLoaded', function() {
        syncTableScroll();
        updateFilterIndicators();
    });
</script>
@endsection