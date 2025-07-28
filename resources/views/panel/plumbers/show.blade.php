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

    <h1 class="page-title">Plumber Details</h1>

    <div class="content-card">
        <div class="action-buttons">
            <a href="{{ route('plumbers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Plumbers
            </a>
            <a href="{{ route('plumbers.edit', $plumber) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('plumbers.destroy', $plumber) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Are you sure you want to delete this plumber?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>

        <div style="margin-top: 20px;">
            <div class="row" style="display: flex; flex-wrap: wrap; margin: 0 -10px;">
                <div class="col" style="flex: 0 0 50%; padding: 0 10px;">
                    <div style="background-color: #f8f9fa; border-radius: 5px; padding: 15px; margin-bottom: 20px;">
                        <h5 style="font-weight: bold; margin-bottom: 15px;">Plumber Information</h5>
                        <table style="width: 100%;">
                             <tr>
                                <td style="padding: 8px 0; font-weight: bold; width: 40%;">Plumber Id:</td>
                                <td style="padding: 8px 0;">{{ $plumber->plumber_id }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; font-weight: bold; width: 40%;">Name:</td>
                                <td style="padding: 8px 0;">{{ $plumber->name }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; font-weight: bold;">Status:</td>
                                <td style="padding: 8px 0;">
                                    <span class="badge {{ $plumber->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($plumber->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; font-weight: bold;">Contact Number:</td>
                                <td style="padding: 8px 0;">{{ $plumber->contact_number ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; font-weight: bold;">Email:</td>
                                <td style="padding: 8px 0;">{{ $plumber->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; font-weight: bold;">Address:</td>
                                <td style="padding: 8px 0;">{{ $plumber->address ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; font-weight: bold;">Created At:</td>
                                <td style="padding: 8px 0;">{{ $plumber->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; font-weight: bold;">Updated At:</td>
                                <td style="padding: 8px 0;">{{ $plumber->updated_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col" style="flex: 0 0 50%; padding: 0 10px;">
                    <div style="background-color: #f8f9fa; border-radius: 5px; padding: 15px; margin-bottom: 20px;">
                        <h5 style="font-weight: bold; margin-bottom: 15px;">Job Statistics</h5>
                        <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                            <div style="flex: 1; background-color: #e31e24; color: white; padding: 15px; border-radius: 5px; text-align: center;">
                                <div style="font-size: 24px; font-weight: bold;">{{ $plumber->pePngs()->count() }}</div>
                                <div>Total Jobs</div>
                            </div>
                            <div style="flex: 1; background-color: #28a745; color: white; padding: 15px; border-radius: 5px; text-align: center;">
                                <div style="font-size: 24px; font-weight: bold;">{{ $plumber->pePngs()->where('plb_bill_status', 'paid')->count() }}</div>
                                <div>Paid Jobs</div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px;">
                            <div style="flex: 1; background-color: #ffc107; color: #212529; padding: 15px; border-radius: 5px; text-align: center;">
                                <div style="font-size: 24px; font-weight: bold;">{{ $plumber->pePngs()->where('plb_bill_status', 'pending')->count() }}</div>
                                <div>Pending Jobs</div>
                            </div>
                            <div style="flex: 1; background-color: #17a2b8; color: white; padding: 15px; border-radius: 5px; text-align: center;">
                                <div style="font-size: 24px; font-weight: bold;">{{ $plumber->pePngs()->where('plb_bill_status', 'processed')->count() }}</div>
                                <div>Processed Jobs</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 10px;">
            <h5 style="font-weight: bold; margin-bottom: 15px;">Recent Jobs</h5>
            
            @if(count($plumber->pePngs) > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Job Order #</th>
                            <th>Category</th>
                            <th>Plumbing Date</th>
                            <th>Bill Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plumber->pePngs as $pePng)
                            <tr>
                                <td>{{ $pePng->job_order_number }}</td>
                                <td>{{ ucfirst($pePng->category) }}</td>
                                <td>{{ $pePng->plumbing_date->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($pePng->plb_bill_status == 'pending') badge-warning
                                        @elseif($pePng->plb_bill_status == 'processed') badge-primary
                                        @elseif($pePng->plb_bill_status == 'paid') badge-success
                                        @elseif($pePng->plb_bill_status == 'locked') badge-danger
                                        @endif">
                                        {{ ucfirst($pePng->plb_bill_status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-icons">
                                        <a href="{{ route('pe-png.show', $pePng) }}" class="action-icon icon-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div style="margin-top: 15px; text-align: center;">
                    <a href="{{ route('pe-png.index', ['plumber_id' => $plumber->id]) }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> View All Jobs
                    </a>
                </div>
            @else
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; text-align: center;">
                    No jobs found for this plumber.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection