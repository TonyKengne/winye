@extends('layouts.app')

@section('title', 'Récupération du mot de passe - WINYE')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-lg w-100" style="max-width: 700px;">
        <div class="card-header bg-primary text-white text-center py-4">
            <h3 class="mb-0">
                <i class="fas fa-lock fa-2x mb-3 d-block" style="color: #ffd700;"></i>
                Récupération du mot de passe
            </h3>
            <p class="text-white-50 mb-0 mt-2">
                Veuillez renseigner vos informations pour vérifier votre identité
            </p>
        </div>
        
        <div class="card-body p-5">
            {{-- Messages flash --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <strong>Erreur(s) :</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.recover.verify') }}" class="mt-3">
                @csrf
                
                {{-- Email --}}
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-envelope me-2" style="color: var(--violet-primary);"></i>
                        Adresse email
                    </label>
                    <div class="input-group-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control" 
                               placeholder="exemple@iutfv.com" required>
                    </div>
                    <small class="text-muted">Votre email académique</small>
                </div>

                <div class="row">
                    {{-- Nom --}}
                    <div class="col-md-6 mb-4">
                        <label class="form-label">
                            <i class="fas fa-user me-2" style="color: var(--violet-primary);"></i>
                            Nom
                        </label>
                        <div class="input-group-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="nom" class="form-control" 
                                   placeholder="Votre nom" required>
                        </div>
                    </div>

                    {{-- Prénom --}}
                    <div class="col-md-6 mb-4">
                        <label class="form-label">
                            <i class="fas fa-user me-2" style="color: var(--violet-primary);"></i>
                            Prénom
                        </label>
                        <div class="input-group-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="prenom" class="form-control" 
                                   placeholder="Votre prénom" required>
                        </div>
                    </div>
                </div>

                {{-- Matricule (optionnel) --}}
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-id-card me-2" style="color: var(--violet-primary);"></i>
                        Matricule
                        <span class="badge bg-light text-dark ms-2">Optionnel</span>
                    </label>
                    <div class="input-group-icon">
                        <i class="fas fa-id-card"></i>
                        <input type="text" name="matricule" class="form-control" 
                               placeholder="20G1001 (si étudiant)">
                    </div>
                    <small class="text-muted">Requis uniquement pour les étudiants</small>
                </div>

                <hr class="my-4" style="border-top: 2px dashed #e9ecef;">

                {{-- Boutons d'action --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour
                    </a>
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-check-circle me-2"></i>
                        Vérifier mon identité
                    </button>
                </div>
            </form>

            {{-- Aide supplémentaire --}}
            <div class="mt-4 pt-3 text-center">
                <div class="bg-light p-3 rounded-3">
                    <i class="fas fa-question-circle me-1" style="color: var(--violet-primary);"></i>
                    <small class="text-muted">
                        En cas de difficulté, contactez les administrateur à 
                        <strong>fokouatony@gmail.com ou queenelvyge@gmail.com</strong>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection