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

/* Filter Section Enhancements */
.filter-section {
    background: #ffffff; /* Brighter background */
    padding: 24px;
    border-radius: 12px;
    margin-bottom: 25px;
    border: 1px solid #e0e6ed;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.filter-row {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    align-items: flex-end; /* Aligns buttons with the bottom of inputs */
}

.filter-group {
    display: flex;
    flex-direction: column;
    flex: 1; /* Allows inputs to grow */
    min-width: 150px; /* Prevents inputs from getting too small */
}

.filter-group label {
    font-size: 12px;
    font-weight: 600;
    color: #555;
    margin-bottom: 5px;
}

.filter-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #333;
}

/* Specific styling for the actions container */
.filter-actions {
    display: flex;
    gap: 10px;
    margin: 13px 0;
    padding-bottom: 2px; /* Fine-tune alignment with input height */
}

.filter-input, .filter-select {
    height: 40px; /* Uniform height */
    padding: 8px 12px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    transition: all 0.2s;
}

.btn {
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 20px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
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

/* Modern Header Filter Design */
.header-search-container {
    display: flex;
    flex-direction: column;
    gap: 5px;
    padding: 5px;
}

.header-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #333;
    white-space: nowrap;
}

.header-search, .header-select, .clear-filters-btn {
    width: 100%;
    padding: 6px 8px;
    font-size: 12px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
    outline: none;
}

.header-search:focus, .header-select:focus {
    background-color: #fff;
    border-color: #4a90e2;
    box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.1);
}

