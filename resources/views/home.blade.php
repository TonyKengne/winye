<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Plateforme WINYE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Light mode colors */
            --primary-color: #8B5FBF;
            --secondary-color: #F0E6FF;
            --accent-color: #E8D5FF;
            --text-dark: #4A4453;
            --text-light: #7A6F8C;
            --success-color: #8BC34A;
            --shadow: 0 4px 15px rgba(139, 95, 191, 0.08);
            --gradient-primary: linear-gradient(135deg, #8B5FBF 0%, #A685E2 100%);
            --gradient-light: linear-gradient(135deg, #F9F5FF 0%, #F0E6FF 100%);
            --bg-body: #F9F5FF;
            --bg-card: #FFFFFF;
            --border-color: #E8D5FF;
        }
        
        [data-theme="dark"] {
            /* Dark mode colors */
            --primary-color: #A685E2;
            --secondary-color: #2D2438;
            --accent-color: #3D3148;
            --text-dark: #E8E8E8;
            --text-light: #B8B8C8;
            --success-color: #9CCC65;
            --shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            --gradient-primary: linear-gradient(135deg, #8B5FBF 0%, #A685E2 100%);
            --gradient-light: linear-gradient(135deg, #1A1625 0%, #2D2438 100%);
            --bg-body: #1A1625;
            --bg-card: #251E30;
            --border-color: #3D3148;
        }
        
        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        /* Navigation */
        .navbar {
            background: var(--bg-card);
            box-shadow: var(--shadow);
            padding: 15px 0;
            transition: background-color 0.3s ease;
        }
        
        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: 700;
            font-size: 1.6rem;
        }
        
        .nav-link {
            color: var(--text-dark) !important;
            margin: 0 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 16px !important;
            border-radius: 8px;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: var(--secondary-color);
            color: var(--primary-color) !important;
        }
        
        /* Theme Toggle Button */
        .theme-toggle {
            background: var(--secondary-color);
            border: 2px solid var(--border-color);
            color: var(--text-dark);
            border-radius: 50px;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 10px;
        }
        
        .theme-toggle:hover {
            background: var(--primary-color);
            color: white;
            transform: rotate(180deg);
        }
        
        /* Hero Section */
        .hero {
            background: var(--gradient-light);
            padding: 80px 20px;
            text-align: center;
            border-radius: 20px;
            margin: 40px 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }
        
        .hero h1 {
            color: var(--primary-color);
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .hero p {
            color: var(--text-light);
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }
        
        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .stat-card {
            background: var(--bg-card);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(139, 95, 191, 0.15);
        }
        
        .stat-card i {
            font-size: 2.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 10px;
        }
        
        .stat-card h3 {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            margin: 10px 0;
        }
        
        .stat-card p {
            color: var(--text-light);
            margin: 0;
        }
        
        /* Filtres Section */
        .filters-section {
            background: var(--bg-card);
            padding: 35px;
            border-radius: 18px;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
            border: 1px solid var(--border-color);
        }
        
        .filters-section h2 {
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 600;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .form-group label {
            color: var(--text-dark);
            font-weight: 500;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            background: var(--bg-card);
            color: var(--text-dark);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(139, 95, 191, 0.15);
            background: var(--bg-card);
            color: var(--text-dark);
        }
        
        /* Boutons */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 95, 191, 0.25);
        }
        
        .btn-secondary {
            background: var(--secondary-color);
            border: 2px solid var(--border-color);
            color: var(--text-dark);
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: var(--accent-color);
            color: var(--text-dark);
        }
        
        /* Sujets Grid */
        .sujets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }
        
        .sujet-card {
            background: var(--bg-card);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            transition: all 0.4s ease;
        }
        
        .sujet-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(139, 95, 191, 0.15);
        }
        
        .sujet-header {
            background: var(--gradient-primary);
            color: white;
            padding: 22px;
            position: relative;
        }
        
        .sujet-header h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: var(--success-color);
            margin-top: 10px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-block;
        }
        
        .badge-type {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            margin-left: 10px;
        }
        
        .sujet-body {
            padding: 22px;
        }
        
        .sujet-body p {
            margin-bottom: 10px;
            color: var(--text-dark);
            display: flex;
            justify-content: space-between;
        }
        
        .sujet-body strong {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .sujet-footer {
            padding: 18px 22px;
            background-color: var(--secondary-color);
            border-top: 1px solid var(--border-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-outline-primary:hover {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--primary-color);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            grid-column: 1 / -1;
            background: var(--bg-card);
            border-radius: 15px;
            border: 2px dashed var(--border-color);
        }
        
        .empty-state i {
            font-size: 3.5rem;
            color: var(--border-color);
            margin-bottom: 20px;
        }
        
        .empty-state p {
            color: var(--text-light);
            font-size: 1.1rem;
        }
        
        /* Section titre */
        .section-title {
            color: var(--primary-color);
            text-align: center;
            margin: 50px 0 35px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }
        
        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 30px;
        }
        
        .pagination .page-link {
            background: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-dark);
            margin: 0 3px;
            border-radius: 8px;
        }
        
        .pagination .page-link:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .pagination .page-item.active .page-link {
            background: var(--gradient-primary);
            border-color: var(--primary-color);
        }
        
        /* Footer */
        footer {
            background: var(--bg-card);
            color: var(--text-dark);
            padding: 50px 0 30px;
            margin-top: 70px;
            border-top: 1px solid var(--border-color);
        }
        
        footer a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        footer a:hover {
            color: var(--text-dark);
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 25px;
        }
        
        .copyright {
            color: var(--text-light);
            font-size: 0.95rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .sujets-grid {
                grid-template-columns: 1fr;
            }
            
            .filters-section {
                padding: 25px;
            }
            
            .hero {
                padding: 50px 20px;
                margin: 20px 0;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
        }
        
        /* Animation subtile */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .sujet-card {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .sujet-card:nth-child(2) { animation-delay: 0.05s; }
        .sujet-card:nth-child(3) { animation-delay: 0.1s; }
        .sujet-card:nth-child(4) { animation-delay: 0.15s; }
        .sujet-card:nth-child(5) { animation-delay: 0.2s; }
        .sujet-card:nth-child(6) { animation-delay: 0.25s; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-book me-2"></i>WINYE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto d-flex align-items-center">
                    <a class="nav-link active" href="/">Accueil</a>
                    
                    @guest
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Se connecter
                        </a>
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>S'inscrire
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Tableau de bord
                        </a>
                        <a class="nav-link" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                    
                    <button class="theme-toggle" id="themeToggle" title="Changer le thème">
                        <i class="fas fa-moon" id="themeIcon"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container mt-2">
        <!-- Hero Section -->
        <div class="hero">
            <h1>Plateforme de Recueil des Anciens Sujets</h1>
            <p>Accédez à une vaste collection de sujets d'examen organisés pour vos révisions</p>
        </div>

        <!-- Statistiques -->
        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-file-alt"></i>
                <h3>{{ $stats['total_sujets'] ?? 0 }}</h3>
                <p>Sujets disponibles</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-graduation-cap"></i>
                <h3>{{ $stats['total_filieres'] ?? 0 }}</h3>
                <p>Filières</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-book"></i>
                <h3>{{ $stats['total_matieres'] ?? 0 }}</h3>
                <p>Matières</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-calendar"></i>
                <h3>{{ $stats['annees_count'] ?? 0 }}</h3>
                <p>Années académiques</p>
            </div>
        </div>

        <!-- Filtres de recherche -->
        <div class="filters-section">
            <h2><i class="fas fa-search me-2"></i>Rechercher des sujets</h2>
            <form method="GET" action="{{ route('home') }}" class="filters-form">
                <div class="form-grid">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Année Académique</label>
                        <select name="annee" class="form-control">
                            <option value="">Toutes les années</option>
                            @foreach($annees_disponibles as $annee)
                                <option value="{{ $annee }}" {{ request('annee') == $annee ? 'selected' : '' }}>
                                    {{ $annee }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-calendar"></i> Semestre</label>
                        <select name="semestre" class="form-control">
                            <option value="">Tous les semestres</option>
                            @for($i = 1; $i <= 7; $i++)
                                <option value="{{ $i }}" {{ request('semestre') == $i ? 'selected' : '' }}>
                                    Semestre {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-layer-group"></i> Filière</label>
                        <select name="filiere_id" class="form-control" id="filiere-select">
                            <option value="">Toutes les filières</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}" {{ request('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                    {{ $filiere->nom }} ({{ $filiere->niveau->nom ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-book"></i> Matière</label>
                        <select name="matiere_id" class="form-control">
                            <option value="">Toutes les matières</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-clipboard"></i> Type</label>
                        <select name="type" class="form-control">
                            <option value="">Tous les types</option>
                            <option value="CC" {{ request('type') == 'CC' ? 'selected' : '' }}>CC (Contrôle Continu)</option>
                            <option value="TD_TP" {{ request('type') == 'TD_TP' ? 'selected' : '' }}>TD/TP</option>
                            <option value="EXAMEN" {{ request('type') == 'EXAMEN' ? 'selected' : '' }}>Examen</option>
                            <option value="RATTRAPAGE" {{ request('type') == 'RATTRAPAGE' ? 'selected' : '' }}>Rattrapage</option>
                        </select>
                    </div>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i> Rechercher
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-redo me-2"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        <!-- Résultats des sujets -->
        <h2 class="section-title">
            Sujets Disponibles
            @if($sujets->total() > 0)
                <span class="badge bg-primary ms-2">{{ $sujets->total() }} résultat(s)</span>
            @endif
        </h2>
        
        <div class="sujets-grid">
            @forelse($sujets as $sujet)
                <div class="sujet-card">
                    <div class="sujet-header">
                        <h3>
                            {{ $sujet->titre }}
                            <span class="badge-type">{{ $sujet->type }}</span>
                        </h3>
                        @if($sujet->corriges->where('statut', 'valide')->count() > 0)
                            <span class="badge-success">
                                <i class="fas fa-check-circle me-1"></i>Corrigé disponible
                            </span>
                        @endif
                    </div>
                    <div class="sujet-body">
                        <p><strong>Année:</strong> <span>{{ $sujet->annee_academique }}</span></p>
                        <p><strong>Semestre:</strong> <span>S{{ $sujet->semestre }}</span></p>
                        <p><strong>Matière:</strong> <span>{{ $sujet->matiere->nom }}</span></p>
                        @foreach($sujet->matiere->filieres as $filiere)
                            <p><strong>Filière:</strong> <span>{{ $filiere->nom }}</span></p>
                            @break
                        @endforeach
                        @if($sujet->session)
                            <p><strong>Session:</strong> <span>{{ $sujet->session }}</span></p>
                        @endif
                    </div>
                    <div class="sujet-footer">
                        @auth
                            <a href="{{ route('etudiant.sujet.show', $sujet->id) }}" class="btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>Consulter
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-outline-primary">
                                <i class="fas fa-lock me-2"></i>Se connecter pour consulter
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Aucun sujet disponible avec ces critères</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left me-2"></i>Voir tous les sujets
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($sujets->hasPages())
            <div class="d-flex justify-content-center">
                {{ $sujets->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-links">
                <a href="/about">À propos</a>
                <a href="/contact">Contact</a>
                <a href="#">Mentions légales</a>
                <a href="#">Confidentialité</a>
            </div>
            <div class="text-center">
                <p class="copyright">&copy; {{ date('Y') }} Plateforme WINYE. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts personnalisés -->
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        // Charger le thème sauvegardé
        const currentTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', currentTheme);
        updateThemeIcon(currentTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });

        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }

        // Animation au survol des cartes
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.sujet-card, .stat-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>