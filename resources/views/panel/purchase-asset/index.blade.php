{{-- resources/views/panel/purchase-asset/index.blade.php --}}
@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
.module-tabs {
    display: flex;
    background: white;
    border-radius: 8px;
    margin-bottom: 20px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.module-tab {
    flex: 1;
    padding: 15px 20px;
    text-align: center;
    cursor: pointer;
    border: none;
    background: #f8f9fa;
    color: #6c757d;
    font-weight: 500;
    transition: all 0.3s ease;
    border-right: 1px solid #dee2e6;
}
.module-tab:last-child {
    border-right: none;
}
.module-tab.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.module-tab:hover:not(.active) {
    background: #e9ecef;
    color: #495057;
}
.tab-content {
    display: none;
}
.tab-content.active {
    display: block;
}
.purchase-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 20px;
    background: white;
    transition: all 0.3s ease;
}
.purchase-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.purchase-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.asset-header {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.cgd-header {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.item-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}
.item-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    transition: all 0.3s ease;
}
.item-card:hover {
    background: #e3f2fd;
    border-color: #1976d2;
    transform: translateY(-2px);
}
.item-title {
    font-weight: 600;
    color: #495057;
    margin-bottom: 10px;
    font-size: 16px;
    display: flex;
    align-items: center;
}
.item-title i {
    margin-right: 8px;
    color: #007bff;
}
.item-details {
    color: #6c757d;
    font-size: 14px;
    line-height: 1.6;
}
.status-pending {
    background: #fff3cd;
    color: #856404;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}
.status-completed {
    background: #d4edda;
    color: #155724;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}
.status-overdue {
    background: #f8d7da;
    color: #721c24;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}
.quick-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}
.stat-card {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
}
.stat-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.stat-number {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 5px;
}
.stat-label {
    color: #6c757d;
    font-size: 14px;
}
</style>
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search PO, vendors, assets...">
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">
        <i class="fas fa-shopping-cart"></i> Purchase, CGD & Asset Management
    </h1>

    <!-- Module Tabs -->
    <div class="module-tabs">
        <button class="module-tab active" onclick="switchTab(event, 'purchase')">
            <i class="fas fa-shopping-cart"></i><br>Purchase Orders
        </button>
        <button class="module-tab" onclick="switchTab(event, 'cgd')">
            <i class="fas fa-gift"></i><br>CGD Free Issue
        </button>
        <button class="module-tab" onclick="switchTab(event, 'assets')">
            <i class="fas fa-boxes"></i><br>Asset Tracking
        </button>
        <button class="module-tab" onclick="switchTab(event, 'vendors')">
            <i class="fas fa-handshake"></i><br>Vendor Management
        </button>
    </div>

    <!-- Purchase Orders Tab -->
    <div id="purchase" class="tab-content active">
        <div class="action-buttons">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Purchase Order
            </a>
            <a href="#" class="btn btn-success">
                <i class="fas fa-check"></i> Approve Pending
            </a>
            <a href="#" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> Purchase Report
            </a>
            <a href="#" class="btn btn-warning">
                <i class="fas fa-download"></i> Export Data
            </a>
        </div>

        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-number" style="color: #007bff;">₹15,75,000</div>
                <div class="stat-label">Total PO Value (This Month)</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #28a745;">25</div>
                <div class="stat-label">Active Purchase Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #ffc107;">8</div>
                <div class="stat-label">Pending Approvals</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #dc3545;">3</div>
                <div class="stat-label">Overdue Deliveries</div>
            </div>
        </div>

        <div class="purchase-card">
            <div class="purchase-header">
                <div>
                    <h3 style="margin: 0;">PO-2025-001</h3>
                    <small>Vendor: ABC Materials Pvt Ltd | Amount: ₹2,50,000</small>
                </div>
                <div>
                    <span class="status-pending">Pending Delivery</span>
                </div>
            </div>
            <div class="item-grid">
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-pipe"></i> PE Pipes Various Sizes
                    </div>
                    <div class="item-details">
                        Quantity: 500 meters<br>
                        Unit Price: ₹85/meter<br>
                        Total: ₹42,500<br>
                        Delivery: 2025-01-20
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-cog"></i> Gas Regulators
                    </div>
                    <div class="item-details">
                        Quantity: 50 pieces<br>
                        Unit Price: ₹1,200/piece<br>
                        Total: ₹60,000<br>
                        Delivery: 2025-01-18
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-wrench"></i> Valves & Fittings
                    </div>
                    <div class="item-details">
                        Quantity: 200 pieces<br>
                        Unit Price: ₹150/piece<br>
                        Total: ₹30,000<br>
                        Delivery: 2025-01-25
                    </div>
                </div>
            </div>
        </div>

        <div class="purchase-card">
            <div class="purchase-header">
                <div>
                    <h3 style="margin: 0;">PO-2025-002</h3>
                    <small>Vendor: XYZ Equipment Co | Amount: ₹1,85,000</small>
                </div>
                <div>
                    <span class="status-overdue">Overdue</span>
                </div>
            </div>
            <div class="item-grid">
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-hammer"></i> Installation Tools
                    </div>
                    <div class="item-details">
                        Quantity: 25 sets<br>
                        Unit Price: ₹3,500/set<br>
                        Total: ₹87,500<br>
                        Expected: 2025-01-15 (Overdue)
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-hard-hat"></i> Safety Equipment
                    </div>
                    <div class="item-details">
                        Quantity: 100 pieces<br>
                        Unit Price: ₹450/piece<br>
                        Total: ₹45,000<br>
                        Expected: 2025-01-12 (Overdue)
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CGD Free Issue Tab -->
    <div id="cgd" class="tab-content">
        <div class="action-buttons">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i> Record CGD Issue
            </a>
            <a href="#" class="btn btn-success">
                <i class="fas fa-sync"></i> Sync with CGD
            </a>
            <a href="#" class="btn btn-info">
                <i class="fas fa-chart-line"></i> CGD Report
            </a>
        </div>

        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-number" style="color: #28a745;">₹8,50,000</div>
                <div class="stat-label">CGD Free Issue Value</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #007bff;">152</div>
                <div class="stat-label">Items Received</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #ffc107;">12</div>
                <div class="stat-label">Pending Allocation</div>
            </div>
        </div>

        <div class="purchase-card">
            <div class="cgd-header">
                <div>
                    <h3 style="margin: 0;">CGD Batch: CG-2025-JAN-01</h3>
                    <small>Received Date: 2025-01-10 | Total Value: ₹3,25,000</small>
                </div>
                <div>
                    <span class="status-completed">Allocated</span>
                </div>
            </div>
            <div class="item-grid">
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-fire"></i> Gas Meters
                    </div>
                    <div class="item-details">
                        Quantity: 25 units<br>
                        Unit Value: ₹8,500/unit<br>
                        Total: ₹2,12,500<br>
                        Status: Allocated to Sites
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-shield-alt"></i> Safety Valves
                    </div>
                    <div class="item-details">
                        Quantity: 50 pieces<br>
                        Unit Value: ₹1,250/piece<br>
                        Total: ₹62,500<br>
                        Status: In Stock
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-thermometer-half"></i> Pressure Regulators
                    </div>
                    <div class="item-details">
                        Quantity: 20 pieces<br>
                        Unit Value: ₹2,500/piece<br>
                        Total: ₹50,000<br>
                        Status: Allocated to Projects
                    </div>
                </div>
            </div>
        </div>

        <div class="purchase-card">
            <div class="cgd-header">
                <div>
                    <h3 style="margin: 0;">CGD Batch: CG-2025-JAN-02</h3>
                    <small>Received Date: 2025-01-15 | Total Value: ₹5,25,000</small>
                </div>
                <div>
                    <span class="status-pending">Pending Allocation</span>
                </div>
            </div>
            <div class="item-grid">
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-tools"></i> Installation Kits
                    </div>
                    <div class="item-details">
                        Quantity: 100 kits<br>
                        Unit Value: ₹3,500/kit<br>
                        Total: ₹3,50,000<br>
                        Status: Awaiting Distribution
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-link"></i> Connection Materials
                    </div>
                    <div class="item-details">
                        Quantity: 500 sets<br>
                        Unit Value: ₹350/set<br>
                        Total: ₹1,75,000<br>
                        Status: Quality Check Pending
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Asset Tracking Tab -->
    <div id="assets" class="tab-content">
        <div class="action-buttons">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Asset
            </a>
            <a href="#" class="btn btn-success">
                <i class="fas fa-exchange-alt"></i> Transfer Asset
            </a>
            <a href="#" class="btn btn-info">
                <i class="fas fa-wrench"></i> Maintenance Log
            </a>
            <a href="#" class="btn btn-warning">
                <i class="fas fa-chart-pie"></i> Depreciation Report
            </a>
        </div>

        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-number" style="color: #007bff;">₹45,75,000</div>
                <div class="stat-label">Total Asset Value</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #28a745;">342</div>
                <div class="stat-label">Active Assets</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #ffc107;">18</div>
                <div class="stat-label">Due for Maintenance</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #dc3545;">5</div>
                <div class="stat-label">Faulty/Retired</div>
            </div>
        </div>

        <div class="purchase-card">
            <div class="asset-header">
                <div>
                    <h3 style="margin: 0;">PLB Tools & Equipment</h3>
                    <small>Location: Main Warehouse | Total Value: ₹12,50,000</small>
                </div>
                <div>
                    <span class="status-completed">Active</span>
                </div>
            </div>
            <div class="item-grid">
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-drill"></i> Boring Machine - BM001
                    </div>
                    <div class="item-details">
                        Purchase Date: 2023-05-15<br>
                        Current Value: ₹3,50,000<br>
                        Last Service: 2024-12-20<br>
                        Next Service: 2025-03-20
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-hammer"></i> Welding Equipment - WE005
                    </div>
                    <div class="item-details">
                        Purchase Date: 2024-02-10<br>
                        Current Value: ₹1,25,000<br>
                        Last Service: 2024-11-15<br>
                        Status: Operational
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-truck"></i> Service Vehicle - SV003
                    </div>
                    <div class="item-details">
                        Purchase Date: 2022-08-30<br>
                        Current Value: ₹8,50,000<br>
                        Last Service: 2025-01-05<br>
                        Location: Site A-123
                    </div>
                </div>
            </div>
        </div>

        <div class="purchase-card">
            <div class="asset-header">
                <div>
                    <h3 style="margin: 0;">Labour Tools & Machinery</h3>
                    <small>Location: Various Sites | Total Value: ₹8,75,000</small>
                </div>
                <div>
                    <span class="status-pending">Maintenance Due</span>
                </div>
            </div>
            <div class="item-grid">
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-cogs"></i> JCB Machine - JCB002
                    </div>
                    <div class="item-details">
                        Purchase Date: 2023-01-20<br>
                        Current Value: ₹15,50,000<br>
                        Last Service: 2024-10-15<br>
                        Status: Maintenance Required
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-toolbox"></i> Tool Kit Set - TK025
                    </div>
                    <div class="item-details">
                        Purchase Date: 2024-06-12<br>
                        Current Value: ₹45,000<br>
                        Assigned to: Rajesh Kumar<br>
                        Status: In Field Use
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-cut"></i> Cutting Equipment - CE008
                    </div>
                    <div class="item-details">
                        Purchase Date: 2023-11-05<br>
                        Current Value: ₹85,000<br>
                        Location: Site B-456<br>
                        Status: Operational
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor Management Tab -->
    <div id="vendors" class="tab-content">
        <div class="action-buttons">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Vendor
            </a>
            <a href="#" class="btn btn-success">
                <i class="fas fa-star"></i> Rate Vendor
            </a>
            <a href="#" class="btn btn-info">
                <i class="fas fa-file-invoice"></i> Payment Status
            </a>
            <a href="#" class="btn btn-warning">
                <i class="fas fa-exclamation-triangle"></i> Debit Notes
            </a>
        </div>

        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-number" style="color: #007bff;">45</div>
                <div class="stat-label">Active Vendors</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #28a745;">₹25,75,000</div>
                <div class="stat-label">Payments This Month</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #ffc107;">8</div>
                <div class="stat-label">Pending Payments</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #dc3545;">3</div>
                <div class="stat-label">Debit Notes</div>
            </div>
        </div>

        <div class="purchase-card">
            <div class="purchase-header">
                <div>
                    <h3 style="margin: 0;">ABC Materials Pvt Ltd</h3>
                    <small>Contact: +91-98765-43210 | Rating: ⭐⭐⭐⭐⭐</small>
                </div>
                <div>
                    <span class="status-completed">Verified Vendor</span>
                </div>
            </div>
            <div class="item-grid">
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-chart-line"></i> Performance Stats
                    </div>
                    <div class="item-details">
                        Total Orders: 25<br>
                        On-time Delivery: 96%<br>
                        Quality Rating: 4.8/5<br>
                        Payment Terms: 30 days
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-money-bill"></i> Financial Summary
                    </div>
                    <div class="item-details">
                        Total Business: ₹8,50,000<br>
                        Pending Amount: ₹1,25,000<br>
                        Last Payment: 2025-01-10<br>
                        Credit Limit: ₹5,00,000
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-clipboard-list"></i> Recent Orders
                    </div>
                    <div class="item-details">
                        PO-2025-001: ₹2,50,000<br>
                        PO-2024-085: ₹1,85,000<br>
                        PO-2024-078: ₹3,25,000<br>
                        Status: All Delivered
                    </div>
                </div>
            </div>
        </div>

        <div class="purchase-card">
            <div class="purchase-header">
                <div>
                    <h3 style="margin: 0;">XYZ Equipment Co</h3>
                    <small>Contact: +91-87654-32109 | Rating: ⭐⭐⭐⭐</small>
                </div>
                <div>
                    <span class="status-overdue">Payment Overdue</span>
                </div>
            </div>
            <div class="item-grid">
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-chart-line"></i> Performance Stats
                    </div>
                    <div class="item-details">
                        Total Orders: 18<br>
                        On-time Delivery: 78%<br>
                        Quality Rating: 4.2/5<br>
                        Payment Terms: 45 days
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-exclamation-triangle"></i> Issues & Penalties
                    </div>
                    <div class="item-details">
                        Late Deliveries: 4<br>
                        Quality Issues: 2<br>
                        Penalty Amount: ₹15,000<br>
                        Debit Note: DN-2025-003
                    </div>
                </div>
                <div class="item-card">
                    <div class="item-title">
                        <i class="fas fa-money-bill"></i> Payment Status
                    </div>
                    <div class="item-details">
                        Total Outstanding: ₹2,85,000<br>
                        Overdue Amount: ₹1,15,000<br>
                        Days Overdue: 15 days<br>
                        Action Required: Follow-up
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function switchTab(event, tabName) {
    // Hide all tab contents
    var tabContents = document.getElementsByClassName('tab-content');
    for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.remove('active');
    }
    
    // Remove active class from all tabs
    var tabs = document.getElementsByClassName('module-tab');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove('active');
    }
    
    // Show selected tab content and mark tab as active
    document.getElementById(tabName).classList.add('active');
    event.currentTarget.classList.add('active');
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Purchase, CGD & Asset Management module loaded');
});
</script>
@endsection
