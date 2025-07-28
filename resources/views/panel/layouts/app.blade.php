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
    @yield('styles')
    
    <style>
        /* Enhanced Sidebar Styles */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            overflow-x: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .logo-container {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 10px;
        }

        .logo-image {
            max-width: 100%;
            height: auto;
            max-height: 60px;
            border-radius: 8px;
        }

        .sidebar-toggle {
            position: absolute;
            top: 20px;
            right: -15px;
            background: #e31e24;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: #c41e24;
            transform: scale(1.1);
        }

        /* Main Menu Items */
        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 1px 10px;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }

        .menu-item.active {
            background: #e31e24;
            color: white;
            box-shadow: 0 2px 10px rgba(227,30,36,0.3);
        }

        .menu-item i {
            width: 25px;
            text-align: center;
            margin-right: 12px;
            font-size: 16px;
        }

        /* Menu Containers for Dropdown Items */
        .menu-container {
            margin: 1px 0;
        }

        .main-menu {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border-radius: 8px;
            margin: 1px 10px;
            position: relative;
        }

        .main-menu:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }

        .main-menu.active {
            background: #e31e24;
            color: white;
            box-shadow: 0 2px 10px rgba(227,30,36,0.3);
        }

        .main-menu i {
            width: 25px;
            text-align: center;
            margin-right: 12px;
            font-size: 16px;
        }

        /* Dropdown Arrow */
        .main-menu::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 20px;
            transition: transform 0.3s ease;
            font-size: 12px;
        }

        .main-menu.active::after {
            transform: rotate(180deg);
        }

        /* Submenu Styles */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: rgba(0,0,0,0.2);
            margin: 0 10px 1px 10px;
            border-radius: 8px;
        }

        .submenu.show {
            max-height: 300px;
            padding: 6px 0;
        }

        .submenu-item {
            display: flex;
            align-items: center;
            padding: 8px 20px 8px 40px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 6px;
            margin: 1px 8px;
            font-size: 14px;
            position: relative;
        }

        .submenu-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(3px);
        }

        .submenu-item.active {
            background: rgba(227,30,36,0.3);
            color: white;
            border-left: 3px solid #e31e24;
        }

        .submenu-item i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            font-size: 14px;
        }

        /* Menu Divider */
        .menu-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 8px 20px;
        }

        /* Collapsed Sidebar Adjustments */
        .sidebar.collapsed .logo-container {
            padding: 20px 10px;
        }

        .sidebar.collapsed .main-menu span,
        .sidebar.collapsed .menu-item span,
        .sidebar.collapsed .submenu {
            display: none;
        }

        .sidebar.collapsed .main-menu,
        .sidebar.collapsed .menu-item {
            justify-content: center;
            padding: 12px;
            margin: 1px 5px;
        }

        .sidebar.collapsed .main-menu i,
        .sidebar.collapsed .menu-item i {
            margin-right: 0;
        }

        .sidebar.collapsed .main-menu::after {
            display: none;
        }

        /* Main Content Adjustment */
        .main-content {
            margin-left: 280px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            background: #f8f9fa;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.collapsed {
                transform: translateX(0);
                width: 70px;
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 70px;
            }
        }

        /* Smooth scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        /* Animation for menu items */
        .menu-item,
        .main-menu,
        .submenu-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Focus states for accessibility */
        .menu-item:focus,
        .main-menu:focus,
        .submenu-item:focus {
            outline: 2px solid rgba(255,255,255,0.5);
            outline-offset: 2px;
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
            <span>NEPL Dashboard</span>
        </a>

        <a href="{{ route('service-types.index') }}" class="menu-item {{ request()->routeIs('service-types.*') ? 'active' : '' }}">
            <i class="fas fa-cogs"></i>
            <span>Service Type</span>
        </a>

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
            <span>Finance - Taxation Desk</span>
        </a>

        <!-- Legal Desk Menu -->
        <div class="menu-container">
            <div class="main-menu {{ request()->routeIs('legal-desk.*') || request()->routeIs('legal-document-types.*') || request()->routeIs('project-legal-documents.*') || request()->routeIs('legal-notifications.*') ? 'active' : '' }}" id="legal-toggle">
                <i class="fas fa-gavel"></i>
                <span>Legal Desk</span>
            </div>
            
            <div class="submenu {{ request()->routeIs('legal-desk.*') || request()->routeIs('legal-document-types.*') || request()->routeIs('project-legal-documents.*') || request()->routeIs('legal-notifications.*') ? 'show' : '' }}" id="legal-submenu">
                <a href="{{ route('legal-desk.index') }}" class="submenu-item {{ request()->routeIs('legal-desk.index') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Legal Dashboard</span>
                </a>
                <a href="{{ route('legal-document-types.index') }}" class="submenu-item {{ request()->routeIs('legal-document-types.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Document Types</span>
                </a>
                <a href="{{ route('project-legal-documents.index') }}" class="submenu-item {{ request()->routeIs('project-legal-documents.*') ? 'active' : '' }}">
                    <i class="fas fa-file-contract"></i>
                    <span>Legal Documents</span>
                </a>
                <a href="{{ route('legal-notifications.index') }}" class="submenu-item {{ request()->routeIs('legal-notifications.*') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                </a>
            </div>
        </div>

        <a href="#" class="menu-item {{ request()->routeIs('purchase.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Purchase Desk</span>
        </a>

        <a href="#" class="menu-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Sales Desk</span>
        </a>

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
        <div class="menu-container">
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
        </div>

        <!-- Riser Data Tracker Menu -->
        <div class="menu-container">
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
        </div>

        <!-- Ladder Data Tracker Menu -->
        <div class="menu-container">
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
        </div>

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
            <span>Sub Con Desk</span>
        </a>

        <div class="menu-divider"></div>

        <a href="#" class="menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i>
            <span>Report</span>
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
            <span>Profit</span>
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