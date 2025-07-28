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
            <span>Record Details</span>
        </div>
        <div class="header-icons">
            <a href="{{ route('pe-tracker.edit', $peTracker) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">PE Tracker Record Details</h1>

    <div class="content-card">
        <!-- Basic Information -->
        <div class="info-section">
            <h3>Basic Information</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Date:</label>
                    <span>{{ $peTracker->formatted_date }}</span>
                </div>
                <div class="info-item">
                    <label>DPR No:</label>
                    <span>{{ $peTracker->dpr_no ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Activity:</label>
                    <span class="badge 
                        @if($peTracker->activity == 'LAYING') badge-primary
                        @elseif($peTracker->activity == 'COMMISSIONING') badge-success
                        @elseif($peTracker->activity == 'EXCAVATION') badge-warning
                        @elseif($peTracker->activity == 'FLUSHING') badge-info
                        @elseif($peTracker->activity == 'JOINT') badge-secondary
                        @elseif($peTracker->activity == 'SR INSTALLATION') badge-dark
                        @endif">
                        {{ $peTracker->activity }}
                    </span>
                </div>
                <div class="info-item">
                    <label>Mukadam Name:</label>
                    <span>{{ $peTracker->mukadam_name ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Supervisor:</label>
                    <span>{{ $peTracker->supervisor ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>TPI Name:</label>
                    <span>{{ $peTracker->tpi_name ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>RA Bill No:</label>
                    <span>{{ $peTracker->ra_bill_no ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Total Laying Length:</label>
                    <span class="highlight">{{ $peTracker->total_laying_length ? number_format($peTracker->total_laying_length, 2) . ' m' : '0.00 m' }}</span>
                </div>
            </div>
            
            <div class="info-item full-width">
                <label>Site Names:</label>
                <div class="site-names-display">{{ $peTracker->sites_names }}</div>
            </div>
        </div>

        <!-- Measurements Section -->
        @if($peTracker->measurements && count($peTracker->measurements) > 0)
        <div class="info-section">
            <h3>Measurements & Laying Data</h3>
            <div class="measurements-grid">
                <div class="measurement-category">
                    <h4>Open Cut Laying</h4>
                    <div class="measurement-list">
                        @if($peTracker->getMeasurement('32_mm_laying_open_cut'))
                            <div class="measurement-item">
                                <span class="measurement-label">32 MM Laying:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('32_mm_laying_open_cut'), 2) }} m</span>
                            </div>
                        @endif
                        @if($peTracker->getMeasurement('63_mm_laying_open_cut'))
                            <div class="measurement-item">
                                <span class="measurement-label">63 MM Laying:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('63_mm_laying_open_cut'), 2) }} m</span>
                            </div>
                        @endif
                        @if($peTracker->getMeasurement('90_mm_laying_open_cut'))
                            <div class="measurement-item">
                                <span class="measurement-label">90 MM Laying:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('90_mm_laying_open_cut'), 2) }} m</span>
                            </div>
                        @endif
                        @if($peTracker->getMeasurement('125_mm_laying_open_cut'))
                            <div class="measurement-item">
                                <span class="measurement-label">125 MM Laying:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('125_mm_laying_open_cut'), 2) }} m</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="measurement-category">
                    <h4>Manual Boring</h4>
                    <div class="measurement-list">
                        @if($peTracker->getMeasurement('32_mm_manual_boring'))
                            <div class="measurement-item">
                                <span class="measurement-label">32 MM Manual Boring:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('32_mm_manual_boring'), 2) }} m</span>
                            </div>
                        @endif
                        @if($peTracker->getMeasurement('63_mm_manual_boring'))
                            <div class="measurement-item">
                                <span class="measurement-label">63 MM Manual Boring:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('63_mm_manual_boring'), 2) }} m</span>
                            </div>
                        @endif
                        @if($peTracker->getMeasurement('90_mm_manual_boring'))
                            <div class="measurement-item">
                                <span class="measurement-label">90 MM Manual Boring:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('90_mm_manual_boring'), 2) }} m</span>
                            </div>
                        @endif
                        @if($peTracker->getMeasurement('125_mm_manual_boring'))
                            <div class="measurement-item">
                                <span class="measurement-label">125 MM Manual Boring:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('125_mm_manual_boring'), 2) }} m</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="measurement-category">
                    <h4>Other Work</h4>
                    <div class="measurement-list">
                        @if($peTracker->getMeasurement('breaking_hard_rock_completion'))
                            <div class="measurement-item">
                                <span class="measurement-label">Breaking Hard Rock:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('breaking_hard_rock_completion'), 2) }} m</span>
                            </div>
                        @endif
                        @if($peTracker->getMeasurement('excavation_beyond_2m_depth'))
                            <div class="measurement-item">
                                <span class="measurement-label">Excavation Beyond 2M:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('excavation_beyond_2m_depth'), 2) }} m</span>
                            </div>
                        @endif
                        @if($peTracker->getMeasurement('rcc_cutting_breaking_150'))
                            <div class="measurement-item">
                                <span class="measurement-label">RCC Cutting/Breaking:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('rcc_cutting_breaking_150'), 2) }} m</span>
                            </div>
                        @endif
                        @if($peTracker->getMeasurement('pcc_cutting_breaking_150'))
                            <div class="measurement-item">
                                <span class="measurement-label">PCC Cutting/Breaking:</span>
                                <span class="measurement-value">{{ number_format($peTracker->getMeasurement('pcc_cutting_breaking_150'), 2) }} m</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Installation Data Section -->
        @if($peTracker->installation_data && count($peTracker->installation_data) > 0)
        <div class="info-section">
            <h3>Installation Data</h3>
            <div class="installation-grid">
                @foreach($peTracker->installation_data as $key => $value)
                    @if($value)
                        <div class="installation-item">
                            <span class="installation-label">{{ ucwords(str_replace('_', ' ', $key)) }}:</span>
                            <span class="installation-value">
                                @if(is_numeric($value))
                                    {{ number_format($value, 2) }}
                                @else
                                    {{ $value }}
                                @endif
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Pipe Fittings Section -->
        @if($peTracker->pipe_fittings && count($peTracker->pipe_fittings) > 0)
        <div class="info-section">
            <h3>Pipe Fittings</h3>
            <div class="pipe-fittings-grid">
                @foreach($peTracker->pipe_fittings as $key => $value)
                    @if($value)
                        <div class="pipe-fitting-item">
                            <span class="pipe-fitting-label">{{ ucwords(str_replace('_', ' ', $key)) }}:</span>
                            <span class="pipe-fitting-value">
                                @if(is_numeric($value))
                                    {{ number_format($value, 2) }}
                                @else
                                    {{ $value }}
                                @endif
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Testing Data Section -->
        @if($peTracker->testing_data && count($peTracker->testing_data) > 0)
        <div class="info-section">
            <h3>Testing & Commissioning Data</h3>
            <div class="testing-grid">
                @foreach($peTracker->testing_data as $key => $value)
                    @if($value)
                        <div class="testing-item">
                            <span class="testing-label">{{ ucwords(str_replace('_', ' ', $key)) }}:</span>
                            <span class="testing-value">{{ $value }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Metadata Section -->
        <div class="info-section">
            <h3>Record Information</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Created:</label>
                    <span>{{ $peTracker->created_at->format('d-m-Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <label>Last Updated:</label>
                    <span>{{ $peTracker->updated_at->format('d-m-Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <label>Status:</label>
                    <span class="badge badge-success">{{ ucfirst($peTracker->project_status) }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('pe-tracker.edit', $peTracker) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Record
            </a>
            <a href="{{ route('pe-tracker.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <form action="{{ route('pe-tracker.destroy', $peTracker) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Are you sure you want to delete this record?')">
                    <i class="fas fa-trash"></i> Delete Record
                </button>
            </form>
        </div>
    </div>
</div>
@endsection