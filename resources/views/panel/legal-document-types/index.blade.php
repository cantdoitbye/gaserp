@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-file-alt"></i>
        <span>Legal Document Types</span>
    </div>
    <a href="{{ route('legal-desk.index') }}" class="back-button">Back to Legal Desk</a>
</div>

<div class="document-types-container">
    <div class="actions-bar">
        <a href="{{ route('legal-document-types.create') }}" class="add-btn">
            <i class="fas fa-plus"></i> Add New Document Type
        </a>
    </div>
    
    @if($documentTypes->count() > 0)
        <table class="document-types-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Requires Expiry</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documentTypes as $documentType)
                    <tr>
                        <td>{{ $documentType->name }}</td>
                        <td>{{ $documentType->description ?: 'No description' }}</td>
                        <td>
                            <span class="badge {{ $documentType->requires_expiry ? 'badge-success' : 'badge-secondary' }}">
                                {{ $documentType->requires_expiry ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-links">
                                <a href="{{ route('legal-document-types.edit', $documentType->id) }}" class="edit-link" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('legal-document-types.destroy', $documentType->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-link" title="Delete" onclick="return confirm('Are you sure you want to delete this document type?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>No document types found. <a href="{{ route('legal-document-types.create') }}">Add your first document type</a>.</p>
        </div>
    @endif
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
    
    .document-types-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .actions-bar {
        padding: 15px;
        background-color: #f5f5f5;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
    }
    
    .add-btn {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .add-btn i {
        margin-right: 5px;
    }
    
    .document-types-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .document-types-table th, 
    .document-types-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    
    .document-types-table th {
        background-color: #f9f9f9;
        font-weight: 600;
    }
    
    .badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .badge-success {
        background-color: #e6f7e6;
        color: #28a745;
    }
    
    .badge-secondary {
        background-color: #e6e6e6;
        color: #6c757d;
    }
    
    .action-links {
        display: flex;
        gap: 10px;
    }
    
    .action-links a,
    .action-links button {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        text-decoration: none;
        color: white;
        border: none;
        cursor: pointer;
    }
    
    .edit-link {
        background-color: #ffc107;
    }
    
    .delete-link {
        background-color: #dc3545;
    }
    
    .delete-form {
        margin: 0;
    }
    
    .no-data {
        padding: 30px;
        text-align: center;
        color: #777;
    }
</style>
@endsection