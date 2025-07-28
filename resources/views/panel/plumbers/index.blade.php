@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-png-tracker.css') }}">
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="search-input" placeholder="Search plumbers...">
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">Plumber Management</h1>

    <div class="content-card">
        <div class="action-buttons">
            <a href="{{ route('plumbers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Plumber
            </a>
            <a href="{{ route('pe-png.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to PE/PNG Tracker
            </a>
            <button class="btn btn-secondary" onclick="toggleFilters()">
                <i class="fas fa-filter"></i> Filters
            </button>
        </div>

        <div id="filters-section" class="filters-section" style="display: none;">
            <form action="{{ route('plumbers.index') }}" method="GET">
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-control">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Search Term</label>
                        <input type="text" name="search" class="filter-control" value="{{ request('search') }}" placeholder="Name, Email or Phone">
                    </div>
                </div>
                <div class="filter-buttons">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('plumbers.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <table class="data-table">
            <thead>
                <tr>
                    {{-- <th>S</th> --}}
                    <th>Plumber ID</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Jobs Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plumbers as $plumber)
                    <tr>
                        <td>{{ $plumber->plumber_id }}</td>
                        <td>{{ $plumber->name }}</td>
                        <td>{{ $plumber->contact_number ?? 'N/A' }}</td>
                        <td>{{ $plumber->email ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $plumber->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($plumber->status) }}
                            </span>
                        </td>
                        <td>{{ $plumber->pePngs_count ?? $plumber->pePngs()->count() }}</td>
                        <td>
                            <div class="action-icons">
                                <a href="{{ route('plumbers.show', $plumber) }}" class="action-icon icon-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('plumbers.edit', $plumber) }}" class="action-icon icon-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('plumbers.destroy', $plumber) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-icon icon-delete" title="Delete" 
                                            onclick="return confirm('Are you sure you want to delete this plumber?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 15px;">No plumbers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 15px; display: flex; justify-content: center;">
            {{ $plumbers->links() }}
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

    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                window.location.href = "{{ route('plumbers.index') }}?search=" + this.value;
            }
        });
    });
</script>
@endsection