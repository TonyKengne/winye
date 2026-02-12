<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Étudiant | Winye</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/etudiant.css') }}">
</head>
<body>

<div class="page-wrapper">

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-student fixed-top">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand fw-bold" href="#">
            <span class="logo-w">W</span>inye
        </a>

        <!-- MOBILE RIGHT ELEMENTS -->
        <div class="d-lg-none d-flex align-items-center gap-3 ms-auto">

            <!-- PREMIUM -->
            <a href="#" class="premium-badge">
                <i class="bi bi-gem"></i> Premium
            </a>

            <!-- FAVORIS -->
            <a href="#">
                <i class="bi bi-heart-fill text-danger fs-5"></i>
            </a>

            <!-- DROPDOWN MOBILE -->
            <div class="dropdown">
                <button class="user-menu-btn" data-bs-toggle="dropdown">

                    @if(session('photo_profil'))
                        <img src="{{ asset('storage/' . session('photo_profil')) }}" class="user-avatar-sm">
                    @else
                        <div class="user-avatar-sm avatar-placeholder">
                            {{ strtoupper(substr(session('prenom_utilisateur','E'),0,1)) }}
                        </div>
                    @endif
                        <i class="bi bi-chevron-down dropdown-arrow"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-end shadow student-dropdown">

                    <div class="dropdown-header text-center">
                    
                        <strong>
                            {{ session('prenom_utilisateur') }}
                            {{ session('nom_utilisateur') }}
                        </strong>
                        <div class="small text-muted">
                            {{ session('email_utilisateur') }}
                        </div>
                        <div class="badge bg-dark mt-2">
                            {{ session('mode') === 'premium' ? 'Premium' : 'Standard' }}
                        </div>
                    </div>

                    <div class="dropdown-divider"></div>
                    <li>
                        <a href="{{ route('utilisateur.dashboard') }}" class="nav-link custom-link" >
                            <i class="bi bi-speedometer2 text-danger me-1"></i> Accueil
                        </a>
                    </li>

                    <a class="dropdown-item" href="{{ route('etudiant.profil') }}">
                        <i class="bi bi-person me-2"></i> Mon compte
                    </a>

                    <a class="dropdown-item" href="#">
                        <i class="bi bi-gem me-2"></i> Abonnement Premium
                    </a>

                    <a class="dropdown-item" href="{{ route('etudiant.favoris.index') }}">
                        <i class="bi bi-heart me-2 text-danger"></i> Favoris
                    </a>

                    <a class="dropdown-item" href="{{ route('etudiant.notifications.index') }}">
                        <i class="bi bi-bell me-2"></i> Notifications
                    </a>

                    <a class="dropdown-item" href="{{ route('etudiant.notifications.create') }}">
                        <i class="bi bi-envelope me-2"></i> Contacter l’administrateur
                    </a>

                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                        </button>
                    </form>

                </div>
            </div>

        </div>

        <!-- DESKTOP MENU -->
        <div class="collapse navbar-collapse">

            <!-- MESSAGE BIENVENU -->
            <span class="welcome-text ms-3 d-none d-lg-block">
                Bonjour 
                <strong>
                    {{ session('prenom_utilisateur') }} 
                    {{ session('nom_utilisateur') }}
                </strong>
            </span>

            <ul class="navbar-nav ms-auto align-items-center gap-4 d-none d-lg-flex">

                <li>
                    <a href="#" class="premium-badge">
                        <i class="bi bi-gem me-1"></i> Premium
                    </a>
                </li>
            <li>
            <a href="{{ route('utilisateur.dashboard') }}" class="nav-link custom-link" >
                <i class="bi bi-speedometer2 text-danger me-1"></i> Accueil
            </a>
          </li>


                <li>
                    <a href="{{ route('etudiant.favoris.index') }}" class="nav-link custom-link">
                        <i class="bi bi-heart-fill text-danger me-1"></i> Favoris
                    </a>
                </li>

                <li>
                    <a href="{{ route('etudiant.profil') }}" class="nav-link custom-link">
                        <i class="bi bi-person me-1"></i> Mon compte
                    </a>
                </li>

                <li>
                    <a href="{{ route('etudiant.notifications.index') }}" class="nav-link custom-link">
                        <i class="bi bi-bell me-1"></i> Notifications
                    </a>
                </li>

                <li>
                    <a href="{{ route('etudiant.notifications.create') }}" class="nav-link custom-link">
                        <i class="bi bi-envelope me-1"></i> Contact
                    </a>
                </li>

                <!-- DROPDOWN DESKTOP -->
                <li class="dropdown">
                    <button class="user-menu-btn" data-bs-toggle="dropdown">

                        @if(session('photo_profil'))
                            <img src="{{ asset('storage/' . session('photo_profil')) }}" class="user-avatar">
                        @else
                            <div class="user-avatar avatar-placeholder">
                                {{ strtoupper(substr(session('prenom_utilisateur','E'),0,1)) }}
                            </div>
                        @endif
                            <i class="bi bi-chevron-down dropdown-arrow"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end shadow student-dropdown">

                        <div class="dropdown-header text-center">
                            <strong>
                                {{ session('prenom_utilisateur') }}
                                {{ session('nom_utilisateur') }}
                            </strong>
                            <div class="small text-muted">
                                {{ session('email_utilisateur') }}
                            </div>
                        </div>

                        <div class="dropdown-divider"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                            </button>
                        </form>

                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<main class="main-content">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="student-footer">
    <div class="container text-center">
        © {{ date('Y') }} Winye — Module Étudiant
    </div>
</footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
