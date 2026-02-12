@extends('layouts.etudiant')

@section('content')
<div class="container my-5">

    {{-- Titre --}}
    <div class="text-center mb-4">
        <h3 class="fw-bold text-violet">
            <i class="bi bi-journal-check me-2"></i>
            Complétez votre inscription
        </h3>
        <p class="text-muted fs-6">
            Renseignez votre filière étape par étape pour accéder au tableau de bord.
        </p>
    </div>

    {{-- Barre de progression --}}
    <div class="progress rounded-pill mb-4" style="height: 15px;">
        <div class="progress-bar bg-violet progress-bar-striped progress-bar-animated"
             role="progressbar"
             style="width: {{ $progress }}%;"
             aria-valuenow="{{ $progress }}"
             aria-valuemin="0"
             aria-valuemax="100">
        </div>
    </div>

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-lg border-0 p-4">

                {{-- BOUTON RETOUR --}}
                @if($selectedCampus && !$selectedFiliere)
                <div class="mb-3 text-start">
                    <form method="POST" action="{{ route('inscription.filiere') }}">
                        @csrf
                        <button type="button" onclick="window.history.back()" class="btn btn-sm btn-outline-violet">
                            <i class="bi bi-arrow-left"></i> Retour
                        </button>
                    </form>
                </div>
                @endif

                {{-- CAMPUS --}}
                @if(!$selectedCampus)
                    <h5 class="fw-bold text-violet mb-3">
                        <i class="bi bi-building me-2"></i>Choisissez votre campus
                    </h5>

                    @foreach($campuses as $campus)
                    <form method="POST" action="{{ route('inscription.selectCampus', $campus->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-violet w-100 mb-2">
                            {{ $campus->nom }}
                        </button>
                    </form>
                    @endforeach
                @endif


                {{-- CURSUS --}}
                @if($selectedCampus && !$selectedCursus)
                    <h5 class="fw-bold text-violet mb-3">
                        <i class="bi bi-book me-2"></i>Choisissez votre cursus
                    </h5>

                    @foreach($cursusList as $cursus)
                    <form method="POST" action="{{ route('inscription.selectCursus', $cursus->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-violet w-100 mb-2">
                            {{ $cursus->nom }}
                        </button>
                    </form>
                    @endforeach
                @endif


                {{-- DÉPARTEMENT --}}
                @if($selectedCursus && !$selectedDepartement)
                    <h5 class="fw-bold text-violet mb-3">
                        <i class="bi bi-diagram-3 me-2"></i>Choisissez votre département
                    </h5>

                    @foreach($departements as $departement)
                    <form method="POST" action="{{ route('inscription.selectDepartement', $departement->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-violet w-100 mb-2">
                            {{ $departement->nom }}
                        </button>
                    </form>
                    @endforeach
                @endif


                {{-- NIVEAU --}}
                @if($selectedDepartement && !$selectedNiveau)
                    <h5 class="fw-bold text-violet mb-3">
                        <i class="bi bi-hierarchy-3 me-2"></i>Choisissez votre niveau
                    </h5>

                    @foreach($niveaux as $niveau)
                    <form method="POST" action="{{ route('inscription.selectNiveau', $niveau->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-violet w-100 mb-2">
                            {{ $niveau->nom }}
                        </button>
                    </form>
                    @endforeach
                @endif


                {{-- FILIÈRE --}}
                @if($selectedNiveau && !$selectedFiliere)
                    <h5 class="fw-bold text-violet mb-3">
                        <i class="bi bi-diagram-2-fill me-2"></i>Choisissez votre filière
                    </h5>

                    @foreach($filieres as $filiere)
                    <form method="POST" action="{{ route('inscription.saveFiliere') }}">
                        @csrf
                        <input type="hidden" name="filiere_id" value="{{ $filiere->id }}">
                        <button type="submit" class="btn btn-violet w-100 mb-2">
                            {{ $filiere->nom }}
                        </button>
                    </form>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
<style>:root {
    --violet-main: #6f42c1;
    --violet-light: #a084e8;
    --violet-dark: #4b2e83;
}

.text-violet {
    color: var(--violet-main);
}

.bg-violet {
    background-color: var(--violet-main) !important;
}

.btn-violet {
    background-color: var(--violet-main);
    color: #fff;
    border: none;
}

.btn-violet:hover {
    background-color: var(--violet-dark);
    color: #fff;
}

.btn-outline-violet {
    border: 1px solid var(--violet-main);
    color: var(--violet-main);
}

.btn-outline-violet:hover {
    background-color: var(--violet-main);
    color: #fff;
}
</style>
@endsection