/* Datepicker specific styling */
.flatpickr-input {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23888' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 8px center;
} 

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
.icon-delete { background-color: #dc3545; color: white; }
.icon-delete:hover { background-color: #c82333; color: white; }

/* Customer Name Link Styling */
.customer-name-link {
    color: #007bff;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-block;
    position: relative;
    cursor: pointer;
}

.customer-name-link:hover {
    color: #0056b3;
    text-decoration: underline;
}

.customer-name-link strong {
    font-weight: 600;
}

.customer-name-link::after {
    content: '\f35d';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    margin-left: 5px;
    font-size: 10px;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.customer-name-link:hover::after {
    opacity: 0.6;
}

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

/* Column Manager Styles */
.column-manager-wrapper {
    position: relative;
    display: inline-block;
}

.column-manager-panel {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 5px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    width: 350px;
    max-height: 600px;
    overflow: hidden;
    z-index: 1000;
    display: flex;
    flex-direction: column;
}

.column-manager-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.column-manager-header h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.close-panel {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    transition: background 0.2s;
}

.close-panel:hover {
    background: rgba(255,255,255,0.2);
}

.column-manager-body {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
    max-height: 450px;
}

.column-section {
    margin-bottom: 20px;
}

.column-section:last-child {
    margin-bottom: 0;
}

.column-section h5 {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin: 0 0 10px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid #667eea;
}

.column-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.column-item {
    display: flex;
    align-items: center;
    padding: 8px 10px;
    background: #f8f9fa;
    border-radius: 4px;
    transition: background 0.2s;
    cursor: pointer;
}

.column-item:hover {
    background: #e9ecef;
}

.column-item input[type="checkbox"] {
    margin-right: 10px;
    cursor: pointer;
    width: 16px;
    height: 16px;
    accent-color: #667eea;
}

.column-item label {
    cursor: pointer;
    margin: 0;
    flex: 1;
    font-size: 13px;
    color: #495057;
    user-select: none;
}

.column-item.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.column-item.disabled input[type="checkbox"],
.column-item.disabled label {
    cursor: not-allowed;
}

.column-manager-footer {
    display: flex;
    gap: 8px;
    padding: 12px 15px;
    border-top: 1px solid #e0e0e0;
    background: #f8f9fa;
    flex-wrap: wrap;
}

.column-manager-footer .btn-sm {
    padding: 6px 12px;
    font-size: 12px;
    flex: 1;
    min-width: 90px;
}

/* Smooth column transitions */
.data-table th,
.data-table td {
    transition: opacity 0.2s ease, width 0.2s ease;
}

.data-table th.column-hidden,
.data-table td.column-hidden {
    display: none;
}

/* Scrollbar styling for column manager */
.column-manager-body::-webkit-scrollbar {
    width: 6px;
}

.column-manager-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.column-manager-body::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.column-manager-body::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .column-manager-panel {
        width: 90vw;
        max-width: 350px;
        right: auto;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .column-manager-footer {
        flex-direction: column;
    }
    
    .column-manager-footer .btn-sm {
        width: 100%;
    }
}
/* Container for alerts to give them some breathing room */
.alert-container {
    margin: 20px 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.alert {
    position: relative;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.5rem;
    display: flex;
    align-items: flex-start; /* Aligns icon to the top if text is long */
    gap: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    line-height: 1.5;
}

/* Left Accent Border */
.alert::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 5px;
    border-radius: 0.5rem 0 0 0.5rem;
}

/* Success Design */
.alert-success {
    background-color: #f0fff4;
    border-color: #c6f6d5;
    color: #22543d;
}
.alert-success::before { background-color: #38a169; }

/* Warning Design (Your Import Case) */
.alert-warning {
    background-color: #fffaf0;
    border-color: #feebc8;
    color: #744210;
}
.alert-warning::before { background-color: #ed8936; }

/* Danger/Error Design */
.alert-danger {
    background-color: #fff5f5;
    border-color: #fed7d7;
    color: #822727;
}
.alert-danger::before { background-color: #e53e3e; }

/* Handling the specific "Import Errors" text */
.alert div {
    flex: 1;
}

.alert strong {
    display: block;
    margin-bottom: 5px;
    font-weight: 700;
}

/* If the error list is very long, wrap it in a scrollable area */
.alert-details {
    margin-top: 8px;
    font-size: 0.9rem;
    max-height: 150px;
    overflow-y: auto;
    white-space: pre-line; /* Keeps line breaks from your row errors */
    padding-right: 10px;
}

/* Custom scrollbar for the alert details */
.alert-details::-webkit-scrollbar { width: 4px; }
.alert-details::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
/* Modal Overlay */
.modal-overlay {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    display: none; /* Hidden by default */
    align-items: center; justify-content: center;
    z-index: 9999;
}

/* Modal Box */
.delete-modal {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    width: 400px;
    text-align: center;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.modal-icon {
    font-size: 3rem;
    color: #e53e3e;
    margin-bottom: 1rem;
}

.modal-title { font-size: 1.25rem; font-weight: 700; color: #1a202c; margin-bottom: 0.5rem; }
.modal-text { color: #718096; margin-bottom: 1.5rem; }

.modal-actions { display: flex; gap: 10px; justify-content: center; }

.btn-cancel { background: #edf2f7; color: #4a5568; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; }
.btn-confirm-delete { background: #e53e3e; color: white; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; }

.btn-cancel:hover { background: #e2e8f0; }
.btn-confirm-delete:hover { background: #c53030; }
</style>
@endsection

@section('content')
<div class="main-container">
    <!-- Filter Section -->
    <div class="content-card">
        <div class="filter-section">
            <div class="filter-title">Search & Filter Options</div>
            <div class="filter-row">
                <div class="filter-group">
                    <label for="filter_contact_numbers">Contact Numbers</label>
                    <input type="text" inputmode="numeric" name="contact_no_filter" id="filter_contact_numbers" 
                    class="filter-input" value="{{ $filters['contact_no_filter'] ?? '' }}" placeholder="Numbers only..."
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
                
                <div class="filter-group">
                    <label for="filter_locations">Locations</label>
                    <input type="text" name="address_filter" id="filter_locations" class="filter-input" 
                        value="{{ $filters['address_filter'] ?? '' }}" placeholder="Search locations...">
                </div>
                
                <div class="filter-group">
                    <label for="filter_plan_type">Activity Type</label>
                    <select name="plan_type" id="filter_plan_type" class="filter-select">
                        <option value="">-- All Activity Types --</option>
                        <option value="domestic" {{ ($filters['plan_type'] ?? '') == 'domestic' ? 'selected' : '' }}>Domestic</option>
                        <option value="commercial" {{ ($filters['plan_type'] ?? '') == 'commercial' ? 'selected' : '' }}>Commercial </option>
                        <option value="riser_hadder" {{ ($filters['plan_type'] ?? '') == 'riser_hadder' ? 'selected' : '' }}>Riser-Hadder</option>
                        <option value="dma" {{ ($filters['plan_type'] ?? '') == 'dma' ? 'selected' : '' }}>DMA</option>
                        <option value="welded" {{ ($filters['plan_type'] ?? '') == 'welded' ? 'selected' : '' }}>Welded</option>
                        <option value="o&m" {{ ($filters['plan_type'] ?? '') == 'o&m' ? 'selected' : '' }}>O&M</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="filter_order_application">Order/Application/Notification</label>
                    <input type="text" name="order_application" id="filter_order_application" class="filter-input" 
                        value="{{ $filters['order_application'] ?? '' }}" placeholder="Search order...">
                </div>

                <div class="filter-actions">
                    <button type="button" class="btn btn-primary" onclick="submitSearch()">
                        <i class="fas fa-search"></i>&nbsp;Search
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="clearAllFilters()">
                        <i class="fas fa-times"></i>&nbsp;Clear
                    </button>
                </div>
            </div>
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
            
            <!-- Column Visibility Manager -->
            <div class="column-manager-wrapper" style="position: relative; display: inline-block;">
                <button type="button" class="btn btn-info" id="column-manager-btn" onclick="toggleColumnManager()">
                    <i class="fas fa-columns"></i> Manage Columns
                </button>
                
                <div id="column-manager-panel" class="column-manager-panel" style="display: none;">
                    <div class="column-manager-header">
                        <h4>Show/Hide Columns</h4>
                        <button type="button" class="close-panel" onclick="toggleColumnManager()">×</button>
                    </div>
                    
                    <div class="column-manager-body">
                        <div class="column-section">
                            <h5>Basic Information</h5>
                            <div class="column-list" id="basic-columns-list">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>
                        
                        <div class="column-section">
                            <h5>Technical Information</h5>
                            <div class="column-list" id="technical-columns-list">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="column-manager-footer">
                        <button type="button" class="btn btn-sm btn-secondary" onclick="selectAllColumns()">
                            <i class="fas fa-check-double"></i> Select All
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="deselectAllColumns()">
                            <i class="fas fa-times"></i> Deselect All
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="resetToDefault()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

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

        <div class="alert-container">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle" style="margin-top: 4px;"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle" style="margin-top: 4px;"></i>
                    <div>
                        <strong>Notification</strong>
                        <div class="alert-details">
                            {{ session('warning') }}
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-times-circle" style="margin-top: 4px;"></i>
                    <div>
                        <strong>Error Occurred</strong>
                        <div class="alert-details">
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Single Form for All Searches -->
        <form id="search-form" action="{{ route('png.search') }}" method="POST" style="display: none;">
            @csrf
            <!-- Top filter inputs (hidden) -->
            <input type="hidden" name="contact_no_filter" value="{{ $filters['contact_no_filter'] ?? '' }}">
            <input type="hidden" name="address_filter" value="{{ $filters['address_filter'] ?? '' }}">
            <input type="hidden" name="plan_type" value="{{ $filters['plan_type'] ?? '' }}">
            <input type="hidden" name="order_application" value="{{ $filters['order_application'] ?? '' }}">
            
            <!-- Inline search inputs (hidden, will be populated by JS) -->
            <input type="hidden" name="agreement_date_from" value="{{ $filters['agreement_date_from'] ?? '' }}">
            <input type="hidden" name="customer_no" value="{{ $filters['customer_no'] ?? '' }}">
            <input type="hidden" name="service_order_no" value="{{ $filters['service_order_no'] ?? '' }}">
            <input type="hidden" name="application_no" value="{{ $filters['application_no'] ?? '' }}">
            <input type="hidden" name="customer_name" value="{{ $filters['customer_name'] ?? '' }}">
            <input type="hidden" name="contact_no" value="{{ $filters['contact_no'] ?? '' }}">
            <input type="hidden" name="address" value="{{ $filters['address'] ?? '' }}">
            <input type="hidden" name="area" value="{{ $filters['area'] ?? '' }}">
            <input type="hidden" name="scheme" value="{{ $filters['scheme'] ?? '' }}">
            <input type="hidden" name="sla_days" value="{{ $filters['sla_days'] ?? '' }}">
            <input type="hidden" name="connections_status" value="{{ $filters['connections_status'] ?? '' }}">
            
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
                            <!-- Actions Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Actions</div>
                                    <button type="button" class="clear-filters-btn" onclick="clearAllFilters()" title="Clear all filters">
                                        <i class="fas fa-times"></i>
                                    </button>
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
                                    <input type="text" name="agreement_date_from" id="date_picker" class="header-search" 
                                        value="{{ request('agreement_date_from') }}" 
                                        placeholder="Pick Date..." 
                                        autocomplete="off">
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

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pngs as $png)
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" class="select-item" value="{{ $png->id }}" onchange="updateDeleteButton()">
                                </td>
                                <td>
                                    <div class="action-icons">
                                        <a href="{{ route('png.show', $png) }}" class="action-icon icon-info" title="View"><i class="fas fa-eye"></i></a>
                                        
                                        <form id="delete-form-{{ $png->id }}" action="{{ route('png.destroy', $png) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="action-icon icon-delete" title="Delete" 
                                                    onclick="openDeleteModal('delete-form-{{ $png->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td>{{ $png->agreement_date ? $png->agreement_date->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $png->customer_no ?? 'N/A' }}</td>
                                <td>{{ $png->service_order_no ?? 'N/A' }}</td>
                                <td>{{ $png->application_no ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('png.edit', $png) }}" target="_blank" class="customer-name-link" title="Click to edit">
                                        <strong>{{ $png->customer_name }}</strong>
                                    </a>
                                </td>
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
<div id="deleteModalOverlay" class="modal-overlay">
    <div class="delete-modal">
        <div class="modal-icon"><i class="fas fa-exclamation-circle"></i></div>
        <div class="modal-title">Are you sure?</div>
        <div class="modal-text">This action cannot be undone. This will permanently delete the record.</div>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-confirm-delete" id="finalDeleteBtn">Yes, Delete</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let formToSubmit = null;

    function openDeleteModal(formId) {
        formToSubmit = formId;
        document.getElementById('deleteModalOverlay').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModalOverlay').style.display = 'none';
    }

    // Attach event listener to the "Yes, Delete" button in the modal
    document.getElementById('finalDeleteBtn').addEventListener('click', function() {
        if (formToSubmit) {
            document.getElementById(formToSubmit).submit();
        }
    });

    // Close modal if user clicks outside of the white box
    window.onclick = function(event) {
        let overlay = document.getElementById('deleteModalOverlay');
        if (event.target == overlay) {
            closeDeleteModal();
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Datepicker
        flatpickr("#date_picker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d-m-Y", // Shows user-friendly date, sends Y-m-d to server
            allowInput: true,
            onChange: function(selectedDates, dateStr, instance) {
                // Manually trigger the update when a date is picked
                const input = document.getElementById('date_picker');
                updateFormAndSubmit(input);
            }
        });
    });

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
        // Redirect to index page with clear_filters parameter
        window.location.href = '{{ route("png.index") }}?clear_filters=1';
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
    document.getElementById('filter_contact_numbers').addEventListener('keypress', function (e) {
        // Block any key that isn't a digit (0-9)
        if (e.which < 48 || e.which > 57) {
            e.preventDefault();
        }
    });
</script>

<!-- Column Manager Script -->
<script src="{{ asset('js/png-column-manager.js') }}"></script>

<!-- Add animation styles for notifications -->
<style>
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>

@endsection