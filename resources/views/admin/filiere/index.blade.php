@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/filiere/index.css') }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h3 class="fw-bold text-dark mb-0">
            <i class="bi bi-diagram-3 text-violet"></i>
            Liste des filières
        </h3>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-violet btn-sm">
                <i class="bi bi-arrow-left"></i>
                <span class="d-none d-md-inline">Retour</span>
            </a>

            <a href="{{ route('admin.filiere.create') }}" class="btn btn-violet btn-sm">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Ajouter une filière</span>
            </a>
        </div>
    </div>

    @include('admin.partials.alerts')

    {{-- FILTRES --}}
    <div class="row g-2 mb-3">
        <div class="col-md-4">
            <form method="GET">
                <select name="campus" class="form-select form-select-sm filter-select"
                        onchange="this.form.submit()">
                    <option value="">Tous les campus</option>
                    @foreach($campuses as $camp)
                        <option value="{{ $camp->id }}"
                            {{ ($campusId ?? '') == $camp->id ? 'selected' : '' }}>
                            {{ $camp->nom }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="col-md-4">
            <form method="GET">
                <select name="cursus" class="form-select form-select-sm filter-select"
                        onchange="this.form.submit()">
                    <option value="">Tous les cursus</option>
                    @foreach($cursusList as $cur)
                        <option value="{{ $cur->id }}"
                            {{ ($cursusId ?? '') == $cur->id ? 'selected' : '' }}>
                            {{ $cur->nom }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="col-md-4">
            <form method="GET">
                <select name="departement" class="form-select form-select-sm filter-select"
                        onchange="this.form.submit()">
                    <option value="">Tous les départements</option>
                    @foreach($departements as $dep)
                        <option value="{{ $dep->id }}"
                            {{ ($departementId ?? '') == $dep->id ? 'selected' : '' }}>
                            {{ $dep->nom }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    {{-- CARTES FILIÈRES --}}
    <div class="row g-3">
        @forelse($filieres as $index => $fil)

        @php
            $colors = [
                'soft-violet','soft-blue','soft-green','soft-orange','soft-teal',
                'soft-pink','soft-indigo','soft-yellow','soft-cyan','soft-lime'
            ];
            $colorClass = $colors[$index % count($colors)];

            $nom = trim($fil->nom);

    // Découper en mots
    $words = preg_split('/\s+/', $nom);

    // Récupérer les initiales des mots
    $initials = collect($words)
        ->map(fn($w) => mb_substr($w, 0, 1))
        ->implode('');

    // S'assurer entre 2 et 5 caractères
    if (mb_strlen($initials) < 2) {
        $initials = mb_strtoupper(mb_substr($nom, 0, 2));
    } elseif (mb_strlen($initials) > 5) {
        $initials = mb_strtoupper(mb_substr($initials, 0, 5));
    } else {
        $initials = mb_strtoupper($initials);
    }
        @endphp

        <div class="col-12">
            <div class="card departement-card {{ $colorClass }} border-0">

                <div class="card-body d-flex align-items-center justify-content-between">

                    {{-- GAUCHE --}}
                    <div class="d-flex align-items-center gap-3">
                        <div class="dept-logo">{{ $initials }}</div>

                        <div class="text-white">
                            <div class="fw-bold">{{ $fil->nom }}</div>
                            <div class="small opacity-75">
                                {{ $fil->departement->nom ?? '-' }} •
                                {{ $fil->departement->cursus->nom ?? '-' }}
                            </div>
                        </div>
                    </div>

                    {{-- DROITE : OPTIONS --}}
                    <div class="dropdown">
                        <button class="btn btn-sm option-btn"
                                data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical text-white"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <form method="POST"
                                      action="{{ route('admin.filiere.destroy', $fil->id) }}"
                                      onsubmit="return confirm('Supprimer cette filière ?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-trash"></i>
                                        Supprimer
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        @empty
        <div class="col-12">
            <div class="alert alert-light">
                <i class="bi bi-info-circle text-violet"></i>
                Aucune filière enregistrée.
            </div>
        </div>
        @endforelse
    </div>

</div>
@endsection
