<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão de Resíduos - @yield('title')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --sidebar-width: 280px;
            --sidebar-width-collapsed: 80px;
            --sidebar-bg: #1a1e2b;
            --sidebar-hover: #2a2f3f;
            --sidebar-active: #4e73df;
            --header-height: 70px;
            --primary: #4e73df;
            --secondary: #858796;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --dark: #5a5c69;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fc;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            background-image: linear-gradient(180deg, var(--sidebar-bg) 0%, #141824 100%);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            overflow-y: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-width-collapsed);
        }

        .sidebar.collapsed .logo span,
        .sidebar.collapsed .logo small,
        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .nav-divider,
        .sidebar.collapsed .logout-btn span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .nav-link i {
            margin: 0;
            width: auto;
            font-size: 1.3rem;
        }

        .sidebar.collapsed .logout-btn {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .logout-btn i {
            margin: 0;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.3);
        }

        /* Logo Area */
        .sidebar .logo-area {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .sidebar.collapsed .logo-area {
            padding: 25px 10px;
        }

        .sidebar .logo {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
        }

        .sidebar.collapsed .logo {
            justify-content: center;
        }

        .sidebar .logo i {
            font-size: 2rem;
            color: var(--sidebar-active);
            background: rgba(255,255,255,0.1);
            padding: 10px;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .sidebar .logo:hover i {
            transform: rotate(10deg);
            background: rgba(255,255,255,0.15);
        }

        .sidebar .logo span {
            font-size: 1.25rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .sidebar .logo small {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.5);
            display: block;
            margin-top: 2px;
            white-space: nowrap;
        }

        /* Navigation */
        .sidebar .nav {
            padding: 0 12px;
        }

        .sidebar .nav-item {
            margin-bottom: 5px;
            list-style: none;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
            font-weight: 500;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--sidebar-active);
            transform: translateX(-100%);
            transition: transform 0.2s;
        }

        .sidebar .nav-link:hover::before,
        .sidebar .nav-link.active::before {
            transform: translateX(0);
        }

        .sidebar .nav-link i {
            width: 24px;
            font-size: 1.1rem;
            text-align: center;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: var(--sidebar-active);
            color: white;
            box-shadow: 0 4px 8px rgba(78, 115, 223, 0.3);
        }

        .sidebar .nav-link.active i {
            color: white;
        }

        .sidebar .nav-divider {
            color: rgba(255,255,255,0.3);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 20px 15px 10px;
            white-space: nowrap;
        }

        /* Logout Button */
        .sidebar .logout-btn {
            margin: 20px 15px;
            padding: 12px 15px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: rgba(255,255,255,0.7);
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
            width: calc(100% - 30px);
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar .logout-btn:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-color: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            position: absolute;
            bottom: 20px;
            right: -12px;
            width: 24px;
            height: 24px;
            background: var(--sidebar-active);
            border: 2px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            z-index: 1001;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .sidebar-toggle:hover {
            transform: scale(1.1);
            background: var(--primary);
        }

        .sidebar.collapsed .sidebar-toggle i {
            transform: rotate(180deg);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: #f8f9fc;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content.expanded {
            margin-left: var(--sidebar-width-collapsed);
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            height: var(--header-height);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
            position: relative;
            padding-left: 15px;
        }

        .page-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background: var(--sidebar-active);
            border-radius: 2px;
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--sidebar-active);
            cursor: pointer;
            margin-right: 15px;
        }

        /* User Menu */
        .user-menu {
            position: relative;
        }

        .user-menu-toggle {
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            padding: 5px 15px;
            border-radius: 50px;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .user-menu-toggle:hover {
            background: #f8f9fc;
            border-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        .user-role {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
            position: relative;
            transition: all 0.3s;
        }

        .user-menu-toggle:hover .user-avatar {
            transform: scale(1.05);
            border-radius: 15px;
        }

        .user-status {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            background: #28a745;
            border: 2px solid white;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4);
            }
            70% {
                box-shadow: 0 0 0 5px rgba(40, 167, 69, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            }
        }

        /* User Dropdown */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 15px);
            right: 0;
            width: 320px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.2);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-15px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .user-menu:hover .user-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .user-dropdown-header {
            padding: 25px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 15px;
            background: linear-gradient(135deg, #f8f9fc 0%, white 100%);
            border-radius: 15px 15px 0 0;
        }

        .dropdown-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .dropdown-info h6 {
            margin: 0;
            font-weight: 600;
            color: #2c3e50;
            font-size: 1rem;
        }

        .dropdown-info small {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .user-dropdown-menu {
            padding: 15px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #2c3e50;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s;
            font-size: 0.9rem;
            border: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            color: var(--sidebar-active);
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 20px;
            color: #6c757d;
            transition: all 0.2s;
        }

        .dropdown-item:hover i {
            color: var(--sidebar-active);
        }

        .dropdown-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e9ecef, transparent);
            margin: 10px 0;
        }

        .badge-notification {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            font-size: 0.65rem;
            padding: 3px 8px;
            border-radius: 20px;
            margin-left: auto;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(220, 53, 69, 0.3);
        }

        /* Content Wrapper */
        .content-wrapper {
            padding: 30px;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert i {
            font-size: 1.2rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffe8a1 100%);
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        .btn-close {
            filter: none;
            opacity: 0.5;
            transition: all 0.2s;
        }

        .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        /* Toast Notifications */
        .toast-container {
            z-index: 1100;
        }

        .toast {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(5px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-overlay.active {
            display: flex;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--sidebar-active);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            :root {
                --sidebar-width: 240px;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }
            
            .sidebar.mobile-show {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0,0,0,0.2);
            }
            
            .main-content {
                margin-left: 0 !important;
            }

            .top-navbar {
                padding: 0 20px;
            }

            .page-title {
                font-size: 1.1rem;
            }

            .user-info {
                display: none;
            }

            .user-menu-toggle {
                padding: 5px;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .user-dropdown {
                width: 280px;
                right: -10px;
            }

            .content-wrapper {
                padding: 20px 15px;
            }

            .sidebar-toggle {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .top-navbar {
                padding: 0 15px;
            }

            .page-title {
                font-size: 1rem;
            }

            .user-dropdown {
                width: 260px;
            }

            .content-wrapper {
                padding: 15px 12px;
            }
        }

        /* Print Styles */
        @media print {
            .sidebar,
            .top-navbar,
            .alert,
            .btn,
            .user-menu {
                display: none !important;
            }

            .main-content {
                margin: 0 !important;
                padding: 0 !important;
            }

            .content-wrapper {
                padding: 0 !important;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Sidebar Toggle Button (Desktop) -->
        <div class="sidebar-toggle" id="sidebarToggle" title="Alternar sidebar">
            <i class="fas fa-chevron-left"></i>
        </div>

        <div class="logo-area">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <i class="fas fa-recycle"></i>
                <div>
                    <span>Gestão Resíduos</span>
                    <small>Lixeira de Hulene</small>
                </div>
            </a>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            @if(Auth::user()->role && Auth::user()->role->nome == 'Administrador')
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        <span>Utilizadores</span>
                    </a>
                </li>
            @endif
            
            @if(in_array(Auth::user()->role->nome ?? '', ['Administrador', 'Operador', 'Gestor']))
                <li class="nav-item">
                    <a href="{{ route('operador.entradas.index') }}" 
                       class="nav-link {{ request()->routeIs('operador.entradas*') ? 'active' : '' }}">
                        <i class="fas fa-truck-loading"></i>
                        <span>Entradas</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('operador.movimentacoes.index') }}" 
                       class="nav-link {{ request()->routeIs('operador.movimentacoes*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Movimentações</span>
                    </a>
                </li>
            @endif
            
            <li class="nav-item">
                <a href="{{ route('relatorios.dashboard') }}" 
                   class="nav-link {{ request()->routeIs('relatorios*') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i>
                    <span>Relatórios</span>
                </a>
            </li>

            <li class="nav-divider">Ferramentas</li>

            <li class="nav-item">
                <a href="#" class="nav-link" id="tasksLink">
                    <i class="fas fa-calendar-check"></i>
                    <span>Tarefas</span>
                    <span class="badge bg-danger ms-auto" id="tasksBadge">3</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link" id="notificationsLink">
                    <i class="fas fa-bell"></i>
                    <span>Notificações</span>
                    <span class="badge bg-warning ms-auto" id="notificationsBadge">5</span>
                </a>
            </li>
        </ul>

        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button type="submit" class="logout-btn" id="logoutBtn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Sair do Sistema</span>
            </button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">
                    @yield('title', 'Dashboard')
                </h1>
            </div>
            
            <!-- User Menu with Dropdown -->
            <div class="user-menu">
                <div class="user-menu-toggle" id="userMenuToggle">
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->nome_completo }}</div>
                        <div class="user-role">{{ Auth::user()->role->nome ?? 'Utilizador' }}</div>
                    </div>
                    <div class="user-avatar">
                        {{ substr(Auth::user()->nome_completo, 0, 2) }}
                        <span class="user-status"></span>
                    </div>
                </div>

                <!-- Dropdown Menu -->
                <div class="user-dropdown">
                    <div class="user-dropdown-header">
                        <div class="dropdown-avatar">
                            {{ substr(Auth::user()->nome_completo, 0, 2) }}
                        </div>
                        <div class="dropdown-info">
                            <h6>{{ Auth::user()->nome_completo }}</h6>
                            <small>{{ Auth::user()->email }}</small>
                        </div>
                    </div>

                    <div class="user-dropdown-menu">
                        <a href="#" class="dropdown-item" onclick="showToast('Perfil em desenvolvimento', 'info')">
                            <i class="fas fa-user"></i>
                            <span>Meu Perfil</span>
                        </a>
                        
                        <a href="#" class="dropdown-item" onclick="showToast('Tarefas em desenvolvimento', 'info')">
                            <i class="fas fa-tasks"></i>
                            <span>Minhas Tarefas</span>
                            <span class="badge-notification" id="dropdownTasksBadge">3</span>
                        </a>
                        
                        <a href="#" class="dropdown-item" onclick="showToast('Notificações em desenvolvimento', 'info')">
                            <i class="fas fa-bell"></i>
                            <span>Notificações</span>
                            <span class="badge-notification" id="dropdownNotifBadge">5</span>
                        </a>
                        
                        <a href="#" class="dropdown-item" onclick="showToast('Atividades em desenvolvimento', 'info')">
                            <i class="fas fa-history"></i>
                            <span>Atividades Recentes</span>
                        </a>
                        
                        <a href="#" class="dropdown-item" onclick="showToast('Configurações em desenvolvimento', 'info')">
                            <i class="fas fa-cog"></i>
                            <span>Configurações</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <a href="#" class="dropdown-item" onclick="showToast('Ajuda em desenvolvimento', 'info')">
                            <i class="fas fa-question-circle"></i>
                            <span>Ajuda & Suporte</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                            @csrf
                            <button type="submit" class="dropdown-item w-100" style="border: none; background: none;">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Sair</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <!-- Notification Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer"></div>

    <!-- Backdrop for mobile sidebar -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 999;"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');
            const loadingOverlay = document.getElementById('loadingOverlay');
            
            // Estado da sidebar (salvo no localStorage)
            const sidebarState = localStorage.getItem('sidebarCollapsed') === 'true';
            if (sidebarState && window.innerWidth > 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }

            // Toggle sidebar (desktop)
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                });
            }

            // Mobile menu
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    sidebar.classList.add('mobile-show');
                    sidebarBackdrop.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                });
            }

            // Close sidebar when clicking backdrop
            sidebarBackdrop.addEventListener('click', function() {
                sidebar.classList.remove('mobile-show');
                sidebarBackdrop.style.display = 'none';
                document.body.style.overflow = '';
            });

            // Close sidebar on window resize (if becomes desktop)
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('mobile-show');
                    sidebarBackdrop.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    try {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    } catch (e) {
                        // Ignore errors
                    }
                });
            }, 5000);

            // Logout confirmation
            const logoutBtn = document.getElementById('logoutBtn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    if (!confirm('Tem certeza que deseja sair do sistema?')) {
                        e.preventDefault();
                    }
                });
            }

            // Loading overlay demo (remove in production)
            window.showLoading = function(show) {
                if (show) {
                    loadingOverlay.classList.add('active');
                } else {
                    loadingOverlay.classList.remove('active');
                }
            };

            // Simulate loading on some actions
            document.querySelectorAll('a:not(.no-loading)').forEach(link => {
                link.addEventListener('click', function() {
                    if (!this.classList.contains('dropdown-item') && !this.hasAttribute('data-no-loading')) {
                        showLoading(true);
                    }
                });
            });

            // Hide loading on page load
            window.addEventListener('load', function() {
                showLoading(false);
            });

            // Update notification badges (simulation)
            function updateBadges() {
                const tasksBadge = document.getElementById('tasksBadge');
                const notifBadge = document.getElementById('notificationsBadge');
                const dropdownTasksBadge = document.getElementById('dropdownTasksBadge');
                const dropdownNotifBadge = document.getElementById('dropdownNotifBadge');
                
                // Simulate random updates
                if (tasksBadge) tasksBadge.textContent = Math.floor(Math.random() * 5) + 1;
                if (notifBadge) notifBadge.textContent = Math.floor(Math.random() * 8) + 2;
                if (dropdownTasksBadge) dropdownTasksBadge.textContent = tasksBadge?.textContent || '0';
                if (dropdownNotifBadge) dropdownNotifBadge.textContent = notifBadge?.textContent || '0';
            }

            // Update badges every 30 seconds
            setInterval(updateBadges, 30000);
        });

        // Função para mostrar notificações toast
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            const toastId = 'toast-' + Date.now();
            
            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'danger' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);
            
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, { autohide: true, delay: 3000 });
            toast.show();
            
            setTimeout(() => {
                toastElement.remove();
            }, 4000);
        }

        // Função para confirmar ações
        function confirmAction(message, callback) {
            if (confirm(message)) {
                callback();
            }
        }

        // Expor funções globalmente
        window.showToast = showToast;
        window.confirmAction = confirmAction;
    </script>
</body>
</html>