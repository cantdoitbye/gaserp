@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-file-contract"></i>
        <span>Document Details</span>
    </div>
    <a href="{{ route('project-legal-documents.index') }}" class="back-button">Back to Documents</a>
</div>

<div class="document-details">
    <div class="document-header">
        <div class="document-title">
            <h2>{{ $projectLegalDocument->legalDocumentType->name }}</h2>
            <span class="status-badge status-{{ $projectLegalDocument->status }}">
                {{ ucfirst(str_replace('_', ' ', $projectLegalDocument->status)) }}
            </span>
        </div>
        <div class="document-actions">
            <a href="{{ route('project-legal-documents.edit', $projectLegalDocument->id) }}" class="edit-btn">
                <i class="fas fa-edit"></i> Edit
            </a>
            @if($projectLegalDocument->document_file)
                <a href="{{ route('project-legal-documents.download', $projectLegalDocument->id) }}" class="download-btn">
                    <i class="fas fa-download"></i> Download
                </a>
            @endif
        </div>
    </div>

    <div class="document-sections">
        <div class="document-section">
            <h3>Document Information</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Document Type</div>
                    <div class="info-value">{{ $projectLegalDocument->legalDocumentType->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Project</div>
                    <div class="info-value">{{ $projectLegalDocument->project->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Issue Date</div>
                    <div class="info-value">{{ $projectLegalDocument->issue_date ? $projectLegalDocument->issue_date->format('d/m/Y') : 'Not set' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Validity Date</div>
                    <div class="info-value">{{ $projectLegalDocument->validity_date ? $projectLegalDocument->validity_date->format('d/m/Y') : 'Not set' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value">{{ ucfirst(str_replace('_', ' ', $projectLegalDocument->status)) }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Required</div>
                    <div class="info-value">{{ $projectLegalDocument->is_required ? 'Yes' : 'No' }}</div>
                </div>
                @if($projectLegalDocument->validity_date && $projectLegalDocument->status !== 'expired')
                <div class="info-item">
                    <div class="info-label">Days Until Expiry</div>
                    <div class="info-value {{ $projectLegalDocument->daysUntilExpiry() <= 30 ? 'text-warning' : '' }}">
                        {{ $projectLegalDocument->daysUntilExpiry() }} days
                    </div>
                </div>
                @endif

                <!-- Additional fields for project-legal-documents/show.blade.php -->

<!-- Add this inside the info-grid in the Document Information section -->
@if($projectLegalDocument->project->pipeline_length)
<div class="info-item">
    <div class="info-label">Pipeline Length</div>
    <div class="info-value">{{ $projectLegalDocument->project->pipeline_length }} km</div>
</div>
@endif

@if($projectLegalDocument->project->pipeline_type)
<div class="info-item">
    <div class="info-label">Pipeline Type</div>
    <div class="info-value">{{ $projectLegalDocument->project->pipeline_type }}</div>
</div>
@endif

@if($projectLegalDocument->project->pipeline_material)
<div class="info-item">
    <div class="info-label">Pipeline Material</div>
    <div class="info-value">{{ $projectLegalDocument->project->pipeline_material }}</div>
</div>
@endif

@if($projectLegalDocument->project->service_type)
<div class="info-item">
    <div class="info-label">Service Type</div>
    <div class="info-value">{{ ucfirst($projectLegalDocument->project->service_type) }}</div>
</div>
@endif
            </div>
        </div>

        <div class="document-section">
            <h3>Document File</h3>
            @if($projectLegalDocument->document_file)
                <div class="file-preview">
                    <i class="fas fa-file-pdf file-icon"></i>
                    <div class="file-info">
                        <div class="file-name">{{ basename($projectLegalDocument->document_file) }}</div>
                        <a href="{{ route('project-legal-documents.download', $projectLegalDocument->id) }}" class="file-download">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            @else
                <div class="no-file">
                    <p>No document file uploaded.</p>
                    <form action="{{ route('project-legal-documents.upload', $projectLegalDocument->id) }}" method="POST" enctype="multipart/form-data" class="upload-form">
                        @csrf
                        <div class="file-upload">
                            <input type="file" name="document_file" id="document_file" class="file-input">
                            <label for="document_file" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i> Choose file
                            </label>
                            <button type="submit" class="upload-btn">Upload</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        @if($projectLegalDocument->notifications->count() > 0)
        <div class="document-section">
            <h3>Related Notifications</h3>
            <div class="notifications-list">
                @foreach($projectLegalDocument->notifications as $notification)
                <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}">
                    <div class="notification-header">
                        <div class="notification-title">
                            <i class="fas fa-bell"></i> {{ $notification->title }}
                        </div>
                        <div class="notification-date">{{ $notification->notification_date->format('d/m/Y') }}</div>
                    </div>
                    <div class="notification-message">{{ $notification->message }}</div>
                    @if(!$notification->is_read)
                    <div class="notification-actions">
                        <form action="{{ route('legal-notifications.mark-as-read', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="mark-read-btn">Mark as Read</button>
                        </form>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
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

    .document-details {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .document-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background-color: #f5f5f5;
        border-bottom: 1px solid #eee;
    }

    .document-title h2 {
        margin: 0 0 5px 0;
        font-size: 22px;
    }

    .document-actions {
        display: flex;
        gap: 10px;
    }

    .edit-btn, .download-btn {
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .edit-btn i, .download-btn i {
        margin-right: 5px;
    }

    .edit-btn {
        background-color: #ffc107;
        color: #333;
    }

    .download-btn {
        background-color: #17a2b8;
        color: white;
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

    .document-sections {
        padding: 20px;
    }

    .document-section {
        margin-bottom: 30px;
    }

    .document-section h3 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 18px;
        color: #333;
        border-bottom: 1px solid #eee;
        padding-bottom: 8px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 15px;
    }

    .info-item {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 4px;
    }

    .info-label {
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
    }

    .info-value {
        font-weight: 500;
    }

    .text-warning {
        color: #ff9800;
    }

    .file-preview {
        display: flex;
        align-items: center;
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 4px;
    }

    .file-icon {
        font-size: 40px;
        color: #e31e24;
        margin-right: 20px;
    }

    .file-info {
        flex: 1;
    }

    .file-name {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .file-download {
        color: #17a2b8;
        text-decoration: none;
        font-size: 14px;
    }

    .file-download i {
        margin-right: 5px;
    }

    .no-file {
        text-align: center;
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 4px;
    }

    .upload-form {
        margin-top: 15px;
    }

    .file-upload {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .file-input {
        display: none;
    }

    .file-label {
        background-color: #f0f0f0;
        color: #333;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
    }

    .file-label i {
        margin-right: 5px;
    }

    .upload-btn {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
    }

    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .notification-item {
        border-left: 3px solid #e31e24;
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 0 4px 4px 0;
    }

    .notification-item.read {
        border-left-color: #ccc;
        opacity: 0.8;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .notification-title {
        font-weight: 500;
    }

    .notification-title i {
        color: #e31e24;
        margin-right: 5px;
    }

    .notification-date {
        font-size: 12px;
        color: #777;
    }

    .notification-message {
        margin-bottom: 10px;
    }

    .notification-actions {
        display: flex;
        justify-content: flex-end;
    }

    .mark-read-btn {
        background-color: transparent;
        color: #e31e24;
        border: 1px solid #e31e24;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .document-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .document-actions {
            margin-top: 10px;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .file-preview {
            flex-direction: column;
            text-align: center;
        }
        
        .file-icon {
            margin-right: 0;
            margin-bottom: 15px;
        }
    }
</style>
@endsection