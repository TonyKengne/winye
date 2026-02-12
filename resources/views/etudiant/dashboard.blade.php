@extends('layouts.etudiant')

@section('content')

{{-- Si l'étudiant n'a pas de filière, on floute le dashboard --}}
@if($needsFiliere)
    <div class="dashboard-blur">
@endif

{{-- Contenu principal du dashboard --}}
<div class="container my-5">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-5 text-center">

            <h2 class="fw-bold mb-3">
                <i class="bi bi-speedometer2 text-primary me-2"></i>
                Tableau de bord
            </h2>

            <p class="text-muted fs-5">
                Bienvenue sur votre espace étudiant 👋
            </p>

            <hr class="my-4">

            <p class="mb-3">
                Depuis cet espace, vous pouvez consulter les sujets, télécharger les corrigés,
                et suivre vos notifications.
            </p>

            {{-- Barre d’évolution placeholder (visible si besoin lors de l'inscription) --}}
            @if($needsFiliere)
                <div class="progress rounded-pill" style="height: 12px;">
                    <div class="progress-bar bg-primary" role="progressbar" 
                         style="width: 25%;" 
                         aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <small class="text-muted mt-2 d-block">
                    Progression de votre inscription
                </small>
            @endif

        </div>
    </div>

</div>

@if($needsFiliere)
    </div> {{-- fin du dashboard-flou --}}

    {{-- Overlay pour compléter l'inscription --}}
    <div class="onboarding-overlay d-flex justify-content-center align-items-center">
        <div class="card shadow p-4 text-center" style="width: 500px; height:400px;">
            <h3 class="fw-bold mb-3">Complétez votre inscription</h3>
            <p class="text-muted mb-4">
                Veuillez renseigner votre filière pour accéder au tableau de bord.

            </p>

            <a href="{{ route('inscription.filiere') }}" 
               class="btn btn-violet btn-lg">
                Déterminer mon inscription
            </a>
             <p class="text-muted mb-4">
                <i class="bi bi-info-circle-fill me-1"></i>
                Suivez les étapes pour terminer votre profil.
            </p>
        </div>
    </div>
@endif

@endsection

@push('styles')
<style>
/* Floutage du dashboard lorsque l'overlay est actif */
.dashboard-blur {
    filter: blur(4px) brightness(0.9);
    pointer-events: none;
    user-select: none;
}

/* Overlay centrée */
.onboarding-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(255,255,255,0.8);
    z-index: 2000;
}

/* Style de la carte de l'onboarding */
.onboarding-overlay .card {
    border-radius: 1rem;
}
p{
    margin-top:50px ;
}
</style>
@endpush
