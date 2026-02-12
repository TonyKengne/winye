@extends('layouts.app')

@section('title', 'Réinitialisation du mot de passe - WINYE')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-lg w-100" style="max-width: 550px;">
        <div class="card-header bg-primary text-white text-center py-4">
            <h3 class="mb-0">
                <i class="fas fa-key fa-2x mb-3 d-block" style="color: #ffd700;"></i>
                Réinitialisation du mot de passe
            </h3>
            <p class="text-white-50 mb-0 mt-2">
                Choisissez un nouveau mot de passe sécurisé
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

            <form method="POST" action="{{ route('password.reset') }}" class="mt-3">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user_id }}">

                {{-- Nouveau mot de passe --}}
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-lock me-2" style="color: var(--violet-primary);"></i>
                        Nouveau mot de passe
                    </label>
                    <div class="input-group-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="form-control" 
                               placeholder="Minimum 8 caractères" required>
                    </div>
                    <div class="password-strength mt-2">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Astuce : Utilisez des lettres, chiffres et caractères spéciaux
                        </small>
                    </div>
                </div>

                {{-- Confirmation --}}
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-lock me-2" style="color: var(--violet-primary);"></i>
                        Confirmer le mot de passe
                    </label>
                    <div class="input-group-icon">
                        <i class="fas fa-check-circle"></i>
                        <input type="password" name="password_confirmation" class="form-control" 
                               placeholder="Retapez votre mot de passe" required>
                    </div>
                </div>

                {{-- Règles de sécurité --}}
                <div class="bg-light p-3 rounded-3 mb-4">
                    <h6 class="mb-2" style="color: var(--violet-primary);">
                        <i class="fas fa-shield-alt me-2"></i>Exigences de sécurité :
                    </h6>
                    <ul class="small mb-0 ps-3">
                        <li class="mb-1">✓ Minimum 8 caractères</li>
                        <li class="mb-1">✓ Au moins une lettre majuscule</li>
                        <li class="mb-1">✓ Au moins une lettre minuscule</li>
                        <li class="mb-1">✓ Au moins un chiffre</li>
                        <li class="mb-1">✓ Au moins un caractère spécial (!@#$%^&*)</li>
                    </ul>
                </div>

                <hr class="my-4" style="border-top: 2px dashed #e9ecef;">

                {{-- Boutons d'action --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i>
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-check-circle me-2"></i>
                        Réinitialiser
                    </button>
                </div>
            </form>

            {{-- Message de sécurité --}}
            <div class="mt-4 pt-3 text-center">
                <div class="alert alert-warning bg-warning bg-opacity-10 border-0 p-3 rounded-3" 
                     style="border-left: 6px solid #ffc107 !important;">
                    <i class="fas fa-exclamation-triangle me-2" style="color: #856404;"></i>
                    <small class="text-warning-emphasis">
                        Ne partagez jamais votre mot de passe. WINYE ne vous demandera jamais vos identifiants.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript pour indicateur de force du mot de passe (optionnel) --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.querySelector('input[name="password"]');
        
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                let feedback = '';
                
                if (password.length >= 8) strength += 1;
                if (password.match(/[A-Z]/)) strength += 1;
                if (password.match(/[a-z]/)) strength += 1;
                if (password.match(/[0-9]/)) strength += 1;
                if (password.match(/[^A-Za-z0-9]/)) strength += 1;
                
                const strengthBar = document.querySelector('.password-strength');
                if (strengthBar) {
                    let color = '#dc3545';
                    let text = 'Faible';
                    
                    if (strength >= 4) {
                        color = '#28a745';
                        text = 'Fort';
                    } else if (strength >= 2) {
                        color = '#ffc107';
                        text = 'Moyen';
                    }
                    
                    strengthBar.innerHTML = `
                        <small class="d-flex align-items-center">
                            <i class="fas fa-circle me-1" style="color: ${color}; font-size: 10px;"></i>
                            Force du mot de passe : <strong class="ms-1" style="color: ${color};">${text}</strong>
                        </small>
                    `;
                }
            });
        }
    });
</script>
@endpush
@endsection