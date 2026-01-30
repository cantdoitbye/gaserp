<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Legal Desk - Gas Erp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('panel')}}/base.css"/>
    <link rel="stylesheet" href="{{asset('panel')}}/main.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @yield('styles')
    
    <style>
        /* Enhanced Sidebar Styles */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #1a252f 0%, #2c3e50 100%);
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            overflow-x: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0,0,0,0.15);
        }

        .sidebar.collapsed {
            width: 65px;
        }

        .logo-container {
            padding: 18px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 8px;
            background: rgba(0,0,0,0.2);
        }

        .logo-image {
            max-width: 100%;
            height: auto;
            max-height: 50px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .logo-image {
            max-height: 35px;
        }

        .sidebar-toggle {
            position: absolute;
            top: 18px;
            right: -12px;
            background: linear-gradient(135deg, #e31e24 0%, #c41e24 100%);
            color: white;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(227,30,36,0.4);
            transition: all 0.3s ease;
            border: 2px solid #fff;
        }

        .sidebar-toggle:hover {
            background: linear-gradient(135deg, #c41e24 0%, #a01a1f 100%);
            transform: scale(1.15);
            box-shadow: 0 4px 15px rgba(227,30,36,0.6);
        }

        .sidebar-toggle i {
            font-size: 11px;
            transition: transform 0.3s ease;
        }

        /* Main Menu Items */
        .menu-item {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            transition: all 0.25s ease;
            border-radius: 6px;
            margin: 2px 12px;
            position: relative;
            font-size: 14px;
            font-weight: 500;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.08);
            color: white;
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .menu-item.active {
            background: linear-gradient(135deg, #e31e24 0%, #c41e24 100%);
            color: white;
            box-shadow: 0 3px 12px rgba(227,30,36,0.35);
            font-weight: 600;
        }

        .menu-item i {
            width: 22px;
            text-align: center;
            margin-right: 12px;
            font-size: 15px;
            flex-shrink: 0;
        }

        /* Menu Containers for Dropdown Items */
        .menu-container {
            margin: 2px 0;
        }

        .main-menu {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            transition: all 0.25s ease;
            cursor: pointer;
            border-radius: 6px;
            margin: 2px 12px;
            position: relative;
            font-size: 14px;
            font-weight: 500;
        }

        .main-menu:hover {
            background: rgba(255,255,255,0.08);
            color: white;
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .main-menu.active {
            background: linear-gradient(135deg, #e31e24 0%, #c41e24 100%);
            color: white;
            box-shadow: 0 3px 12px rgba(227,30,36,0.35);
            font-weight: 600;
        }

        .main-menu i {
            width: 22px;
            text-align: center;
            margin-right: 12px;
            font-size: 15px;
            flex-shrink: 0;
        }

        /* Dropdown Arrow */
        .main-menu::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 16px;
            transition: transform 0.3s ease;
            font-size: 10px;
            opacity: 0.7;
        }

        .main-menu.active::after {
            transform: rotate(180deg);
            opacity: 1;
        }

        /* Submenu Styles */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: rgba(0,0,0,0.15);
            margin: 0 12px 2px 12px;
            border-radius: 6px;
        }

        .submenu.show {
            max-height: 400px;
            padding: 4px 0;
        }

        .submenu-item {
            display: flex;
            align-items: center;
            padding: 8px 16px 8px 38px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            transition: all 0.25s ease;
            border-radius: 5px;
            margin: 1px 8px;
            font-size: 13px;
            position: relative;
        }

        .submenu-item::before {
            content: '';
            position: absolute;
            left: 20px;
            width: 4px;
            height: 4px;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            transition: all 0.25s ease;
        }

        .submenu-item:hover {
            background: rgba(255,255,255,0.08);
            color: white;
            transform: translateX(3px);
        }

        .submenu-item:hover::before {
            background: #e31e24;
            transform: scale(1.5);
        }

        .submenu-item.active {
            background: rgba(227,30,36,0.25);
            color: white;
            border-left: 3px solid #e31e24;
            font-weight: 600;
        }

        .submenu-item.active::before {
            background: #e31e24;
            transform: scale(1.5);
        }

        .submenu-item i {
            width: 18px;
            text-align: center;
            margin-right: 10px;
            font-size: 13px;
        }

        /* Menu Divider */
        .menu-divider {
            height: 1px;
            background: rgba(255,255,255,0.08);
            margin: 10px 20px;
        }

        /* Section Headers */
        .menu-section-header {
            padding: 12px 16px 6px 16px;
            color: rgba(255,255,255,0.4);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 8px;
        }

        /* Collapsed Sidebar Adjustments */
        .sidebar.collapsed .logo-container {
            padding: 18px 8px;
        }

        .sidebar.collapsed .main-menu span,
        .sidebar.collapsed .menu-item span,
        .sidebar.collapsed .submenu,
        .sidebar.collapsed .menu-section-header {
            display: none;
        }

        .sidebar.collapsed .main-menu,
        .sidebar.collapsed .menu-item {
            justify-content: center;
            padding: 10px;
            margin: 2px 8px;
        }

        .sidebar.collapsed .main-menu i,
        .sidebar.collapsed .menu-item i {
            margin-right: 0;
            font-size: 16px;
        }

        .sidebar.collapsed .main-menu::after {
            display: none;
        }

        .sidebar.collapsed .menu-divider {
            margin: 10px 12px;
        }

        /* Main Content Adjustment */
        .main-content {
            margin-left: 260px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            background: #f5f7fa;
            padding: 20px;
        }

        .main-content.expanded {
            margin-left: 65px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                transform: translateX(0);
                width: 65px;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .main-content.expanded {
                margin-left: 65px;
            }
        }

        /* Smooth scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.35);
        }

        /* Animation for menu items */
        .menu-item,
        .main-menu,
        .submenu-item {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Focus states for accessibility */
        .menu-item:focus,
        .main-menu:focus,
        .submenu-item:focus {
            outline: 2px solid rgba(227,30,36,0.5);
            outline-offset: 2px;
        }

        /* Badge for notifications */
        .menu-badge {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: #e31e24;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 700;
        }

        .sidebar.collapsed .menu-badge {
            right: 5px;
            top: 5px;
            transform: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-container">
            <img src="{{ asset('panel/logo.jpeg') }}" alt="Navsarjan Engineering" class="logo-image">
        </div>

        <!-- Sidebar toggle button -->
        <div class="sidebar-toggle">
            <i class="fas fa-chevron-left"></i>
        </div>

        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>

        <div class="menu-section-header">Core Modules</div>

        <a href="{{ route('projects.index') }}" class="menu-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
            <i class="fas fa-project-diagram"></i>
            <span>Projects</span>
        </a>

        <a href="#" class="menu-item {{ request()->routeIs('dpr.*') ? 'active' : '' }}">
            <i class="fas fa-desktop"></i>
            <span>DPR Desk</span>
        </a>

        <a href="#" class="menu-item {{ request()->routeIs('finance.*') ? 'active' : '' }}">
            <i class="fas fa-calculator"></i>
            <span>Finance & Taxation</span>
        </a>

        <div class="menu-section-header">Operations</div>

        <a href="{{ route('purchase-assets.index') }}" class="menu-item {{ request()->routeIs('purchase.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Purchase Desk</span>
        </a>

        <a href="{{ route('sales-financial.index') }}" class="menu-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Sales Desk</span>
        </a>

        <a href="{{ route('consumption.index') }}" class="menu-item {{ request()->routeIs('consumption.*') ? 'active' : '' }}">
            <i class="fas fa-boxes"></i>
            <span>Consumption</span>
        </a>

        <div class="menu-section-header">Data Trackers</div>

        <!-- PNG Data Tracker Menu -->
        <div class="menu-container">
            <div class="main-menu {{ request()->is('png*') ? 'active' : '' }}" id="png-toggle">
                <i class="fas fa-database"></i>
                <span>PNG Data Tracker</span>
            </div>
            
            <div class="submenu {{ request()->is('png*') ? 'show' : '' }}" id="png-submenu">
                <a href="{{ route('png.index') }}" class="submenu-item {{ request()->is('png') || request()->is('png/index') ? 'active' : '' }}">
                    <i class="fas fa-list"></i>
                    <span>Jobs List</span>
                </a>
                <a href="{{ route('png.create') }}" class="submenu-item {{ request()->is('png/create') ? 'active' : '' }}">
                    <i class="fas fa-plus"></i>
                    <span>Add New Job</span>
                </a>
                <a href="{{ route('png.import.form') }}" class="submenu-item {{ request()->is('png/import') ? 'active' : '' }}">
                    <i class="fas fa-file-excel"></i>
                    <span>Import Excel</span>
                </a>
            </div>
        </div>

       

        <!-- Commercial Data Tracker Menu -->
        {{-- <div class="menu-container">
            <div class="main-menu {{ request()->is('commercial*') ? 'active' : '' }}" id="commercial-toggle">
                <i class="fas fa-building"></i>
                <span>Commercial Tracker</span>
            </div>
            
            <div class="submenu {{ request()->is('commercial*') ? 'show' : '' }}" id="commercial-submenu">
                <a href="{{ route('commercial.index') }}" class="submenu-item {{ request()->is('commercial') || request()->is('commercial/index') ? 'active' : '' }}">
                    <i class="fas fa-list"></i>
                    <span>Jobs List</span>
                </a>
                <a href="{{ route('commercial.create') }}" class="submenu-item {{ request()->is('commercial/create') ? 'active' : '' }}">
                    <i class="fas fa-plus"></i>
                    <span>Add New Job</span>
                </a>
                <a href="{{ route('commercial.import.form') }}" class="submenu-item {{ request()->is('commercial/import') ? 'active' : '' }}">
                    <i class="fas fa-file-excel"></i>
                    <span>Import Excel</span>
                </a>
            </div>
        </div> --}}

        <!-- Riser Data Tracker Menu -->
        {{-- <div class="menu-container">
            <div class="main-menu {{ request()->is('riser*') ? 'active' : '' }}" id="riser-toggle">
                <i class="fas fa-arrows-alt-v"></i>
                <span>Riser Tracker</span>
            </div>
            
            <div class="submenu {{ request()->is('riser*') ? 'show' : '' }}" id="riser-submenu">
                <a href="{{ route('riser.index') }}" class="submenu-item {{ request()->is('riser') || request()->is('riser/index') ? 'active' : '' }}">
                    <i class="fas fa-list"></i>
                    <span>Jobs List</span>
                </a>
                <a href="{{ route('riser.create') }}" class="submenu-item {{ request()->is('riser/create') ? 'active' : '' }}">
                    <i class="fas fa-plus"></i>
                    <span>Add New Job</span>
                </a>
                <a href="{{ route('riser.import.form') }}" class="submenu-item {{ request()->is('riser/import') ? 'active' : '' }}">
                    <i class="fas fa-file-excel"></i>
                    <span>Import Excel</span>
                </a>
            </div>
        </div> --}}

        <!-- Ladder Data Tracker Menu -->
        {{-- <div class="menu-container">
            <div class="main-menu {{ request()->is('ladder*') ? 'active' : '' }}" id="ladder-toggle">
                <i class="fas fa-project-diagram"></i>
                <span>Hadder Tracker</span>
            </div>
            
            <div class="submenu {{ request()->is('ladder*') ? 'show' : '' }}" id="ladder-submenu">
                <a href="{{ route('ladder.index') }}" class="submenu-item {{ request()->is('ladder') || request()->is('ladder/index') ? 'active' : '' }}">
                    <i class="fas fa-list"></i>
                    <span>Jobs List</span>
                </a>
                <a href="{{ route('ladder.create') }}" class="submenu-item {{ request()->is('ladder/create') ? 'active' : '' }}">
                    <i class="fas fa-plus"></i>
                    <span>Add New Job</span>
                </a>
                <a href="{{ route('ladder.import.form') }}" class="submenu-item {{ request()->is('ladder/import') ? 'active' : '' }}">
                    <i class="fas fa-file-excel"></i>
                    <span>Import Excel</span>
                </a>
            </div>
        </div> --}}

        <!-- PE Tracker Menu -->
        <div class="menu-container">
            <div class="main-menu {{ request()->routeIs('pe-tracker.*') ? 'active' : '' }}" id="pe-toggle">
                <i class="fas fa-chart-line"></i>
                <span>PE Tracker</span>
            </div>
            
            <div class="submenu {{ request()->routeIs('pe-tracker.*') ? 'show' : '' }}" id="pe-submenu">
                <a href="{{ route('pe-tracker.index') }}" class="submenu-item {{ request()->routeIs('pe-tracker.index') ? 'active' : '' }}">
                    <i class="fas fa-list"></i>
                    <span>Records List</span>
                </a>
                <a href="{{ route('pe-tracker.create') }}" class="submenu-item {{ request()->routeIs('pe-tracker.create') ? 'active' : '' }}">
                    <i class="fas fa-plus"></i>
                    <span>Add New Record</span>
                </a>
                <a href="{{ route('pe-tracker.import.form') }}" class="submenu-item {{ request()->routeIs('pe-tracker.import.form') ? 'active' : '' }}">
                    <i class="fas fa-file-excel"></i>
                    <span>Import Excel</span>
                </a>
            </div>
        </div>

        <div class="menu-section-header">Resources</div>

        <a href="{{ route('plumbers.index') }}" class="menu-item {{ request()->routeIs('plumbers.*') ? 'active' : '' }}">
            <i class="fas fa-wrench"></i>
            <span>Plumber Desk</span>
        </a>

        <a href="#" class="menu-item {{ request()->routeIs('labour.*') ? 'active' : '' }}">
            <i class="fas fa-hard-hat"></i>
            <span>Labour Desk</span>
        </a>

        <a href="#" class="menu-item {{ request()->routeIs('subcon.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Sub Contractors</span>
        </a>

        <div class="menu-section-header">Management</div>

        <a href="#" class="menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i>
            <span>Reports</span>
        </a>

        <a href="#" class="menu-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
            <i class="fas fa-tasks"></i>
            <span>Tasks</span>
        </a>

        <a href="#" class="menu-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
            <i class="fas fa-user-friends"></i>
            <span>Clients</span>
        </a>

        <a href="#" class="menu-item {{ request()->routeIs('profit.*') ? 'active' : '' }}">
            <i class="fas fa-rupee-sign"></i>
            <span>Profit Analysis</span>
        </a>

        <a href="#" class="menu-item {{ request()->routeIs('integrations.*') ? 'active' : '' }}">
            <i class="fas fa-plug"></i>
            <span>Integrations</span>
        </a>

        <div class="menu-divider"></div>
        
        <form method="GET" action="{{ route('admin.logout') }}" id="logout-form">
            @csrf
            <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </form>
    </div>
    
    <div class="main-content">
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                
                // Rotate toggle icon
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    icon.style.transform = 'rotate(0deg)';
                }
            });
            
            // Menu toggle function
            function setupMenuToggle(toggleId, submenuId) {
                const toggleButton = document.getElementById(toggleId);
                const submenu = document.getElementById(submenuId);
                
                if (toggleButton && submenu) {
                    toggleButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        submenu.classList.toggle('show');
                        toggleButton.classList.toggle('active');
                    });
                }
            }
            
            // Setup all menu toggles
            setupMenuToggle('legal-toggle', 'legal-submenu');
            setupMenuToggle('png-toggle', 'png-submenu');
               setupMenuToggle('commercial-toggle', 'commercial-submenu');
            setupMenuToggle('riser-toggle', 'riser-submenu');
            setupMenuToggle('ladder-toggle', 'ladder-submenu');
            setupMenuToggle('pe-toggle', 'pe-submenu');
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                }
            });
            
            // Initially check if screen is small
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
            
            // Close submenus when clicking elsewhere
            document.addEventListener('click', function(event) {
                const menuContainers = document.querySelectorAll('.menu-container');
                
                menuContainers.forEach(container => {
                    const toggle = container.querySelector('.main-menu');
                    const submenu = container.querySelector('.submenu');
                    
                    if (toggle && submenu) {
                        const isClickInside = container.contains(event.target);
                        const isActive = submenu.classList.contains('show');
                        
                        // Don't close if clicking inside the container or if it's an active route
                        if (!isClickInside && isActive && !toggle.classList.contains('active')) {
                            submenu.classList.remove('show');
                            toggle.classList.remove('active');
                        }
                    }
                });
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>
