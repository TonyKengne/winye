@extends('layouts.enseignant')

@section('content')
<link rel="stylesheet" href="{{ asset('css/matiere/create.css') }}">

<style>
/* Focus des inputs et selects */
 :root{
        --primary-color: #6f42c1;
        --primary-light: rgba(111,66,193,.08);
        --danger-color: #dc3545;
    }
.form-control:focus,
.form-select:focus {
    border-color: #6f42c1;
    box-shadow: 0 0 0 .15rem rgba(111,66,193,.25);
}


/* Carte violet */
.card.border-violet {
    border-left: 4px solid #6f42c1;
}
* Violet */
    .btn-violet {
        background: transparent;
        color: var(--primary-color);
        border: 1.5px solid var(--primary-color);
        transition: 0.25s ease;
    }

    .btn-violet:hover {
        background: var(--primary-color);
        color: #fff;
    }

    /* Rouge Annuler */
    .btn-danger-outline {
        background: transparent;
        color: var(--danger-color);
        border: 1.5px solid var(--danger-color);
        transition: 0.25s ease;
    }

    .btn-danger-outline:hover {
        background: var(--danger-color);
        color: #fff;
    }

/* Upload stylisé */
.upload-zone {
        width: 100%; /* FULL WIDTH */
        display: block;
        border: 2px dashed var(--primary-color);
        border-radius: 8px;
        padding: 30px 15px;
        text-align: center;
        background: var(--primary-light);
        transition: 0.3s ease;
        cursor: pointer;
    }

    .upload-zone:hover {
        background: rgba(111,66,193,.15);
    }

    .upload-zone i.main-icon {
        font-size: 26px;
        color: var(--primary-color);
        margin-bottom: 8px;
        display: block;
    }

    .upload-zone .choose-file {
        display: inline-block;
        margin-top: 8px;
        padding: 6px 14px;
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
        border-radius: 6px;
        font-size: 14px;
        transition: 0.25s ease;
    }

    .upload-zone .choose-file:hover {
        background: var(--primary-color);
        color: #fff;
    }

    .upload-zone input {
        display: none;
    }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3 class="fw-bold">
            <i class="bi bi-file-earmark-check text-violet"></i>
            Ajouter un corrigé
        </h3>
        <a href="{{ route('enseignant.sujet.index') }}" class="btn btn-violet btn-sm">
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

            <form method="POST" action="{{ route('enseignant.corrige.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- =======================
                     FILTRES DE RECHERCHE
                ======================== --}}
                <div class="card border-violet mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-funnel text-primary"></i>
                            Filtrer les sujets
                        </h6>

                        <div class="row g-3">

                            <div class="col-md-3">
                                <select id="campusSelect" class="form-select">
                                    <option value="">Campus</option>
                                    @foreach($campuses as $c)
                                        <option value="{{ $c->id }}">{{ $c->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select id="cursusSelect" class="form-select">
                                    <option value="">Cursus</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select id="departementSelect" class="form-select">
                                    <option value="">Département</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select id="filiereSelect" class="form-select">
                                    <option value="">Filière</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select id="semestreSelect" class="form-select">
                                    <option value="">Semestre</option>
                                    <option value="1">Semestre 1</option>
                                    <option value="2">Semestre 2</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select id="matiereSelect" class="form-select">
                                    <option value="">Matière</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- =======================
                     SUJET
                ======================== --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Sujet concerné</label>
                    <select name="sujet_id" id="sujetSelect" class="form-select" required>
                        <option value="">-- Choisir un sujet --</option>
                    </select>
                </div>

                {{-- =======================
                     UPLOAD PDF
                ======================== --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Fichier du corrigé (PDF)</label>
                    <label class="upload-zone">
                        <i class="fas fa-inbox main-icon"></i>
                        <div>Glissez ou sélectionnez votre fichier</div>

                        <span class="choose-file">
                            <i class="fas fa-upload me-2"></i> Choisir un fichier
                        </span>
                        <br>
                        <span class="file-chosen" id="fileChosen">Aucun fichier choisi</span>

                        <input type="file" name="fichier" accept="application/pdf" required>
                    </label>
                </div>

                {{-- ACTIONS --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('enseignant.sujet.index') }}" class="btn btn-outline">
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

{{-- =======================
     JS FILTRAGE INTELLIGENT
======================= --}}
<script>
const campusSelect  = document.getElementById('campusSelect');
const cursusSelect  = document.getElementById('cursusSelect');
const deptSelect    = document.getElementById('departementSelect');
const filiereSelect = document.getElementById('filiereSelect');
const semestreSelect= document.getElementById('semestreSelect');
const matiereSelect = document.getElementById('matiereSelect');
const sujetSelect   = document.getElementById('sujetSelect');
const fileInput     = document.querySelector('input[name="fichier"]');
const fileChosen    = document.getElementById('fileChosen');

const cursuses      = @json($cursuses);
const departements  = @json($departements);
const filieres      = @json($filieres);
const matieres      = @json($matieres);
const sujets        = @json($sujets);

// Affiche le nom du fichier choisi
fileInput.addEventListener('change', () => {
    if(fileInput.files.length > 0){
        fileChosen.textContent = fileInput.files[0].name;
    } else {
        fileChosen.textContent = 'Aucun fichier choisi';
    }
});

// Reset d'un select
function reset(select, label){
    select.innerHTML = `<option value="">${label}</option>`;
}

// Rafraîchir la liste des sujets en fonction des filtres
function refreshSujets(){
    reset(sujetSelect, '-- Choisir un sujet --');

    sujets.forEach(s => {
        let ok = true;
        if(semestreSelect.value && s.semestre != semestreSelect.value) ok = false;
        if(matiereSelect.value && s.matiere_id != matiereSelect.value) ok = false;

        if(ok){
            sujetSelect.innerHTML += `
                <option value="${s.id}">
                    ${s.titre} • ${s.matiere.nom} • S${s.semestre} • ${s.annee_academique}
                </option>`;
        }
    });
}

// FILTRES EN CHAÎNE
campusSelect.onchange = () => {
    reset(cursusSelect, 'Cursus');
    cursuses.filter(c => c.campus_id == campusSelect.value)
           .forEach(c => cursusSelect.innerHTML += `<option value="${c.id}">${c.nom}</option>`);
    reset(deptSelect, 'Département'); reset(filiereSelect, 'Filière'); reset(matiereSelect, 'Matière'); refreshSujets();
};

cursusSelect.onchange = () => {
    reset(deptSelect, 'Département');
    departements.filter(d => d.cursus_id == cursusSelect.value)
               .forEach(d => deptSelect.innerHTML += `<option value="${d.id}">${d.nom}</option>`);
    reset(filiereSelect, 'Filière'); reset(matiereSelect, 'Matière'); refreshSujets();
};

deptSelect.onchange = () => {
    reset(filiereSelect, 'Filière');
    filieres.filter(f => f.departement_id == deptSelect.value)
           .forEach(f => filiereSelect.innerHTML += `<option value="${f.id}">${f.nom}</option>`);
    reset(matiereSelect, 'Matière'); refreshSujets();
};

filiereSelect.onchange = () => {
    reset(matiereSelect, 'Matière');
    matieres.filter(m => m.filieres.some(f => f.id == filiereSelect.value))
            .forEach(m => matiereSelect.innerHTML += `<option value="${m.id}">${m.nom}</option>`);
    refreshSujets();
};

semestreSelect.onchange = refreshSujets;
matiereSelect.onchange  = refreshSujets;

// Initialisation
refreshSujets();
</script>

@endsection
