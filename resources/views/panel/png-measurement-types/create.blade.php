@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
.field-builder {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    background: #f8f9fa;
}
.field-item {
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 15px;
    margin-bottom: 15px;
    background: white;
    position: relative;
}
.field-controls {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 10px;
}
.field-number {
    background: #007bff;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-right: 15px;
}
.remove-field {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #dc3545;
    color: white;
    border: none;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    cursor: pointer;
}
.template-buttons {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.template-btn {
    background: #e3f2fd;
    border: 1px solid #1976d2;
    color: #1976d2;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}
.template-btn:hover {
    background: #1976d2;
    color: white;
}
</style>
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="search-box"></div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">Create Measurement Type</h1>

    <div class="form-card">
        <div class="form-header">
            New Measurement Type Configuration
        </div>
        <div class="form-body">
            <form action="{{ route('png-measurement-types.store') }}" method="POST">
                @csrf

                <!-- Basic Information -->
                <div class="form-section-title">Basic Information</div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required placeholder="e.g., Standard Flat Type A">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Type <span class="required">*</span></label>
                        <select name="png_type" id="png_type" class="form-control @error('png_type') is-invalid @enderror" required onchange="loadTemplate()">
                            <option value="">Select Type</option>
                            @foreach($pngTypes as $key => $value)
                                <option value="{{ $key }}" {{ old('png_type') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('png_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-full">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="Describe this measurement type and its use cases">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Field Builder -->
                <div class="form-section-title">Measurement Fields Configuration</div>
                
                <div class="template-buttons">
                    <button type="button" class="template-btn" onclick="loadDefaultTemplate('flat')">
                        <i class="fas fa-building"></i> Load Flat Template
                    </button>
                    <button type="button" class="template-btn" onclick="loadDefaultTemplate('house')">
                        <i class="fas fa-home"></i> Load House Template
                    </button>
                    <button type="button" class="template-btn" onclick="loadDefaultTemplate('bungalow')">
                        <i class="fas fa-warehouse"></i> Load Bungalow Template
                    </button>
                    <button type="button" class="template-btn" onclick="clearAllFields()">
                        <i class="fas fa-trash"></i> Clear All
                    </button>
                </div>

                <div class="field-builder">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Measurement Fields</h5>
                        <button type="button" class="btn btn-primary btn-sm" onclick="addField()">
                            <i class="fas fa-plus"></i> Add Field
                        </button>
                    </div>
                    
                    <div id="fields-container">
                        <!-- Fields will be added here dynamically -->
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('png-measurement-types.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Measurement Type</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let fieldCounter = 0;

const fieldTypes = @json($fieldTypes);

const templates = {
    flat: [
        {
            name: 'gi_guard_to_main_valve',
            label: 'GI Guard to Main Valve (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_main_valve_to_meter',
            label: 'GI Main Valve to Meter (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_meter_to_kitchen',
            label: 'GI Meter to Kitchen (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_meter_to_geyser',
            label: 'GI Meter to Geyser (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'total_gi',
            label: 'Total GI (Auto-calculated)',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: true,
            calculation_formula: 'sum_category:gi_measurements'
        },
        {
            name: 'valve_half_inch',
            label: 'Valve 1/2"',
            type: 'integer',
            unit: 'qty',
            category: 'fittings',
            required: false,
            calculated: false
        },
        {
            name: 'gi_coupling_half_inch',
            label: 'GI Coupling 1/2"',
            type: 'integer',
            unit: 'qty',
            category: 'fittings',
            required: false,
            calculated: false
        }
    ],
    house: [
        {
            name: 'gi_guard_to_main_valve',
            label: 'GI Guard to Main Valve (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_main_valve_to_meter',
            label: 'GI Main Valve to Meter (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_meter_to_kitchen',
            label: 'GI Meter to Kitchen (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_meter_to_geyser_ground',
            label: 'GI Meter to Geyser Ground Floor (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_meter_to_geyser_first',
            label: 'GI Meter to Geyser First Floor (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'total_gi',
            label: 'Total GI (Auto-calculated)',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: true,
            calculation_formula: 'sum_category:gi_measurements'
        }
    ],
    bungalow: [
        {
            name: 'gi_guard_to_main_valve',
            label: 'GI Guard to Main Valve (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_main_valve_to_meter',
            label: 'GI Main Valve to Meter (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_meter_to_kitchen_main',
            label: 'GI Meter to Main Kitchen (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_meter_to_kitchen_guest',
            label: 'GI Meter to Guest Kitchen (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_meter_to_geyser_master',
            label: 'GI Meter to Master Geyser (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        },
        {
            name: 'gi_meter_to_geyser_guest',
            label: 'GI Meter to Guest Geyser (1/2")',
            type: 'decimal',
            unit: 'meters',
            category: 'gi_measurements',
            required: false,
            calculated: false
        }
    ]
};

function addField(fieldData = null) {
    fieldCounter++;
    const container = document.getElementById('fields-container');
    
    const fieldHtml = `
        <div class="field-item" id="field-${fieldCounter}">
            <button type="button" class="remove-field" onclick="removeField(${fieldCounter})">
                <i class="fas fa-times"></i>
            </button>
            
            <div class="field-controls">
                <div class="field-number">${fieldCounter}</div>
                <h6 class="mb-0">Field Configuration</h6>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Field Name <span class="required">*</span></label>
                    <input type="text" name="measurement_fields[${fieldCounter}][name]" 
                           class="form-control" required 
                           value="${fieldData?.name || ''}" 
                           placeholder="e.g., gi_pipe_length">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Display Label <span class="required">*</span></label>
                    <input type="text" name="measurement_fields[${fieldCounter}][label]" 
                           class="form-control" required 
                           value="${fieldData?.label || ''}" 
                           placeholder="e.g., GI Pipe Length (1/2 inch)">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Field Type <span class="required">*</span></label>
                    <select name="measurement_fields[${fieldCounter}][type]" class="form-control" required onchange="toggleSelectOptions(${fieldCounter})">
                        <option value="">Select Type</option>
                        ${Object.entries(fieldTypes).map(([key, value]) => 
                            `<option value="${key}" ${fieldData?.type === key ? 'selected' : ''}>${value}</option>`
                        ).join('')}
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Unit</label>
                    <input type="text" name="measurement_fields[${fieldCounter}][unit]" 
                           class="form-control" 
                           value="${fieldData?.unit || ''}" 
                           placeholder="e.g., meters, qty, kg">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Category <span class="required">*</span></label>
                    <input type="text" name="measurement_fields[${fieldCounter}][category]" 
                           class="form-control" required 
                           value="${fieldData?.category || 'general'}" 
                           placeholder="e.g., gi_measurements, fittings, equipment">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Calculation Formula</label>
                    <input type="text" name="measurement_fields[${fieldCounter}][calculation_formula]" 
                           class="form-control" 
                           value="${fieldData?.calculation_formula || ''}" 
                           placeholder="e.g., sum_category:gi_measurements">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="option-label">
                        <input type="checkbox" name="measurement_fields[${fieldCounter}][required]" 
                               ${fieldData?.required ? 'checked' : ''}>
                        <span class="checkmark"></span>
                        Required Field
                    </label>
                </div>
                
                <div class="form-group">
                    <label class="option-label">
                        <input type="checkbox" name="measurement_fields[${fieldCounter}][calculated]" 
                               ${fieldData?.calculated ? 'checked' : ''}>
                        <span class="checkmark"></span>
                        Auto-calculated Field
                    </label>
                </div>
            </div>
            
            <div class="form-group" id="select-options-${fieldCounter}" style="display: ${fieldData?.type === 'select' ? 'block' : 'none'};">
                <label class="form-label">Select Options (one per line)</label>
                <textarea name="measurement_fields[${fieldCounter}][options]" rows="3" 
                          class="form-control" 
                          placeholder="Option 1\nOption 2\nOption 3">${fieldData?.options ? fieldData.options.join('\n') : ''}</textarea>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', fieldHtml);
}

function removeField(fieldId) {
    const field = document.getElementById(`field-${fieldId}`);
    if (field) {
        field.remove();
    }
}

function toggleSelectOptions(fieldId) {
    const typeSelect = document.querySelector(`select[name="measurement_fields[${fieldId}][type]"]`);
    const optionsDiv = document.getElementById(`select-options-${fieldId}`);
    
    if (typeSelect.value === 'select') {
        optionsDiv.style.display = 'block';
    } else {
        optionsDiv.style.display = 'none';
    }
}

function loadDefaultTemplate(templateType) {
    if (templates[templateType]) {
        clearAllFields();
        templates[templateType].forEach(fieldData => {
            addField(fieldData);
        });
    }
}

function clearAllFields() {
    document.getElementById('fields-container').innerHTML = '';
    fieldCounter = 0;
}

function loadTemplate() {
    const pngType = document.getElementById('png_type').value;
    if (pngType && templates[pngType]) {
        if (confirm('Load default template for ' + pngType + '? This will replace existing fields.')) {
            loadDefaultTemplate(pngType);
        }
    }
}

// Initialize with one empty field
document.addEventListener('DOMContentLoaded', function() {
    addField();
});
</script>
@endsection