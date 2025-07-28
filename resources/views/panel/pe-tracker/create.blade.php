@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="breadcrumb">
            <a href="{{ route('pe-tracker.index') }}">PE Tracker</a>
            <span>/</span>
            <span>{{ isset($peTracker) ? 'Edit Record' : 'Add New Record' }}</span>
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">{{ isset($peTracker) ? 'Edit PE Tracker Record' : 'Add New PE Tracker Record' }}</h1>

    <div class="content-card">
        <form action="{{ isset($peTracker) ? route('pe-tracker.update', $peTracker) : route('pe-tracker.store') }}" method="POST">
            @csrf
            @if(isset($peTracker))
                @method('PUT')
            @endif

            <!-- Basic Information Section -->
            <div class="form-section">
                <h3>Basic Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Date <span class="required">*</span></label>
                        <input type="date" name="date" id="date" 
                               value="{{ old('date', isset($peTracker) ? $peTracker->date->format('Y-m-d') : '') }}" 
                               class="form-control @error('date') is-invalid @enderror" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="dpr_no">DPR No</label>
                        <input type="text" name="dpr_no" id="dpr_no" 
                               value="{{ old('dpr_no', isset($peTracker) ? $peTracker->dpr_no : '') }}" 
                               class="form-control @error('dpr_no') is-invalid @enderror">
                        @error('dpr_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="sites_names">Site Names <span class="required">*</span></label>
                    <textarea name="sites_names" id="sites_names" rows="3" 
                              class="form-control @error('sites_names') is-invalid @enderror" required>{{ old('sites_names', isset($peTracker) ? $peTracker->sites_names : '') }}</textarea>
                    @error('sites_names')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="activity">Activity <span class="required">*</span></label>
                        <select name="activity" id="activity" class="form-control @error('activity') is-invalid @enderror" required>
                            <option value="">Select Activity</option>
                            @foreach($activities as $key => $value)
                                <option value="{{ $key }}" 
                                        {{ old('activity', isset($peTracker) ? $peTracker->activity : '') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('activity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="mukadam_name">Mukadam Name</label>
                        <input type="text" name="mukadam_name" id="mukadam_name" 
                               value="{{ old('mukadam_name', isset($peTracker) ? $peTracker->mukadam_name : '') }}" 
                               class="form-control @error('mukadam_name') is-invalid @enderror"
                               list="mukadam-list">
                        <datalist id="mukadam-list">
                            @foreach($mukadams as $mukadam)
                                <option value="{{ $mukadam }}">
                            @endforeach
                        </datalist>
                        @error('mukadam_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="supervisor">Supervisor</label>
                        <input type="text" name="supervisor" id="supervisor" 
                               value="{{ old('supervisor', isset($peTracker) ? $peTracker->supervisor : '') }}" 
                               class="form-control @error('supervisor') is-invalid @enderror"
                               list="supervisor-list">
                        <datalist id="supervisor-list">
                            @foreach($supervisors as $supervisor)
                                <option value="{{ $supervisor }}">
                            @endforeach
                        </datalist>
                        @error('supervisor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tpi_name">TPI Name</label>
                        <input type="text" name="tpi_name" id="tpi_name" 
                               value="{{ old('tpi_name', isset($peTracker) ? $peTracker->tpi_name : '') }}" 
                               class="form-control @error('tpi_name') is-invalid @enderror">
                        @error('tpi_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="ra_bill_no">RA Bill No</label>
                    <input type="text" name="ra_bill_no" id="ra_bill_no" 
                           value="{{ old('ra_bill_no', isset($peTracker) ? $peTracker->ra_bill_no : '') }}" 
                           class="form-control @error('ra_bill_no') is-invalid @enderror">
                    @error('ra_bill_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Measurements Section -->
            <div class="form-section">
                <h3>Measurements & Laying Data</h3>
                <p class="section-help">Enter measurements in meters. Only fill fields that are applicable.</p>
                
                <div class="measurement-grid">
                    <div class="measurement-group">
                        <h4>Open Cut Laying</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="32_mm_laying_open_cut">32 MM Laying</label>
                                <input type="number" step="0.01" min="0" name="32_mm_laying_open_cut" id="32_mm_laying_open_cut" 
                                       value="{{ old('32_mm_laying_open_cut', isset($peTracker) ? $peTracker->getMeasurement('32_mm_laying_open_cut') : '') }}" 
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="63_mm_laying_open_cut">63 MM Laying</label>
                                <input type="number" step="0.01" min="0" name="63_mm_laying_open_cut" id="63_mm_laying_open_cut" 
                                       value="{{ old('63_mm_laying_open_cut', isset($peTracker) ? $peTracker->getMeasurement('63_mm_laying_open_cut') : '') }}" 
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="90_mm_laying_open_cut">90 MM Laying</label>
                                <input type="number" step="0.01" min="0" name="90_mm_laying_open_cut" id="90_mm_laying_open_cut" 
                                       value="{{ old('90_mm_laying_open_cut', isset($peTracker) ? $peTracker->getMeasurement('90_mm_laying_open_cut') : '') }}" 
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="125_mm_laying_open_cut">125 MM Laying</label>
                                <input type="number" step="0.01" min="0" name="125_mm_laying_open_cut" id="125_mm_laying_open_cut" 
                                       value="{{ old('125_mm_laying_open_cut', isset($peTracker) ? $peTracker->getMeasurement('125_mm_laying_open_cut') : '') }}" 
                                       class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="measurement-group">
                        <h4>Manual Boring</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="32_mm_manual_boring">32 MM Manual Boring</label>
                                <input type="number" step="0.01" min="0" name="32_mm_manual_boring" id="32_mm_manual_boring" 
                                       value="{{ old('32_mm_manual_boring', isset($peTracker) ? $peTracker->getMeasurement('32_mm_manual_boring') : '') }}" 
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="63_mm_manual_boring">63 MM Manual Boring</label>
                                <input type="number" step="0.01" min="0" name="63_mm_manual_boring" id="63_mm_manual_boring" 
                                       value="{{ old('63_mm_manual_boring', isset($peTracker) ? $peTracker->getMeasurement('63_mm_manual_boring') : '') }}" 
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="90_mm_manual_boring">90 MM Manual Boring</label>
                                <input type="number" step="0.01" min="0" name="90_mm_manual_boring" id="90_mm_manual_boring" 
                                       value="{{ old('90_mm_manual_boring', isset($peTracker) ? $peTracker->getMeasurement('90_mm_manual_boring') : '') }}" 
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="125_mm_manual_boring">125 MM Manual Boring</label>
                                <input type="number" step="0.01" min="0" name="125_mm_manual_boring" id="125_mm_manual_boring" 
                                       value="{{ old('125_mm_manual_boring', isset($peTracker) ? $peTracker->getMeasurement('125_mm_manual_boring') : '') }}" 
                                       class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="measurement-group">
                        <h4>Other Work</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="breaking_hard_rock_completion">Breaking Hard Rock</label>
                                <input type="number" step="0.01" min="0" name="breaking_hard_rock_completion" id="breaking_hard_rock_completion" 
                                       value="{{ old('breaking_hard_rock_completion', isset($peTracker) ? $peTracker->getMeasurement('breaking_hard_rock_completion') : '') }}" 
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="excavation_beyond_2m_depth">Excavation Beyond 2M</label>
                                <input type="number" step="0.01" min="0" name="excavation_beyond_2m_depth" id="excavation_beyond_2m_depth" 
                                       value="{{ old('excavation_beyond_2m_depth', isset($peTracker) ? $peTracker->getMeasurement('excavation_beyond_2m_depth') : '') }}" 
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Installation Section -->
            <div class="form-section">
                <h3>Installation & Testing Data</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="installation_sr_5_regulator">Installation SR 5 Regulator</label>
                        <input type="number" step="0.01" min="0" name="installation_sr_5_regulator" id="installation_sr_5_regulator" 
                               value="{{ old('installation_sr_5_regulator', isset($peTracker) ? $peTracker->getInstallationData('installation_sr_5_regulator') : '') }}" 
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="flushing_testing_done">Flushing/Testing Done</label>
                        <input type="text" name="flushing_testing_done" id="flushing_testing_done" 
                               value="{{ old('flushing_testing_done', isset($peTracker) ? $peTracker->getTestingData('flushing_testing_done') : '') }}" 
                               class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="commissioning">Commissioning</label>
                        <input type="text" name="commissioning" id="commissioning" 
                               value="{{ old('commissioning', isset($peTracker) ? $peTracker->getTestingData('commissioning') : '') }}" 
                               class="form-control">
                    </div>
                </div>
            </div>

            <!-- Advanced Fields Toggle -->
            <div class="form-section">
                <div class="advanced-toggle">
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleAdvancedFields()">
                        <i class="fas fa-chevron-down" id="advanced-toggle-icon"></i>
                        Show All Fields
                    </button>
                </div>

                <div id="advanced-fields" style="display: none;">
                    <!-- All the remaining fields would go here in a similar structure -->
                    <div class="measurement-group">
                        <h4>Additional Measurements</h4>
                        <!-- Add more fields as needed -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="rcc_cutting_breaking_150">RCC Cutting/Breaking 150</label>
                                <input type="number" step="0.01" min="0" name="rcc_cutting_breaking_150" id="rcc_cutting_breaking_150" 
                                       value="{{ old('rcc_cutting_breaking_150', isset($peTracker) ? $peTracker->getMeasurement('rcc_cutting_breaking_150') : '') }}" 
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="pcc_cutting_breaking_150">PCC Cutting/Breaking 150</label>
                                <input type="number" step="0.01" min="0" name="pcc_cutting_breaking_150" id="pcc_cutting_breaking_150" 
                                       value="{{ old('pcc_cutting_breaking_150', isset($peTracker) ? $peTracker->getMeasurement('pcc_cutting_breaking_150') : '') }}" 
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ isset($peTracker) ? 'Update Record' : 'Save Record' }}
                </button>
                <a href="{{ route('pe-tracker.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleAdvancedFields() {
    const advancedFields = document.getElementById('advanced-fields');
    const toggleIcon = document.getElementById('advanced-toggle-icon');
    const toggleButton = document.querySelector('.advanced-toggle button');
    
    if (advancedFields.style.display === 'none') {
        advancedFields.style.display = 'block';
        toggleIcon.className = 'fas fa-chevron-up';
        toggleButton.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Advanced Fields';
    } else {
        advancedFields.style.display = 'none';
        toggleIcon.className = 'fas fa-chevron-down';
        toggleButton.innerHTML = '<i class="fas fa-chevron-down"></i> Show All Fields';
    }
}

// Auto-calculate total laying length
function calculateTotalLaying() {
    const layingFields = [
        '32_mm_laying_open_cut',
        '63_mm_laying_open_cut', 
        '90_mm_laying_open_cut',
        '125_mm_laying_open_cut',
        '32_mm_manual_boring',
        '63_mm_manual_boring',
        '90_mm_manual_boring',
        '125_mm_manual_boring'
    ];
    
    let total = 0;
    layingFields.forEach(field => {
        const input = document.getElementById(field);
        if (input && input.value) {
            total += parseFloat(input.value) || 0;
        }
    });
    
    // Update a display element if it exists
    const totalDisplay = document.getElementById('total-laying-display');
    if (totalDisplay) {
        totalDisplay.textContent = total.toFixed(2) + ' m';
    }
}

// Add event listeners to laying fields
document.addEventListener('DOMContentLoaded', function() {
    const layingFields = [
        '32_mm_laying_open_cut',
        '63_mm_laying_open_cut', 
        '90_mm_laying_open_cut',
        '125_mm_laying_open_cut',
        '32_mm_manual_boring',
        '63_mm_manual_boring',
        '90_mm_manual_boring',
        '125_mm_manual_boring'
    ];
    
    layingFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', calculateTotalLaying);
        }
    });
    
    // Initial calculation
    calculateTotalLaying();
});
</script>
@endsection