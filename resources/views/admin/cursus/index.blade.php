@extends('layouts.admin')


@section('content')
 <link rel="stylesheet" href="{{ asset('css/cursus/index.css') }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
      
        {{-- TITRE --}}
        <h3 class="fw-bold text-dark mb-0">
            <i class="bi bi-diagram-3 text-violet"></i>
            Liste des cursus
        </h3>
         @include('admin.partials.alerts')
        {{-- BOUTONS (toujours à droite du titre) --}}
        <div class="d-flex gap-2 position right">
            <a href="{{ route('admin.campus.index') }}" class="btn btn-outline-violet btn-sm">
                <i class="bi bi-arrow-left"></i>
                <span class="d-none d-md-inline">Retour</span>
            </a>

            <a href="{{ route('admin.cursus.create') }}" class="btn btn-violet btn-sm">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Ajouter un cursus</span>
            </a>
        </div>
    </div>

    {{-- FILTRE CAMPUS --}}
    <div class="mb-3">
        <form method="GET" class="w-100 d-block d-md-inline-block">
            <select name="campus" class="form-select form-select-sm filter-select" onchange="this.form.submit()">
                <option value="">Tous les campus</option>
                @foreach($campuses as $camp)
                    <option value="{{ $camp->id }}" {{ ($campusId ?? '') == $camp->id ? 'selected' : '' }}>
                        {{ $camp->nom }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- CARTES --}}
    <div class="row g-4">
    @forelse ($cursus as $index => $item)
        <div class="col-xl-3 col-lg-4 col-md-6">
            @php
                $colors = ['soft-violet', 'soft-blue', 'soft-green', 'soft-orange', 'soft-teal'];
                $colorClass = $colors[$index % count($colors)];
            @endphp
            <div class="card border-0 shadow-sm h-100 cursus-card {{ $colorClass }}">
                <div class="card-body text-center text-white position-relative">
                    <h6 class="fw-bold mb-1">{{ $item->nom }}</h6>
                    <small>{{ $item->campus->nom ?? '-' }}</small>

                    {{-- DROITE : OPTIONS --}}
                    <div class="dropdown position-absolute top-0 end-0 m-2">
                        <button type="button"
                                class="btn btn-sm option-btn"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <i class="bi bi-three-dots-vertical text-white"></i>
                        </button>

                       <ul class="dropdown-menu dropdown-menu-end shadow-sm text-dark">
                            <li>
                                <form method="POST"
                                    action="{{ route('admin.cursus.destroy', $item->id) }}"
                                    onsubmit="return confirm('Supprimer ce cursus ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-trash"></i>
                                        Supprimer
                                    </button>
                                </form>
                            </li>
                        </ul>

                    </div>
                    {{-- FIN DROITE : OPTIONS --}}
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-light ">
                <i class="bi bi-info-circle text-violet"></i>
                Aucun cursus enregistré pour le moment.
            </div>
        </div>
    @endforelse
</div>


</div>

@endsection
