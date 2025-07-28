
@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-project-diagram"></i>
        <span>Project Details</span>
    </div>
    <a href="{{ route('projects.index') }}" class="back-button">Back to Projects</a>
</div>

<div class="project-details-container">
    <!-- Project Info Header -->
    <div class="project-info-header">
        <div class="project-title-section">
            <h2>{{ $project->name }}</h2>
            <span class="project-status status-{{ $project->status }}">{{ ucfirst($project->status) }}</span>
        </div>
        <div class="project-actions">
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-edit">
                <i class="fas fa-edit"></i> Edit Project
            </a>
            <a href="{{ route('projects.add-document', $project->id) }}" class="btn btn-document">
                <i class="fas fa-file-plus"></i> Add Document
            </a>
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this project? All associated documents will be lost. This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">
                    <i class="fas fa-trash"></i> Delete Project
                </button>
            </form>
        </div>
    </div>
    
    <!-- Project Info Body -->
    <div class="project-info-body">
        <!-- Basic Information -->
        <div class="info-section">
            <div class="section-header">
                <h3><i class="fas fa-info-circle"></i> Basic Information</h3>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Contract Number</div>
                    <div class="info-value">{{ $project->contract_number ?: 'Not specified' }}</div>
                </div>
                 <div class="info-item">
                    <div class="info-label">Callout/Release Order Date</div>
                    <div class="info-value">{{ $project->release_order_date ?: 'Not specified' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Location</div>
                    <div class="info-value">{{ $project->location ?: 'Not specified' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Start Date</div>
                    <div class="info-value">{{ $project->start_date ? $project->start_date->format('d M Y') : 'Not specified' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">End Date</div>
                    <div class="info-value">{{ $project->end_date ? $project->end_date->format('d M Y') : 'Not specified' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Project Manager</div>
                    <div class="info-value">{{ $project->project_manager ?: 'Not assigned' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value status-text-{{ $project->status }}">{{ ucfirst($project->status) }}</div>
                </div>
            </div>
            
            @if($project->description)
                <div class="project-description">
                    <div class="description-label">Description</div>
                    <div class="description-text">{{ $project->description }}</div>
                </div>
            @endif
        </div>


        <div class="info-section">
    <div class="section-header">
        <h3><i class="fas fa-file-signature"></i> Tender Information</h3>
    </div>
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Tender ID</div>
            <div class="info-value">{{ $project->tender_id ?: 'Not specified' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Prebid Meeting Date</div>
            <div class="info-value">{{ $project->prebid_meeting_date ? $project->prebid_meeting_date->format('d M Y') : 'Not specified' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Tender Submit Date</div>
            <div class="info-value">{{ $project->tender_submit_date ? $project->tender_submit_date->format('d M Y') : 'Not specified' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Price Open Percentage</div>
            <div class="info-value">{{ $project->price_open_percentage ? $project->price_open_percentage . '%' : 'Not specified' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Kick-off Meeting Date</div>
            <div class="info-value">{{ $project->kick_off_meeting_date ? $project->kick_off_meeting_date->format('d M Y') : 'Not specified' }}</div>
        </div>
    </div>
</div>

<div class="info-section">
    <div class="section-header">
        <h3><i class="fas fa-file-contract"></i> Contract Information</h3>
    </div>
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Contract Value</div>
            <div class="info-value">{{ $project->contact_value ? '₹' . number_format($project->contact_value, 2) : 'Not specified' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Contract Value Consumption</div>
            <div class="info-value">{{ $project->contract_value_consumption ? '₹' . number_format($project->contract_value_consumption, 2) : 'Not specified' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Contract Balance</div>
            <div class="info-value {{ $project->contract_balance < 0 ? 'text-danger' : '' }}">
                {{ $project->contract_balance ? '₹' . number_format($project->contract_balance, 2) : 'Not specified' }}
            </div>
        </div>
    </div>
</div>

<div class="info-section">
    <div class="section-header">
        <h3><i class="fas fa-file-alt"></i> Amendment Information</h3>
    </div>
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Amendment Date</div>
            <div class="info-value">{{ $project->amendment_date ? $project->amendment_date->format('d M Y') : 'Not specified' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Amendment Value</div>
            <div class="info-value">{{ $project->amendment_value ? '₹' . number_format($project->amendment_value, 2) : 'Not specified' }}</div>
        </div>
    </div>
</div>

{{-- <div class="info-section">
    <div class="section-header">
        <h3><i class="fas fa-id-card"></i> Labour License Information</h3>
    </div>
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Labour License Number</div>
            <div class="info-value">{{ $project->labour_licence_number ?: 'Not specified' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">License Application Date</div>
            <div class="info-value">{{ $project->licence_application_date ? $project->licence_application_date->format('d M Y') : 'Not specified' }}</div>
        </div>
    </div>
</div> --}}
        
        <!-- Client Information -->
        <div class="info-section">
            <div class="section-header">
                <h3><i class="fas fa-user-tie"></i> Client Information</h3>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Client Name</div>
                    <div class="info-value">{{ $project->client_name ?: 'Not specified' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Client Contact</div>
                    <div class="info-value">{{ $project->client_contact ?: 'Not specified' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Pipeline Information -->
        <div class="info-section">
            <div class="section-header">
                <h3><i class="fas fa-route"></i> Pipeline Information</h3>
            </div>
            <div class="pipeline-info-container">
                <div class="pipeline-specs">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Pipeline Length</div>
                            <div class="info-value">{{ $project->pipeline_length ? $project->pipeline_length . ' km' : 'Not specified' }}</div>
                        </div>
                        {{-- <div class="info-item">
                            <div class="info-label">Pipeline Type</div>
                            <div class="info-value pipeline-type-{{ str_replace('-', '', strtolower($project->pipeline_type)) }}">{{ $project->pipeline_type ?: 'Not specified' }}</div>
                        </div> --}}
                        <div class="info-item">
                            <div class="info-label">Pipeline Material</div>
                            <div class="info-value">{{ $project->pipeline_material ?: 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Service Type</div>
                            <div class="info-value">
                                @if($project->service_type)
                                    <span class="service-badge service-{{ $project->service_type }}">{{ ucfirst($project->service_type) }}</span>
                                @else
                                    Not specified
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($project->pipeline_length && $project->pipeline_type)
                    {{-- <div class="pipeline-visualization">
                        <div class="pipeline-visual-header">Pipeline Visualization</div>
                        <div class="pipeline-diagram">
                            <div class="pipeline-line pipeline-{{ str_replace('-', '', strtolower($project->pipeline_type)) }}" style="width: {{ min(100, $project->pipeline_length * 5) }}%;">
                                <span class="pipeline-length-label">{{ $project->pipeline_length }} km</span>
                            </div>
                        </div>
                    </div> --}}
                @endif
            </div>
        </div>


        {{-- <div class="info-section">
    <div class="section-header">
        <h3><i class="fas fa-check-square"></i> Required Document Types</h3>
    </div>
    
    @if($project->requiredDocumentTypes->count() > 0)
        <div class="required-docs-container">
            <div class="required-docs-grid">
                @foreach($project->requiredDocumentTypes as $documentType)
                    <div class="required-doc-item {{ $project->legalDocuments->where('legal_document_type_id', $documentType->id)->count() > 0 ? 'has-documents' : 'pending' }}">
                        <div class="doc-icon">
                            <i class="fas {{ $project->legalDocuments->where('legal_document_type_id', $documentType->id)->count() > 0 ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
                        </div>
                        <div class="doc-details">
                            <div class="doc-name">{{ $documentType->name }}</div>
                            <div class="doc-status">
                                @if($project->legalDocuments->where('legal_document_type_id', $documentType->id)->count() > 0)
                                    <span class="status-complete">Document Uploaded</span>
                                @else
                                    <span class="status-pending">Document Pending</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="no-required-docs">
            <p>No document types have been marked as required for this project. Edit the project to specify required document types.</p>
        </div>
    @endif
</div> --}}
        
        <!-- Legal Documents Section -->
        <div class="info-section">
            <div class="section-header">
                <h3><i class="fas fa-file-contract"></i> Legal Documents</h3>
                <a href="{{ route('projects.add-document', $project->id) }}" class="btn btn-sm btn-add-document">
                    <i class="fas fa-plus"></i> Add Document
                </a>
            </div>
            
            @if(count($legalDocuments) > 0)
                <div class="documents-tabs">
                    <div class="tabs-header">
                        <button class="tab-button active" data-tab="all">All Documents ({{ $project->legalDocuments->count() }})</button>
                        <button class="tab-button" data-tab="valid">Valid ({{ $project->legalDocuments->where('status', 'valid')->count() }})</button>
                        <button class="tab-button" data-tab="expiring">Expiring Soon ({{ $project->legalDocuments->where('status', 'upcoming_expiry')->count() }})</button>
                        <button class="tab-button" data-tab="expired">Expired ({{ $project->legalDocuments->where('status', 'expired')->count() }})</button>
                    </div>
                    
                    <div class="tab-content" id="all">
                        <table class="documents-table">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Issue Date</th>
                                    <th>Validity Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->legalDocuments as $document)
                                    <tr class="{{ $document->status === 'expired' ? 'expired-row' : ($document->status === 'upcoming_expiry' ? 'upcoming-expiry-row' : '') }}">
                                        <td>{{ $document->legalDocumentType->name }}</td>
                                        <td>{{ $document->issue_date ? $document->issue_date->format('d/m/Y') : '-' }}</td>
                                        <td>{{ $document->validity_date ? $document->validity_date->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $document->status }}">
                                                {{-- {{ ucfirst(str_replace('_', ' ', $document->status)) }} --}}

                                                 {!! $document->getDaysStatusHtml() !!}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="document-actions">
                                                <a href="{{ route('project-legal-documents.show', $document->id) }}" class="btn btn-sm btn-view" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($document->document_file)
                                                    <a href="{{ route('project-legal-documents.download', $document->id) }}" class="btn btn-sm btn-download" title="Download">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('project-legal-documents.edit', $document->id) }}" class="btn btn-sm btn-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="tab-content" id="valid" style="display: none;">
                        <table class="documents-table">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Issue Date</th>
                                    <th>Validity Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $validDocuments = $project->legalDocuments->where('status', 'valid'); @endphp
                                @if($validDocuments->count() > 0)
                                    @foreach($validDocuments as $document)
                                        <tr>
                                            <td>{{ $document->legalDocumentType->name }}</td>
                                            <td>{{ $document->issue_date ? $document->issue_date->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $document->validity_date ? $document->validity_date->format('d/m/Y') : '-' }}</td>
                                            <td>
                                                <div class="document-actions">
                                                    <a href="{{ route('project-legal-documents.show', $document->id) }}" class="btn btn-sm btn-view" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($document->document_file)
                                                        <a href="{{ route('project-legal-documents.download', $document->id) }}" class="btn btn-sm btn-download" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('project-legal-documents.edit', $document->id) }}" class="btn btn-sm btn-edit" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="no-documents">No valid documents found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="tab-content" id="expiring" style="display: none;">
                        <table class="documents-table">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Issue Date</th>
                                    <th>Validity Date</th>
                                    <th>Days Left</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $expiringDocuments = $project->legalDocuments->where('status', 'upcoming_expiry'); @endphp
                                @if($expiringDocuments->count() > 0)
                                    @foreach($expiringDocuments as $document)
                                        <tr class="upcoming-expiry-row">
                                            <td>{{ $document->legalDocumentType->name }}</td>
                                            <td>{{ $document->issue_date ? $document->issue_date->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $document->validity_date ? $document->validity_date->format('d/m/Y') : '-' }}</td>
                                            <td class="days-left-cell"> {!! $document->getDaysStatusHtml() !!} days</td>
                                            <td>
                                                <div class="document-actions">
                                                    <a href="{{ route('project-legal-documents.show', $document->id) }}" class="btn btn-sm btn-view" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($document->document_file)
                                                        <a href="{{ route('project-legal-documents.download', $document->id) }}" class="btn btn-sm btn-download" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('project-legal-documents.edit', $document->id) }}" class="btn btn-sm btn-edit" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="no-documents">No documents expiring soon.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="tab-content" id="expired" style="display: none;">
                        <table class="documents-table">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Issue Date</th>
                                    <th>Validity Date</th>
                                    <th>Days Overdue</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $expiredDocuments = $project->legalDocuments->where('status', 'expired'); @endphp
                                @if($expiredDocuments->count() > 0)
                                    @foreach($expiredDocuments as $document)
                                        <tr class="expired-row">
                                            <td>{{ $document->legalDocumentType->name }}</td>
                                            <td>{{ $document->issue_date ? $document->issue_date->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $document->validity_date ? $document->validity_date->format('d/m/Y') : '-' }}</td>
                                            <td class="days-overdue-cell">{{ abs($document->daysUntilExpiry()) }} days</td>
                                            <td>
                                                <div class="document-actions">
                                                    <a href="{{ route('project-legal-documents.show', $document->id) }}" class="btn btn-sm btn-view" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($document->document_file)
                                                        <a href="{{ route('project-legal-documents.download', $document->id) }}" class="btn btn-sm btn-download" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('project-legal-documents.edit', $document->id) }}" class="btn btn-sm btn-edit" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="no-documents">No expired documents.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="no-documents-container">
                    <div class="no-documents-message">
                        <i class="fas fa-file-alt no-docs-icon"></i>
                        <h4>No Legal Documents</h4>
                        <p>This project doesn't have any legal documents yet. Add documents to track compliance requirements for this project.</p>
                        <a href="{{ route('projects.add-document', $project->id) }}" class="btn btn-add-document">
                            <i class="fas fa-plus"></i> Add First Document
                        </a>
                    </div>
                </div>
            @endif
        </div>
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
    .project-details-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }
    
    .project-info-header {
        padding: 20px;
        background-color: #f5f5f5;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .project-title-section h2 {
        margin: 0 0 5px 0;
        font-size: 24px;
        color: #333;
    }
    
    .project-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-pending {
        background-color: #e6e6e6;
        color: #6c757d;
    }
    
    .status-active {
        background-color: #e6f7e6;
        color: #28a745;
    }
    
    .status-completed {
        background-color: #e6f0ff;
        color: #007bff;
    }
    
    .status-cancelled {
        background-color: #ffe6e6;
        color: #dc3545;
    }
    
    .status-text-pending {
        color: #6c757d;
    }
    
    .status-text-active {
        color: #28a745;
    }
    
    .status-text-completed {
        color: #007bff;
    }
    
    .status-text-cancelled {
        color: #dc3545;
    }
    
    .project-actions {
        display: flex;
        gap: 10px;
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
    
    .btn-edit {
        background-color: #ffc107;
        color: #333;
    }
    
    .btn-document {
        background-color: #6610f2;
        color: white;
    }
    
    .btn-delete {
        background-color: #dc3545;
        color: white;
    }
    
    .delete-form {
        margin: 0;
    }
    
    .project-info-body {
        padding: 20px;
    }
    
    .info-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .info-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .section-header h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }
    
    .section-header h3 i {
        margin-right: 8px;
        color: #e31e24;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }
    
    .info-item {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 4px;
    }
    
    .info-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }
    
    .info-value {
        font-weight: 500;
    }
    
    .project-description {
        margin-top: 20px;
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 4px;
    }
    
    .description-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }
    
    .description-text {
        white-space: pre-line;
    }
    
    .pipeline-info-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .pipeline-specs {
        flex: 1;
        min-width: 300px;
    }
    
    .pipeline-visualization {
        flex: 1;
        min-width: 300px;
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 4px;
    }
    
    .pipeline-visual-header {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }
    
    .pipeline-diagram {
        height: 60px;
        display: flex;
        align-items: center;
    }
    
    .pipeline-line {
        height: 20px;
        border-radius: 10px;
        position: relative;
    }
    
    .pipeline-highpressure {
        background-color: #dc3545;
    }
    
    .pipeline-mediumpressure {
        background-color: #fd7e14;
    }
    
    .pipeline-lowpressure {
        background-color: #28a745;
    }
    
    .pipeline-length-label {
        position: absolute;
        right: 10px;
        top: -25px;
        font-size: 12px;
        color: #666;
    }
    
    .pipeline-type-highpressure {
        color: #dc3545;
        font-weight: 600;
    }
    
    .pipeline-type-mediumpressure {
        color: #fd7e14;
        font-weight: 600;
    }
    
    .pipeline-type-lowpressure {
        color: #28a745;
        font-weight: 600;
    }
    
    .service-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        text-transform: capitalize;
    }
    
    .service-installation {
        background-color: #e7f5ff;
        color: #1a73e8;
    }
    
    .service-repair {
        background-color: #ffe8e8;
        color: #e53935;
    }
    
    .service-maintenance {
        background-color: #fff8e1;
        color: #f9a825;
    }
    
    .service-inspection {
        background-color: #e8f5e9;
        color: #43a047;
    }
    
    .service-mixed {
        background-color: #f5f5f5;
        color: #757575;
    }
    
    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }
    
    .btn-add-document {
        background-color: #6610f2;
        color: white;
    }
    
    .documents-tabs {
        border: 1px solid #eee;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .tabs-header {
        display: flex;
        background-color: #f5f5f5;
        border-bottom: 1px solid #eee;
    }
    
    .tab-button {
        padding: 10px 15px;
        border: none;
        background-color: transparent;
        cursor: pointer;
        font-weight: 500;
    }
    
    .tab-button.active {
        background-color: white;
        border-top: 2px solid #e31e24;
    }
    
    .tab-content {
        padding: 15px;
    }
    
    .documents-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .documents-table th,
    .documents-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    
    .documents-table th {
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
        display: inline-block;
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
    
    .document-actions {
        display: flex;
        gap: 5px;
    }
    
    .btn-view {
        background-color: #17a2b8;
        color: white;
    }
    
    .btn-download {
        background-color: #6c757d;
        color: white;
    }
    
    .days-left-cell {
        color: #ff9800;
        font-weight: 500;
    }
    
    .days-overdue-cell {
        color: #dc3545;
        font-weight: 500;
    }
    
    .no-documents {
        text-align: center;
        padding: 20px;
        color: #666;
    }
    
    .no-documents-container {
        display: flex;
        justify-content: center;
        padding: 40px 0;
    }
    
    .no-documents-message {
        text-align: center;
        max-width: 400px;
    }
    
    .no-docs-icon {
        font-size: 48px;
        color: #ddd;
        margin-bottom: 15px;
    }
    
    .no-documents-message h4 {
        margin-bottom: 10px;
        color: #333;
    }
    
    .no-documents-message p {
        margin-bottom: 20px;
        color: #666;
    }
    
    @media (max-width: 768px) {
        .project-info-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .project-actions {
            margin-top: 15px;
            width: 100%;
            flex-wrap: wrap;
        }
        
        .project-actions .btn,
        .delete-form {
            flex: 1;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .tabs-header {
            flex-wrap: wrap;
        }
        
        .tab-button {
            flex: 1;
            font-size: 12px;
            padding: 8px;
            text-align: center;
        }
        
        .documents-table {
            display: block;
            overflow-x: auto;
        }
    }



    .required-docs-container {
    margin-top: 15px;
}

.required-docs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 15px;
}

.required-doc-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-radius: 6px;
    background-color: #f9f9f9;
    border-left: 4px solid #ccc;
    transition: transform 0.2s, box-shadow 0.2s;
}

.required-doc-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.required-doc-item.has-documents {
    border-left-color: #28a745;
}

.required-doc-item.pending {
    border-left-color: #ffc107;
}

.doc-icon {
    font-size: 20px;
    margin-right: 15px;
}

.required-doc-item.has-documents .doc-icon {
    color: #28a745;
}

.required-doc-item.pending .doc-icon {
    color: #ffc107;
}

.doc-details {
    flex: 1;
}

.doc-name {
    font-weight: 500;
    margin-bottom: 5px;
}

.doc-status {
    font-size: 12px;
}

.status-complete {
    color: #28a745;
}

.status-pending {
    color: #ffc107;
}

.no-required-docs {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 6px;
    color: #666;
    text-align: center;
}

/* For negative contract balance */
.text-danger {
    color: #dc3545;
}

</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching logic
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                tabButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Hide all tab contents
                tabContents.forEach(content => content.style.display = 'none');
                
                // Show the selected tab content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).style.display = 'block';
            });
        });
    });
</script>
@endsection