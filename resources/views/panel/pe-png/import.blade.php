<!-- resources/views/pe-png/import.blade.php -->
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

    <h1 class="page-title">Import PE/PNG Data</h1>

    <div class="form-card">
        <div class="form-header">
            Upload Excel File
        </div>
        <div class="form-body">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pe-png.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group-full">
                        <label class="form-label">Excel File</label>
                        <input type="file" name="excel_file" class="form-control-file" required>
                        <div class="form-file-info">Accepted formats: XLSX, XLS</div>
                    </div>
                </div>

                <div style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                    <h6 style="font-weight: bold;">Excel File Format Guidelines:</h6>
                    <p>Your Excel file should have the following columns:</p>
                    <ul style="padding-left: 20px;">
                        <li><strong>job_order_number</strong> - Unique identifier for the job (required)</li>
                        <li><strong>category</strong> - Job category: domestic, commercial, riser, gc, or conversion (required)</li>
                        <li><strong>plumbing_date</strong> - Date when plumbing work was done (required)</li>
                        <li><strong>plumber_name</strong> - Name of the plumber who performed the work</li>
                        <li><strong>gc_date</strong> - GC date</li>
                        <li><strong>mmt_date</strong> - MMT date</li>
                        <li><strong>remarks</strong> - Any remarks about the job</li>
                        <li><strong>bill_ra_no</strong> - Bill RA Number</li>
                        <li><strong>plb_bill_status</strong> - Bill status: pending, processed, paid, or locked</li>
                        <li><strong>sla_days</strong> - SLA days</li>
                        <li><strong>pe_dpr</strong> - PE DPR information</li>
                    </ul>
                    <p style="margin-bottom: 0;">Note: The first row should contain column headers exactly as listed above.</p>
                </div>

                <a href="{{ asset('templates/pe_png_import_template.xlsx') }}" class="btn btn-success" style="margin-bottom: 20px;">
                    <i class="fas fa-download"></i> Download Template
                </a>

                <div class="form-actions">
                    <a href="{{ route('pe-png.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection