<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Plateforme Anciens Sujets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #8B5FBF; /* Violet doux */
            --secondary-color: #F0E6FF; /* Violet très clair */
            --accent-color: #E8D5FF; /* Violet pastel */
            --text-dark: #4A4453; /* Gris violet foncé */
            --text-light: #7A6F8C; /* Gris violet clair */
            --success-color: #8BC34A; /* Vert doux */
            --shadow: 0 4px 15px rgba(139, 95, 191, 0.08);
            --gradient-primary: linear-gradient(135deg, #8B5FBF 0%, #A685E2 100%);
            --gradient-light: linear-gradient(135deg, #F9F5FF 0%, #F0E6FF 100%);
        }
        
        body {
            background-color: #F9F5FF; /* Fond très clair */
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        
        /* Navigation */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(139, 95, 191, 0.1);
            padding: 15px 0;
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
        
        /* Filtres Section */
        .filters-section {
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
            border: 1px solid #E8D5FF;
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
            border: 2px solid #E8D5FF;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(139, 95, 191, 0.15);
        }
        
        /* Boutons */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 95, 191, 0.25);
        }
        
        /* Sujets Grid */
        .sujets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }
        
        .sujet-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 1px solid #E8D5FF;
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
            background-color: #F9F5FF;
            border-top: 1px solid #E8D5FF;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
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
            background: white;
            border-radius: 15px;
            border: 2px dashed #E8D5FF;
        }
        
        .empty-state i {
            font-size: 3.5rem;
            color: #E8D5FF;
            margin-bottom: 20px;
        }
        
        .empty-state p {
            color: var(--text-light);
            font-size: 1.1rem;
        }
        
        /* Features */
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 32px;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid #E8D5FF;
            transition: all 0.4s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(139, 95, 191, 0.12);
        }
        
        .feature-card i {
            font-size: 2.8rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 22px;
        }
        
        .feature-card h5 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .feature-card p {
            color: var(--text-light);
            line-height: 1.7;
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
        
        /* Footer */
        footer {
            background: white;
            color: var(--text-dark);
            padding: 50px 0 30px;
            margin-top: 70px;
            border-top: 1px solid #E8D5FF;
        }
        
        footer .container {
            max-width: 1200px;
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
        
        .sujet-card, .feature-card {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .sujet-card:nth-child(2) { animation-delay: 0.1s; }
        .sujet-card:nth-child(3) { animation-delay: 0.2s; }
        .feature-card:nth-child(2) { animation-delay: 0.1s; }
        .feature-card:nth-child(3) { animation-delay: 0.2s; }
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
                <div class="navbar-nav ms-auto">
                    <a class="nav-link active" href="/">Accueil</a>
            
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Se connecter
                    </a>
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i>S'inscrire
                    </a>
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

        <!-- Filtres de recherche -->
        <div class="filters-section">
            <h2><i class="fas fa-search me-2"></i>Rechercher des sujets</h2>
            <form method="GET" action="{{ url('/home') }}" class="filters-form">
                <div class="form-grid">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i>Année</label>
                        <select name="annee" class="form-control">
                            <option value="">Toutes les années</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-calendar"></i>Semestre</label>
                        <select name="semestre" class="form-control">
                            <option value="">Tous les semestres</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                            <option value="S4">S4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-graduation-cap"></i>Filière</label>
                        <select name="filliere_id" class="form-control">
                            <option value="">Toutes les filières</option>
                            <option value="1">Informatique</option>
                            <option value="2">Mathématiques</option>
                            <option value="3">Physique</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-book"></i>Matière</label>
                        <select name="matiere_id" class="form-control">
                            <option value="">Toutes les matières</option>
                            <option value="1">Algorithmique</option>
                            <option value="2">Base de données</option>
                            <option value="3">Programmation Web</option>
                        </select>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i> Rechercher
                    </button>
                </div>
            </form>
        </div>

        <!-- Résultats des sujets -->
        <h2 class="section-title">Sujets Disponibles</h2>
        <div class="sujets-grid">
            <div class="sujet-card">
                <div class="sujet-header">
                    <h3>Algorithmique</h3>
                    <span class="badge badge-success">
                        <i class="fas fa-check-circle me-1"></i>Corrigé disponible
                    </span>
                </div>
                <div class="sujet-body">
                    <p><strong>Année:</strong> <span>2023</span></p>
                    <p><strong>Semestre:</strong> <span>S2</span></p>
                    <p><strong>Type:</strong> <span>Examen Final</span></p>
                    <p><strong>Filière:</strong> <span>Informatique</span></p>
                </div>
                <div class="sujet-footer">
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>Consulter
                    </a>
                </div>
            </div>
            
            <div class="sujet-card">
                <div class="sujet-header">
                    <h3>Base de données</h3>
                </div>
                <div class="sujet-body">
                    <p><strong>Année:</strong> <span>2022</span></p>
                    <p><strong>Semestre:</strong> <span>S1</span></p>
                    <p><strong>Type:</strong> <span>Partiel</span></p>
                    <p><strong>Filière:</strong> <span>Informatique</span></p>
                </div>
                <div class="sujet-footer">
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>Consulter
                    </a>
                </div>
            </div>
            
            <div class="sujet-card">
                <div class="sujet-header">
                    <h3>Programmation Web</h3>
                    <span class="badge badge-success">
                        <i class="fas fa-check-circle me-1"></i>Corrigé disponible
                    </span>
                </div>
                <div class="sujet-body">
                    <p><strong>Année:</strong> <span>2023</span></p>
                    <p><strong>Semestre:</strong> <span>S3</span></p>
                    <p><strong>Type:</strong> <span>Examen Final</span></p>
                    <p><strong>Filière:</strong> <span>Informatique</span></p>
                </div>
                <div class="sujet-footer">
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>Consulter
                    </a>
                </div>
            </div>
        </div>

        <!-- Fonctionnalités -->
        <h2 class="section-title">Nos Fonctionnalités</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <i class="fas fa-search"></i>
                    <h5>Recherche Avancée</h5>
                    <p>Trouvez rapidement les sujets par année, filière, matière et semestre grâce à notre système de filtres intuitif.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <i class="fas fa-eye"></i>
                    <h5>Visualisation Directe</h5>
                    <p>Consultez tous les sujets en ligne avec notre lecteur intégré, sans besoin de téléchargement.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <i class="fas fa-users"></i>
                    <h5>Communauté Étudiante</h5>
                    <p>Échangez et collaborez avec des milliers d'étudiants à travers notre plateforme interactive.</p>
                </div>
            </div>
        </div>
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
                <p class="copyright">&copy; {{ date('Y') }} Plateforme Anciens Sujets. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts personnalisés -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation au survol des cartes
            const cards = document.querySelectorAll('.sujet-card, .feature-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Amélioration des selects
            const selects = document.querySelectorAll('select');
            selects.forEach(select => {
                select.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });
                
                select.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>