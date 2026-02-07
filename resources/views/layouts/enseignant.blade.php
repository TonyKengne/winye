{{-- resources/views/layouts/enseignant.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Enseignant')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
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
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
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
            width: var(--sidebar-width);
            transition: all 0.3s ease;
            z-index: 1000;
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
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar.collapsed .sidebar-header h4 {
            opacity: 0;
            width: 0;
        }

        .sidebar-header h4 {
            transition: opacity 0.3s ease;
            margin: 0;
        }
        
        .toggle-btn {
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
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
        }
        
        .user-profile-sidebar {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .user-profile-sidebar {
            padding: 15px 10px;
        }
        
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            margin: 0 auto 15px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .user-avatar {
            width: 45px;
            height: 45px;
            margin-bottom: 0;
        }
        
        .user-name {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .user-name {
            opacity: 0;
            height: 0;
            margin: 0;
            overflow: hidden;
        }
        
        .user-role {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .user-role {
            opacity: 0;
            height: 0;
            overflow: hidden;
        }

        .sidebar.collapsed .user-profile-sidebar small {
            opacity: 0;
            height: 0;
            overflow: hidden;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 25px;
            margin: 5px 15px;
            border-radius: 8px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-link {
            padding: 12px;
            margin: 5px 10px;
            justify-content: center;
        }

        .sidebar.collapsed .nav-link span {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }
        
        .nav-link:hover, .nav-link.active {
            background: rgba(93, 63, 211, 0.2);
            color: white;
            transform: translateX(5px);
        }

        .sidebar.collapsed .nav-link:hover,
        .sidebar.collapsed .nav-link.active {
            transform: translateX(0);
        }
        
        .nav-link i {
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-link span {
            transition: opacity 0.3s ease, width 0.3s ease;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Top Bar */
        .top-bar {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title h2 {
            color: var(--sidebar-color);
            margin: 0;
            font-weight: 600;
        }

        .page-title .btn-primary {
            display: none;
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
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .user-menu-btn:hover {
            background: var(--secondary-color);
        }
        
        .user-avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .dropdown-menu {
            min-width: 200px;
            border-radius: 10px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 10px 0;
        }
        
        .dropdown-item {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        
        .dropdown-item:hover {
            background: var(--secondary-color);
            color: var(--primary-color);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            .sidebar.active {
                margin-left: 0;
            }

            .sidebar.collapsed {
                width: var(--sidebar-width);
            }
            
            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 0;
            }
            
            .mobile-toggle {
                display: block !important;
            }

            .page-title .btn-primary {
                display: inline-block !important;
            }

            .sidebar-header .toggle-btn {
                display: none;
            }
        }

        @media (min-width: 993px) {
            .sidebar-header .toggle-btn {
                display: flex !important;
            }
        }
        
        .mobile-toggle {
            display: none;
            background: var(--primary-color);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            font-size: 1.2rem;
        }

        /* Tooltip pour les icônes en mode collapsed */
        .sidebar.collapsed .nav-link {
            position: relative;
        }

        .sidebar.collapsed .nav-link::after {
            content: attr(data-title);
            position: absolute;
            left: 100%;
            margin-left: 10px;
            padding: 8px 12px;
            background: var(--sidebar-color);
            color: white;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
            z-index: 1001;
        }

        .sidebar.collapsed .nav-link:hover::after {
            opacity: 1;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <h4><i class="fas fa-chalkboard-teacher me-2"></i>Enseignant</h4>
            <button class="toggle-btn" id="sidebarToggle">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>

        <div class="user-profile-sidebar">
            @if(Auth::user()->photo_path)
                <img src="{{ asset('storage/' . Auth::user()->photo_path) }}" alt="Photo" class="user-avatar">
            @else
                <div class="user-avatar d-flex align-items-center justify-content-center" style="background: var(--primary-color); color: white; font-size: 2rem;">
                    {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                </div>
            @endif
            <div class="user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
            <div class="user-role">Enseignant</div>
            @if(Auth::user()->departement)
                <small class="text-muted">{{ Auth::user()->departement }}</small>
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
                <!-- Bouton toggle sidebar pour mobile -->
                <button class="btn btn-primary" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <h2>@yield('page-title', 'Dashboard')</h2>
                <small class="text-muted">@yield('page-subtitle', 'Tableau de bord enseignant')</small>
            </div>
            
            <div class="top-bar-actions">
                <div class="user-dropdown">
                    <button class="user-menu-btn" type="button" data-bs-toggle="dropdown">
                        @if(Auth::user()->photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->photo_path) }}" alt="Photo" class="user-avatar-sm">
                        @else
                            <div class="user-avatar-sm d-flex align-items-center justify-content-center" style="background: var(--primary-color); color: white;">
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
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileToggle = document.getElementById('mobileToggle');

            // Restaurer l'état (desktop uniquement)
            if (window.innerWidth > 992) {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                    sidebarToggle.querySelector('i').className = 'fas fa-chevron-right';
                }
            }

            // Toggle desktop
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');

                const icon = this.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.className = 'fas fa-chevron-right';
                } else {
                    icon.className = 'fas fa-chevron-left';
                }

                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });

            // Toggle mobile
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');

                const icon = this.querySelector('i');
                if (sidebar.classList.contains('active')) {
                    icon.className = 'fas fa-times';
                } else {
                    icon.className = 'fas fa-bars';
                }
            });

            // Fermer sidebar mobile si clic à l'extérieur
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 992) {
                    if (!sidebar.contains(event.target) && !mobileToggle.contains(event.target)) {
                        sidebar.classList.remove('active');
                        mobileToggle.querySelector('i').className = 'fas fa-bars';
                    }
                }
            });

            // Reset lors du redimensionnement
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    sidebar.classList.remove('active');
                    // Restaurer l'état collapsed si nécessaire
                    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                    if (isCollapsed) {
                        sidebar.classList.add('collapsed');
                        mainContent.classList.add('expanded');
                        sidebarToggle.querySelector('i').className = 'fas fa-chevron-right';
                    } else {
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('expanded');
                        sidebarToggle.querySelector('i').className = 'fas fa-chevron-left';
                    }
                } else {
                    // En mode mobile, retirer l'état collapsed
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                    mobileToggle.querySelector('i').className = 'fas fa-bars';
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>