@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-png-tracker.css') }}">
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search...">
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">Add New PE/PNG Job</h1>

    <div class="form-card">
        <div class="form-header">
            New Job Order Details
        </div>
        <div class="form-body">
            <form action="{{ route('pe-png.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Job Order Number <span class="required">*</span></label>
                        <input type="text" name="job_order_number" class="form-control @error('job_order_number') is-invalid @enderror" value="{{ old('job_order_number') }}" required>
                        @error('job_order_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Category <span class="required">*</span></label>
                        <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            <option value="domestic" {{ old('category') == 'domestic' ? 'selected' : '' }}>Domestic</option>
                            <option value="commercial" {{ old('category') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="riser" {{ old('category') == 'riser' ? 'selected' : '' }}>Riser</option>
                            <option value="gc" {{ old('category') == 'gc' ? 'selected' : '' }}>GC</option>
                            <option value="conversion" {{ old('category') == 'conversion' ? 'selected' : '' }}>Conversion</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Plumbing Date <span class="required">*</span></label>
                        <input type="date" name="plumbing_date" class="form-control @error('plumbing_date') is-invalid @enderror" value="{{ old('plumbing_date') }}" required>
                        @error('plumbing_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Plumber <span class="required">*</span></label>
                        <select name="plumber_id" class="form-control @error('plumber_id') is-invalid @enderror" required>
                            <option value="">Select Plumber</option>
                            @foreach($plumbers as $plumber)
                                <option value="{{ $plumber->id }}" {{ old('plumber_id') == $plumber->id ? 'selected' : '' }}>
                                    {{ $plumber->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('plumber_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">GC Date</label>
                        <input type="date" name="gc_date" class="form-control @error('gc_date') is-invalid @enderror" value="{{ old('gc_date') }}">
                        @error('gc_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">MMT Date</label>
                        <input type="date" name="mmt_date" class="form-control @error('mmt_date') is-invalid @enderror" value="{{ old('mmt_date') }}">
                        @error('mmt_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Bill RA Number</label>
                        <input type="text" name="bill_ra_no" class="form-control @error('bill_ra_no') is-invalid @enderror" value="{{ old('bill_ra_no') }}">
                        @error('bill_ra_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">PLB Bill Status</label>
                        <select name="plb_bill_status" class="form-control @error('plb_bill_status') is-invalid @enderror">
                            <option value="pending" {{ old('plb_bill_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processed" {{ old('plb_bill_status') == 'processed' ? 'selected' : '' }}>Processed</option>
                            <option value="paid" {{ old('plb_bill_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="locked" {{ old('plb_bill_status') == 'locked' ? 'selected' : '' }}>Locked</option>
                        </select>
                        @error('plb_bill_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">SLA Days</label>
                        <input type="number" name="sla_days" class="form-control @error('sla_days') is-invalid @enderror" value="{{ old('sla_days') }}" min="0">
                        @error('sla_days')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">PE DPR</label>
                        <input type="text" name="pe_dpr" class="form-control @error('pe_dpr') is-invalid @enderror" value="{{ old('pe_dpr') }}">
                        @error('pe_dpr')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Scan Copy</label>
                        <input type="file" name="scan_copy" class="form-control-file @error('scan_copy') is-invalid @enderror">
                        <div class="form-file-info">Accepted formats: PDF, JPG, PNG (max: 2MB)</div>
                        @error('scan_copy')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">AutoCAD Drawing</label>
                        <input type="file" name="autocad_drawing" class="form-control-file @error('autocad_drawing') is-invalid @enderror">
                        <div class="form-file-info">Accepted formats: DWG, DXF, PDF (max: 5MB)</div>
                        @error('autocad_drawing')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-full">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" rows="4" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-full">
                        <label class="form-label">Site Visit Details</label>
                        <div id="site-visits-container" class="dynamic-list">
                            <div class="dynamic-item">
                                <input type="date" name="site_visits[0][date]" class="form-control dynamic-field">
                                <input type="text" name="site_visits[0][remarks]" class="form-control dynamic-field" placeholder="Visit Remarks">
                                <button type="button" class="btn-add" onclick="addSiteVisit()">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-full">
                        <label class="form-label">Consumption Details</label>
                        <div id="consumption-container" class="dynamic-list">
                            <div class="dynamic-item">
                                <input type="text" name="consumption_details[0][item]" class="form-control dynamic-field" placeholder="Item">
                                <input type="number" name="consumption_details[0][quantity]" class="form-control dynamic-field" placeholder="Quantity" min="0" step="0.01">
                                <input type="text" name="consumption_details[0][unit]" class="form-control dynamic-field" placeholder="Unit">
                                <input type="number" name="consumption_details[0][rate]" class="form-control dynamic-field" placeholder="Rate" min="0" step="0.01">
                                <button type="button" class="btn-add" onclick="addConsumption()">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('pe-png.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function addSiteVisit() {
        const container = document.getElementById('site-visits-container');
        const count = container.querySelectorAll('.dynamic-item').length;
        
        const newItem = document.createElement('div');
        newItem.className = 'dynamic-item';
        newItem.innerHTML = `
            <input type="date" name="site_visits[${count}][date]" class="form-control dynamic-field">
            <input type="text" name="site_visits[${count}][remarks]" class="form-control dynamic-field" placeholder="Visit Remarks">
            <button type="button" class="btn-remove" onclick="removeDynamicItem(this)">-</button>
        `;
        container.appendChild(newItem);
    }

    function addConsumption() {
        const container = document.getElementById('consumption-container');
        const count = container.querySelectorAll('.dynamic-item').length;
        
        const newItem = document.createElement('div');
        newItem.className = 'dynamic-item';
        newItem.innerHTML = `
            <input type="text" name="consumption_details[${count}][item]" class="form-control dynamic-field" placeholder="Item">
            <input type="number" name="consumption_details[${count}][quantity]" class="form-control dynamic-field" placeholder="Quantity" min="0" step="0.01">
            <input type="text" name="consumption_details[${count}][unit]" class="form-control dynamic-field" placeholder="Unit">
            <input type="number" name="consumption_details[${count}][rate]" class="form-control dynamic-field" placeholder="Rate" min="0" step="0.01">
            <button type="button" class="btn-remove" onclick="removeDynamicItem(this)">-</button>
        `;
        container.appendChild(newItem);
    }

    function removeDynamicItem(button) {
        const item = button.parentNode;
        item.parentNode.removeChild(item);
    }
</script>
@endsection