{{-- resources/views/layouts/enseignant.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Enseignant')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    @if($theme === 'dark')
        <link rel="stylesheet" href="{{ asset('css/dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/light.css') }}">
    @endif


    <style>
        :root {
            --primary-color: #5D3FD3;
            --secondary-color: #F8F7FF;
            --sidebar-color: #2C3E50;
            --accent-color: #6C63FF;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --shadow: 0 4px 12px rgba(93, 63, 211, 0.1);
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        /* Sidebar Styling */
        .sidebar {
            background: linear-gradient(180deg, var(--sidebar-color) 0%, #1a2530 100%);
            color: white;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            box-shadow: 3px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-header h4 {
            margin: 0;
            font-size: 1.2rem;
            transition: opacity 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar.collapsed .sidebar-header h4 {
            opacity: 0;
            width: 0;
        }
        
        .toggle-btn {
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            flex-shrink: 0;
        }
        
        .toggle-btn:hover {
            background: rgba(255,255,255,0.2);
            transform: scale(1.05);
        }
        
        .user-profile-sidebar {
            text-align: center;
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .user-profile-sidebar {
            padding: 20px 10px;
        }
        
        .user-avatar {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            margin: 0 auto 15px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .sidebar.collapsed .user-avatar {
            width: 50px;
            height: 50px;
            margin-bottom: 0;
            font-size: 1.3rem;
        }
        
        .user-name {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .user-name,
        .sidebar.collapsed .user-role,
        .sidebar.collapsed .user-profile-sidebar small {
            opacity: 0;
            height: 0;
            margin: 0;
            overflow: hidden;
        }
        
        .user-role {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .user-profile-sidebar small {
            transition: all 0.3s ease;
        }
        
        .sidebar-menu {
            padding: 20px 0;
            overflow-y: auto;
            max-height: calc(100vh - 300px);
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 14px 25px;
            margin: 5px 15px;
            border-radius: 10px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            position: relative;
        }

        .sidebar.collapsed .nav-link {
            padding: 14px;
            margin: 5px 15px;
            justify-content: center;
        }

        .sidebar.collapsed .nav-link span {
            position: absolute;
            opacity: 0;
            width: 0;
            overflow: hidden;
        }
        
        .nav-link:hover {
            background: rgba(93, 63, 211, 0.3);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .sidebar.collapsed .nav-link:hover,
        .sidebar.collapsed .nav-link.active {
            transform: translateX(0);
        }
        
        .nav-link i {
            width: 22px;
            font-size: 1.1rem;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-link span {
            transition: opacity 0.3s ease;
            white-space: nowrap;
        }
        
        /* Tooltip pour mode collapsed */
        .sidebar.collapsed .nav-link::before {
            content: attr(data-title);
            position: absolute;
            left: calc(100% + 15px);
            padding: 8px 14px;
            background: var(--sidebar-color);
            color: white;
            border-radius: 8px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
            z-index: 1051;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .sidebar.collapsed .nav-link::after {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: var(--sidebar-color);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .nav-link:hover::before,
        .sidebar.collapsed .nav-link:hover::after {
            opacity: 1;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 25px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }
        
        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Top Bar */
        .top-bar {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title h2 {
            color: var(--sidebar-color);
            margin: 0;
            font-weight: 600;
            font-size: 1.6rem;
        }

        .mobile-menu-btn {
            display: none;
            background: var(--primary-color);
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .mobile-menu-btn:hover {
            background: var(--accent-color);
            transform: scale(1.05);
        }

        .mobile-menu-btn i {
            font-size: 1.2rem;
        }
        
        .top-bar-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-dropdown {
            position: relative;
        }
        
        .user-menu-btn {
            background: var(--secondary-color);
            border: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
            border-radius: 10px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .user-menu-btn:hover {
            background: #e8e6ff;
            box-shadow: 0 2px 8px rgba(93, 63, 211, 0.15);
        }
        
        .user-avatar-sm {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .dropdown-menu {
            min-width: 220px;
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            padding: 12px 0;
            margin-top: 10px;
        }
        
        .dropdown-header {
            padding: 12px 20px;
        }

        .dropdown-header strong {
            color: var(--sidebar-color);
        }
        
        .dropdown-item {
            padding: 12px 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
            color: #555;
        }
        
        .dropdown-item:hover {
            background: var(--secondary-color);
            color: var(--primary-color);
        }

        .dropdown-item i {
            width: 18px;
        }

        /* Overlay pour mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                width: var(--sidebar-width);
                transform: translateX(-100%);
            }

            .sidebar.collapsed.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .sidebar-header .toggle-btn {
                display: none;
            }

            .top-bar {
                padding: 15px 20px;
            }

            .page-title h2 {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 15px;
            }

            .top-bar {
                padding: 12px 15px;
                flex-wrap: wrap;
            }

            .page-title h2 {
                font-size: 1.1rem;
            }

            .user-menu-btn span {
                display: none;
            }

            .sidebar {
                width: 85%;
                max-width: 300px;
            }
        }

        @media (min-width: 993px) {
            .sidebar-header .toggle-btn {
                display: flex;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="{{ $theme }}">
    <!-- Overlay pour mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <h4><i class="fas fa-chalkboard-teacher me-2"></i>Enseignant</h4>
            <button class="toggle-btn" id="desktopToggle">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>

        <div class="user-profile-sidebar">
            @if(Auth::user()->photo_path)
                <img src="{{ asset('storage/' . Auth::user()->photo_path) }}" alt="Photo" class="user-avatar">
            @else
                <div class="user-avatar" style="background: var(--primary-color); color: white;">
                    {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                </div>
            @endif
            <div class="user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
            <div class="user-role">Enseignant</div>
            @if(Auth::user()->departement)
                <small style="color: rgba(255,255,255,0.6); display: block; margin-top: 5px;">{{ Auth::user()->departement }}</small>
            @endif
        </div>
        
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}" 
                       href="{{ route('enseignant.dashboard') }}"
                       data-title="Tableau de bord">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('enseignant.upload') ? 'active' : '' }}" 
                       href="{{ route('enseignant.upload') }}"
                       data-title="Uploader document">
                        <i class="fas fa-upload"></i>
                        <span>Uploader document</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('enseignant.documents') ? 'active' : '' }}" 
                       href="{{ route('enseignant.documents') }}"
                       data-title="Mes documents">
                        <i class="fas fa-file-alt"></i>
                        <span>Mes documents</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('enseignant.matieres') ? 'active' : '' }}" 
                       href="{{ route('enseignant.matieres') }}"
                       data-title="Mes matières">
                        <i class="fas fa-book"></i>
                        <span>Mes matières</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('enseignant.statistiques') ? 'active' : '' }}" 
                       href="{{ route('enseignant.statistiques') }}"
                       data-title="Statistiques">
                        <i class="fas fa-chart-line"></i>
                        <span>Statistiques</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('enseignant.parametres') ? 'active' : '' }}" 
                       href="{{ route('enseignant.parametres') }}"
                       data-title="Paramètres">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                        @csrf
                        <a class="nav-link text-danger" 
                           href="#" 
                           onclick="event.preventDefault(); document.getElementById('logoutForm').submit();"
                           data-title="Déconnexion">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="page-title">
                <button class="mobile-menu-btn" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div>
                    <h2>@yield('page-title', 'Dashboard')</h2>
                    <small class="text-muted">@yield('page-subtitle', 'Tableau de bord enseignant')</small>
                </div>
            </div>
            
            <div class="top-bar-actions">
                <div class="user-dropdown">
                    <button class="user-menu-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->photo_path) }}" alt="Photo" class="user-avatar-sm">
                        @else
                            <div class="user-avatar-sm" style="background: var(--primary-color); color: white;">
                                {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}
                            </div>
                        @endif
                        <span>{{ Auth::user()->prenom }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="dropdown-header">
                            <strong>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</strong>
                            <div class="small text-muted">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('enseignant.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Tableau de bord
                        </a>
                        <a class="dropdown-item" href="{{ route('enseignant.parametres') }}">
                            <i class="fas fa-user-cog"></i> Mon profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu spécifique à chaque page -->
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const desktopToggle = document.getElementById('desktopToggle');
            const mobileToggle = document.getElementById('mobileToggle');
            const overlay = document.getElementById('sidebarOverlay');

            // Fonction pour fermer la sidebar mobile
            function closeMobileSidebar() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                mobileToggle.querySelector('i').className = 'fas fa-bars';
            }

            // Fonction pour ouvrir la sidebar mobile
            function openMobileSidebar() {
                sidebar.classList.add('active');
                overlay.classList.add('active');
                mobileToggle.querySelector('i').className = 'fas fa-times';
            }

            // Restaurer l'état collapsed (desktop uniquement)
            if (window.innerWidth > 992) {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                    desktopToggle.querySelector('i').className = 'fas fa-chevron-right';
                }
            }

            // Toggle desktop (bouton dans le header de la sidebar)
            if (desktopToggle) {
                desktopToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');

                    const icon = this.querySelector('i');
                    if (sidebar.classList.contains('collapsed')) {
                        icon.className = 'fas fa-chevron-right';
                        localStorage.setItem('sidebarCollapsed', 'true');
                    } else {
                        icon.className = 'fas fa-chevron-left';
                        localStorage.setItem('sidebarCollapsed', 'false');
                    }
                });
            }

            // Toggle mobile (bouton hamburger dans la top-bar)
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (sidebar.classList.contains('active')) {
                        closeMobileSidebar();
                    } else {
                        openMobileSidebar();
                    }
                });
            }

            // Fermer sidebar mobile si clic sur l'overlay
            if (overlay) {
                overlay.addEventListener('click', function() {
                    closeMobileSidebar();
                });
            }

            // Fermer sidebar mobile lors d'un clic sur un lien de navigation
            const navLinks = sidebar.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        closeMobileSidebar();
                    }
                });
            });

            // Gestion du redimensionnement de la fenêtre
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth > 992) {
                        // Mode desktop
                        closeMobileSidebar();
                        
                        // Restaurer l'état collapsed
                        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                        if (isCollapsed) {
                            sidebar.classList.add('collapsed');
                            mainContent.classList.add('expanded');
                            desktopToggle.querySelector('i').className = 'fas fa-chevron-right';
                        } else {
                            sidebar.classList.remove('collapsed');
                            mainContent.classList.remove('expanded');
                            desktopToggle.querySelector('i').className = 'fas fa-chevron-left';
                        }
                    } else {
                        // Mode mobile
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('expanded');
                    }
                }, 250);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>