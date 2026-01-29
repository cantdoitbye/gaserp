{{-- resources/views/panel/sales-financial/index.blade.php --}}
@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('panel/pe-tracker.css') }}">
<style>
.financial-tabs {
    display: flex;
    background: white;
    border-radius: 8px;
    margin-bottom: 20px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.financial-tab {
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
.financial-tab:last-child {
    border-right: none;
}
.financial-tab.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.financial-tab:hover:not(.active) {
    background: #e9ecef;
    color: #495057;
}
.tab-content {
    display: none;
}
.tab-content.active {
    display: block;
}
.sales-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 20px;
    background: white;
    transition: all 0.3s ease;
}
.sales-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.sales-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.payment-header {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tax-header {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.financial-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}
.financial-item {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    transition: all 0.3s ease;
}
.financial-item:hover {
    background: #e3f2fd;
    border-color: #1976d2;
    transform: translateY(-2px);
}
.financial-title {
    font-weight: 600;
    color: #495057;
    margin-bottom: 10px;
    font-size: 16px;
    display: flex;
    align-items: center;
}
.financial-title i {
    margin-right: 8px;
    color: #007bff;
}
.financial-details {
    color: #6c757d;
    font-size: 14px;
    line-height: 1.6;
}
.amount-large {
    font-size: 20px;
    font-weight: 700;
    color: #28a745;
    margin-bottom: 5px;
}
.amount-medium {
    font-size: 16px;
    font-weight: 600;
    color: #007bff;
    margin-bottom: 5px;
}
.status-paid {
    background: #d4edda;
    color: #155724;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}
.status-pending {
    background: #fff3cd;
    color: #856404;
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
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
.percentage-up {
    color: #28a745;
    font-size: 12px;
    font-weight: 600;
}
.percentage-down {
    color: #dc3545;
    font-size: 12px;
    font-weight: 600;
}
.financial-dashboard {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}
.dashboard-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #495057;
    display: flex;
    align-items: center;
}
.dashboard-title i {
    margin-right: 10px;
    color: #007bff;
}
.chart-placeholder {
    height: 300px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 18px;
    border: 2px dashed #dee2e6;
}
</style>
@endsection

@section('content')
<div class="main-container">
    <div class="top-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search PO, customers, invoices...">
        </div>
        <div class="header-icons">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-question-circle"></i></button>
            <div class="user-avatar">{{ auth()->user()->initials ?? 'U' }}</div>
        </div>
    </div>

    <h1 class="page-title">
        <i class="fas fa-chart-line"></i> Sales & Financial Tracking
    </h1>

    <!-- Financial Dashboard -->
    <div class="financial-dashboard">
        <div class="dashboard-title">
            <i class="fas fa-tachometer-alt"></i> Real-time Financial Insights
        </div>
        <div class="chart-placeholder">
            <i class="fas fa-chart-area" style="font-size: 48px; color: #dee2e6; margin-right: 
15px;"></i>
            Revenue & Profitability Chart (Interactive Dashboard)
        </div>
    </div>

    <!-- Module Tabs -->
    <div class="financial-tabs">
        <button class="financial-tab active" onclick="switchFinancialTab(event, 'sales')">
            <i class="fas fa-handshake"></i><br>Sales Records
        </button>
        <button class="financial-tab" onclick="switchFinancialTab(event, 'payments')">
            <i class="fas fa-credit-card"></i><br>Payments & TDS
        </button>
        <button class="financial-tab" onclick="switchFinancialTab(event, 'taxes')">
            <i class="fas fa-calculator"></i><br>Tax Management
        </button>
        <button class="financial-tab" onclick="switchFinancialTab(event, 'retention')">
            <i class="fas fa-shield-alt"></i><br>Retention & NOC
        </button>
        <button class="financial-tab" onclick="switchFinancialTab(event, 'dashboard')">
            <i class="fas fa-chart-pie"></i><br>Dashboard
        </button>
    </div>

    <!-- Sales Records Tab -->
    <div id="sales" class="tab-content active">
        <div class="action-buttons">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Sales Entry
            </a>
            <a href="#" class="btn btn-success">
                <i class="fas fa-file-invoice"></i> Generate Invoice
            </a>
            <a href="#" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> Sales Report
            </a>
            <a href="#" class="btn btn-warning">
                <i class="fas fa-download"></i> Export Data
            </a>
        </div>

        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-number" style="color: #28a745;">₹45,75,000</div>
                <div class="stat-label">Total Sales (This Month)</div>
                <div class="percentage-up">↗ +12.5% from last month</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #007bff;">38</div>
                <div class="stat-label">Active Purchase Orders</div>
                <div class="percentage-up">↗ +8 new POs</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #ffc107;">₹8,50,000</div>
                <div class="stat-label">Pending Receivables</div>
                <div class="percentage-down">↗ -5.2% from last month</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #6f42c1;">85%</div>
                <div class="stat-label">Billing Completion</div>
                <div class="percentage-up">↗ +3% improvement</div>
            </div>
        </div>

        <div class="sales-card">
            <div class="sales-header">
                <div>
                    <h3 style="margin: 0;">PO-GAIL-2025-001</h3>
                    <small>Customer: GAIL India Ltd | Contract Value: ₹15,50,000</small>
                </div>
                <div>
                    <span class="status-pending">85% Billed</span>
                </div>
            </div>
            <div class="financial-grid">
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-file-contract"></i> Contract Details
                    </div>
                    <div class="financial-details">
                        Project: Gas Pipeline Extension<br>
                        Start Date: 2024-11-15<br>
                        Expected Completion: 2025-03-15<br>
                        Work Progress: 85%
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-money-bill-wave"></i> Billing Summary
                    </div>
                    <div class="financial-details">
                        <div class="amount-large">₹13,17,500</div>
                        Billed Amount (85%)<br>
                        Pending: ₹2,32,500<br>
                        Next Billing: 2025-02-15
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-percentage"></i> Revenue Projection
                    </div>
                    <div class="financial-details">
                        Projected Revenue: ₹15,50,000<br>
                        Estimated Profit: ₹3,75,000<br>
                        Margin: 24.2%<br>
                        ROI: 35.8%
                    </div>
                </div>
            </div>
        </div>

        <div class="sales-card">
            <div class="sales-header">
                <div>
                    <h3 style="margin: 0;">PO-IOC-2025-002</h3>
                    <small>Customer: Indian Oil Corporation | Contract Value: ₹8,75,000</small>
                </div>
                <div>
                    <span class="status-paid">100% Completed</span>
                </div>
            </div>
            <div class="financial-grid">
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-check-circle"></i> Project Completion
                    </div>
                    <div class="financial-details">
                        Project: Residential Gas Connection<br>
                        Completed: 2025-01-10<br>
                        Duration: 45 days<br>
                        Customer Rating: ⭐⭐⭐⭐⭐
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-receipt"></i> Final Billing
                    </div>
                    <div class="financial-details">
                        <div class="amount-large">₹8,75,000</div>
                        Total Billed (100%)<br>
                        Payment Received: ₹8,75,000<br>
                        Status: Fully Paid
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-chart-line"></i> Actual Performance
                    </div>
                    <div class="financial-details">
                        Actual Revenue: ₹8,75,000<br>
                        Actual Profit: ₹2,15,000<br>
                        Margin: 24.6%<br>
                        Performance: Exceeded Target
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments & TDS Tab -->
    <div id="payments" class="tab-content">
        <div class="action-buttons">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i> Record Payment
            </a>
            <a href="#" class="btn btn-success">
                <i class="fas fa-calculator"></i> Calculate TDS
            </a>
            <a href="#" class="btn btn-info">
                <i class="fas fa-file-alt"></i> Payment Advice
            </a>
            <a href="#" class="btn btn-warning">
                <i class="fas fa-download"></i> TDS Certificate
            </a>
        </div>

        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-number" style="color: #28a745;">₹35,25,000</div>
                <div class="stat-label">Payments Received</div>
                <div class="percentage-up">↗ This Month</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #007bff;">₹3,52,500</div>
                <div class="stat-label">TDS Deducted</div>
                <div class="percentage-up">10% of payments</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #ffc107;">₹12,75,000</div>
                <div class="stat-label">Payment Pending</div>
                <div class="percentage-down">From 8 customers</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #dc3545;">₹1,85,000</div>
                <div class="stat-label">Overdue Amount</div>
                <div class="percentage-down">Follow-up required</div>
            </div>
        </div>

        <div class="sales-card">
            <div class="payment-header">
                <div>
                    <h3 style="margin: 0;">Payment Received - GAIL India Ltd</h3>
                    <small>Invoice: INV-2025-001 | Amount: ₹8,75,000 | Date: 2025-01-15</small>
                </div>
                <div>
                    <span class="status-paid">Payment Received</span>
                </div>
            </div>
            <div class="financial-grid">
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-file-invoice-dollar"></i> Invoice Details
                    </div>
                    <div class="financial-details">
                        Invoice Number: INV-2025-001<br>
                        Invoice Date: 2025-01-01<br>
                        Due Date: 2025-01-31<br>
                        Payment Mode: NEFT
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-calculator"></i> TDS Calculation
                    </div>
                    <div class="financial-details">
                        <div class="amount-medium">₹87,500</div>
                        TDS @ 10%<br>
                        Net Amount: ₹7,87,500<br>
                        TDS Certificate: Generated
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-university"></i> Bank Details
                    </div>
                    <div class="financial-details">
                        UTR Number: UTR2025001234<br>
                        Bank: SBI Main Branch<br>
                        Account: ****5678<br>
                        Reference: GAIL-PO-001
                    </div>
                </div>
            </div>
        </div>

        <div class="sales-card">
            <div class="payment-header">
                <div>
                    <h3 style="margin: 0;">Pending Payment - IOC Ltd</h3>
                    <small>Invoice: INV-2025-002 | Amount: ₹5,25,000 | Due: 2025-01-25</small>
                </div>
                <div>
                    <span class="status-pending">Payment Pending</span>
                </div>
            </div>
            <div class="financial-grid">
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-clock"></i> Payment Status
                    </div>
                    <div class="financial-details">
                        Days Outstanding: 12 days<br>
                        Payment Terms: 30 days<br>
                        Reminder Sent: 2025-01-20<br>
                        Next Follow-up: 2025-01-22
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-exclamation-triangle"></i> Expected TDS
                    </div>
                    <div class="financial-details">
                        <div class="amount-medium">₹52,500</div>
                        Expected TDS @ 10%<br>
                        Net Receivable: ₹4,72,500<br>
                        Status: Awaiting Payment
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-phone"></i> Customer Contact
                    </div>
                    <div class="financial-details">
                        Contact Person: Mr. Sharma<br>
                        Phone: +91-98765-43210<br>
                        Email: accounts@ioc.in<br>
                        Last Contact: 2025-01-20
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tax Management Tab -->
    <div id="taxes" class="tab-content">
        <div class="action-buttons">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Tax Entry
            </a>
            <a href="#" class="btn btn-success">
                <i class="fas fa-file-upload"></i> File GST Return
            </a>
            <a href="#" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> Tax Report
            </a>
            <a href="#" class="btn btn-warning">
                <i class="fas fa-calculator"></i> Tax Calculator
            </a>
        </div>

        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-number" style="color: #28a745;">₹8,25,000</div>
                <div class="stat-label">GST Collected</div>
                <div class="percentage-up">18% on sales</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #007bff;">₹2,15,000</div>
                <div class="stat-label">GST Paid</div>
                <div class="percentage-up">Input tax credit</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #ffc107;">₹6,10,000</div>
                <div class="stat-label">Net GST Liability</div>
                <div class="percentage-down">Due: 20th Jan</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #6f42c1;">₹1,85,000</div>
                <div class="stat-label">BOCW Cess</div>
                <div class="percentage-up">1% on contract value</div>
            </div>
        </div>

        <div class="sales-card">
            <div class="tax-header">
                <div>
                    <h3 style="margin: 0;">GST Summary - January 2025</h3>
                    <small>GSTIN: 09ABCDE1234F1Z5 | Period: Jan 2025</small>
                </div>
                <div>
                    <span class="status-pending">Return Due</span>
                </div>
            </div>
            <div class="financial-grid">
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-arrow-up"></i> Output GST
                    </div>
                    <div class="financial-details">
                        <div class="amount-large">₹8,25,000</div>
                        GST on Sales @ 18%<br>
                        Taxable Value: ₹45,83,333<br>
                        No. of Invoices: 28
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-arrow-down"></i> Input GST
                    </div>
                    <div class="financial-details">
                        <div class="amount-medium">₹2,15,000</div>
                        GST on Purchases @ 18%<br>
                        Taxable Value: ₹11,94,444<br>
                        Credit Available: ₹2,15,000
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-balance-scale"></i> Net Liability
                    </div>
                    <div class="financial-details">
                        <div class="amount-large">₹6,10,000</div>
                        Net GST Payable<br>
                        Due Date: 2025-01-20<br>
                        Status: Pending Payment
                    </div>
                </div>
            </div>
        </div>

        <div class="sales-card">
            <div class="tax-header">
                <div>
                    <h3 style="margin: 0;">Other Tax Obligations</h3>
                    <small>BOCW Cess, Professional Tax & Other Statutory Payments</small>
                </div>
                <div>
                    <span class="status-paid">Compliance Updated</span>
                </div>
            </div>
            <div class="financial-grid">
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-hard-hat"></i> BOCW Cess
                    </div>
                    <div class="financial-details">
                        <div class="amount-medium">₹1,85,000</div>
                        @ 1% on contract value<br>
                        Contract Value: ₹1,85,00,000<br>
                        Status: Paid on 15th Jan
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-user-tie"></i> Professional Tax
                    </div>
                    <div class="financial-details">
                        Monthly PT: ₹2,500<br>
                        Annual PT: ₹30,000<br>
                        Last Paid: December 2024<br>
                        Next Due: January 2025
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-shield-alt"></i> Other Compliances
                    </div>
                    <div class="financial-details">
                        ESI Contribution: ₹15,750<br>
                        PF Contribution: ₹45,000<br>
                        Labour Cess: ₹8,500<br>
                        All Updated: ✅
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Retention & NOC Tab -->
    <div id="retention" class="tab-content">
        <div class="action-buttons">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Retention Entry
            </a>
            <a href="#" class="btn btn-success">
                <i class="fas fa-check"></i> Release Retention
            </a>
            <a href="#" class="btn btn-info">
                <i class="fas fa-certificate"></i> Issue NOC
            </a>
            <a href="#" class="btn btn-warning">
                <i class="fas fa-clock"></i> Retention Tracker
            </a>
        </div>

        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-number" style="color: #ffc107;">₹12,75,000</div>
                <div class="stat-label">Total Retention Held</div>
                <div class="percentage-up">From 15 projects</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #28a745;">₹5,85,000</div>
                <div class="stat-label">Retention Released</div>
                <div class="percentage-up">This quarter</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #007bff;">8</div>
                <div class="stat-label">NOCs Issued</div>
                <div class="percentage-up">This month</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #dc3545;">3</div>
                <div class="stat-label">Overdue Releases</div>
                <div class="percentage-down">Action required</div>
            </div>
        </div>

        <div class="sales-card">
            <div class="payment-header">
                <div>
                    <h3 style="margin: 0;">Retention Management - GAIL Project</h3>
                    <small>PO: GAIL-2024-089 | Project Value: ₹25,00,000</small>
                </div>
                <div>
                    <span class="status-pending">Retention Active</span>
                </div>
            </div>
            <div class="financial-grid">
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-hand-holding-usd"></i> Retention Details
                    </div>
                    <div class="financial-details">
                        <div class="amount-large">₹2,50,000</div>
                        Retention @ 10%<br>
                        Retention Period: 12 months<br>
                        Release Date: 2025-08-15
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-calendar-check"></i> Project Status
                    </div>
                    <div class="financial-details">
                        Completion Date: 2024-08-15<br>
                        Defect Liability: 12 months<br>
                        Remaining Period: 6 months<br>
                        Warranty Status: Active
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-tools"></i> Maintenance Record
                    </div>
                    <div class="financial-details">
                        Service Visits: 3<br>
                        Issues Resolved: 2<br>
                        Pending Issues: 0<br>
                        Customer Satisfaction: ⭐⭐⭐⭐⭐
                    </div>
                </div>
            </div>
        </div>

        <div class="sales-card">
            <div class="payment-header">
                <div>
                    <h3 style="margin: 0;">NOC Issued - IOC Project</h3>
                    <small>PO: IOC-2023-156 | NOC Date: 2025-01-10</small>
                </div>
                <div>
                    <span class="status-paid">NOC Issued</span>
                </div>
            </div>
            <div class="financial-grid">
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-certificate"></i> NOC Details
                    </div>
                    <div class="financial-details">
                        NOC Number: NOC-2025-001<br>
                        Issue Date: 2025-01-10<br>
                        Valid Until: Indefinite<br>
                        Digital Signature: Applied
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-money-check"></i> Retention Released
                    </div>
                    <div class="financial-details">
                        <div class="amount-large">₹1,85,000</div>
                        Released on 2025-01-10<br>
                        Release Mode: NEFT<br>
                        UTR: UTR2025001890
                    </div>
                </div>
                <div class="financial-item">
                    <div class="financial-title">
                        <i class="fas fa-check-circle"></i> Final Clearance
                    </div>
                    <div class="financial-details">
                        All Dues Cleared: ✅<br>
                        Customer Feedback: Excellent<br>
                        Future Business: Confirmed<br>
                        Relationship Status: Active
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Tab -->
    <div id="dashboard" class="tab-content">
        <div class="action-buttons">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-sync"></i> Refresh Data
            </a>
            <a href="#" class="btn btn-success">
                <i class="fas fa-download"></i> Export Report
            </a>
            <a href="#" class="btn btn-info">
                <i class="fas fa-cog"></i> Configure Dashboard
            </a>
            <a href="#" class="btn btn-warning">
                <i class="fas fa-print"></i> Print Summary
            </a>
        </div>

        <!-- Advanced Financial Stats -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
gap: 20px; margin-bottom: 30px;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: 
white; padding: 25px; border-radius: 12px; text-align: center;">
                <div style="font-size: 28px; font-weight: 700; margin-bottom: 
8px;">₹1,25,75,000</div>
                <div style="opacity: 0.9; font-size: 16px;">Total Revenue (YTD)</div>
                <div style="font-size: 14px; margin-top: 8px; opacity: 0.8;">↗ +18.5% vs last 
year</div>
            </div>
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: 
white; padding: 25px; border-radius: 12px; text-align: center;">
                <div style="font-size: 28px; font-weight: 700; margin-bottom: 
8px;">₹28,15,000</div>
                <div style="opacity: 0.9; font-size: 16px;">Net Profit (YTD)</div>
                <div style="font-size: 14px; margin-top: 8px; opacity: 0.8;">↗ Margin: 
22.4%</div>
            </div>
            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: 
white; padding: 25px; border-radius: 12px; text-align: center;">
                <div style="font-size: 28px; font-weight: 700; margin-bottom: 
8px;">₹15,85,000</div>
                <div style="opacity: 0.9; font-size: 16px;">Outstanding Receivables</div>
                <div style="font-size: 14px; margin-top: 8px; opacity: 0.8;">↗ Average: 32 
days</div>
            </div>
            <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: 
white; padding: 25px; border-radius: 12px; text-align: center;">
                <div style="font-size: 28px; font-weight: 700; margin-bottom: 8px;">125</div>
                <div style="opacity: 0.9; font-size: 16px;">Active Customers</div>
                <div style="font-size: 14px; margin-top: 8px; opacity: 0.8;">↗ +12 new this 
quarter</div>
            </div>
        </div>

        <!-- Chart Areas -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 
20px;">
            <div class="financial-dashboard">
                <div class="dashboard-title">
                    <i class="fas fa-chart-line"></i> Monthly Revenue Trend
                </div>
                <div class="chart-placeholder">
                    <i class="fas fa-chart-line" style="font-size: 36px; color: #dee2e6; 
margin-right: 10px;"></i>
                    Revenue Trend Chart
                </div>
            </div>
            <div class="financial-dashboard">
                <div class="dashboard-title">
                    <i class="fas fa-chart-pie"></i> Revenue by Customer
                </div>
                <div class="chart-placeholder">
                    <i class="fas fa-chart-pie" style="font-size: 36px; color: #dee2e6; 
margin-right: 10px;"></i>
                    Customer Distribution
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="financial-dashboard">
                <div class="dashboard-title">
                    <i class="fas fa-chart-bar"></i> Project Profitability
                </div>
                <div class="chart-placeholder">
                    <i class="fas fa-chart-bar" style="font-size: 36px; color: #dee2e6; 
margin-right: 10px;"></i>
                    Profit Margin Analysis
                </div>
            </div>
            <div class="financial-dashboard">
                <div class="dashboard-title">
                    <i class="fas fa-calendar-alt"></i> Payment Collection Trends
                </div>
                <div class="chart-placeholder">
                    <i class="fas fa-calendar-alt" style="font-size: 36px; color: #dee2e6; 
margin-right: 10px;"></i>
                    Collection Performance
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function switchFinancialTab(event, tabName) {
    // Hide all tab contents
    var tabContents = document.getElementsByClassName('tab-content');
    for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.remove('active');
    }
    
    // Remove active class from all tabs
    var tabs = document.getElementsByClassName('financial-tab');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove('active');
    }
    
    // Show selected tab content and mark tab as active
    document.getElementById(tabName).classList.add('active');
    event.currentTarget.classList.add('active');
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Sales & Financial Tracking module loaded');
    
  
});
</script>
@endsection
