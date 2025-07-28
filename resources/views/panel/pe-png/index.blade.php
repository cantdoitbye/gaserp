@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-png-tracker.css') }}">
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

    <h1 class="page-title">PE/PNG Data Tracker</h1>

    <div class="content-card">
        <div class="action-buttons">
            <a href="{{ route('pe-png.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Job
            </a>
            <a href="{{ route('pe-png.import.form') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Import Excel
            </a>
            <a href="{{ route('pe-png.export') }}" class="btn btn-secondary">
                <i class="fas fa-download"></i> Export Data
            </a>
            <button class="btn btn-secondary" onclick="toggleFilters()">
                <i class="fas fa-filter"></i> Filters
            </button>
        </div>

        <div id="filters-section" class="filters-section" style="display: none;">
            <form action="{{ route('pe-png.index') }}" method="GET">
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">Category</label>
                        <select name="category" class="filter-control">
                            <option value="">All Categories</option>
                            <option value="domestic" {{ request('category') == 'domestic' ? 'selected' : '' }}>Domestic</option>
                            <option value="commercial" {{ request('category') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="riser" {{ request('category') == 'riser' ? 'selected' : '' }}>Riser</option>
                            <option value="gc" {{ request('category') == 'gc' ? 'selected' : '' }}>GC</option>
                            <option value="conversion" {{ request('category') == 'conversion' ? 'selected' : '' }}>Conversion</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Plumber</label>
                        <select name="plumber_id" class="filter-control">
                            <option value="">All Plumbers</option>
                            @foreach($plumbers as $plumber)
                                <option value="{{ $plumber->id }}" {{ request('plumber_id') == $plumber->id ? 'selected' : '' }}>
                                    {{ $plumber->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="filter-row">
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
                    <a href="{{ route('pe-png.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <table class="data-table">
            <thead>
                <tr>
                    <th>Job Order #</th>
                    <th>Category</th>
                    <th>Plumbing Date</th>
                    <th>Plumber</th>
                    <th>GC Date</th>
                    <th>MMT Date</th>
                    <th>Bill Status</th>
                    <th>SLA Days</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pePngs as $pePng)
                    <tr>
                        <td>{{ $pePng->job_order_number }}</td>
                        <td>{{ ucfirst($pePng->category) }}</td>
                        <td>{{ $pePng->plumbing_date->format('d-m-Y') }}</td>
                        <td>{{ $pePng->plumber ? $pePng->plumber->name : 'N/A' }}</td>
                        <td>{{ $pePng->gc_date ? $pePng->gc_date->format('d-m-Y') : 'N/A' }}</td>
                        <td>{{ $pePng->mmt_date ? $pePng->mmt_date->format('d-m-Y') : 'N/A' }}</td>
                        <td>
                            <span class="badge 
                                @if($pePng->plb_bill_status == 'pending') badge-warning
                                @elseif($pePng->plb_bill_status == 'processed') badge-primary
                                @elseif($pePng->plb_bill_status == 'paid') badge-success
                                @elseif($pePng->plb_bill_status == 'locked') badge-danger
                                @endif">
                                {{ ucfirst($pePng->plb_bill_status) }}
                            </span>
                        </td>
                        <td>{{ $pePng->sla_days ?? 'N/A' }}</td>
                        <td>
                            <div class="action-icons">
                                <a href="{{ route('pe-png.show', $pePng) }}" class="action-icon icon-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pe-png.edit', $pePng) }}" class="action-icon icon-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pe-png.destroy', $pePng) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-icon icon-delete" title="Delete" 
                                            onclick="return confirm('Are you sure you want to delete this job?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 15px;">No PE/PNG jobs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 15px; display: flex; justify-content: center;">
            {{ $pePngs->links() }}
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