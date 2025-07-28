@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-file-contract"></i>
        <span>Legal Documents</span>
    </div>
    <a href="{{ route('legal-desk.index') }}" class="back-button">Back to Legal Desk</a>
</div>

<!-- Filters Section -->
<div class="filters-container">
    <form action="{{ route('project-legal-documents.index') }}" method="GET" class="filters-form">
        <div class="filters">
            <div class="filter">
                <label for="project_id" class="filter-label">Project</label>
                <select name="project_id" id="project_id" class="filter-select">
                    <option value="">All Projects</option>
                    @foreach($projects as $id => $name)
                        <option value="{{ $id }}" {{ request('project_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter">
                <label for="document_type_id" class="filter-label">Document Type</label>
                <select name="document_type_id" id="document_type_id" class="filter-select">
                    <option value="">All Document Types</option>
                    @foreach($documentTypes as $id => $name)
                        <option value="{{ $id }}" {{ request('document_type_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter">
                <label for="status" class="filter-label">Status</label>
                <select name="status" id="status" class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="valid" {{ request('status') == 'valid' ? 'selected' : '' }}>Valid</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="upcoming_expiry" {{ request('status') == 'upcoming_expiry' ? 'selected' : '' }}>Upcoming Expiry</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="filter-buttons">
                <button type="submit" class="filter-btn">Filter</button>
                <a href="{{ route('project-legal-documents.index') }}" class="reset-btn">Reset</a>
            </div>
        </div>
    </form>
    <div class="action-buttons">
        <a href="{{ route('project-legal-documents.create') }}" class="add-btn">
            <i class="fas fa-plus"></i> Add New Document
        </a>
    </div>
</div>

<!-- Documents List -->
<div class="documents-container">
    @if($documents->count() > 0)
        <table class="documents-table">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Document Type</th>
                    <th>Issue Date</th>
                   <th>License Number</th>
<th>Application Date</th>
<th>
    <a href="{{ route('project-legal-documents.index', array_merge(request()->query(), ['sort' => 'validity_date', 'direction' => request('sort') === 'validity_date' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="sort-link">
        Validity Date
        @if(request('sort') === 'validity_date')
            <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
        @else
            <i class="fas fa-sort"></i>
        @endif
    </a>
</th>
<th>Reapply Date</th>
<th>
    <a href="{{ route('project-legal-documents.index', array_merge(request()->query(), ['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="sort-link">
        Status
        @if(request('sort') === 'status')
            <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
        @else
            <i class="fas fa-sort"></i>
        @endif
    </a>
</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $document)
                    <tr class="{{ $document->status === 'expired' ? 'expired-row' : ($document->status === 'upcoming_expiry' ? 'upcoming-expiry-row' : '') }}">
                        <td>{{ $document->project->name }}</td>
                        <td>{{ $document->legalDocumentType->name }}</td>
                        <td>{{ $document->issue_date ? $document->issue_date->format('d/m/Y') : '-' }}</td>
                        
                        
<td>{{ $document->license_number ?: '-' }}</td>
<td>{{ $document->application_date ? $document->application_date->format('d/m/Y') : '-' }}</td>
<td>{{ $document->validity_date ? $document->validity_date->format('d/m/Y') : '-' }}</td>
<td>{{ $document->reapply_date ? $document->reapply_date->format('d/m/Y') : '-' }}</td>
                        <td>
                            {{-- <span class="status-badge status-{{ $document->status }}">
                                {{ ucfirst(str_replace('_', ' ', $document->status)) }}
                            </span> --}}

                              <td>
    <span class="status-badge status-{{ $document->status }}">
        {{ ucfirst(str_replace('_', ' ', $document->status)) }}
    </span>
    {!! $document->getDaysStatusHtml() !!}
    
    @if($document->reapplication_status)
        <div class="reapplication-status">
            Reapplication: {{ ucfirst(str_replace('_', ' ', $document->reapplication_status)) }}
        </div>
    @endif

                        </td>
                        <td>
                            <div class="action-links">
                                <a href="{{ route('project-legal-documents.show', $document->id) }}" class="view-link" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('project-legal-documents.edit', $document->id) }}" class="edit-link" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($document->document_file)
                                    <a href="{{ route('project-legal-documents.download', $document->id) }}" class="download-link" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                @endif
                                <form action="{{ route('project-legal-documents.destroy', $document->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-link" title="Delete" onclick="return confirm('Are you sure you want to delete this document?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="pagination-container">
            {{ $documents->appends(request()->query())->links() }}
        </div>
    @else
        <div class="no-documents">
            <p>No legal documents found. <a href="{{ route('project-legal-documents.create') }}">Add your first document</a>.</p>
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

    .filters-container {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .filters {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 15px;
    }

    .filter {
        flex: 1;
        min-width: 200px;
    }

    .filter-label {
        display: block;
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
    }

    .filter-select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: white;
    }

    .filter-buttons {
        display: flex;
        gap: 10px;
        align-items: flex-end;
    }

    .filter-btn {
        background-color: #e31e24;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
    }

    .reset-btn {
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ddd;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }

    .action-buttons {
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

    .documents-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .documents-table {
        width: 100%;
        border-collapse: collapse;
    }

    .documents-table th,
    .documents-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .documents-table th {
        background-color: #f5f5f5;
        font-weight: 600;
        color: #333;
    }

    .expired-row {
        background-color: #fff5f5;
    }

    .upcoming-expiry-row {
        background-color: #fffbf0;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-valid {
        background-color: #e6f7e6;
        color: #28a745;
    }

    .status-expired {
        background-color: #ffe6e6;
        color: #dc3545;
    }

    .status-upcoming_expiry {
        background-color: #fff3e0;
        color: #ff9800;
    }

    .status-pending {
        background-color: #e6e6e6;
        color: #6c757d;
    }

      /* Days count styling */
    .days-count {
        display: block;
        margin-top: 5px;
        font-size: 11px;
        font-weight: 500;
    }

    .days-count.valid {
        color: #28a745;
    }

    .days-count.warning {
        color: #ff9800;
    }

    .days-count.expired {
        color: #dc3545;
    }

    .action-links {
        display: flex;
        gap: 10px;
        align-items: center;
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

    .view-link {
        background-color: #17a2b8;
    }

    .edit-link {
        background-color: #ffc107;
    }

    .download-link {
        background-color: #6c757d;
    }

    .delete-link {
        background-color: #dc3545;
    }

    .delete-form {
        margin: 0;
    }

    .pagination-container {
        padding: 15px;
        display: flex;
        justify-content: center;
    }

    .no-documents {
        padding: 30px;
        text-align: center;
        color: #777;
    }

    @media (max-width: 768px) {
        .filters {
            flex-direction: column;
        }

        .filter {
            width: 100%;
        }

        .documents-table {
            display: block;
            overflow-x: auto;
        }
    }

    .days-count.reapplied {
    color: #0c5460;
    background-color: #d1ecf1;
    border: 1px solid #bee5eb;
}

.status-reapplied {
    background-color: #d1ecf1;
    color: #0c5460;
}

.reapplication-status {
    font-size: 0.8em;
    margin-top: 4px;
    color: #6c757d;
    font-style: italic;
}
</style>
@endsection


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
// Add this to your existing script
const validityDateInput = document.getElementById('validity_date');
const reapplyDateInput = document.getElementById('reapply_date');

if (validityDateInput && reapplyDateInput) {
    validityDateInput.addEventListener('change', function() {
        if (this.value) {
            // Set reapply date to 30 days before validity date by default
            const validityDate = new Date(this.value);
            const reapplyDate = new Date(validityDate);
            reapplyDate.setDate(reapplyDate.getDate() - 30); // 30 days before expiry
            
            // Format the date as YYYY-MM-DD for the input field
            const reapplyDateFormatted = reapplyDate.toISOString().split('T')[0];
            reapplyDateInput.value = reapplyDateFormatted;
        }
    });
}

    });


</script>

@endsection