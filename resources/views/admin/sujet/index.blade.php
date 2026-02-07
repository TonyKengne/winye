@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/matiere/index.css') }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-file-earmark-text text-violet"></i>
            Liste des sujets
        </h3>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-violet btn-sm">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <a href="{{ route('admin.sujet.create') }}" class="btn btn-violet btn-sm">
                <i class="bi bi-plus-lg"></i> Ajouter un sujet
            </a>
        </div>
    </div>

    @include('admin.partials.alerts')

    {{-- FILTRES AVANCÉS --}}
<form method="GET" class="mb-3">
    <div class="row g-2">

        {{-- Campus --}}
        <div class="col-md-2">
            <select name="campus" class="form-select form-select-sm">
                <option value="">Campus</option>
                @foreach($campuses as $c)
                    <option value="{{ $c->id }}" {{ request('campus') == $c->id ? 'selected' : '' }}>
                        {{ $c->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Cursus --}}
        <div class="col-md-2">
            <select name="cursus" class="form-select form-select-sm">
                <option value="">Cursus</option>
                @foreach($cursuses as $c)
                    <option value="{{ $c->id }}" {{ request('cursus') == $c->id ? 'selected' : '' }}>
                        {{ $c->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Département --}}
        <div class="col-md-2">
            <select name="departement" class="form-select form-select-sm">
                <option value="">Département</option>
                @foreach($departements as $d)
                    <option value="{{ $d->id }}" {{ request('departement') == $d->id ? 'selected' : '' }}>
                        {{ $d->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filière --}}
        <div class="col-md-2">
            <select name="filiere" class="form-select form-select-sm">
                <option value="">Filière</option>
                @foreach($filieres as $f)
                    <option value="{{ $f->id }}" {{ request('filiere') == $f->id ? 'selected' : '' }}>
                        {{ $f->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- Matière --}}
        <div class="col-md-2">
            <select name="matiere"
                    id="matiereSelect"
                    class="form-select form-select-sm"
                    {{ request()->filled('semestre') ? '' : '' }}>
                <option value="">Matière</option>
                @foreach($matieres as $m)
                    <option value="{{ $m->id }}" {{ request('matiere') == $m->id ? 'selected' : '' }}>
                        {{ $m->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Semestre --}}
        <div class="col-md-2">
            <select name="semestre" class="form-select form-select-sm">
                <option value="">Semestre</option>
                <option value="S1" {{ request('semestre') == 'S1' ? 'selected' : '' }}>Semestre 1</option>
                <option value="S2" {{ request('semestre') == 'S2' ? 'selected' : '' }}>Semestre 2</option>
            </select>
        </div>

        {{-- Type --}}
        <div class="col-md-2">
            <select name="type" class="form-select form-select-sm">
                <option value="">Type</option>
                @foreach(['CC','TD/TP','EXAM','EXAM COMPLET','RATTRAPAGE'] as $t)
                    <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>
                        {{ $t }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Année --}}
        <div class="col-md-2">
            <select name="annee_academique" class="form-select form-select-sm">
                <option value="">Année</option>
                @foreach($anneesAcademiques as $a)
                    <option value="{{ $a }}" {{ request('annee_academique') == $a ? 'selected' : '' }}>
                        {{ $a }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>
</form>


    {{-- CARTES SUJETS --}}
    <div class="row g-3">
        @forelse($sujets as $index => $sujet)

        @php
            $colors = [
                'soft-violet','soft-blue','soft-green','soft-orange',
                'soft-teal','soft-indigo','soft-cyan','soft-lime'
            ];
            $colorClass = $colors[$index % count($colors)];
        @endphp

        <div class="col-12">
            <div class="card {{ $colorClass }} border-0 departement-card">
                <div class="card-body d-flex justify-content-between align-items-center">

                    {{-- GAUCHE --}}
                    <div class="text-white">
                        <div class="fw-bold">{{ $sujet->titre }}</div>
                        <div class="small opacity-75">
                            {{ $sujet->matiere->nom ?? '-' }} •
                            {{ $sujet->type }} •
                            {{ $sujet->annee_academique }}
                        </div>
                    </div>

                    {{-- DROITE --}}
                    <div class="d-flex align-items-center gap-2">

                        <span class="badge bg-light text-dark">
                            {{ ucfirst(str_replace('_', ' ', $sujet->statut)) }}
                        </span>

                        <div class="dropdown">
                            <button class="btn btn-sm option-btn" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical text-white"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                            {{-- Voir le sujet --}}
                            <li>
                                <a class="dropdown-item"
                                href="{{ route('admin.sujet.show', $sujet->id) }}">
                                    <i class="bi bi-eye"></i> Voir le sujet
                                </a>
                            </li>

                            {{-- Voir le corrigé --}}
                            @if($sujet->corrige)
                                <li>
                                    <a class="dropdown-item text-success"
                                    href="{{ route('admin.corrige.show', $sujet->corrige->id) }}"
                                    target="_blank">
                                        <i class="bi bi-file-earmark-pdf"></i> Voir le corrigé
                                    </a>
                                </li>
                            @else
                                <li>
                                    <span class="dropdown-item text-muted small">
                                        <i class="bi bi-file-earmark-x"></i> Aucun corrigé
                                    </span>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider"></li>

                            {{-- Supprimer --}}
                            <li>
                                <form method="POST"
                                    action="{{ route('admin.sujet.destroy', $sujet->id) }}"
                                    onsubmit="return confirm('Supprimer ce sujet ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
                            </li>

                        </ul>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        @empty
        <div class="col-12">
            <div class="alert alert-light">
                <i class="bi bi-info-circle text-violet"></i>
                Aucun sujet enregistré.
            </div>
        </div>
        @endforelse
    </div>
</div>

<script>
const campusSelect   = document.getElementById('campusSelect');
const cursusSelect   = document.getElementById('cursusSelect');
const deptSelect     = document.getElementById('departementSelect');
const filiereSelect  = document.getElementById('filiereSelect');
const semestreSelect = document.getElementById('semestreSelect');
const matiereSelect  = document.getElementById('matiereSelect');

const cursusData       = @json($cursuses);
const departementsData = @json($departements);
const filieresData     = @json($filieres);
const matieresData     = @json($matieres);

campusSelect.addEventListener('change', () => {
    reset(cursusSelect, deptSelect, filiereSelect, semestreSelect, matiereSelect);
    cursusData.filter(c => c.campus_id == campusSelect.value)
        .forEach(c => cursusSelect.innerHTML += `<option value="${c.id}">${c.nom}</option>`);
    cursusSelect.disabled = !campusSelect.value;
});

cursusSelect.addEventListener('change', () => {
    reset(deptSelect, filiereSelect, semestreSelect, matiereSelect);
    departementsData.filter(d => d.cursus_id == cursusSelect.value)
        .forEach(d => deptSelect.innerHTML += `<option value="${d.id}">${d.nom}</option>`);
    deptSelect.disabled = !cursusSelect.value;
});

deptSelect.addEventListener('change', () => {
    reset(filiereSelect, semestreSelect, matiereSelect);
    filieresData.filter(f => f.departement_id == deptSelect.value)
        .forEach(f => filiereSelect.innerHTML += `<option value="${f.id}">${f.nom}</option>`);
    filiereSelect.disabled = !deptSelect.value;
});

filiereSelect.addEventListener('change', () => {
    reset(semestreSelect, matiereSelect);
    semestreSelect.disabled = !filiereSelect.value;
});

semestreSelect.addEventListener('change', () => {
    matiereSelect.innerHTML = '<option value="">Matière</option>';
    matieresData.forEach(m => {
        if (
            m.semestre == semestreSelect.value &&
            m.filieres.some(f => f.id == filiereSelect.value)
        ) {
            matiereSelect.innerHTML += `<option value="${m.id}">${m.nom}</option>`;
        }
    });
    matiereSelect.disabled = false;
});

function reset(...elements) {
    elements.forEach(e => {
        e.innerHTML = '<option value="">--</option>';
        e.disabled = true;
    });
}
</script>

@endsection
