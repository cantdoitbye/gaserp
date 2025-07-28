@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
.measurement-type-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 20px;
    background: white;
}
.measurement-type-header {
    background: #f8f9fa;
    padding: 15px 20px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.measurement-type-body {
    padding: 20px;
}
.measurement-type-title {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    color: #495057;
}
.measurement-type-meta {
    font-size: 14px;
    color: #6c757d;
    margin-top: 5px;
}
.field-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 15px;
    margin-top: 15px;
}
.field-item {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 12px;
    font-size: 14px;
}
.field-name {
    font-weight: 600;
    color: #495057;
}
.field-details {
    color: #6c757d;
    margin-top: 5px;
}
.status-active {
    background: #d4edda;
    color: #155724;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}
.status-inactive {
    background: #f8d7da;
    color: #721c24;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}
.png-type-badge {
    background: #e3f2fd;
    color: #1976d2;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    text-transform: capitalize;
}
</style>
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="search-box">
            <!-- Search functionality can be added here -->
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">Measurement Types Management</h1>

    <div class="content-card">
        <div class="action-buttons">
            <a href="{{ route('png-measurement-types.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Measurement Type
            </a>
            <form action="{{ route('png-measurement-types.create-defaults') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('This will create default measurement types for Flat, House, and Bungalow. Continue?')">
                    <i class="fas fa-magic"></i> Create Default Types
                </button>
            </form>
            <a href="{{ route('png.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to PNG Jobs
            </a>
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

        @forelse($measurementTypes as $type)
            <div class="measurement-type-card">
                <div class="measurement-type-header">
                    <div>
                        <h3 class="measurement-type-title">{{ $type->name }}</h3>
                        <div class="measurement-type-meta">
                            <span class="png-type-badge">{{ $type->png_type }}</span>
                            <span class="{{ $type->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $type->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="text-muted">
                                • {{ count($type->measurement_fields) }} fields 
                                • {{ $type->pngs_count ?? 0 }} jobs using this type
                            </span>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                            Actions
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('png-measurement-types.show', $type) }}">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <a class="dropdown-item" href="{{ route('png-measurement-types.edit', $type) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('png-measurement-types.toggle-status', $type) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-power-off"></i> 
                                    {{ $type->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('png-measurement-types.destroy', $type) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger" 
                                        onclick="return confirm('Are you sure? This will permanently delete this measurement type.')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="measurement-type-body">
                    @if($type->description)
                        <p class="text-muted">{{ $type->description }}</p>
                    @endif
                    
                    <h5>Measurement Fields:</h5>
                    <div class="field-grid">
                        @foreach($type->measurement_fields as $field)
                            <div class="field-item">
                                <div class="field-name">
                                    {{ $field['label'] ?? $field['name'] }}
                                    @if($field['required'] ?? false)
                                        <span class="text-danger">*</span>
                                    @endif
                                </div>
                                <div class="field-details">
                                    Type: {{ ucfirst($field['type']) }}
                                    @if($field['unit'] ?? false)
                                        • Unit: {{ $field['unit'] }}
                                    @endif
                                    @if($field['calculated'] ?? false)
                                        • <span class="text-info">Auto-calculated</span>
                                    @endif
                                    <br>
                                    Category: {{ ucfirst($field['category'] ?? 'general') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-ruler-combined fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Measurement Types Found</h4>
                <p class="text-muted">Create your first measurement type to get started with dynamic PNG measurements.</p>
                <a href="{{ route('png-measurement-types.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create First Measurement Type
                </a>
            </div>
        @endforelse

        @if($measurementTypes->hasPages())
            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $measurementTypes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection