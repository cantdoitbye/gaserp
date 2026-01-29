{{-- resources/views/panel/consumption/index.blade.php --}}
@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
.consumption-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 20px;
    background: white;
    transition: all 0.3s ease;
}
.consumption-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.consumption-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 20px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 8px 8px 0 0;
}
.material-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    padding: 20px;
}
.material-item {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    transition: all 0.3s ease;
}
.material-item:hover {
    background: #e3f2fd;
    border-color: #1976d2;
}
.material-name {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
    font-size: 16px;
}
.material-details {
    color: #6c757d;
    font-size: 14px;
    line-height: 1.5;
}
.quantity-badge {
    background: #e8f5e8;
    color: #2e7d32;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
    margin-top: 8px;
}
.status-issued {
    background: #fff3cd;
    color: #856404;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}
.status-returned {
    background: #d1ecf1;
    color: #0c5460;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}
.project-filter {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}
.filter-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    align-items: end;
}
</style>
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search materials, projects...">
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">
        <i class="fas fa-boxes"></i> Consumption & Free Issue Management
    </h1>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="#" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Material Issue
        </a>
        <a href="#" class="btn btn-success">
            <i class="fas fa-undo"></i> Return Materials
        </a>
        <a href="#" class="btn btn-info">
            <i class="fas fa-chart-bar"></i> Stock Report
        </a>
        <a href="#" class="btn btn-warning">
            <i class="fas fa-download"></i> Export Data
        </a>
    </div>

    <!-- Filter Section -->
    <div class="project-filter">
        <h3 style="margin-bottom: 15px; color: #495057;">
            <i class="fas fa-filter"></i> Filter Materials
        </h3>
        <div class="filter-row">
            <div class="form-group">
                <label>Project Type</label>
                <select class="form-control">
                    <option value="">All Projects</option>
                    <option value="domestic">Domestic</option>
                    <option value="commercial">Commercial</option>
                    <option value="riser">Riser</option>
                    <option value="gc">GC</option>
                    <option value="conversion">Conversion</option>
                </select>
            </div>
            <div class="form-group">
                <label>Plumber</label>
                <select class="form-control">
                    <option value="">All Plumbers</option>
                    <option value="plumber1">Rajesh Kumar</option>
                    <option value="plumber2">Suresh Sharma</option>
                    <option value="plumber3">Amit Singh</option>
                </select>
            </div>
            <div class="form-group">
                <label>Date Range</label>
                <input type="date" class="form-control">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control">
                    <option value="">All Status</option>
                    <option value="issued">Issued</option>
                    <option value="returned">Returned</option>
                    <option value="consumed">Consumed</option>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Consumption Cards -->
    <div class="consumption-card">
        <div class="consumption-header">
            <div>
                <h3 style="margin: 0;">Project: Domestic - Site A-123</h3>
                <small>Plumber: Rajesh Kumar | Date: 2025-01-15</small>
            </div>
            <div>
                <span class="status-issued">Materials Issued</span>
            </div>
        </div>
        <div class="material-grid">
            <div class="material-item">
                <div class="material-name">
                    <i class="fas fa-pipe"></i> PE Pipe 32mm
                </div>
                <div class="material-details">
                    Issued: 50 meters<br>
                    Consumed: 45 meters<br>
                    Returned: 5 meters
                </div>
                <span class="quantity-badge">Stock Adjusted</span>
            </div>
            <div class="material-item">
                <div class="material-name">
                    <i class="fas fa-cog"></i> Gas Tap
                </div>
                <div class="material-details">
                    Issued: 2 pieces<br>
                    Consumed: 1 piece<br>
                    Returned: 1 piece
                </div>
                <span class="quantity-badge">Partial Return</span>
            </div>
            <div class="material-item">
                <div class="material-name">
                    <i class="fas fa-wrench"></i> Valve Half Inch
                </div>
                <div class="material-details">
                    Issued: 3 pieces<br>
                    Consumed: 3 pieces<br>
                    Returned: 0 pieces
                </div>
                <span class="quantity-badge">Fully Consumed</span>
            </div>
            <div class="material-item">
                <div class="material-name">
                    <i class="fas fa-link"></i> GI Coupling
                </div>
                <div class="material-details">
                    Issued: 4 pieces<br>
                    Consumed: 2 pieces<br>
                    Returned: 2 pieces
                </div>
                <span class="quantity-badge">Stock Adjusted</span>
            </div>
        </div>
    </div>

    <div class="consumption-card">
        <div class="consumption-header">
            <div>
                <h3 style="margin: 0;">Project: Commercial - Office Complex B-456</h3>
                <small>Plumber: Suresh Sharma | Date: 2025-01-14</small>
            </div>
            <div>
                <span class="status-returned">Materials Returned</span>
            </div>
        </div>
        <div class="material-grid">
            <div class="material-item">
                <div class="material-name">
                    <i class="fas fa-pipe"></i> PE Pipe 63mm
                </div>
                <div class="material-details">
                    Issued: 100 meters<br>
                    Consumed: 95 meters<br>
                    Returned: 5 meters
                </div>
                <span class="quantity-badge">Stock Adjusted</span>
            </div>
            <div class="material-item">
                <div class="material-name">
                    <i class="fas fa-fire"></i> High Press Regulator
                </div>
                <div class="material-details">
                    Issued: 5 pieces<br>
                    Consumed: 4 pieces<br>
                    Returned: 1 piece
                </div>
                <span class="quantity-badge">Partial Return</span>
            </div>
            <div class="material-item">
                <div class="material-name">
                    <i class="fas fa-grip-lines"></i> Anaconda Pipe
                </div>
                <div class="material-details">
                    Issued: 20 meters<br>
                    Consumed: 18 meters<br>
                    Returned: 2 meters
                </div>
                <span class="quantity-badge">Stock Adjusted</span>
            </div>
        </div>
    </div>

    <div class="consumption-card">
        <div class="consumption-header">
            <div>
                <h3 style="margin: 0;">Project: Riser - Apartment C-789</h3>
                <small>Plumber: Amit Singh | Date: 2025-01-13</small>
            </div>
            <div>
                <span class="status-issued">Materials Issued</span>
            </div>
        </div>
        <div class="material-grid">
            <div class="material-item">
                <div class="material-name">
                    <i class="fas fa-pipe"></i> PE Pipe 90mm
                </div>
                <div class="material-details">
                    Issued: 75 meters<br>
                    Consumed: 70 meters<br>
                    Returned: 5 meters
                </div>
                <span class="quantity-badge">Stock Adjusted</span>
            </div>
            <div class="material-item">
                <div class="material-name">
                    <i class="fas fa-shield-alt"></i> RCC Guard 20mm
                </div>
                <div class="material-details">
                    Issued: 10 pieces<br>
                    Consumed: 8 pieces<br>
                    Returned: 2 pieces
                </div>
                <span class="quantity-badge">Partial Return</span>
            </div>
            <div class="material-item">
                <div class="material-name">
                    <i class="fas fa-puzzle-piece"></i> GF Coupler 20mm
                </div>
                <div class="material-details">
                    Issued: 6 pieces<br>
                    Consumed: 6 pieces<br>
                    Returned: 0 pieces
                </div>
                <span class="quantity-badge">Fully Consumed</span>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 
20px; margin-top: 30px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; 
padding: 20px; border-radius: 8px; text-align: center;">
            <h3 style="margin: 0; font-size: 24px;">₹2,45,000</h3>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Material Value Issued</p>
        </div>
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; 
padding: 20px; border-radius: 8px; text-align: center;">
            <h3 style="margin: 0; font-size: 24px;">₹35,000</h3>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Material Value Returned</p>
        </div>
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; 
padding: 20px; border-radius: 8px; text-align: center;">
            <h3 style="margin: 0; font-size: 24px;">₹2,10,000</h3>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Net Material Consumed</p>
        </div>
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; 
padding: 20px; border-radius: 8px; text-align: center;">
            <h3 style="margin: 0; font-size: 24px;">45</h3>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Active Projects</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any JavaScript functionality here
    console.log('Consumption & Free Issue module loaded');
});
</script>
@endsection
