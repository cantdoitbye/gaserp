
@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-project-diagram"></i>
        <span>Edit Project</span>
    </div>
    <a href="{{ route('projects.show', $project->id) }}" class="back-button">Back to Project</a>
</div>

<div class="form-container">
    <form action="{{ route('projects.update', $project->id) }}" method="POST" class="project-form">
        @csrf
        @method('PUT')
        
        <div class="form-header">
            <h2>Edit Project Information</h2>
        </div>
        
        <div class="form-body">
            @if ($errors->any())
                <div class="alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="form-section">
                <h3>Basic Information</h3>
                
                <div class="form-group">
                    <label for="name">Project Name <span class="required">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" class="form-control" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="contract_number">Contract Number</label>
                        <input type="date" name="contract_number" id="contract_number" value="{{ old('contract_number', $project->contract_number) }}" class="form-control">
                    </div>

                      <div class="form-group">
                        <label for="contract_number">Callout/Release order date</label>
                        <input type="date" name="release_order_date" id="release_order_date" value="{{ old('release_order_date', $project->release_order_date) }}" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $project->location) }}" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Project Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $project->description) }}</textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $project->start_date ? $project->start_date->format('Y-m-d') : '') }}" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $project->end_date ? $project->end_date->format('Y-m-d') : '') }}" class="form-control">
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Client Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="client_name">Client Name</label>
                        <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $project->client_name) }}" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="client_contact">Client Contact</label>
                        <input type="text" name="client_contact" id="client_contact" value="{{ old('client_contact', $project->client_contact) }}" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="project_manager">Project Manager</label>
                    <input type="text" name="project_manager" id="project_manager" value="{{ old('project_manager', $project->project_manager) }}" class="form-control">
                </div>
            </div>
            
            <div class="form-section">
                <h3>Pipeline Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="pipeline_length">Pipeline Length (km)</label>
                        <input type="number" name="pipeline_length" id="pipeline_length" step="0.01" min="0" value="{{ old('pipeline_length', $project->pipeline_length) }}" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="pipeline_type">Pipeline Type</label>
                        <select name="pipeline_type" id="pipeline_type" class="form-control">
                            <option value="">Select Pipeline Type</option>
                            <option value="High-pressure" {{ old('pipeline_type', $project->pipeline_type) == 'High-pressure' ? 'selected' : '' }}>High-pressure</option>
                            <option value="Medium-pressure" {{ old('pipeline_type', $project->pipeline_type) == 'Medium-pressure' ? 'selected' : '' }}>Medium-pressure</option>
                            <option value="Low-pressure" {{ old('pipeline_type', $project->pipeline_type) == 'Low-pressure' ? 'selected' : '' }}>Low-pressure</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="pipeline_material">Pipeline Material</label>
                        <select name="pipeline_material" id="pipeline_material" class="form-control">
                            <option value="">Select Material</option>
                            <option value="Steel" {{ old('pipeline_material', $project->pipeline_material) == 'Steel' ? 'selected' : '' }}>Steel</option>
                            <option value="HDPE" {{ old('pipeline_material', $project->pipeline_material) == 'HDPE' ? 'selected' : '' }}>HDPE</option>
                            <option value="MDPE" {{ old('pipeline_material', $project->pipeline_material) == 'MDPE' ? 'selected' : '' }}>MDPE</option>
                            <option value="PVC" {{ old('pipeline_material', $project->pipeline_material) == 'PVC' ? 'selected' : '' }}>PVC</option>
                            <option value="Cast Iron" {{ old('pipeline_material', $project->pipeline_material) == 'Cast Iron' ? 'selected' : '' }}>Cast Iron</option>
                            <option value="Ductile Iron" {{ old('pipeline_material', $project->pipeline_material) == 'Ductile Iron' ? 'selected' : '' }}>Ductile Iron</option>
                            <option value="Copper" {{ old('pipeline_material', $project->pipeline_material) == 'Copper' ? 'selected' : '' }}>Copper</option>
                            <option value="HDPE/Steel" {{ old('pipeline_material', $project->pipeline_material) == 'HDPE/Steel' ? 'selected' : '' }}>HDPE/Steel (Composite)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="service_type">Service Type</label>
                        <select name="service_type" id="service_type" class="form-control">
                            <option value="">Select Service Type</option>
                            <option value="installation" {{ old('service_type', $project->service_type) == 'installation' ? 'selected' : '' }}>Installation</option>
                            <option value="repair" {{ old('service_type', $project->service_type) == 'repair' ? 'selected' : '' }}>Repair</option>
                            <option value="maintenance" {{ old('service_type', $project->service_type) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="inspection" {{ old('service_type', $project->service_type) == 'inspection' ? 'selected' : '' }}>Inspection</option>
                            <option value="mixed" {{ old('service_type', $project->service_type) == 'mixed' ? 'selected' : '' }}>Mixed Services</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Project Status</h3>
                
                <div class="form-group">
                    <label for="status">Status <span class="required">*</span></label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending" {{ old('status', $project->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $project->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="form-section">
    <h3>Tender Information</h3>
    
    <div class="form-group">
        <label for="tender_id">Tender ID With Details</label>
        <input type="text" name="tender_id" id="tender_id" value="{{ old('tender_id', $project->tender_id) }}" class="form-control">
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="prebid_meeting_date">Prebid Meeting Date</label>
            <input type="date" name="prebid_meeting_date" id="prebid_meeting_date" value="{{ old('prebid_meeting_date', $project->prebid_meeting_date ? $project->prebid_meeting_date->format('Y-m-d') : '') }}" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="tender_submit_date">Tender Submit Date</label>
            <input type="date" name="tender_submit_date" id="tender_submit_date" value="{{ old('tender_submit_date', $project->tender_submit_date ? $project->tender_submit_date->format('Y-m-d') : '') }}" class="form-control">
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="price_open_percentage">Price Open Percentage</label>
            <input type="number" step="0.01" min="0" max="100" name="price_open_percentage" id="price_open_percentage" value="{{ old('price_open_percentage', $project->price_open_percentage) }}" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="kick_off_meeting_date">Kick-off Meeting Date</label>
            <input type="date" name="kick_off_meeting_date" id="kick_off_meeting_date" value="{{ old('kick_off_meeting_date', $project->kick_off_meeting_date ? $project->kick_off_meeting_date->format('Y-m-d') : '') }}" class="form-control">
        </div>
    </div>
</div>

<div class="form-section">
    <h3>Contract Information</h3>
    
    <div class="form-row">
        <div class="form-group">
            <label for="contact_value">Contract Value</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">₹</span>
                </div>
                <input type="number" step="0.01" min="0" name="contact_value" id="contact_value" value="{{ old('contact_value', $project->contact_value) }}" class="form-control">
            </div>
        </div>
        
        <div class="form-group">
            <label for="contract_value_consumption">Contract Value Consumption</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">₹</span>
                </div>
                <input type="number" step="0.01" min="0" name="contract_value_consumption" id="contract_value_consumption" value="{{ old('contract_value_consumption', $project->contract_value_consumption) }}" class="form-control">
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label for="contract_balance">Contract Balance</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">₹</span>
            </div>
            <input type="number" step="0.01" id="contract_balance" value="{{ $project->contract_balance }}" class="form-control" readonly>
        </div>
        <small class="form-text text-muted">This will be calculated automatically based on Contract Value and Consumption</small>
    </div>
</div>

<div class="form-section">
    <h3>Amendment Information</h3>
    
    <div class="form-row">
        <div class="form-group">
            <label for="amendment_date">Amendment Date</label>
            <input type="date" name="amendment_date" id="amendment_date" value="{{ old('amendment_date', $project->amendment_date ? $project->amendment_date->format('Y-m-d') : '') }}" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="amendment_value">Amendment Value</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">₹</span>
                </div>
                <input type="number" step="0.01" name="amendment_value" id="amendment_value" value="{{ old('amendment_value', $project->amendment_value) }}" class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="form-section">
    <h3>Labour License Information</h3>
    
    <div class="form-row">
        <div class="form-group">
            <label for="labour_licence_number">Labour Licence Number</label>
            <input type="text" name="labour_licence_number" id="labour_licence_number" value="{{ old('labour_licence_number', $project->labour_licence_number) }}" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="licence_application_date">Licence Application Date</label>
            <input type="date" name="licence_application_date" id="licence_application_date" value="{{ old('licence_application_date', $project->licence_application_date ? $project->licence_application_date->format('Y-m-d') : '') }}" class="form-control">
        </div>
    </div>
</div>

<div class="form-section">
    <h3>Required Legal Documents</h3>
    <p class="document-selection-help">Select which document types will be required for this project. Only selected document types will be available when adding legal documents to this project.</p>
    
    <div class="document-type-selection">
        <div class="select-all-container">
            <label class="select-all-label">
                <input type="checkbox" id="select-all-documents" class="select-all-checkbox">
                <span>Select All Document Types</span>
            </label>
        </div>
        
        <div class="document-types-grid">
            @foreach($documentTypes as $documentType)
                <div class="document-type-item">
                    <label class="document-type-label">
                        <input type="checkbox" name="required_document_types[]" value="{{ $documentType->id }}" class="document-type-checkbox" 
                            {{ (is_array(old('required_document_types', $requiredDocumentTypeIds)) && in_array($documentType->id, old('required_document_types', $requiredDocumentTypeIds))) ? 'checked' : '' }}>
                        <span>{{ $documentType->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
        </div>
        
        <div class="form-footer">
            <button type="submit" class="btn btn-save">Update Project</button>
            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-cancel">Cancel</a>
        </div>
    </form>
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
    .form-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }
    
    .project-form {
        width: 100%;
    }
    
    .form-header {
        padding: 20px;
        background-color: #f5f5f5;
        border-bottom: 1px solid #eee;
    }
    
    .form-header h2 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }
    
    .form-body {
        padding: 20px;
    }
    
    .alert-danger {
        background-color: #fff5f5;
        color: #e31e24;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
    }
    
    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }
    
    .form-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .form-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .form-section h3 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 16px;
        color: #333;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-row {
        display: flex;
        gap: 20px;
    }
    
    .form-row .form-group {
        flex: 1;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555;
    }
    
    .required {
        color: #e31e24;
    }
    
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .form-control:focus {
        border-color: #e31e24;
        outline: none;
        box-shadow: 0 0 0 2px rgba(227, 30, 36, 0.1);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    
    .form-footer {
        padding: 20px;
        background-color: #f5f5f5;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    
    .btn {
        padding: 10px 20px;
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
    
    .btn-save {
        background-color: #28a745;
        color: white;
    }
    
    .btn-cancel {
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ddd;
    }
    
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }

    .document-selection-help {
    margin-bottom: 15px;
    color: #666;
}

.document-type-selection {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.select-all-container {
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.select-all-label {
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.select-all-checkbox {
    margin-right: 10px;
}

.document-types-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 10px;
}

.document-type-item {
    padding: 8px;
    transition: background-color 0.2s;
    border-radius: 4px;
}

.document-type-item:hover {
    background-color: #f0f0f0;
}

.document-type-label {
    cursor: pointer;
    display: flex;
    align-items: center;
    margin: 0;
}

.document-type-checkbox {
    margin-right: 10px;
}

/* Add some additional styling for the form sections */
.form-section {
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.form-section h3 {
    margin-top: 0;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    color: #333;
}

.input-group-text {
    background-color: #f8f9fa;
    color: #495057;
}
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Date validation
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        
        if (startDateInput && endDateInput) {
            startDateInput.addEventListener('change', function() {
                if (this.value) {
                    endDateInput.min = this.value;
                }
            });
            
            // Set initial minimum date for end_date
            if (startDateInput.value) {
                endDateInput.min = startDateInput.value;
            }
        }

        const contractValueInput = document.getElementById('contact_value');
    const contractConsumptionInput = document.getElementById('contract_value_consumption');
    const contractBalanceInput = document.getElementById('contract_balance');
    
    function calculateBalance() {
        if (contractValueInput.value && contractConsumptionInput.value) {
            const value = parseFloat(contractValueInput.value) || 0;
            const consumption = parseFloat(contractConsumptionInput.value) || 0;
            const balance = value - consumption;
            contractBalanceInput.value = balance.toFixed(2);
        } else {
            contractBalanceInput.value = '';
        }
    }
    
    contractValueInput.addEventListener('input', calculateBalance);
    contractConsumptionInput.addEventListener('input', calculateBalance);
    
    // Initial calculation
    calculateBalance();
    
    // Select all document types functionality
    const selectAllCheckbox = document.getElementById('select-all-documents');
    const documentTypeCheckboxes = document.querySelectorAll('.document-type-checkbox');
    
    selectAllCheckbox.addEventListener('change', function() {
        documentTypeCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });
    
    // Update select all checkbox state based on individual selections
    function updateSelectAllState() {
        const allChecked = Array.from(documentTypeCheckboxes).every(checkbox => checkbox.checked);
        const someChecked = Array.from(documentTypeCheckboxes).some(checkbox => checkbox.checked);
        
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
    }
    
    documentTypeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectAllState);
    });
    
    // Initial state
    updateSelectAllState();
    });
</script>
@endsection