<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        :root {
        --navbar-bg: #2c3e50;
        --navbar-text: #ecf0f1;
        --sidebar-bg: #f8f9fa;
        --sidebar-text: #2c3e50;
        --viewer-bg: #ffffff;
        --header-bg: #f1f1f1;
        --btn-bg: #3498db;
        --btn-text: #fff;
        --btn-hover-bg: #2980b9;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
        }

        .layout-container {
            display: flex;
            height: calc(100vh - 60px);
        }

        .sidebar {
            width: 300px;
            background: var(--sidebar-bg);
            padding: 20px;
            overflow-y: auto;
            border-right: 1px solid #ddd;
        }

        .pdf-viewer-container {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .dashboard-container {
            display: flex;
            height: calc(100vh - 60px);
        }

        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
        }

        .sidebar h5 {
            margin-bottom: 20px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 15px;
        }

        .sidebar-menu a {
            color: #ecf0f1;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar-menu a:hover {
            color: #3498db;
        }

        .dashboard-main {
            flex: 1;
            padding: 20px;
            background: #f4f6f9;
        }

        .dashboard-header {
            margin-bottom: 20px;
        }

        .dashboard-cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .sujets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .sujet-card {
            background: #fff;
            padding: 15px;
            border-radius: 6px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }

    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="/">
                <i class="fas fa-book me-2"></i>WINYE
            </a>
            <div class="d-flex align-items-center">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-home me-1"></i>Accueil
                </a>
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                </a>
                <a class="nav-link" href="{{ route('profil.index') }}">
                    <i class="fas fa-user me-1"></i>Profil
                </a>
                <a class="nav-link" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                </a>
                <button class="theme-toggle" id="themeToggle" title="Changer le thème">
                    <i class="fas fa-moon" id="themeIcon"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Layout -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h5><i class="fas fa-bars me-2"></i>Menu</h5>
            <ul class="sidebar-menu">
                <li><a href="{{ route('profil.index') }}"><i class="fas fa-user-cog me-2"></i>Paramètres</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-main">
            <div class="dashboard-header">
                <h3><i class="fas fa-tachometer-alt me-2"></i>Tableau de bord étudiant</h3>
            </div>

                        <!-- Liste des derniers sujets -->
            
        </main>
    </div>
</body>

</html>