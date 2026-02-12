<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Enseignant')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Theme -->
    @if($theme === 'dark')
        <link rel="stylesheet" href="{{ asset('css/dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/light.css') }}">
    @endif

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/enseignant.css') }}">

    @stack('styles')
</head>
<body class="{{ $theme }}">

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ================= SIDEBAR ================= -->
<div id="sidebar" class="sidebar">
    
    <div class="sidebar-header">
        <h4>
            <i class="fas fa-chalkboard-teacher me-2"></i> Enseignant
            
        </h4>
        <button class="toggle-btn" id="desktopToggle">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>

    <!-- PROFIL -->
    <div class="user-profile-sidebar text-center">
        @if(session('photo_profil'))
            <img src="{{ asset('storage/' . session('photo_profil')) }}" class="user-avatar">
        @else
            <div class="user-avatar avatar-placeholder">
                {{ strtoupper(substr(session('prenom_utilisateur','E'),0,1)) }}
                {{ strtoupper(substr(session('nom_utilisateur',''),0,1)) }}
            </div>
        @endif

        <div class="user-name mt-2">
            {{ session('prenom_utilisateur','Enseignant') }}
            {{ session('nom_utilisateur') }}
        </div>

        <div class="mt-2">
            <span class="badge bg-success">Compte actif</span>
        </div>
    </div>

    <!-- MENU -->
    <ul class="nav flex-column sidebar-menu mt-4">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}"
               href="{{ route('enseignant.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Tableau de bord</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('enseignant.sujet.create') ? 'active' : '' }}"
               href="{{ route('enseignant.sujet.create') }}">
                <i class="fas fa-upload"></i>
                <span>Uploader sujet</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('enseignant.corrige.create') ? 'active' : '' }}"
               href="{{ route('enseignant.corrige.create') }}">
                <i class="fas fa-upload"></i>
                <span>Uploader corrige</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('enseignant.documents') ? 'active' : '' }}"
               href="{{ route('enseignant.sujet.index') }}">
                <i class="fas fa-file-alt"></i>
                <span>Mes documents</span>
            </a>
        </li>
        <!-- Mes matières -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('enseignant.matieres') ? 'active' : '' }}"
            href="{{ route('enseignant.notification') }}"
            data-title="Mes matières">
                <i class="fas fa-bell"></i>
                <span>Mes Notification</span>
            </a>
        </li>
        <!-- Statistiques -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('enseignant.statistiques') ? 'active' : '' }}"
            href="{{ route('enseignant.statistiques') }}"
            data-title="Statistiques">
                <i class="fas fa-chart-line"></i>
                <span>Statistiques</span>
            </a>
        </li>
        <!-- Paramètres -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('enseignant.parametres') ? 'active' : '' }}"
            href="{{ route('enseignant.parametres') }}"
            data-title="Paramètres">
                <i class="fas fa-cog"></i>
                <span>Paramètres</span>
            </a>
        </li>

        <li class="nav-item mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </li>
    </ul>
</div>

<!-- ================= MAIN CONTENT ================= -->
<div class="main-content" id="mainContent">

    <!-- TOP BAR -->
   <!-- ================= TOP BAR ================= -->
<div class="top-bar">

    <div class="top-left d-flex align-items-center">
        <button class="mobile-menu-btn me-3" id="mobileToggle">
            <i class="fas fa-bars"></i>
        </button>

        <div>
            <h2 class="mb-0">
                <div class="logo-text">
                    <span>W</span>inye 
                </div>
             </h2>
            <small class="text-muted">
                {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }}
            </small>
        </div>
    </div>

    <div class="top-right d-flex align-items-center gap-3">

        <!-- NOTIFICATION DESKTOP -->
        <a href="{{ route('enseignant.notification') }}" class="notification-bell desktop-only position-relative">
            <i class="fas fa-bell fa-lg"></i>

            @if(isset($notificationsCount) && $notificationsCount > 0)
                <span class="notification-badge">
                    {{ $notificationsCount }}
                </span>
            @endif
        </a>

        <!-- 👤 USER DROPDOWN -->
        <div class="dropdown">
            <button class="user-menu-btn" data-bs-toggle="dropdown">

                @if(session('photo_profil'))
                    <img src="{{ asset('storage/' . session('photo_profil')) }}" class="user-avatar-sm">
                @else
                    <div class="user-avatar-sm avatar-placeholder">
                        {{ strtoupper(substr(session('prenom_utilisateur','E'),0,1)) }}
                    </div>
                @endif

                <span class="username-desktop">
                    {{ session('prenom_utilisateur') }}
                </span>

                <i class="fas fa-chevron-down"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-end shadow">

                <div class="dropdown-header">
                    <strong>
                        {{ session('prenom_utilisateur') }}
                        {{ session('nom_utilisateur') }}
                    </strong>
                    <div class="small text-muted">
                        {{ session('email_utilisateur') }}
                    </div>
                </div>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ route('enseignant.parametres') }}">
                    <i class="fas fa-user-cog me-2"></i> Mon profil
                </a>

                <!--  NOTIFICATIONS MOBILE -->
                <a class="dropdown-item mobile-only position-relative" href="#">
                    <i class="fas fa-bell me-2"></i>Notifications

                    @if(isset($notificationsCount) && $notificationsCount > 0)
                        <span class="badge bg-danger ms-auto">
                            {{ $notificationsCount }}
                        </span>
                    @endif
                </a>

                <div class="dropdown-divider mobile-only"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>


    <!-- PAGE CONTENT -->
    <div class="container-fluid mt-4">
        @yield('content')
    </div>

</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('mainContent');
    const desktopToggle = document.getElementById('desktopToggle');
    const mobileToggle = document.getElementById('mobileToggle');
    const overlay = document.getElementById('sidebarOverlay');

    desktopToggle?.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('expanded');
    });

    mobileToggle?.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });

});
</script>

@stack('scripts')

</body>
</html>
