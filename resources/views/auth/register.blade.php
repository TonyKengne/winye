<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Winye</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #6f42c1;
            --color-primary-light: #8c5eff;
            --color-primary-dark: #5a2ea6;
            --color-bg: rgba(255,255,255,0.9);
            --color-text: #333;
            --border-radius: 8px;
            --border-radius-lg: 15px;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --font-size-base: 1rem;
            --font-size-lg: 1.2rem;
            --font-size-xl: 1.8rem;
            --letter-spacing-lg: 2px;
            --transition-speed: 0.3s;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, rgba(128,0,128,0.08), rgba(75,0,130,0.08));
            font-family: var(--font-family);
            color: var(--color-text);
            margin: 0;
            padding: 0;
        }

        .register-container {
            width: 100%;
            max-width: 700px;
            padding: var(--spacing-lg);
        }

        .register-header {
            font-size: var(--font-size-xl);
            font-weight: 600;
            letter-spacing: var(--letter-spacing-lg);
            padding-bottom: 0.5rem;
            border-bottom: 3px solid var(--color-primary);
            border-radius: var(--border-radius) 0 var(--border-radius) 0;
            display: inline-block;
            margin-bottom: var(--spacing-lg);
            color: var(--color-primary);
        }

        .info-card {
            background: var(--color-bg);
            padding: var(--spacing-lg);
            border-radius: var(--border-radius-lg);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            margin-bottom: var(--spacing-lg);
            text-align: center;
        }

        .info-card p {
            margin: 0;
            font-size: var(--font-size-lg);
            font-weight: 500;
            color: var(--color-primary-dark);
        }

        .form-card {
            background: var(--color-bg);
            padding: var(--spacing-lg);
            border-radius: var(--border-radius-lg);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .form-control {
            border: none;
            border-bottom: 2px solid var(--color-primary);
            border-radius: 0;
            box-shadow: none;
            margin-bottom: var(--spacing-md);
            transition: border-color var(--transition-speed) ease;
        }

        .form-control:focus {
            border-color: var(--color-primary-light);
            box-shadow: none;
        }
           

        .alert-success-custom {
            background: rgba(111, 66, 193, 0.1);
            border-left: 4px solid var(--color-primary);
            color: var(--color-primary-dark);
        }

        .alert-error-custom {
            background: rgba(220, 53, 69, 0.1);
            border-left: 4px solid #dc3545;
            color: #842029;
        }

        .alert ul {
            padding-left: 1.2rem;
        }

        .alert li {
            font-size: 0.9rem;
        }


        .btn-register {
            background: linear-gradient(90deg, var(--color-primary), var(--color-primary-light));
            color: #fff;
            border-radius: var(--border-radius);
            border: none;
            padding: 0.75rem 1.5rem;
            transition: all var(--transition-speed) ease;
            width: 100%;
            text-align: center;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            opacity: 0.9;
            background: linear-gradient(90deg, var(--color-primary-dark), var(--color-primary-light));
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        select.form-select:hover {
            transform: translateY(-2px);
            opacity: 0.9;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        .text-center a {
            color: var(--color-primary);
            text-decoration: none;
            transition: color var(--transition-speed) ease, text-decoration var(--transition-speed) ease;
        }

        .text-center a:hover {
            color: var(--color-primary-light);
            text-decoration: underline;
        }

        .alert {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
        }


        @media (max-width: 768px) {
            .btn-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="register-container">
        <!-- Header -->
        <div class="register-header">S'inscrire</div>

        <!-- Carte d'information -->
        <div class="info-card">
            <p>Vous êtes nouveau sur la plateforme et vous ne disposez pas d'un compte,<br>alors créez-en un dès maintenant !</p>
        </div>
        {{-- Messages de succès --}}
@if (session('success'))
    <div class="alert alert-success-custom text-center mb-3">
        {{ session('success') }}
    </div>
@endif

{{-- Message d’erreur générale --}}
@if (session('error'))
    <div class="alert alert-error-custom text-center mb-3">
        {{ session('error') }}
    </div>
@endif

{{-- Erreurs de validation --}}
@if ($errors->any())
    <div class="alert alert-error-custom mb-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        <!-- Formulaire -->
        <div class="form-card">
            <form method="POST" action="">
                @csrf
                <!-- Choix du rôle -->
                <select id="role" class="form-select mb-3" name="role">
                    <option value="etudiant" selected>Étudiant</option>
                    <option value="enseignant">Enseignant</option>
                </select>

                <!-- Champs communs -->
                <input type="text" class="form-control" name="nom" placeholder="Nom" required>
                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required >
                <input type="email" class="form-control" name="email" placeholder="Email" required>
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
                <input type="text" class="form-control" id="matricule" name="matricule" placeholder="Matricule de l'enseignant" style="display:none;">

                <div class="d-grid mt-3">
                    <button type="submit" class="btn-register">Créer mon compte</button>

                </div>
                <div class="text-center mt-3">
                     <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--color-primary);">
                     &#8592; Retour à la connexion</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const roleSelect = document.getElementById('role');
        const codeField = document.getElementById('matricule');
        

        roleSelect.addEventListener('change', function() {
            if (this.value === 'enseignant') {
                codeField.style.display = 'block';
               
            } else {
                codeField.style.display = 'none';
               
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
