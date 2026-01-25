@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/matiere/index.css') }}">

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-journal-bookmark text-violet"></i>
            Liste des matières
        </h3>
         <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-violet btn-sm">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <a href="{{ route('admin.matiere.create') }}" class="btn btn-violet btn-sm">
                <i class="bi bi-plus-lg"></i> Ajouter une matière
            </a>
        </div>
    </div>

    @include('admin.partials.alerts')

    {{-- FILTRES --}}
    <div class="row g-2 mb-3">
        @php
            $filterCols = [
                'campus' => $campuses,
                'cursus' => $cursusList,
                'departement' => $departements,
                'niveau' => $niveaux,
                'filiere' => $filieres
            ];
        @endphp

        @foreach($filterCols as $key => $list)
            <div class="col-md-3">
                <form method="GET">
                    <select name="{{ $key }}" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">
                            @if($key == 'campus') Tous les campus
                            @elseif($key == 'cursus') Tous les cursus
                            @elseif($key == 'departement') Tous les départements
                            @elseif($key == 'niveau') Tous les niveaux
                            @else Toutes les filières @endif
                        </option>
                        @foreach($list as $item)
                            <option value="{{ $item->id }}" {{ (${ $key.'Id' } ?? '') == $item->id ? 'selected' : '' }}>
                                {{ $item->nom }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        @endforeach
    </div>

    {{-- CARTES --}}
    <div class="row g-3">
        @forelse($matieres as $index => $mat)
            @php
                $colors = [
                    'soft-violet','soft-blue','soft-green','soft-orange','soft-teal',
                    'soft-pink','soft-indigo','soft-yellow','soft-cyan','soft-lime',
                    'soft-rose','soft-purple','soft-sky','soft-emerald','soft-orange-light'
                ];
                $colorClass = $colors[$index % count($colors)];
            @endphp

            <div class="col-12">
                <div class="card {{ $colorClass }} border-0 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        {{-- INFO MATIÈRE --}}
                        <div>
                            <div class="fw-bold">{{ $mat->nom }}</div>
                            <div class="small text-white opacity-75">
                                Code : {{ $mat->code }} •
                                {{ $mat->niveau->nom ?? '-' }} •
                                Semestre {{ $mat->semestre }}
                            </div>
                        </div>

                        {{-- BADGE FILIÈRES --}}
                        <span class="badge bg-light text-dark">
                            {{ $mat->filieres->count() }} filière(s)
                        </span>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light">
                    Aucune matière enregistrée.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
