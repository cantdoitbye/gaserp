@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
.table-responsive {
    overflow-x: auto;
    white-space: nowrap;
}
.data-table th, .data-table td {
    min-width: 120px;
    padding: 8px;
    border: 1px solid #ddd;
    font-size: 12px;
    vertical-align: top;
}
.data-table th {
    background-color: #ffd966;
    font-weight: 600;
    position: sticky;
    top: 0;
    z-index: 10;
    color: black;
    text-align: center;
}
.data-table .basic-info-header {
    background-color: #ffd966;
}
.data-table .technical-info-header {
    background-color: #d9ead3;
}

/* Inline search styles */
.header-search-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    min-height: 70px;
    padding: 5px;
}

.header-title {
    font-weight: 600;
    font-size: 12px;
    text-align: center;
    margin-bottom: 3px;
}

.header-search {
    width: 100%;
    max-width: 120px;
    padding: 4px 6px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 11px;
    background: white;
}

.header-search:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 3px rgba(0, 123, 255, 0.3);
}

.header-select {
    width: 100%;
    max-width: 120px;
    padding: 3px 4px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 10px;
    background: white;
}

.header-select:focus {
    border-color: #007bff;
    outline: none;
}

.sort-link {
    color: inherit;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.sort-link:hover {
    color: #007bff;
    text-decoration: none;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
}
.status-workable { background-color: #d4edda; color: #155724; }
.status-not-workable { background-color: #f8d7da; color: #721c24; }
.status-pending { background-color: #fff3cd; color: #856404; }
.status-comm { background-color: #d1ecf1; color: #0c5460; }
.connections-status {
    font-size: 11px;
    padding: 2px 6px;
    border-radius: 8px;
}
.area-badge {
    background-color: #e3f2fd;
    color: #1976d2;
    padding: 3px 8px;
    border-radius: 10px;
    font-size: 10px;
}

.text-success {
    color: #28a745 !important;
}

.text-danger {
    color: #dc3545 !important;
}

.text-warning {
    color: #ffc107 !important;
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

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

.btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: white;
}

.clear-filters-btn {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
    padding: 4px 8px;
    font-size: 11px;
    border-radius: 3px;
    margin-top: 5px;
}

.clear-filters-btn:hover {
    background-color: #c82333;
    border-color: #c82333;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .data-table th, .data-table td {
        min-width: 100px;
        font-size: 11px;
    }
    
    .header-search, .header-select {
        font-size: 10px;
        max-width: 90px;
    }
    
    .action-buttons {
        flex-direction: column;
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

    <h1 class="page-title">PNG Data Tracker</h1>

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
        </div>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form id="search-form" action="{{ route('png.index') }}" method="GET">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
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
                                           onchange="submitSearch()">
                                  
                                </div>
                            </th>

                            <!-- Customer No Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Customer No</div>
                                    <input type="text" name="customer_no" class="header-search" 
                                           value="{{ request('customer_no') }}" 
                                           placeholder="Search..."
                                           oninput="debounceSearch(this)">
                                </div>
                            </th>

                            <!-- Order No Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Order No</div>
                                    <input type="text" name="service_order_no" class="header-search" 
                                           value="{{ request('service_order_no') }}" 
                                           placeholder="Search..."
                                           oninput="debounceSearch(this)">
                                </div>
                            </th>

                            <!-- Application No Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Application No</div>
                                    <input type="text" name="application_no" class="header-search" 
                                           value="{{ request('application_no') }}" 
                                           placeholder="Search..."
                                           oninput="debounceSearch(this)">
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
                                           oninput="debounceSearch(this)">
                                </div>
                            </th>

                            <!-- Contact No Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Contact No</div>
                                    <input type="text" name="contact_no" class="header-search" 
                                           value="{{ request('contact_no') }}" 
                                           placeholder="Search..."
                                           oninput="debounceSearch(this)">
                                </div>
                            </th>

                            <!-- Address Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Address</div>
                                    <input type="text" name="address" class="header-search" 
                                           value="{{ request('address') }}" 
                                           placeholder="Search address..."
                                           oninput="debounceSearch(this)">
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
                                       <input type="text" name="area" class="header-search" 
                                           value="{{ request('area') }}" 
                                           placeholder="Search..."
                                           oninput="debounceSearch(this)">
                                    {{-- <select name="area" class="header-select" onchange="submitSearch()">
                                        <option value="">-- All --</option>
                                        @foreach(\App\Models\Png::getAreaOptions() as $key => $value)
                                            <option value="{{ $key }}" {{ request('area') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </th>

                            <!-- Scheme Column -->
                            <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Scheme</div>
                                    <select name="scheme" class="header-select" onchange="submitSearch()">
                                        <option value="">-- All --</option>
                                        @foreach(\App\Models\Png::getSchemeOptions() as $key => $value)
                                            <option value="{{ $key }}" {{ request('scheme') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </th>

                            <!-- Connections Status Column -->
                            {{-- <th class="technical-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">
                                        <a href="{{ route('png.index', array_merge(request()->query(), ['sort' => 'connections_status', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="sort-link">
                                            Connections Status
                                            @if(request('sort') === 'connections_status')
                                                <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </div>
                                    <select name="connections_status" class="header-select" onchange="submitSearch()">
                                        <option value="">-- All --</option>
                                        @foreach(\App\Models\Png::getConnectionsStatusOptions() as $key => $value)
                                            <option value="{{ $key }}" {{ request('connections_status') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </th> --}}

                            <!-- Plumber Name Column -->
                            {{-- <th class="technical-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Plumber Name</div>
                                    <input type="text" name="plumber_name" class="header-search" 
                                           value="{{ request('plumber_name') }}" 
                                           placeholder="Search..."
                                           oninput="debounceSearch(this)">
                                </div>
                            </th> --}}

                            <!-- Conversion Status Column -->
                            {{-- <th class="technical-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Conversion Status</div>
                                    <select name="conversion_status" class="header-select" onchange="submitSearch()">
                                        <option value="">-- All --</option>
                                        @foreach(\App\Models\Png::getConversionStatusOptions() as $key => $value)
                                            <option value="{{ $key }}" {{ request('conversion_status') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </th> --}}

                            <!-- Meter Number Column -->
                            {{-- <th class="technical-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Meter Number</div>
                                    <input type="text" name="meter_number" class="header-search" 
                                           value="{{ request('meter_number') }}" 
                                           placeholder="Search..."
                                           oninput="debounceSearch(this)">
                                </div>
                            </th> --}}

                            <!-- Measurement Type Column -->
                            {{-- <th class="technical-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">Measurement Type</div>
                                    <select name="png_measurement_type_id" class="header-select" onchange="submitSearch()">
                                        <option value="">-- All --</option>
                                        @foreach($measurementTypes as $type)
                                            <option value="{{ $type->id }}" {{ request('png_measurement_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </th> --}}

                              <th class="basic-info-header">
                                <div class="header-search-container">
                                    <div class="header-title">SLA Days</div>
                                    <input type="text" name="sla_days" class="header-search" 
                                           value="{{ request('sla_days') }}" 
                                           placeholder="Search..."
                                           oninput="debounceSearch(this)">
                                </div>
                            </th>

                            <!-- Actions Column -->
                            <th class="technical-info-header">
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
                                <td>{{ $png->agreement_date ? $png->agreement_date->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $png->customer_no ?? 'N/A' }}</td>
                                <td>{{ $png->service_order_no ?? 'N/A' }}</td>
                                <td>{{ $png->application_no ?? 'N/A' }}</td>
                                <td><strong>{{ $png->customer_name }}</strong></td>
                                <td>{{ $png->contact_no ?? 'N/A' }}</td>
                                <td title="{{ $png->address }}">{{ Str::limit($png->address, 25) }}</td>
                                <td>
                                    @if($png->area)
                                        <span class="area-badge">{{ ucfirst(str_replace('_', ' ', $png->area)) }}</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $png->scheme ? ucfirst(str_replace('_', ' ', $png->scheme)) : 'N/A' }}</td>
                                {{-- <td>
                                    @if($png->connections_status)
                                        <span class="status-badge status-{{ strtolower(str_replace(['_', ' '], '-', $png->connections_status)) }} connections-status">
                                            {{ ucfirst(str_replace('_', ' ', $png->connections_status)) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $png->plb_name ?? 'N/A' }}</td>
                                <td>
                                    @if($png->conversion_status)
                                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $png->conversion_status)) }}">
                                            {{ ucfirst(str_replace('_', ' ', $png->conversion_status)) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $png->meter_number ?? 'N/A' }}</td>
                                <td>
                                    @if($png->measurementType)
                                        <span class="badge badge-info" title="{{ $png->measurementType->description ?? '' }}">
                                            {{ $png->measurementType->name }}
                                        </span>
                                    @else
                                        <span class="text-muted">No Type</span>
                                    @endif
                                </td> --}}
                                <td>{{$png->SlaCalculatedDays}}</td>
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
                                <td colspan="15" style="text-align: center; padding: 15px;">
                                    No PNG jobs found. 
                                    <a href="{{ route('png.create') }}">Create the first PNG job</a> or 
                                    <a href="{{ route('png.import.form') }}">import from Excel</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <div style="margin-top: 15px; display: flex; justify-content: center;">
            {{ $pngs->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let searchTimeout;

    function debounceSearch(input) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (input.value.length >= 2 || input.value.length === 0) {
                submitSearch();
            }
        }, 500); // Wait 500ms after user stops typing
    }

    function submitSearch() {
        document.getElementById('search-form').submit();
    }

    function clearAllFilters() {
        // Clear all input fields
        document.querySelectorAll('#search-form input').forEach(input => {
            if (input.type === 'text' || input.type === 'date') {
                input.value = '';
            }
        });
        
        // Clear all select fields
        document.querySelectorAll('#search-form select').forEach(select => {
            select.selectedIndex = 0;
        });
        
        // Submit the form to apply cleared filters
        submitSearch();
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Add visual feedback for active filters
        updateFilterIndicators();
    });

    function updateFilterIndicators() {
        const form = document.getElementById('search-form');
        const inputs = form.querySelectorAll('input, select');
        let hasActiveFilters = false;

        inputs.forEach(input => {
            if (input.value && input.value.trim() !== '') {
                hasActiveFilters = true;
                input.style.borderColor = '#007bff';
                input.style.backgroundColor = '#e3f2fd';
            } else {
                input.style.borderColor = '#ccc';
                input.style.backgroundColor = 'white';
            }
        });

        // Update clear button visibility
        const clearBtn = document.querySelector('.clear-filters-btn');
        if (clearBtn) {
            clearBtn.style.display = hasActiveFilters ? 'block' : 'none';
        }
    }
</script>
@endsection