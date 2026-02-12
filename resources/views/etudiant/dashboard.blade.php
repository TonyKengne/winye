@extends('layouts.etudiant')

@section('content')

@if($needsFiliere)
    <div class="dashboard-blur">
@endif

<div class="container my-5">

    <div class="text-center mb-5">
        <h2 class="fw-bold text-violet">
            <i class="bi bi-mortarboard-fill me-2"></i>
            Tableau de bord académique
        </h2>
        <p class="text-muted">Accédez à vos matières et sujets disponibles</p>
    </div>
    {{-- Messages flash --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif


    {{-- ================= MATIERES ================= --}}
    <div class="row g-3">

        @foreach($matieres as $matiere)
        <div class="col-12">

            <div class="card matiere-card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    {{-- Carte principale matière --}}
                    <button class="btn btn-light w-100 text-start fw-bold matiere-toggle"
                            data-bs-toggle="collapse"
                            data-bs-target="#matiere{{ $matiere->id }}">
                        <i class="bi bi-book me-2"></i>
                        {{ $matiere->nom }} - <span class="small text-muted">Code: {{ $matiere->code }} | Semestre: {{ $matiere->semestre }}</span>
                    </button>

                    {{-- Contenu caché : types, sessions, sujets --}}
                    <div class="collapse mt-3" id="matiere{{ $matiere->id }}">

                        @foreach($matiere->sujets->groupBy('type') as $type => $sujetsParType)
                            <div class="card type-card mb-3 p-3">

                                <button class="btn btn-outline-secondary w-100 text-start fw-semibold type-toggle"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#type{{ $matiere->id }}{{ Str::slug($type) }}">
                                    {{ ucfirst($type) }}
                                </button>

                                <div class="collapse mt-2" id="type{{ $matiere->id }}{{ Str::slug($type) }}">
                                    @foreach($sujetsParType->groupBy('session') as $session => $sujets)
                                        <div class="card session-card p-2 mb-2">

                                            <h6 class="fw-bold text-violet mb-2">
                                                {{ ucfirst($session) }}
                                            </h6>

                                            @foreach($sujets as $sujet)
                                                <div class="sujet-item d-flex justify-content-between align-items-center mb-2">

                                                    <span class="small">{{ $sujet->titre }}</span>

                                                    <div class="d-flex gap-2">

                                                        <a href="{{ route('sujets.voir', $sujet->id) }}" class="btn btn-violet">Voir</a>

                                                        @if($sujet->corrige)
                                                            <a href="{{ route('corriges.voir', $sujet->corrige->id) }}" class="btn btn-outline-success">Corrigé</a>
                                                        @else
                                                            <span class="btn btn-outline-danger">Pas de corrigé</span>
                                                        @endif

                                                        <form method="POST" action="{{ route('favoris.ajouter', $sujet->id) }}">
    @csrf
    <button class="btn btn-outline-warning">
        <i class="bi bi-star{{ $sujet->favoris->where('utilisateur_id', session('compte_utilisateur_id'))->count() ? '-fill text-danger' : '' }}"></i>
    </button>
</form>


                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>
        @endforeach

    </div>
</div>

@if($needsFiliere)
    </div>

    <div class="onboarding-overlay d-flex justify-content-center align-items-center">
        <div class="card shadow p-4 text-center" style="width: 500px;">
            <h3 class="fw-bold mb-3 text-violet">Complétez votre inscription</h3>
            <p class="text-muted mb-4">Veuillez renseigner votre filière pour accéder aux matières.</p>

            <a href="{{ route('inscription.filiere') }}" class="btn btn-violet btn-lg">
                Déterminer ma filière
            </a>
        </div>
    </div>
@endif

@endsection

@push('styles')
<style>
.text-violet { color: #6f42c1; }

.btn-violet {
    background-color: #6f42c1;
    color: white;
}
.btn-violet:hover { background-color: #5a34a8; }

.btn-outline-violet {
    border: 1px solid #6f42c1;
    color: #6f42c1;
}
.btn-outline-violet:hover { background-color: #6f42c1; color: white; }

.matiere-card, .type-card, .session-card {
    transition: all 0.3s ease;
}
.matiere-card:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(111,66,193,0.2); }

.type-card { border-radius: 12px; background: #f4f1fc; }
.session-card { border-radius: 10px; background: #f8f6fc; }

.dashboard-blur { filter: blur(4px); pointer-events: none; }

.onboarding-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100vh;
    background: rgba(255,255,255,0.85);
    z-index: 2000;
}
</style>
@endpush
