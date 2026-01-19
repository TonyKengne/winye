<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Winye</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, rgba(128,0,128,0.08), rgba(75,0,130,0.08));
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-header {
            font-size: 1.8rem;
            font-weight: 600;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #6f42c1; /* violet */
            border-radius: 8px 0 8px 0;
            display: inline-block;
            margin-bottom: 1rem;
            
        }

        .login-card p.welcome {
            margin-bottom: 1.3rem;
            font-size: 1.1rem;
            color: #333;
        }

        .form-control {
            border: none;
            border-bottom: 2px solid #6f42c1;
            border-radius: 0;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #8c5eff;
            box-shadow: none;
        }

        .btn-login {
            background: linear-gradient(90deg, #6f42c1, #8c5eff);
            color: #fff;
            border-radius: 8px;
            border: none;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            opacity: 0.9;
            scale: 1.02;
            background: linear-gradient(90deg, #6d3dc4, #8656fe);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        .text-center a {
            color: #6f42c1;
            text-decoration: none;
            transition: color 0.3s ease, text-decoration 0.3s ease;

        }

        .text-center a:hover {
            text-decoration: underline;
            font-size: 1.05rem;
        }

        .alert {
            font-size: 0.9rem;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
            }

            .login-header {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Titre -->
        <div class="login-header">Connexion</div>

        <!-- Message de bienvenue -->
        <p class="welcome">Bienvenue sur Winye</p>

         @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <!-- Formulaire -->
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Votre email" required>
            </div>

            <!-- Mot de passe -->
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
            </div>

            <!-- Bouton connexion -->
            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-login">Se connecter</button>
            </div>

            <!-- Mot de passe oublié -->
            <div class="text-center mb-3">
                <a href="#">Mot de passe oublié ?</a>
            </div>

            <!-- Inscription -->
            <div class="text-center">
                <span>Pas de compte ? </span><a href="{{ route("register") }}">S'inscrire</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
