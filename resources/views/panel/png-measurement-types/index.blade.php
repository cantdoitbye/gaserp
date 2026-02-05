@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
<style>
.measurement-type-card {
    border: none;
    border-radius: 12px;
    margin-bottom: 24px;
    background: white;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.measurement-type-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}
.measurement-type-header {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    padding: 20px 25px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 12px 12px 0 0;
}
.measurement-type-body {
    padding: 25px;
}
.measurement-type-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    color: white;
    display: flex;
    align-items: center;
    gap: 12px;
}
.measurement-type-meta {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.8);
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 15px;
}
.field-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 20px;
}
.field-item {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 15px;
    font-size: 14px;
    transition: border-color 0.2s ease;
}
.field-item:hover {
    border-color: #adb5bd;
}
.field-name {
    font-weight: 600;
    color: #495057;
    margin-bottom: 6px;
    font-size: 15px;
}
.field-details {
    color: #6c757d;
    font-size: 13px;
    line-height: 1.5;
}
.status-active {
    background: #d4edda;
    color: #155724;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.status-active::before {
    content: '';
    width: 6px;
    height: 6px;
    background: #155724;
    border-radius: 50%;
}
.status-inactive {
    background: #f8d7da;
    color: #721c24;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.status-inactive::before {
    content: '';
    width: 6px;
    height: 6px;
    background: #721c24;
    border-radius: 50%;
}
.png-type-badge {
    background: #e7f5ff;
    color: #1c7ed6;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize;
    letter-spacing: 0.5px;
}

/* New Action Buttons Styling */
.action-buttons {
    display: flex;
    gap: 12px;
    margin-bottom: 25px;
    flex-wrap: wrap;
}
.action-buttons .btn {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
    border: none;
}
.action-buttons .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.action-buttons .btn-primary {
    background: linear-gradient(135deg, #0d6efd, #0b5ed7);
}
.action-buttons .btn-success {
    background: linear-gradient(135deg, #198754, #157347);
}
.action-buttons .btn-secondary {
    background: linear-gradient(135deg, #6c757d, #5c636a);
}

/* Action Group for Items */
.action-group {
    display: flex;
    gap: 8px;
    align-items: center;
}
.btn-icon {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    color: #495057;
    background: white;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
}
.btn-icon:hover {
    background: #f8f9fa;
    color: #0d6efd;
    border-color: #0d6efd;
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.08);
}
.btn-icon.btn-icon-danger:hover {
    color: #dc3545;
    border-color: #dc3545;
    background: #fff5f5;
}
.btn-icon.btn-icon-warning:hover {
    color: #ffc107;
    border-color: #ffc107;
    background: #fff9db;
}
.btn-icon i {
    font-size: 14px;
}
</style>
@endsection

@section('content')
<div class="main-container">


    <h1 class="page-title">Measurement Types Management</h1>

    <div class="content-card" style="background: transparent; box-shadow: none; padding: 0;">
        <div class="action-buttons">
            <a href="{{ route('png-measurement-types.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Type
            </a>
            <form action="{{ route('png-measurement-types.create-defaults') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('This will create default measurement types for Flat, House, and Bungalow. Continue?')">
                    <i class="fas fa-magic"></i> Create Defaults
                </button>
            </form>
            <a href="{{ route('png.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to PNG Jobs
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success" role="alert" style="border-radius: 10px; border: none; background: #d1e7dd; color: #0f5132;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" role="alert" style="border-radius: 10px; border: none; background: #f8d7da; color: #842029;">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif

        @forelse($measurementTypes as $type)
            <div class="measurement-type-card">
                <div class="measurement-type-header">
                    <div>
                        <h3 class="measurement-type-title">
                            {{ $type->name }}
                        </h3>
                        <div class="measurement-type-meta">
                            <span class="png-type-badge">{{ $type->png_type }}</span>
                            <span class="{{ $type->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $type->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <span style="opacity: 0.6;">|</span>
                            <span>
                                <i class="fas fa-ruler-combined me-1"></i> {{ count($type->measurement_fields) }} fields
                            </span>
                            <span>
                                <i class="fas fa-briefcase me-1"></i> {{ $type->pngs_count ?? 0 }} jobs
                            </span>
                        </div>
                    </div>
                    
                    <div class="action-group">
                        <a href="{{ route('png-measurement-types.show', $type) }}" class="btn-icon" title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('png-measurement-types.edit', $type) }}" class="btn-icon" title="Edit Type">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <form action="{{ route('png-measurement-types.toggle-status', $type) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-icon btn-icon-warning" title="{{ $type->is_active ? 'Deactivate' : 'Activate' }}">
                                <i class="fas fa-power-off"></i>
                            </button>
                        </form>
                        
                        <form action="{{ route('png-measurement-types.destroy', $type) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-icon-danger" title="Delete Type" 
                                    onclick="return confirm('Are you sure? This will permanently delete this measurement type.')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
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