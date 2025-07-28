@extends('panel.layouts.app')
@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-project-diagram"></i>
        <span>Projects</span>
    </div>
    <a href="{{ route('dashboard') }}" class="back-button">Back to Dashboard</a>
</div>

<div class="content-container">
    <!-- Filters Section -->
    <!-- Filters Section -->
    <div class="filters-section">
        <h3>Filter Projects</h3>
        <form action="{{ route('projects.index') }}" method="GET" class="filter-form">
            <div class="filters-grid">
                <!-- Status Filter -->
                <div class="filter-item">
                    <label>Status</label>
                    <div class="filter-header">
                        <a href="#" class="select-all" data-group="status">Select All</a> |
                        <a href="#" class="deselect-all" data-group="status">Deselect All</a>
                    </div>
                    <div class="checkbox-filter-group" id="status-group">
                        <div class="checkbox-filter-item">
                            <label>
                                <input type="checkbox" name="status[]" value="pending" 
                                    {{ is_array(request('status')) && in_array('pending', request('status')) ? 'checked' : '' }}>
                                Pending
                            </label>
                        </div>
                        <div class="checkbox-filter-item">
                            <label>
                                <input type="checkbox" name="status[]" value="active" 
                                    {{ is_array(request('status')) && in_array('active', request('status')) ? 'checked' : '' }}>
                                Active
                            </label>
                        </div>
                        <div class="checkbox-filter-item">
                            <label>
                                <input type="checkbox" name="status[]" value="completed" 
                                    {{ is_array(request('status')) && in_array('completed', request('status')) ? 'checked' : '' }}>
                                Completed
                            </label>
                        </div>
                        <div class="checkbox-filter-item">
                            <label>
                                <input type="checkbox" name="status[]" value="cancelled" 
                                    {{ is_array(request('status')) && in_array('cancelled', request('status')) ? 'checked' : '' }}>
                                Cancelled
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Location Filter -->
                <div class="filter-item">
                    <label>Location</label>
                    <div class="filter-header">
                        <a href="#" class="select-all" data-group="location">Select All</a> |
                        <a href="#" class="deselect-all" data-group="location">Deselect All</a>
                    </div>
                    <div class="checkbox-filter-group" id="location-group">
                        @foreach($locations as $location)
                            <div class="checkbox-filter-item">
                                <label>
                                    <input type="checkbox" name="location[]" value="{{ $location }}" 
                                        {{ is_array(request('location')) && in_array($location, request('location')) ? 'checked' : '' }}>
                                    {{ $location }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Client/Company Filter -->
                <div class="filter-item">
                    <label>Company/Client</label>
                    <div class="filter-header">
                        <a href="#" class="select-all" data-group="client_name">Select All</a> |
                        <a href="#" class="deselect-all" data-group="client_name">Deselect All</a>
                    </div>
                    <div class="checkbox-filter-group" id="client-group">
                        @foreach($clients as $client)
                            <div class="checkbox-filter-item">
                                <label>
                                    <input type="checkbox" name="client_name[]" value="{{ $client }}" 
                                        {{ is_array(request('client_name')) && in_array($client, request('client_name')) ? 'checked' : '' }}>
                                    {{ $client }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Service Type Filter -->
                <div class="filter-item">
                    <label>Service Type</label>
                    <div class="filter-header">
                        <a href="#" class="select-all" data-group="service_type_id">Select All</a> |
                        <a href="#" class="deselect-all" data-group="service_type_id">Deselect All</a>
                    </div>
                    <div class="checkbox-filter-group" id="service-type-group">
                        @foreach($serviceTypes as $id => $name)
                            <div class="checkbox-filter-item">
                                <label>
                                    <input type="checkbox" name="service_type_id[]" value="{{ $id }}" 
                                        {{ is_array(request('service_type_id')) && in_array($id, request('service_type_id')) ? 'checked' : '' }}>
                                    {{ ucfirst($name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Tender ID Filter -->
                <div class="filter-item">
                    <label>Tender ID</label>
                    <div class="filter-header">
                        <a href="#" class="select-all" data-group="tender_id">Select All</a> |
                        <a href="#" class="deselect-all" data-group="tender_id">Deselect All</a>
                    </div>
                    <div class="checkbox-filter-group" id="tender-id-group">
                        @foreach($tenderIds as $tenderId)
                            <div class="checkbox-filter-item">
                                <label>
                                    <input type="checkbox" name="tender_id[]" value="{{ $tenderId }}" 
                                        {{ is_array(request('tender_id')) && in_array($tenderId, request('tender_id')) ? 'checked' : '' }}>
                                    {{ $tenderId }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Contract Number Filter -->
                <div class="filter-item">
                    <label>Contract Number/Purchase Order</label>
                    <div class="filter-header">
                        <a href="#" class="select-all" data-group="contract_number">Select All</a> |
                        <a href="#" class="deselect-all" data-group="contract_number">Deselect All</a>
                    </div>
                    <div class="checkbox-filter-group" id="contract-number-group">
                        @foreach($contractNumbers as $contractNumber)
                            <div class="checkbox-filter-item">
                                <label>
                                    <input type="checkbox" name="contract_number[]" value="{{ $contractNumber }}" 
                                        {{ is_array(request('contract_number')) && in_array($contractNumber, request('contract_number')) ? 'checked' : '' }}>
                                    {{ $contractNumber }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="filter-item filter-buttons">
                    <button type="submit" class="btn btn-filter">Apply Filters</button>
                    <a href="{{ route('projects.index') }}" class="btn btn-reset">Reset</a>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Actions Section -->
    <div class="actions-section">
        <a href="{{ route('projects.create') }}" class="btn btn-create">
            <i class="fas fa-plus"></i> Create New Project
        </a>
        
        <div class="sort-section">
            <span>Sort by:</span>
            <form action="{{ route('projects.index') }}" method="GET" id="sort-form">
                <!-- Keep existing sort form inputs -->
                @if(is_array(request('status')))
                    @foreach(request('status') as $status)
                        <input type="hidden" name="status[]" value="{{ $status }}">
                    @endforeach
                    
                @elseif(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                
                @if(is_array(request('location')))
                    @foreach(request('location') as $location)
                        <input type="hidden" name="location[]" value="{{ $location }}">
                    @endforeach
                @elseif(request('location'))
                    <input type="hidden" name="location" value="{{ request('location') }}">
                @endif
                
                @if(is_array(request('client_name')))
                    @foreach(request('client_name') as $client)
                        <input type="hidden" name="client_name[]" value="{{ $client }}">
                    @endforeach
                @elseif(request('client_name'))
                    <input type="hidden" name="client_name" value="{{ request('client_name') }}">
                @endif
                
                <!-- New service_type_id hidden inputs -->
                @if(is_array(request('service_type_id')))
                    @foreach(request('service_type_id') as $serviceTypeId)
                        <input type="hidden" name="service_type_id[]" value="{{ $serviceTypeId }}">
                    @endforeach
                @elseif(request('service_type_id'))
                    <input type="hidden" name="service_type_id" value="{{ request('service_type_id') }}">
                @endif
                
                <!-- New tender_id hidden inputs -->
                @if(is_array(request('tender_id')))
                    @foreach(request('tender_id') as $tenderId)
                        <input type="hidden" name="tender_id[]" value="{{ $tenderId }}">
                    @endforeach
                @elseif(request('tender_id'))
                    <input type="hidden" name="tender_id" value="{{ request('tender_id') }}">
                @endif
                
                <!-- New contract_number hidden inputs -->
                @if(is_array(request('contract_number')))
                    @foreach(request('contract_number') as $contractNumber)
                        <input type="hidden" name="contract_number[]" value="{{ $contractNumber }}">
                    @endforeach
                @elseif(request('contract_number'))
                    <input type="hidden" name="contract_number" value="{{ request('contract_number') }}">
                @endif
                
                <select name="sort_by" id="sort_by" class="form-control" onchange="document.getElementById('sort-form').submit()">
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Project Name</option>
                    <option value="start_date" {{ request('sort_by') == 'start_date' ? 'selected' : '' }}>Start Date</option>
                    <option value="end_date" {{ request('sort_by') == 'end_date' ? 'selected' : '' }}>End Date</option>
                    <option value="pipeline_length" {{ request('sort_by') == 'pipeline_length' ? 'selected' : '' }}>Pipeline Length</option>
                </select>
                
                <select name="sort_direction" id="sort_direction" class="form-control" onchange="document.getElementById('sort-form').submit()">
                    <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                </select>
            </form>
        </div>
    </div>
    
    <!-- Projects List -->
    <div class="projects-list">
        @if($projects->count() > 0)
            @foreach($projects as $project)
                <div class="project-card">
                    <div class="project-header">
                        <h3>{{ $project->name }}</h3>
                        <span class="project-status status-{{ $project->status }}">{{ ucfirst($project->status) }}</span>
                    </div>
                    
                    <div class="project-details">
                        <div class="project-info">
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $project->location ?: 'Location not specified' }}</span>
                            </div>
                            {{-- <div class="info-item">
                                <i class="fas fa-file-contract"></i>
                                <span>{{ $project->contract_number ?: 'No contract number' }}</span>
                            </div>
                            @if($project->tender_id)
                            <div class="info-item">
                                <i class="fas fa-gavel"></i>
                                <span>Tender ID: {{ $project->tender_id }}</span>
                            </div>
                            @endif
                            <div class="info-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ $project->start_date ? $project->start_date->format('d M Y') : 'No start date' }} - {{ $project->end_date ? $project->end_date->format('d M Y') : 'No end date' }}</span>
                            </div> --}}
                            {{-- <div class="info-item">
                                <i class="fas fa-user"></i>
                                <span>{{ $project->client_name ?: 'No client specified' }}</span>
                            </div> --}}
                        </div>
                        
                        <div class="pipeline-details">
                            @if($project->pipeline_length || $project->pipeline_material)
                                <div class="pipeline-info">
                                    @if($project->pipeline_length)
                                        <div class="pipeline-length">
                                            <i class="fas fa-ruler"></i> {{ $project->pipeline_length }} km
                                        </div>
                                    @endif
                                    
                                    @if($project->pipeline_material)
                                        <div class="pipeline-material">
                                            <i class="fas fa-layer-group"></i> {{ $project->pipeline_material }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            @if($project->serviceType)
                                <div class="service-type service-{{ $project->serviceType->name }}">
                                    {{ ucfirst($project->serviceType->name) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    {{-- <div class="project-description">
                        {{ Str::limit($project->description, 150) ?: 'No description provided.' }}
                    </div> --}}
                    
                    <div class="project-actions">
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-view">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('projects.add-document', $project->id) }}" class="btn btn-document">
                            <i class="fas fa-file"></i> Add Document
                        </a>
                        <a href="{{ route('projects.legal-desk', $project->id) }}" class="btn btn-primary">
    <i class="fas fa-gavel"></i> Legal Dashboard
</a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            
            <div class="pagination-container">
                {{ $projects->appends(request()->except('page'))->links() }}
            </div>
        @else
            <div class="no-projects">
                <i class="fas fa-folder-open empty-icon"></i>
                <h3>No projects found</h3>
                <p>There are no projects matching your criteria. Try adjusting your filters or create a new project.</p>
                <a href="{{ route('projects.create') }}" class="btn btn-create">Create New Project</a>
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
    
    .filters-section {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .filters-section h3 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
    }
    
    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .filter-item {
        margin-bottom: 10px;
    }
    
    .filter-item label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555;
    }
    
    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: white;
    }
    
    .filter-buttons {
        display: flex;
        align-items: flex-end;
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
    
    .btn-filter {
        background-color: #e31e24;
        color: white;
    }
    
    .btn-reset {
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ddd;
    }
    
    .actions-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .btn-create {
        background-color: #28a745;
        color: white;
    }
    
    .sort-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .sort-section span {
        color: #555;
        font-weight: 500;
    }
    
    .projects-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .project-card {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }
    
    .project-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .project-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background-color: #f9f9f9;
        border-bottom: 1px solid #eee;
    }
    
    .project-header h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }
    
    .project-status {
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
    
    .project-details {
        padding: 15px;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .project-info {
        flex: 2;
        min-width: 300px;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .info-item i {
        width: 20px;
        color: #666;
        margin-right: 10px;
    }
    
    .pipeline-details {
        flex: 1;
        min-width: 200px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .pipeline-info {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .pipeline-type {
        font-weight: 500;
    }
    
    .highpressure {
        color: #dc3545;
    }
    
    .mediumpressure {
        color: #fd7e14;
    }
    
    .lowpressure {
        color: #28a745;
    }
    
    .pipeline-length, .pipeline-material {
        color: #555;
    }
    
    .service-type {
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
    
    .project-description {
        padding: 0 15px 15px;
        color: #666;
        border-bottom: 1px solid #eee;
    }
    
    .project-actions {
        display: flex;
        padding: 15px;
        gap: 10px;
    }
    
    .btn-view {
        background-color: #17a2b8;
        color: white;
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
    
    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
    
    .no-projects {
        text-align: center;
        padding: 40px 0;
        color: #666;
    }
    
    .empty-icon {
        font-size: 48px;
        color: #ddd;
        margin-bottom: 15px;
    }
    
    .no-projects h3 {
        margin-bottom: 10px;
        color: #333;
    }
    
    .no-projects p {
        margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .filters-grid {
            grid-template-columns: 1fr;
        }
        
        .actions-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .sort-section {
            width: 100%;
        }
        
        .sort-section select {
            flex: 1;
        }
        
        .project-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .project-status {
            margin-top: 5px;
        }
        
        .project-actions {
            display: flex;
            padding: 15px;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .btn-view {
            background-color: #17a2b8;
            color: white;
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
        
        .pagination-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        
        .no-projects {
            text-align: center;
            padding: 40px 0;
            color: #666;
        }
        
        .empty-icon {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 15px;
        }
        
        .no-projects h3 {
            margin-bottom: 10px;
            color: #333;
        }
        
        .no-projects p {
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .filters-grid {
                grid-template-columns: 1fr;
            }
            
            .actions-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .sort-section {
                width: 100%;
            }
            
            .sort-section select {
                flex: 1;
            }
            
            .project-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .project-status {
                margin-top: 5px;
            }
            
            .project-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .project-actions .btn,
            .delete-form {
                width: 100%;
            }
        }
    }
</style>
@endsection


@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-multiple').select2({
            placeholder: "Select options",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection