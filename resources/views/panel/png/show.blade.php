@extends('panel.layouts.app')

@section('title', 'PNG Job Details')

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteFile(field, index, btn) {
        Swal.fire({
            title: 'Delete this file?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `{{ route('png.delete-file', ['png' => $png->id, 'field' => ':field', 'index' => ':index']) }}`
                    .replace(':field', field)
                    .replace(':index', index);

                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Deleted!', 'File has been removed.', 'success');
                        // Remove the element from DOM
                        $(btn).closest('.position-relative').fadeOut(300, function() {
                            $(this).remove();
                            if ($('.doc-grid').children('.position-relative').length === 0) {
                                $('.doc-grid').html('<div class="col-12 text-center text-muted py-4">No documents attached.</div>');
                            }
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'Something went wrong.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Network error or server error.', 'error');
                });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Find all delete forms
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default submission

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    });
</script>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
/* ==========================================
   MODERN DASHBOARD THEME - VIEW PAGE
   Uses Edit/Create colors but View structure
   ========================================== */

:root {
    --primary: #3b82f6;
    --primary-dark: #2563eb;
    --secondary: #64748b;
    --success: #22c55e;
    --bg-soft: #f8fafc;
    --text-main: #1e293b;
    --text-muted: #64748b;
}

body {
    background-color: var(--bg-soft);
}

/* Info Cards */
.view-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.03);
    margin-bottom: 24px;
    height: 100%;
    transition: transform 0.2s ease;
    overflow: hidden;
}

.view-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.card-header-custom {
    padding: 18px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 12px;
}

.card-header-custom.gradient-blue {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
}

.card-title-custom {
    font-weight: 700;
    font-size: 16px;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.card-body-custom {
    padding: 24px;
}

/* Icons */
.icon-box {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 16px;
}

.icon-box.primary { background: #eff6ff; color: var(--primary); }
.icon-box.success { background: #dcfce7; color: var(--success); }
.icon-box.white { background: rgba(255,255,255,0.2); color: white; }


/* Typography - Distinct from Forms */
.info-group {
    margin-bottom: 18px;
}

.info-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--text-muted);
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.info-value {
    font-size: 15px;
    font-weight: 500;
    color: var(--text-main);
    line-height: 1.5;
}

.info-value.hero {
    font-size: 24px;
    font-weight: 800;
    color: var(--primary-dark);
}

/* Status Pill */
.status-pill {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
}
.status-workable { background: #dcfce7; color: #15803d; }
.status-not-workable { background: #fee2e2; color: #b91c1c; }
.status-plb-done { background: #dbeafe; color: #1e40af; }
.status-default { background: #f1f5f9; color: #475569; }

/* Timeline Component */
.timeline-container {
    position: relative;
    padding-left: 20px;
}

.timeline-item {
    position: relative;
    padding-bottom: 24px;
    padding-left: 24px;
    border-left: 2px solid #e2e8f0;
}

.timeline-item:last-child {
    border-left: 2px solid transparent;
}

.timeline-marker {
    position: absolute;
    left: -9px;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: white;
    border: 3px solid var(--text-muted);
}

.timeline-item.completed .timeline-marker {
    border-color: var(--success);
    background: var(--success);
}

.timeline-date {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 2px;
}

.timeline-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-main);
}

/* Documents Grid */
.doc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
}

.doc-card-mini {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    padding-top: 24px;
    text-align: center;
    transition: all 0.2s;
    text-decoration: none;
    display: block;
    position: relative;
}

.remove-doc {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 22px;
    height: 22px;
    background: #fee2e2;
    color: #ef4444;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    cursor: pointer;
    transition: all 0.2s;
    z-index: 10;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.1);
}

.remove-doc:hover {
    background: #ef4444;
    color: white;
    transform: scale(1.1);
}

.position-relative {
    position: relative;
}


.doc-card-mini:hover {
    background: white;
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
}

.doc-icon-lg {
    font-size: 32px;
    color: var(--primary);
    margin-bottom: 12px;
}

.doc-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-main);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
}

.doc-type {
    font-size: 11px;
    color: var(--text-muted);
    text-transform: uppercase;
}

/* Header Actions */
.action-bar {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-bottom: 24px;
}

