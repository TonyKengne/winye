@extends('layouts.enseignant')

@section('content')
<link rel="stylesheet" href="{{ asset('css/matiere/index.css') }}">

<style>
    :root {
        --primary-color: #6f42c1;
        --primary-light: rgba(111,66,193,.08);
    }

    /* Header buttons */
    .btn-violet {
        background: transparent;
        color: var(--primary-color);
        border: 1.5px solid var(--primary-color);
        transition: .25s ease;
    }
    .btn-violet:hover {
        background: var(--primary-color);
        color: #fff;
    }

    /* Responsive text on button */
    .btn-text {
        display: inline;
    }
    @media (max-width: 576px) {
        .btn-text {
            display: none;
        }
    }

    /* Cards */
    .sujet-card {
        border-radius: 12px;
        transition: .25s ease;
        border: none;
        background: var(--primary-light);
    }
    .sujet-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,.08);
    }

    .badge-statut {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 20px;
    }

    /* Select spacing pour éviter chevauchement */
    .filter-row .col-md-2, .filter-row .col-md-1 {
        margin-bottom: 0.5rem;
    }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-file-earmark-text text-violet"></i>
                Mes sujets
            </h3>
            <small class="text-muted">Tous les sujets que vous avez publiés</small>
        </div>

        <a href="{{ route('enseignant.sujet.create') }}" class="btn btn-violet btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-plus-lg"></i> <span class="btn-text">Ajouter un sujet</span>
        </a>
    </div>

    @include('admin.partials.alerts')

    {{-- FILTRES AVANCES --}}
    <form method="GET" class="mb-4">
        <div class="row g-2 filter-row">

            <div class="col-md-2">
                <select name="campus" class="form-select form-select-sm">
                    <option value="">Campus</option>
                    @foreach($campuses as $c)
                        <option value="{{ $c->id }}" {{ request('campus') == $c->id ? 'selected' : '' }}>{{ $c->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="cursus" class="form-select form-select-sm" disabled>
                    <option value="">Cursus</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="departement" class="form-select form-select-sm" disabled>
                    <option value="">Département</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="filiere" class="form-select form-select-sm" disabled>
                    <option value="">Filière</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="matiere" class="form-select form-select-sm" disabled>
                    <option value="">Matière</option>
                </select>
            </div>

            <div class="col-md-1">
                <select name="semestre" class="form-select form-select-sm" disabled>
                    <option value="">Semestre</option>
                    <option value="1">S1</option>
                    <option value="2">S2</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="type" class="form-select form-select-sm">
                    <option value="">Type</option>
                    @foreach(['CC','TD_TP','EXAMEN','RATTRAPAGE'] as $t)
                        <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-2">
                <select name="annee_academique" class="form-select form-select-sm">
                    <option value="">Année</option>
                    @foreach($anneesAcademiques as $a)
                        <option value="{{ $a }}" {{ request('annee_academique') == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </form>

    {{-- LISTE DES SUJETS --}}
    <div class="row g-3">
        @forelse($sujets as $sujet)
            <div class="col-12">
                <div class="card sujet-card">
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <div class="fw-bold fs-6">{{ $sujet->titre }}</div>
                            <div class="small text-muted">
                                {{ $sujet->matiere->nom ?? '-' }} • {{ $sujet->type }} • {{ $sujet->annee_academique }}
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-light text-dark badge-statut">
                                {{ ucfirst(str_replace('_',' ',$sujet->statut)) }}
                            </span>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-violet" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('enseignant.sujet.show', $sujet->id) }}">
                                            <i class="bi bi-eye me-2"></i> Voir le sujet
                                        </a>
                                    </li>

                                    @if($sujet->corrige)
                                        <li>
                                            <a class="dropdown-item text-success" href="{{ route('enseignant.corrige.show', $sujet->corrige->id) }}" target="_blank">
                                                <i class="bi bi-file-earmark-pdf me-2"></i> Voir le corrigé
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <span class="dropdown-item text-muted small">
                                                <i class="bi bi-file-earmark-x me-2"></i> Aucun corrigé
                                            </span>
                                        </li>
                                    @endif

                                    <li><hr class="dropdown-divider"></li>

                                    <li>
                                        <form method="POST" action="{{ route('enseignant.sujet.destroy', $sujet->id) }}" onsubmit="return confirm('Supprimer ce sujet ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i> Supprimer
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
                <div class="alert alert-light shadow-sm">
                    <i class="bi bi-info-circle text-primary"></i> Vous n’avez encore publié aucun sujet.
                </div>
            </div>
        @endforelse
    </div>

</div>

<script>
const campusSelect   = document.querySelector('select[name="campus"]');
const cursusSelect   = document.querySelector('select[name="cursus"]');
const deptSelect     = document.querySelector('select[name="departement"]');
const filiereSelect  = document.querySelector('select[name="filiere"]');
const semestreSelect = document.querySelector('select[name="semestre"]');
const matiereSelect  = document.querySelector('select[name="matiere"]');

const cursusData       = @json($cursuses);
const departementsData = @json($departements);
const filieresData     = @json($filieres);
const matieresData     = @json($matieres);

// Désactiver les selects tant que la sélection précédente n'est pas faite
[cursusSelect, deptSelect, filiereSelect, semestreSelect, matiereSelect].forEach(s => s.disabled = true);

// Helpers
function reset(...elements) {
    elements.forEach(e => {
        let placeholder = e.name.charAt(0).toUpperCase() + e.name.slice(1);
        if(e.name === 'semestre') placeholder = 'Semestre';
        if(e.name === 'type') placeholder = 'Type';
        if(e.name === 'annee_academique') placeholder = 'Année';
        e.innerHTML = `<option value="">${placeholder}</option>`;
        e.disabled = true;
    });
}

// Campus -> Cursus
campusSelect.addEventListener('change', () => {
    reset(cursusSelect, deptSelect, filiereSelect, semestreSelect, matiereSelect);
    if(campusSelect.value) {
        cursusSelect.disabled = false;
        cursusData.filter(c => c.campus_id == campusSelect.value)
            .forEach(c => cursusSelect.innerHTML += `<option value="${c.id}">${c.nom}</option>`);
    }
});

// Cursus -> Département
cursusSelect.addEventListener('change', () => {
    reset(deptSelect, filiereSelect, semestreSelect, matiereSelect);
    if(cursusSelect.value) {
        deptSelect.disabled = false;
        departementsData.filter(d => d.cursus_id == cursusSelect.value)
            .forEach(d => deptSelect.innerHTML += `<option value="${d.id}">${d.nom}</option>`);
    }
});

// Département -> Filière
deptSelect.addEventListener('change', () => {
    reset(filiereSelect, semestreSelect, matiereSelect);
    if(deptSelect.value) {
        filiereSelect.disabled = false;
        filieresData.filter(f => f.departement_id == deptSelect.value)
            .forEach(f => filiereSelect.innerHTML += `<option value="${f.id}">${f.nom}</option>`);
    }
});

// Filière -> Semestre
filiereSelect.addEventListener('change', () => {
    reset(semestreSelect, matiereSelect);
    if(filiereSelect.value) {
        semestreSelect.disabled = false;
    }
});

// Semestre -> Matière
semestreSelect.addEventListener('change', () => {
    reset(matiereSelect);
    if(semestreSelect.value && filiereSelect.value) {
        matiereSelect.disabled = false;
        matieresData.forEach(m => {
            if (m.semestre == semestreSelect.value && m.filieres.some(f => f.id == filiereSelect.value)) {
                matiereSelect.innerHTML += `<option value="${m.id}">${m.nom}</option>`;
            }
        });
    }
});
</script>
@endsection
