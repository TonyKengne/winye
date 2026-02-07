@extends('layouts.enseignant')

@section('content')
<style>
    .settings-container {
        max-width: 1100px;
        margin: auto;
        padding: 20px;
    }

    .settings-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #2c3e50;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .card {
        background: #ffffff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: 0.3s;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }

    .card h3 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #34495e;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-weight: 600;
        color: #2c3e50;
    }

    input, select {
        width: 100%;
        padding: 10px 12px;
        border-radius: 8px;
        border: 1px solid #dcdcdc;
        margin-top: 5px;
        font-size: 15px;
    }

    input:focus {
        border-color: #3498db;
        outline: none;
        box-shadow: 0 0 5px rgba(52,152,219,0.3);
    }

    .btn-primary {
        background: #3498db;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background: #2980b9;
    }

    .profile-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #3498db;
        margin-bottom: 15px;
    }

    @media(max-width: 900px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="settings-container">
    <h1 class="settings-title">⚙️ Paramètres du compte</h1>

    <div class="settings-grid">

        <!-- PROFIL -->
        <div class="card">
            <h3>Informations personnelles</h3>

            <form action="{{ route('enseignant.updateProfile') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nom complet</label>
                    <input type="text" name="name" value="{{ $user->name ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>Adresse email</label>
                    <input type="email" name="email" value="{{ $user->email ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="text" name="phone" value="{{ $user->phone ?? '' }}">
                </div>

                <button class="btn-primary">Mettre à jour</button>
            </form>
        </div>

        <!-- PHOTO DE PROFIL -->
        <div class="card">
            <h3>Photo de profil</h3>

            <center>
                <img src="{{ $user->photo ?? 'https://via.placeholder.com/120' }}" class="profile-photo">
            </center>

            <form action="{{ route('enseignant.updatePhoto') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Changer la photo</label>
                    <input type="file" name="photo" accept="image/*">
                </div>

                <button class="btn-primary">Mettre à jour la photo</button>
            </form>
        </div>

        <!-- MOT DE PASSE -->
        <div class="card">
            <h3>Changer le mot de passe</h3>

            <form action="{{ route('enseignant.updatePassword') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Mot de passe actuel</label>
                    <input type="password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label>Nouveau mot de passe</label>
                    <input type="password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="new_password_confirmation" required>
                </div>

                <button class="btn-primary">Changer le mot de passe</button>
            </form>
        </div>

        <!-- PARAMÈTRES DU COMPTE -->
        <div class="card">
            <h3>Préférences du compte</h3>

            <form action="{{ route('enseignant.updateSettings') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Langue</label>
                    <select name="language">
                        <option value="fr">Français</option>
                        <option value="en">Anglais</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Thème</label>
                    <select name="theme">
                        <option value="light">Clair</option>
                        <option value="dark">Sombre</option>
                    </select>
                </div>

                <button class="btn-primary">Enregistrer</button>
            </form>
        </div>

    </div>
</div>

@endsection
