@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search PE tracker records...">
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">PE Tracker</h1>

    <div class="content-card">
        <div class="action-buttons">
            <a href="{{ route('pe-tracker.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Record
            </a>
            <a href="{{ route('pe-tracker.import.form') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Import Excel
            </a>
            <a href="{{ route('pe-tracker.export') }}" class="btn btn-secondary">
                <i class="fas fa-download"></i> Export Data
            </a>
            <button class="btn btn-secondary" onclick="toggleFilters()">
                <i class="fas fa-filter"></i> Filters
            </button>
        </div>

        <div id="filters-section" class="filters-section" style="display: none;">
            <form action="{{ route('pe-tracker.index') }}" method="GET">
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">Activity</label>
                        <select name="activity" class="filter-control">
                            <option value="">All Activities</option>
                            @foreach($activities as $key => $value)
                                <option value="{{ $key }}" {{ request('activity') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Supervisor</label>
                        <select name="supervisor" class="filter-control">
                            <option value="">All Supervisors</option>
                            @foreach($supervisors as $supervisor)
                                <option value="{{ $supervisor }}" {{ request('supervisor') == $supervisor ? 'selected' : '' }}>
                                    {{ $supervisor }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Mukadam</label>
                        <select name="mukadam_name" class="filter-control">
                            <option value="">All Mukadams</option>
                            @foreach($mukadams as $mukadam)
                                <option value="{{ $mukadam }}" {{ request('mukadam_name') == $mukadam ? 'selected' : '' }}>
                                    {{ $mukadam }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">DPR No</label>
                        <input type="text" name="dpr_no" class="filter-control" value="{{ request('dpr_no') }}" placeholder="Enter DPR number">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Start Date</label>
                        <input type="date" name="start_date" class="filter-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">End Date</label>
                        <input type="date" name="end_date" class="filter-control" value="{{ request('end_date') }}">
                    </div>
                </div>
                <div class="filter-buttons">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('pe-tracker.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>
                            <a href="{{ route('pe-tracker.index', array_merge(request()->query(), ['sort' => 'date', 'direction' => request('sort') == 'date' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                Date
                                @if(request('sort') == 'date')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('pe-tracker.index', array_merge(request()->query(), ['sort' => 'dpr_no', 'direction' => request('sort') == 'dpr_no' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                DPR No
                                @if(request('sort') == 'dpr_no')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Site Names</th>
                        <th>
                            <a href="{{ route('pe-tracker.index', array_merge(request()->query(), ['sort' => 'activity', 'direction' => request('sort') == 'activity' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                Activity
                                @if(request('sort') == 'activity')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Mukadam</th>
                        <th>
                            <a href="{{ route('pe-tracker.index', array_merge(request()->query(), ['sort' => 'supervisor', 'direction' => request('sort') == 'supervisor' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                Supervisor
                                @if(request('sort') == 'supervisor')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>TPI Name</th>
                        <th>RA Bill No</th>
                        <th>
                            <a href="{{ route('pe-tracker.index', array_merge(request()->query(), ['sort' => 'total_laying_length', 'direction' => request('sort') == 'total_laying_length' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                Total Laying (m)
                                @if(request('sort') == 'total_laying_length')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peTrackers as $peTracker)
                        <tr>
                            <td>{{ $peTracker->formatted_date }}</td>
                            <td>{{ $peTracker->dpr_no ?? 'N/A' }}</td>
                            <td>
                                <div class="site-names-cell" title="{{ $peTracker->sites_names }}">
                                    {{ Str::limit($peTracker->sites_names, 30) }}
                                </div>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($peTracker->activity == 'LAYING') badge-primary
                                    @elseif($peTracker->activity == 'COMMISSIONING') badge-success
                                    @elseif($peTracker->activity == 'EXCAVATION') badge-warning
                                    @elseif($peTracker->activity == 'FLUSHING') badge-info
                                    @elseif($peTracker->activity == 'JOINT') badge-secondary
                                    @elseif($peTracker->activity == 'SR INSTALLATION') badge-dark
                                    @endif">
                                    {{ $peTracker->activity }}
                                </span>
                            </td>
                            <td>{{ $peTracker->mukadam_name ?? 'N/A' }}</td>
                            <td>{{ $peTracker->supervisor ?? 'N/A' }}</td>
                            <td>{{ $peTracker->tpi_name ?? 'N/A' }}</td>
                            <td>{{ $peTracker->ra_bill_no ?? 'N/A' }}</td>
                            <td>{{ $peTracker->total_laying_length ? number_format($peTracker->total_laying_length, 2) : '0.00' }}</td>
                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('pe-tracker.show', $peTracker) }}" class="action-icon icon-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pe-tracker.edit', $peTracker) }}" class="action-icon icon-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pe-tracker.destroy', $peTracker) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-icon icon-delete" title="Delete" 
                                                onclick="return confirm('Are you sure you want to delete this record?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 15px;">No PE tracker records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 15px; display: flex; justify-content: center;">
            {{ $peTrackers->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleFilters() {
        var filtersSection = document.getElementById('filters-section');
        filtersSection.style.display = filtersSection.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endsection