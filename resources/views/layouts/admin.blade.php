<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin | Winye</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
   
    <!-- CSS Admin -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-custom">
    <div class="container-fluid d-flex align-items-center">

        <!-- Menu mobile -->
        <i class="bi bi-list menu-toggle me-3" id="menuToggle"></i>

        <div class="logo-text">
            <span>W</span>inye
        </div>
         

        <div class="profile-info ms-auto">
            <span class="profile-welcome">
                Bienvenu <strong>{{ session('prenom_utilisateur', 'Admin') }} {{ session('nom_utilisateur') }}</strong>

            </span>
            <i class="bi bi-heart text-danger fs-5" title="Favoris"></i>


            <img 
                src="{{ session('photo_profil') 
                        ? asset('storage/' . session('photo_profil')) 
                        : asset('images/default-avatar.png') }}" 
                alt="Profil"
                class="profile-avatar">


            <!-- Déconnexion icône -->
            <form method="POST" action="{{ route('logout') }}" class="d-flex align-items-center">
                @csrf
                <button class="btn btn-link text-danger p-0 d-flex align-items-center">
                    <i class="bi bi-box-arrow-right fs-4 logout-icon"></i>
                    <span class="logout-text ms-1">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">W</div>
<div class="sidebar-content">
    <ul>


    {{-- PROFIL --}}
    <li>
        <a href="{{ route('profil.index') }}" class="sidebar-link">
            <i class="bi bi-person text-light"></i> Profil
        </a>
    </li>

    {{-- DASHBOARD --}}
    <li>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
            <i class="bi bi-speedometer2 text-light"></i> Tableau de bord
        </a>
    </li>
    <li> 
    <a href="{{ route('admin.sujet.validation') }}" class="sidebar-link">
        <i class="bi bi-check2-square text-light"></i> Validation des sujets
    </a>
    </li>
    <li>
    <a href="{{ route('admin.corrige.index') }}" class="sidebar-link">
        <i class="bi bi-file-earmark-check text-light"></i> Validation des corrigés
    </a>
</li>

    {{-- GESTION ACADÉMIQUE --}}
    <li class="sidebar-title text-uppercase text-light mt-3 px-3 small">
        Gestion académique
    </li>

    <li>
        <a href="{{ route('admin.campus.index') }}" class="sidebar-link">
            <i class="bi bi-building text-light"></i> Campus
        </a>
    </li>

    <li>
        <a href="{{ route('admin.cursus.index') }}" class="sidebar-link">
            <i class="bi bi-diagram-3 text-light"></i> Cursus
        </a>
    </li>

    <li>
        <a href="{{ route('admin.departement.index') }}" class="sidebar-link">
            <i class="bi bi-diagram-2 text-light"></i> Départements
        </a>
    </li>

    <li>
        <a href="{{ route('admin.filiere.index') }}" class="sidebar-link">
            <i class="bi bi-collection text-light"></i> Filières
        </a>
    </li>

    <li>
        <a href="{{ route('admin.matiere.index') }}" class="sidebar-link">
            <i class="bi bi-book text-light"></i> Matières
        </a>
    </li>
   

    <li>
        <a href="{{ route('admin.sujet.index') }}" class="sidebar-link">
            <i class="bi bi-journal-text text-light"></i> Sujets
        </a>
    </li>

    <li>
        <a href="{{ route('admin.corrige.create') }}" class="sidebar-link">
            <i class="bi bi-file-earmark-check text-light"></i> Ajouter un corrigé
        </a>
    </li>

    {{-- INSCRIPTIONS --}}
    <li class="sidebar-title text-uppercase text-light mt-3 px-3 small">
        Administration
    </li>

    <li>
        <a href="{{ route('admin.inscriptions') }}" class="sidebar-link">
            <i class="bi bi-person-check text-light"></i> Inscriptions
        </a>
    </li>

    <li>
        <a href="{{ route('notifications.index') }}" class="sidebar-link">
            <i class="bi bi-bell text-light"></i> Notifications
        </a>
    </li>

    <li>
        <a href="{{ route('admin.notifications.index') }}" class="sidebar-link">
            <i class="bi bi-send text-light"></i> Envoyer un message
        </a>
    </li>
    

   

</ul>
</div>
</div>

<!-- CONTENU -->
<div class="content">
    @yield('content')
</div>

<!-- JS -->
<script>
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });
</script>
<footer class="admin-footer">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <span class="footer-text">
            © {{ date('Y') }} Winye — Tous droits réservés
        </span>

        <span class="footer-version">
            Admin Panel v1.0
        </span>
    </div>
</footer>

</body>
</html>
