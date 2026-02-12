@extends('layouts.enseignant')

@section('content')
<link rel="stylesheet" href="{{ asset('css/enseignant/parametre.css') }}">

<div class="settings-container">
    <h1 class="settings-title">⚙️ Paramètres du compte</h1>

    <div class="settings-grid">

        <!-- PROFIL -->
        <div class="card">
            <h3>Informations personnelles</h3>

            <form action="{{ route('enseignant.updateProfile') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nom </label>
                    <input type="text" name="nom" value="{{ $utilisateur->nom ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>Prenom</label>
                    <input type="text" name="prenom" value="{{ $utilisateur->prenom ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>Adresse email</label>
                    <input type="email" name="email" value="{{ $compte->email ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" value="{{ $utilisateur->telephone ?? '' }}">
                </div>

                <button class="btn-primary">Mettre à jour</button>
            </form>
        </div>

        <!-- PHOTO DE PROFIL -->
        <div class="card">
            <h3>Photo de profil</h3>

            <center>
            <img src="{{ $utilisateur->photo_profil ? asset('storage/'.$utilisateur->photo_profil) : 'https://via.placeholder.com/120' }}" class="profile-photo">
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
