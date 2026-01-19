@extends('layouts.admin')

@section('content')

<style>
/* Couleur primaire violet à 15% pour les cartes et sections */
.card, .text-center {
    background-color: rgba(111, 66, 193, 0.15); /* #6f42c1 à 15% */
}

/* Fond blanc principal */
body, .card-body {
    background-color: #ffffff;
}

/* Boutons principaux */
.btn-primary {
    background-color: #6f42c1;
    border-color: #6f42c1;
    color: #fff;
}

/* Boutons Modifier */
.btn-outline-secondary {
    color: #6f42c1;
    border-color: #6f42c1;
    background-color: transparent;
    transition: all 0.3s;
}
.btn-outline-secondary:hover {
    background-color: #6f42c1;
    color: #fff;
    border-color: #6f42c1;
}

/* Boutons rouges pour actions d’alerte */
.btn-danger {
    background-color: white;
    border-color: #dc3545;
    color: #dc3545;
}

/* Inputs */
.form-control:focus {
    border-color: #6f42c1;
    box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
}

/* Icônes et petits éléments */
.bi {
    color: #6f42c1;
}
</style>
{{-- Messages de succès --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Messages d'erreur --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- PHOTO PROFIL --}}
<div class="text-center mb-4">
    <img 
        id="previewPhoto"
        src="{{ $utilisateur->photo_profil 
                ? asset('storage/'.$utilisateur->photo_profil) 
                : asset('images/default-avatar.png') }}"
        class="rounded-circle shadow mb-2"
        width="120"
        height="120"
        style="object-fit: cover;"
    >

    <form method="POST" action="{{ route('profil.update.photo') }}" enctype="multipart/form-data">
        @csrf
        <input 
            type="file" 
            name="photo" 
            class="form-control mt-2"
            accept="image/*"
            onchange="previewImage(event)"
        >
        <button class="btn btn-sm btn-primary mt-2">
            Mettre à jour la photo
        </button>
    </form>
</div>

{{-- CARTE INFOS PERSONNELLES --}}
<div class="card mb-4 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Informations personnelles</span>
        <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center" onclick="toggleEdit('infosForm')">
            <i class="bi bi-pencil"></i>
            <span class="ms-1 d-none d-md-inline">Modifier</span>
        </button>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('profil.update.informations') }}" id="infosForm">
            @csrf @method('PUT')
            <input name="nom" value="{{ $utilisateur->nom }}" class="form-control mb-2" disabled>
            <input name="prenom" value="{{ $utilisateur->prenom }}" class="form-control mb-2" disabled>
            <input type="date" name="date_naissance" class="form-control mb-2"value="{{ \Carbon\Carbon::parse($utilisateur->date_naissance)->format('Y-m-d') }}"disabled>
            <input name="telephone" value="{{ $utilisateur->telephone }}" class="form-control mb-2" placeholder="Téléphone" disabled>
            <button class="btn btn-success btn-sm" disabled>Enregistrer</button>
        </form>
    </div>
</div>

{{-- CARTE MOT DE PASSE --}}
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Sécurité</span>
        <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center" onclick="toggleEdit('passwordForm')">
            <i class="bi bi-pencil"></i>
            <span class="ms-1 d-none d-md-inline">Modifier</span>
        </button>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('profil.update.password') }}" id="passwordForm">
            @csrf @method('PUT')
            <input type="password" name="password_actuel" class="form-control mb-2" placeholder="Mot de passe actuel" disabled>
            <input type="password" name="password" class="form-control mb-2" placeholder="Nouveau mot de passe" disabled>
            <input type="password" name="password_confirmation" class="form-control mb-2" placeholder="Confirmation" disabled>
            <button class="btn btn-danger btn-sm" disabled>Changer</button>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('previewPhoto').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

/* Fonction pour activer les inputs lors du clic sur Modifier */
function toggleEdit(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input');
    const button = form.querySelector('button');

    inputs.forEach(input => input.disabled = false);
    button.disabled = false;
}
</script>

@endsection
