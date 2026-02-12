<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WINYE')</title>
    
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    {{-- Google Fonts (Poppins) --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --violet-primary: #6f42c1;
            --violet-dark: #5a32a1;
            --violet-light: #8a5fd8;
            --violet-soft: #f3e8ff;
            --violet-gradient: linear-gradient(135deg, #6f42c1 0%, #8a5fd8 100%);
            --gray-bg: #f8f9fc;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gray-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar {
            background: var(--violet-gradient) !important;
            box-shadow: 0 4px 12px rgba(111, 66, 193, 0.15);
            padding: 12px 24px;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            letter-spacing: 1px;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-brand i {
            color: #ffd700;
            text-shadow: 0 0 8px rgba(255, 215, 0, 0.5);
        }
        
        main {
            flex: 1;
            padding: 30px 20px;
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(111, 66, 193, 0.1);
            overflow: hidden;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .card-header {
            background: var(--violet-gradient) !important;
            padding: 20px;
            border-bottom: none;
        }
        
        .card-header h3 {
            font-weight: 600;
            margin: 0;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        
        .btn-primary {
            background: var(--violet-gradient);
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(111, 66, 193, 0.2);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(111, 66, 193, 0.3);
            background: linear-gradient(135deg, #5a32a1 0%, #6f42c1 100%);
        }
        
        .btn-outline-secondary {
            border: 2px solid #6c757d;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 500;
            color: #6c757d;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-2px);
        }
        
        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .form-control:focus {
            border-color: var(--violet-primary);
            box-shadow: 0 0 0 4px rgba(111, 66, 193, 0.1);
            outline: none;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        
        .col-form-label {
            font-weight: 600;
            color: #495057;
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 6px solid #28a745;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 6px solid #dc3545;
        }
        
        footer {
            background: var(--violet-gradient) !important;
            color: white;
            padding: 20px;
            margin-top: auto;
            text-align: center;
            font-weight: 400;
            letter-spacing: 0.5px;
        }
        
        .container-custom {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .input-group-icon {
            position: relative;
        }
        
        .input-group-icon i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--violet-primary);
            z-index: 10;
        }
        
        .input-group-icon input {
            padding-left: 45px;
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
        
        .card {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <i class="fas fa-book-open fa-lg"></i>
                WINYE
            </a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <p class="mb-0">
                <i class="fas fa-copyright me-1"></i> {{ date('Y') }} WINYE - Plateforme de recueil des sujets d'évaluation
            </p>
            <p class="mb-0 mt-2 small opacity-75">
                <i class="fas fa-shield-alt me-1"></i> Sécurisé par IUTFV Bandjoun
            </p>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>