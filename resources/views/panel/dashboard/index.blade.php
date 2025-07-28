@extends('panel.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('panel')}}/dashboard.css"/>


@endsection
@section('content')
        <div class="header">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search...">
            </div>
            <div class="header-icons">
                <i class="fas fa-bell header-icon"></i>
                <i class="fas fa-question-circle header-icon"></i>
                <div class="user-avatar">CA</div>
            </div>
        </div>

        <div class="dashboard-title">NEPL Desk</div>

        <!-- Content will be loaded here -->
        <div id="content-container">
            <!-- <h2>Dashboard content will be loaded here</h2>
            <p>This is where the dashboard content would appear.</p> -->
            <div class="header-row">
                <div class="section-title">Individual Desks</div>
                <div class="right-section">
                    <div style="display: flex; align-items: center;">
                        <div class="user-list">
                            <div class="user-avatar" style="background-color: #FF5733;">JS</div>
                            <div class="user-avatar" style="background-color: #3498DB;">RP</div>
                            <div class="user-avatar" style="background-color: #27AE60;">AK</div>
                            <div class="user-avatar" style="background-color: #F1C40F;">MT</div>
                            <div class="user-more">+5</div>
                        </div>
                        <div class="this-month">
                            This month
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="desk-grid">
                <div class="desk-card">
                    <div class="desk-icon finance">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="desk-name">Finance - Taxation Desk</div>
                </div>
                <div class="desk-card">
                    <div class="desk-icon legal">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <div class="desk-name">Legal Desk</div>
                </div>
                <div class="desk-card">
                    <div class="desk-icon purchase">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="desk-name">Purchase Desk</div>
                </div>
                <div class="desk-card">
                    <div class="desk-icon sales">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="desk-name">Sales Desk</div>
                </div>
                <div class="desk-card">
                    <div class="desk-icon plumber">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <div class="desk-name">Plumber Desk</div>
                </div>
                <div class="desk-card">
                    <div class="desk-icon labour">
                        <i class="fas fa-hard-hat"></i>
                    </div>
                    <div class="desk-name">Labour Desk</div>
                </div>
                <div class="desk-card">
                    <div class="desk-icon sub-contractor">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="desk-name">Sub Contractor Desk</div>
                </div>
                <div class="desk-card">
                    <div class="desk-icon dpr">
                        <i class="fas fa-desktop"></i>
                    </div>
                    <div class="desk-name">DPR Desk</div>
                </div>
            </div>
        
            <div class="overview-section">
                <div class="section-title">Overview</div>
                <div class="filters">
                    <div class="filter">
                        Location<br>
                        <strong>Pick Location</strong>
                    </div>
                    <div class="filter">
                        Work Period From<br>
                        <strong>Choose a Date</strong>
                    </div>
                    <div class="filter">
                        Work Period To<br>
                        <strong>Choose a Date</strong>
                    </div>
                    <div class="filter">
                        Contract No<br>
                        <strong>Choose Contract</strong>
                    </div>
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
        
                <!-- First row of stats -->
                <div class="stats-grid">
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-green"></div>
                        <div class="stat-title">Store Physical Balance</div>
                        <div class="stat-value">₹28,92,000</div>
                    </div>
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-green"></div>
                        <div class="stat-title">Sales</div>
                        <div class="stat-value">₹5,72,000</div>
                    </div>
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-green"></div>
                        <div class="stat-title">Retention</div>
                        <div class="stat-value">₹8,17,000</div>
                    </div>
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-green"></div>
                        <div class="stat-title">Holding/ Other</div>
                        <div class="stat-value">₹2,588</div>
                    </div>
                </div>
        
                <!-- Second row of stats -->
                <div class="stats-grid">
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-green"></div>
                        <div class="stat-title">NOC</div>
                        <div class="stat-value">₹15,04,000</div>
                    </div>
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-red"></div>
                        <div class="stat-title">Salary</div>
                        <div class="stat-value">₹15,04,000</div>
                    </div>
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-red"></div>
                        <div class="stat-title">Labour Cost</div>
                        <div class="stat-value">₹8,17,000</div>
                    </div>
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-red"></div>
                        <div class="stat-title">Plumber Cost</div>
                        <div class="stat-value">₹2,588</div>
                    </div>
                </div>
        
                <!-- Third row of stats -->
                <div class="stats-grid">
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-red"></div>
                        <div class="stat-title">Purchase</div>
                        <div class="stat-value">₹2,49,000</div>
                    </div>
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-red"></div>
                        <div class="stat-title">Daily Expense</div>
                        <div class="stat-value">₹8,946</div>
                    </div>
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-red"></div>
                        <div class="stat-title">Penalty</div>
                        <div class="stat-value">₹5,108</div>
                    </div>
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-red"></div>
                        <div class="stat-title">Policy Expenses</div>
                        <div class="stat-value">₹8,17,000</div>
                    </div>
                </div>
        
                <!-- Fourth row of stats -->
                <div class="stats-grid">
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-red"></div>
                        <div class="stat-title">Legal Compliance</div>
                        <div class="stat-value">₹15,04,000</div>
                    </div>
                    <div class="stat-card" style="position: relative;">
                        <div class="stat-indicator indicator-yellow"></div>
                        <div class="stat-title">Bank Guarantee</div>
                        <div class="stat-value">₹28,92,000</div>
                    </div>
                    <div class="stat-card" style="position: relative; grid-column: span 2;">
                        <div class="net-profit">
                            <div class="net-profit-title">Overall Net Profit</div>
                            <div class="net-profit-value">₹1,28,000 <span class="profit-percentage">↑ 5.39%</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endsection

   