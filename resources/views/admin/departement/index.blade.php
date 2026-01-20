@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/departement/index.css') }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">

        {{-- TITRE --}}
        <h3 class="fw-bold text-dark mb-0">
            <i class="bi bi-diagram-3 text-violet"></i>
            Liste des départements
        </h3>
        @include('admin.partials.alerts')

        {{-- BOUTONS (toujours à droite) --}}
        <div class="d-flex gap-2">
            <a href="{{ route('admin.cursus.index') }}"
               class="btn btn-outline-violet btn-sm">
                <i class="bi bi-arrow-left"></i>
                <span class="d-none d-md-inline">Retour</span>
            </a>

            <a href="{{ route('admin.departement.create') }}"
               class="btn btn-violet btn-sm">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Ajouter un département</span>
            </a>
        </div>
    </div>

    {{-- FILTRES --}}
    <div class="row g-2 mb-3">
        <div class="col-md-6">
            <form method="GET">
                <select name="campus"
                        class="form-select form-select-sm filter-select"
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

        <div class="col-md-6">
            <form method="GET">
                <select name="cursus"
                        class="form-select form-select-sm filter-select"
                        onchange="this.form.submit()">
                    <option value="">Tous les cursus</option>
                    @foreach($cursus as $cur)
                        <option value="{{ $cur->id }}"
                            {{ ($cursusId ?? '') == $cur->id ? 'selected' : '' }}>
                            {{ $cur->nom }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    {{-- CARTES --}}
 <div class="row g-3">
@forelse($departements as $index => $dep)

@php
    $colors = ['soft-violet', 'soft-blue', 'soft-green', 'soft-orange', 'soft-teal'];
    $colorClass = $colors[$index % count($colors)];

    $words = explode(' ', $dep->nom);
    $initials = strtoupper(
        collect($words)->take(2)->map(fn($w) => substr($w, 0, 1))->implode('')
    );
@endphp

<div class="col-12">
    <div class="card departement-card {{ $colorClass }} border-0">

        <div class="card-body d-flex align-items-center justify-content-between">

            {{-- GAUCHE : LOGO + INFOS --}}
            <div class="d-flex align-items-center gap-3">

                {{-- LOGO --}}
                <div class="dept-logo">
                    {{ $initials }}
                </div>

                {{-- INFOS --}}
                <div class="text-white">
                    <div class="fw-bold">
                        {{ $dep->nom }}
                    </div>
                    <div class="small opacity-75">
                        {{ $dep->cursus->nom ?? '-' }} •
                        {{ $dep->cursus->campus->nom ?? '-' }}
                    </div>
                </div>

            </div>

                    {{-- DROITE : OPTIONS --}}
            <div class="dropdown">

                <button type="button"
                        class="btn btn-sm option-btn"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                    <i class="bi bi-three-dots-vertical text-white"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm text-dark">
                    <li>
                        <form method="POST"
                            action="{{ route('admin.departement.destroy', $dep->id) }}"
                            onsubmit="return confirm('Supprimer ce département ?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="dropdown-item text-danger">
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
        Aucun département enregistré.
    </div>
</div>
@endforelse
</div>


</div>
@endsection
