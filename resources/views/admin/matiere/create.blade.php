@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/matiere/create.css') }}">

<div class="container-fluid">

    {{-- TITRE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-journal-plus text-violet"></i>
            Nouvelle matière
        </h3>
        <a href="{{ route('admin.matiere.index') }}" class="btn btn-outline-violet btn-sm">
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
            <form method="POST" action="{{ route('admin.matiere.store') }}">
                @csrf

                {{-- CAMPUS --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Campus</label>
                    <select id="campusSelect" name="campus_id" class="form-select" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($campuses as $c)
                            <option value="{{ $c->id }}">{{ $c->nom }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- CURSUS --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Cursus</label>
                    <select id="cursusSelect" name="cursus_id" class="form-select" disabled required></select>
                </div>

                {{-- DEPARTEMENT --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Département</label>
                    <select id="departementSelect" name="departement_id" class="form-select" disabled required></select>
                </div>

                {{-- MODE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Créer la matière par</label>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mode"
                               value="filiere" id="modeFiliere" checked>
                        <label class="form-check-label">Filière</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mode"
                               value="niveau" id="modeNiveau">
                        <label class="form-check-label">Niveau</label>
                    </div>
                </div>

                {{-- FILIERE --}}
                <div class="mb-3" id="blockFiliere">
                    <label class="form-label fw-semibold">Filière</label>
                    <select id="filiereSelect" name="filiere_id" class="form-select" disabled></select>
                </div>

                {{-- NIVEAU --}}
                <div class="mb-3 d-none" id="blockNiveau">
                    <label class="form-label fw-semibold">Niveau</label>
                    <select id="niveauSelect" name="niveau_id" class="form-select">
                        <option value="">-- Sélectionner --</option>
                        @foreach($niveaux as $n)
                            <option value="{{ $n->id }}">{{ $n->nom }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- APERÇU FILIERES --}}
                <div class="mb-3 d-none" id="blockApercu">
                    <label class="form-label fw-semibold">Filières concernées</label>
                    <ul class="list-group small" id="apercuFilieres"></ul>
                </div>

                {{-- SEMESTRE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Semestre</label>
                    <select name="semestre" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="1">Semestre 1</option>
                        <option value="2">Semestre 2</option>
                    </select>
                </div>

                {{-- CODE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Code matière</label>
                    <input type="text" name="code" class="form-control" required>
                </div>

                {{-- NOM --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom matière</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>

                {{-- ACTIONS --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.matiere.index') }}" class="btn btn-outline">Annuler</a>
                    <button class="btn btn-violet">Enregistrer</button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
/* =========================
   RÉFÉRENCES
========================= */
const campusSelect     = document.getElementById('campusSelect');
const cursusSelect     = document.getElementById('cursusSelect');
const deptSelect       = document.getElementById('departementSelect');
const filiereSelect    = document.getElementById('filiereSelect');
const niveauSelect     = document.getElementById('niveauSelect');

const blockFiliere     = document.getElementById('blockFiliere');
const blockNiveau      = document.getElementById('blockNiveau');
const blockApercu      = document.getElementById('blockApercu');
const apercuList       = document.getElementById('apercuFilieres');

/* =========================
   DONNÉES PASSÉES DE PHP
========================= */
const filieresData = @json($filieres);
const departementsData = @json($departements);
const cursusData = @json($cursuses);

/* =========================
   CAMPUS → CURSUS
========================= */
campusSelect.addEventListener('change', function() {
    cursusSelect.innerHTML = '<option value="">-- Sélectionner --</option>';
    deptSelect.innerHTML   = '<option value="">-- Sélectionner --</option>';
    filiereSelect.innerHTML = '<option value="">-- Sélectionner --</option>';

    cursusSelect.disabled  = true;
    deptSelect.disabled    = true;
    filiereSelect.disabled = true;

    const campusId = this.value;
    if (!campusId) return;

    // filtrer les cursus par campus
    const filteredCursus = cursusData.filter(c => c.campus_id == campusId);
    filteredCursus.forEach(c => {
        cursusSelect.innerHTML += `<option value="${c.id}">${c.nom}</option>`;
    });
    cursusSelect.disabled = false;
});

/* =========================
   CURSUS → DEPARTEMENTS
========================= */
cursusSelect.addEventListener('change', function() {
    deptSelect.innerHTML = '<option value="">-- Sélectionner --</option>';
    filiereSelect.innerHTML = '<option value="">-- Sélectionner --</option>';

    deptSelect.disabled = true;
    filiereSelect.disabled = true;

    const cursusId = this.value;
    if (!cursusId) return;

    const filteredDeps = departementsData.filter(d => d.cursus_id == cursusId);
    filteredDeps.forEach(d => {
        deptSelect.innerHTML += `<option value="${d.id}">${d.nom}</option>`;
    });
    deptSelect.disabled = false;
});

/* =========================
   DEPARTEMENT → FILIÈRES
========================= */
deptSelect.addEventListener('change', function() {
    filiereSelect.innerHTML = '<option value="">-- Sélectionner --</option>';
    filiereSelect.disabled = true;

    const deptId = this.value;
    if (!deptId) return;

    const filteredFilieres = filieresData.filter(f => f.departement_id == deptId);
    filteredFilieres.forEach(f => {
        filiereSelect.innerHTML += `<option value="${f.id}">${f.nom}</option>`;
    });
    filiereSelect.disabled = false;
});

/* =========================
   MODE FILIÈRE / NIVEAU
========================= */
document.querySelectorAll('input[name="mode"]').forEach(radio => {
    radio.addEventListener('change', function () {
        if (this.value === 'niveau') {
            blockFiliere.classList.add('d-none');
            blockNiveau.classList.remove('d-none');
            blockApercu.classList.remove('d-none');

            filiereSelect.disabled = true;
            niveauSelect.disabled = false;
            apercuList.innerHTML = '';
        } else {
            blockFiliere.classList.remove('d-none');
            blockNiveau.classList.add('d-none');
            blockApercu.classList.add('d-none');

            filiereSelect.disabled = false;
            niveauSelect.disabled = true;
            apercuList.innerHTML = '';
        }
    });
});

/* =========================
   APERÇU FILIÈRES PAR NIVEAU
========================= */
niveauSelect.addEventListener('change', function() {
    apercuList.innerHTML = '';

    if (!this.value) {
        apercuList.innerHTML = '<li class="list-group-item text-muted">Aucune filière</li>';
        return;
    }

    const niveauId = parseInt(this.value);
    const filteredFilieres = filieresData.filter(f => f.niveau_id == niveauId);

    if (filteredFilieres.length === 0) {
        apercuList.innerHTML = '<li class="list-group-item text-muted">Aucune filière trouvée</li>';
        return;
    }

    filteredFilieres.forEach(f => {
        // trouver le département de la filière
        const dep = departementsData.find(d => d.id == f.departement_id);
        apercuList.innerHTML += `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                ${f.nom}
                <span class="badge bg-light text-dark">
                    ${dep ? dep.nom : ''}
                </span>
            </li>
        `;
    });
});
</script>




@endsection
