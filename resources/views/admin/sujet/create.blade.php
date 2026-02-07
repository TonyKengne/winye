@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/matiere/create.css') }}">

{{-- STYLE LOCAL : effets violets --}}
<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 .15rem rgba(111,66,193,.25);
    }

    .form-control:hover,
    .form-select:hover {
        border-color: #6f42c1;
    }

    .card.border-violet {
        border-left: 4px solid #6f42c1;
    }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-file-earmark-plus text-violet"></i>
            Nouveau sujet
        </h3>
        <a href="{{ route('admin.sujet.index') }}" class="btn btn-outline-violet btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    {{-- ERREURS --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.sujet.store') }}"
                  enctype="multipart/form-data">
                @csrf

                {{-- =========================
                   FILTRES MATIÈRE
                ========================= --}}
                <div class="card border-violet mb-4">
                    <div class="card-body">

                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-funnel text-violet"></i>
                            Filtrer la matière
                        </h6>

                        <div class="row g-3">

                            {{-- CAMPUS --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Campus</label>
                                <select id="campusSelect" class="form-select">
                                    <option value="">-- Choisir un campus --</option>
                                    @foreach($campuses as $c)
                                        <option value="{{ $c->id }}">{{ $c->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- CURSUS --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Cursus</label>
                                <select id="cursusSelect" class="form-select">
                                    <option value="">-- Choisir un cursus --</option>
                                </select>
                            </div>

                            {{-- DEPARTEMENT --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Département</label>
                                <select id="departementSelect" class="form-select">
                                    <option value="">-- Choisir un département --</option>
                                </select>
                            </div>

                            {{-- FILIERE --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Filière</label>
                                <select id="filiereSelect" class="form-select">
                                    <option value="">-- Choisir une filière --</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- SEMESTRE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Semestre</label>
                    <select id="semestreSelect" name="semestre" class="form-select" required>
                        <option value="">-- Choisir un semestre --</option>
                        <option value="1">Semestre 1</option>
                        <option value="2">Semestre 2</option>
                    </select>
                </div>


                {{-- MATIÈRE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Matière</label>
                    <select id="matiereSelect"
                            name="matiere_id"
                            class="form-select"
                            required>
                        <option value="">-- Sélectionner une matière --</option>
                    </select>
                </div>

                <hr class="my-4">

                {{-- TITRE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Titre du sujet</label>
                    <input type="text" name="titre" class="form-control" required>
                </div>

                {{-- TYPE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Type</label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="CC">CC</option>
                        <option value="TD_TP">TD/TP</option>
                        <option value="EXAMEN">EXAM</option>
                        <option value="RATTRAPAGE">RATTRAPAGE</option>
                    </select>
                </div>

                {{-- ANNÉE ACADÉMIQUE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Année académique</label>
                    <select name="annee_academique" class="form-select" required>
                        <option value="">-- Sélectionner l'année académique --</option>
                        @foreach($anneesAcademiques as $a)
                            <option value="{{ $a }}">{{ $a }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- FICHIER --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Fichier du sujet (PDF)</label>
                    <input type="file"
                           name="fichier"
                           class="form-control"
                           accept="application/pdf"
                           required>
                </div>

                {{-- ACTIONS --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.sujet.index') }}"
                       class="btn btn-outline">
                        Annuler
                    </a>
                    <button class="btn btn-violet">
                        <i class="bi bi-save"></i> Enregistrer
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- JS pour filtrer les matières sans bloquer --}}
<script>
const campusSelect      = document.getElementById('campusSelect');
const cursusSelect      = document.getElementById('cursusSelect');
const departementSelect = document.getElementById('departementSelect');
const filiereSelect     = document.getElementById('filiereSelect');
const semestreSelect    = document.getElementById('semestreSelect');
const matiereSelect     = document.getElementById('matiereSelect');

const cursusData        = @json($cursuses);
const departementsData  = @json($departements);
const filieresData      = @json($filieres);
const matieresData      = @json($matieres);

// Helpers
function resetSelect(select, placeholder) {
    select.innerHTML = `<option value="">${placeholder}</option>`;
}

function refreshMatieres() {
    resetSelect(matiereSelect, '-- Sélectionner une matière --');

    matieresData.forEach(m => {
        let ok = true;

        // filtrer par semestre si choisi
        if (semestreSelect.value && m.semestre != semestreSelect.value) ok = false;

        // filtrer par filière si choisi
        if (filiereSelect.value) {
            ok = m.filieres.some(f => f.id == filiereSelect.value) ? ok : false;
        }

        if (ok) {
            matiereSelect.innerHTML += `<option value="${m.id}">${m.nom}</option>`;
        }
    });
}

// Événements filtrage
campusSelect.addEventListener('change', () => {
    resetSelect(cursusSelect, '-- Choisir un cursus --');
    resetSelect(departementSelect, '-- Choisir un département --');
    resetSelect(filiereSelect, '-- Choisir une filière --');

    cursusData
        .filter(c => c.campus_id == campusSelect.value)
        .forEach(c => cursusSelect.innerHTML += `<option value="${c.id}">${c.nom}</option>`);

    refreshMatieres();
});

cursusSelect.addEventListener('change', () => {
    resetSelect(departementSelect, '-- Choisir un département --');
    resetSelect(filiereSelect, '-- Choisir une filière --');

    departementsData
        .filter(d => d.cursus_id == cursusSelect.value)
        .forEach(d => departementSelect.innerHTML += `<option value="${d.id}">${d.nom}</option>`);

    refreshMatieres();
});

departementSelect.addEventListener('change', () => {
    resetSelect(filiereSelect, '-- Choisir une filière --');

    filieresData
        .filter(f => f.departement_id == departementSelect.value)
        .forEach(f => filiereSelect.innerHTML += `<option value="${f.id}">${f.nom}</option>`);

    refreshMatieres();
});

filiereSelect.addEventListener('change', refreshMatieres);
semestreSelect.addEventListener('change', refreshMatieres);

// Initialiser
refreshMatieres();
</script>

@endsection