.btn-custom {
    padding: 10px 20px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-light-custom {
    background: white;
    color: var(--text-muted);
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}
.btn-light-custom:hover { background: #f8fafc; color: var(--text-main); }

.btn-primary-custom {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}
.btn-primary-custom:hover { transform: translateY(-2px); color: white; }

.btn-danger-custom {
    background: #fee2e2;
    color: #ef4444;
}
.btn-danger-custom:hover { background: #fee2e2; transform: translateY(-2px); }

/* Measurements Grid */
.measure-box {
    background: #f8fafc;
    border-radius: 10px;
    padding: 12px 16px;
    border-left: 3px solid var(--primary);
}

.measure-val {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-main);
}
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Top Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h1 class="h3 fw-bold mb-1" style="color: var(--text-main);">Job Overview</h1>
            <p style="color: var(--text-muted);">
                Service Order: <span class="fw-bold text-dark">#{{ $png->service_order_no }}</span>
                <span class="mx-2">•</span>
                Last updated {{ $png->updated_at->diffForHumans() }}
            </p>
        </div>
        <div class="col-md-6">
            <div class="action-bar">
                <a href="{{ route('png.index') }}" class="btn-custom btn-light-custom">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <a href="{{ route('png.edit', $png) }}" class="btn-custom btn-primary-custom">
                    <i class="fas fa-pen"></i> Edit Job
                </a>
                <form action="{{ route('png.destroy', $png) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-custom btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- LEFT COLUMN -->
        <div class="col-lg-8">
            <!-- Main Info Card -->
            <div class="view-card">
                <div class="card-header-custom gradient-blue">
                    <div class="icon-box white">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="ms-2">
                        <h5 class="card-title-custom">Customer & Location</h5>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-white text-primary px-3 py-2 rounded-pill shadow-sm">
                            {{ ucfirst($png->png_type ?? 'Standard') }}
                        </span>
                    </div>
                </div>
                <div class="card-body-custom">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                             <div class="info-group">
                                <span class="info-label">Customer Name</span>
                                <div class="info-value hero">{{ $png->customer_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 text-md-end">
                            <div class="info-group">
                                <span class="info-label">Current Status</span>
                                @php
                                    $statusClass = 'status-default';
                                    if($png->connections_status) {
                                        $slug = strtolower(str_replace('_', '-', $png->connections_status));
                                        $statusClass = "status-{$slug}";
                                    }
                                @endphp
                                <span class="status-pill {{ $statusClass }}">
                                    {{ str_replace('_', ' ', $png->connections_status ?? 'Pending') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-group">
                                <span class="info-label">Customer No</span>
                                <div class="info-value">{{ $png->customer_no ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-group">
                                <span class="info-label">Contact Number</span>
                                <div class="info-value">{{ $png->contact_no ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-group">
                                <span class="info-label">Application No</span>
                                <div class="info-value">{{ $png->application_no ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="info-group">
                                <span class="info-label">Property Address</span>
                                <div class="info-value">{{ $png->address ?? 'No address provided.' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="info-group">
                                <span class="info-label">Area</span>
                                <div class="info-value">{{ $png->area ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="info-group">
                                <span class="info-label">Scheme</span>
                                <div class="info-value">{{ $png->scheme ?? '-' }}</div>
                            </div>
                        </div>
                         <div class="col-md-4 mt-3">
                            <div class="info-group">
                                <span class="info-label">House Type</span>
                                <div class="info-value">{{ $png->house_type_name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical & Measurements -->
            <div class="view-card">
                 <div class="card-header-custom gradient-blue">
                     <div class="icon-box primary">
                        <i class="fas fa-ruler-combined"></i>
                    </div>
                    <span class="card-title-custom text-dark">Technical Specifications</span>
                    <div class="ms-auto text-muted small">
                        Type: {{ $png->measurementType->name ?? 'Standard' }}
                    </div>
                </div>
                <div class="card-body-custom">
                    <!-- Tech Readings -->
                    <div class="row mb-4">
                         <div class="col-md-3">
                             <div class="info-group">
                                <span class="info-label">Meter Number</span>
                                <div class="info-value fw-bold text-primary">{{ $png->meter_number ?? '-' }}</div>
                            </div>
                         </div>
                         <div class="col-md-3">
                             <div class="info-group">
                                <span class="info-label">Initial Reading</span>
                                <div class="info-value">{{ $png->meter_reading ?? '-' }}</div>
                            </div>
                         </div>
                         <div class="col-md-3">
                             <div class="info-group">
                                <span class="info-label">Conversion Status</span>
                                <div class="info-value">{{ ucfirst($png->conversion_status ?? '-') }}</div>
                            </div>
                         </div>
                    </div>
                    
                    <h6 class="text-muted text-uppercase fw-bold small mb-3">Measurements & Fittings</h6>
                    @if(!empty($png->measurements_data))
                        <div class="row g-3">
                             @foreach($png->measurements_data as $key => $value)
                                @if(!empty($value))
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="measure-box">
                                        <div class="info-label mb-1">{{ ucfirst(str_replace('_', ' ', $key)) }}</div>
                                        <div class="measure-val">{{ $value }}</div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="p-3 bg-light rounded text-center text-muted">
                            No measurements recorded.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Documents -->
             <div class="view-card">
                 <div class="card-header-custom gradient-blue">
                     <div class="icon-box primary">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <span class="card-title-custom text-dark">Files & Documents</span>
                </div>
                <div class="card-body-custom">
                    <div class="doc-grid">
                        <!-- Helper for File Cards -->
                        @php
                            $allFiles = [];
                            
                            // Singles
                            if($png->scan_copy_path) $allFiles[] = ['path' => $png->scan_copy_path, 'name' => 'Scan Copy', 'type' => 'PDF', 'field' => 'scan_copy_path'];
                            if($png->autocad_drawing_path) $allFiles[] = ['path' => $png->autocad_drawing_path, 'name' => 'AutoCAD Drawing', 'type' => 'DWG', 'field' => 'autocad_drawing_path'];
                            if($png->certificate_path) $allFiles[] = ['path' => $png->certificate_path, 'name' => 'Certificate', 'type' => 'DOC', 'field' => 'certificate_path'];

                            // Multiples
                            $multiFields = ['job_cards_paths' => 'Job Card', 'site_visit_reports_paths' => 'Site Report', 'other_documents_paths' => 'Other'];
                            foreach($multiFields as $field => $label) {
                                if($png->$field) {
                                    $files = is_string($png->$field) ? json_decode($png->$field, true) : $png->$field;
                                    if(is_array($files)) {
                                        foreach($files as $i => $f) {
                                             $allFiles[] = ['path' => $f['path'], 'name' => $f['name'] ?? "$label #".($i+1), 'type' => 'FILE', 'field' => $field, 'index' => $i];
                                        }
                                    }
                                }
                            }
                        @endphp

                        @forelse($allFiles as $index => $file)
                            <div class="position-relative">
                                 <button type="button" class="remove-doc" 
                                    onclick="deleteFile('{{ $file['field'] }}', '{{ $file['index'] ?? '' }}', this)" 
                                    title="Remove file">
                                    <i class="fas fa-times"></i>
                                </button>
                                <a href="{{ Storage::disk('public')->url($file['path']) }}" target="_blank" class="doc-card-mini">
                                    <div class="doc-icon-lg">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <span class="doc-name" title="{{ $file['name'] }}">{{ $file['name'] }}</span>
                                    <span class="doc-type">{{ $file['type'] }}</span>
                                </a>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-4">
                                No documents attached.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-4">
            
            <!-- Timeline -->
            <div class="view-card">
                <div class="card-header-custom gradient-blue">
                    <span class="card-title-custom text-dark">Job Timeline</span>
                </div>
                <div class="card-body-custom">
                    <div class="timeline-container">
                        @php
                            $dates = [
                                ['label' => 'Agreement Signed', 'date' => $png->agreement_date],
                                ['label' => 'Plumbing Done', 'date' => $png->plb_date],
                                ['label' => 'PPT Tested', 'date' => $png->pdt_date],
                                ['label' => 'Ground Conn.', 'date' => $png->ground_connections_date],
                                ['label' => 'MMT Completed', 'date' => $png->mmt_date],
                                ['label' => 'Conversion', 'date' => $png->conversion_date],
                                ['label' => 'Report Submitted', 'date' => $png->report_submission_date],
                            ];
                        @endphp

                        @foreach($dates as $item)
                            <div class="timeline-item {{ $item['date'] ? 'completed' : '' }}">
                                <div class="timeline-marker"></div>
                                <div class="timeline-date">{{ $item['date'] ? $item['date']->format('d M, Y') : 'Pending' }}</div>
                                <div class="timeline-title">{{ $item['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Team -->
            <div class="view-card">
                <div class="card-header-custom gradient-blue">
                    <span class="card-title-custom text-dark">Assigned Team</span>
                </div>
                <div class="card-body-custom">
                     <div class="info-group border-bottom pb-2 mb-2">
                        <span class="info-label">Plumber</span>
                        <div class="info-value">{{ $png->plb_name ?? 'Unassigned' }}</div>
                    </div>
                    <div class="info-group border-bottom pb-2 mb-2">
                        <span class="info-label">PPT Witness</span>
                        <div class="info-value">{{ $png->pdt_witness_by ?? 'Unassigned' }}</div>
                    </div>
                    <div class="info-group border-bottom pb-2 mb-2">
                        <span class="info-label">GC Witness</span>
                        <div class="info-value">{{ $png->ground_connections_witness_by ?? 'Unassigned' }}</div>
                    </div>
                    <div class="info-group">
                        <span class="info-label">MMT Witness</span>
                        <div class="info-value">{{ $png->mmt_witness_by ?? 'Unassigned' }}</div>
                    </div>
                </div>
            </div>

            <!-- Remarks -->
            @if($png->remarks)
            <div class="view-card bg-light border-0">
                <div class="card-body-custom ">
                    <h6 class="fw-bold mb-2">Remarks</h6>
                    <p class="mb-0 text-muted small">{{ $png->remarks }}</p>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection


