@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-tools"></i>
        <span>Service Types</span>
    </div>
    <a href="{{ route('dashboard') }}" class="back-button">Back to Dashboard</a>
</div>

<div class="content-container">
    <div class="actions-section">
        <a href="{{ route('service-types.create') }}" class="btn btn-create">
            <i class="fas fa-plus"></i> Create New Service Type
        </a>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    
    <div class="service-types-list">
        @if($serviceTypes->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($serviceTypes as $serviceType)
                        <tr>
                            <td>{{ $serviceType->id }}</td>
                            <td>{{ ucfirst($serviceType->name) }}</td>
                            <td>{{ $serviceType->created_at->format('d M Y') }}</td>
                            <td class="actions">
                                <a href="{{ route('service-types.edit', $serviceType->id) }}" class="btn btn-sm btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('service-types.destroy', $serviceType->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this service type? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="pagination-container">
                {{ $serviceTypes->links() }}
            </div>
        @else
            <div class="no-data">
                <i class="fas fa-tools empty-icon"></i>
                <h3>No service types found</h3>
                <p>There are no service types in the system yet. Create your first service type to get started.</p>
                <a href="{{ route('service-types.create') }}" class="btn btn-create">Create Service Type</a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .desk-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .desk-title {
        display: flex;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
    }

    .desk-title i {
        font-size: 24px;
        margin-right: 10px;
        color: #e31e24;
    }

    .back-button {
        background-color: #f0f0f0;
        color: #333;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }

    .back-button:hover {
        background-color: #e0e0e0;
    }

    .content-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 20px;
    }

    .actions-section {
        margin-bottom: 20px;
    }

    .btn {
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        border: none;
        transition: background-color 0.2s;
    }

    .btn i {
        margin-right: 5px;
    }

    .btn-create {
        background-color: #28a745;
        color: white;
    }

    .btn-edit {
        background-color: #ffc107;
        color: #333;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .alert {
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .table th {
        background-color: #f9f9f9;
        font-weight: 600;
    }

    .actions {
        display: flex;
        gap: 8px;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
    }

    .delete-form {
        margin: 0;
    }

    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .no-data {
        text-align: center;
        padding: 40px 0;
        color: #666;
    }

    .empty-icon {
        font-size: 48px;
        color: #ddd;
        margin-bottom: 15px;
    }

    .no-data h3 {
        margin-bottom: 10px;
        color: #333;
    }

    .no-data p {
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .actions {
            flex-direction: column;
            gap: 5px;
        }

        .btn-sm {
            width: 100%;
        }
    }
</style>
@endsection
