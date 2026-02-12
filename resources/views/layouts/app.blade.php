<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'WINYE')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f9; }
        .navbar { background: #2c3e50; padding: 10px; color: #fff; }
        .navbar a { color: #fff; text-decoration: none; font-weight: bold; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; 
                     padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,.1); }
        h3 { margin-bottom: 20px; }
        .btn { background: #3498db; color: #fff; border: none; padding: 10px 15px; 
               border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #2980b9; }
        footer { text-align: center; margin-top: 40px; color: #777; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-primary p-2">
        <a href="{{ route('home') }}" class="navbar-brand text-white">
            <i class="fas fa-book me-2"></i> WINYE
        </a>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer class="text-center py-3 mt-4 bg-dark text-white">
        <p>&copy; {{ date('Y') }} WINYE</p>
    </footer>
</body>
</html>
