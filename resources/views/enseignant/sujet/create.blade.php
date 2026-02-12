@extends('layouts.enseignant')

@section('content')

<style>
    :root{
        --primary-color: #6f42c1;
        --primary-light: rgba(111,66,193,.08);
        --danger-color: #dc3545;
    }

    /* ================= INPUTS ================= */

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 .15rem rgba(111,66,193,.25);
    }

    .form-control:hover,
    .form-select:hover {
        border-color: var(--primary-color);
    }

    /* ================= CARD ================= */

    .card.border-accent {
        border-left: 4px solid var(--primary-color);
    }

    /* ================= BUTTONS ================= */

    /* Violet */
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

    /* ================= UPLOAD ZONE ================= */

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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-file-earmark-plus text-violet"></i>
            Ajouter un sujet
        </h3>

        <a href="{{ route('enseignant.sujet.index') }}"
           class="btn btn-violet btn-sm">
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
                  action="{{ route('enseignant.sujet.store') }}"
                  enctype="multipart/form-data">
                @csrf

                {{-- FILTRAGE --}}
                <div class="card border-accent mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-funnel text-purple"></i>
                            Sélection de la matière
                        </h6>

                        <div class="row g-3">

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Campus</label>
                                <select id="campusSelect" class="form-select">
                                    <option value="">-- Choisir --</option>
                                    @foreach($campuses as $c)
                                        <option value="{{ $c->id }}">{{ $c->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Cursus</label>
                                <select id="cursusSelect" class="form-select">
                                    <option value="">-- Choisir --</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Département</label>
                                <select id="departementSelect" class="form-select">
                                    <option value="">-- Choisir --</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Filière</label>
                                <select id="filiereSelect" class="form-select">
                                    <option value="">-- Choisir --</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- SEMESTRE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Semestre</label>
                    <select id="semestreSelect" name="semestre" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="1">Semestre 1</option>
                        <option value="2">Semestre 2</option>
                    </select>
                </div>

                {{-- MATIERE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Matière</label>
                    <select id="matiereSelect"
                            name="matiere_id"
                            class="form-select"
                            required>
                        <option value="">-- Sélectionner --</option>
                    </select>
                </div>

                <hr class="my-4">

                {{-- TITRE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Titre du sujet</label>
                    <input type="text"
                           name="titre"
                           class="form-control"
                           required>
                </div>

                {{-- TYPE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Type d'évaluation</label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="CC">Contrôle Continu</option>
                        <option value="TD_TP">TD / TP</option>
                        <option value="EXAMEN">Examen</option>
                        <option value="RATTRAPAGE">Rattrapage</option>
                    </select>
                </div>

                {{-- ANNEE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Année académique</label>
                    <select name="annee_academique" class="form-select" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($anneesAcademiques as $a)
                            <option value="{{ $a }}">{{ $a }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- UPLOAD STYLISÉ --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                    </label>

                    <label class="upload-zone">
                        <i class="fas fa-inbox main-icon"></i>
                        <div>Glissez ou sélectionnez votre fichier</div>

                        <span class="choose-file">
                            <i class="fas fa-upload me-2"></i>
                            Choisir un fichier
                            
                        </span>

                        <input type="file"
                               name="fichier"
                               accept="application/pdf"
                               required>
                    </label>
                </div>

                {{-- ACTIONS --}}
                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('enseignant.sujet.index') }}"
                       class="btn btn-danger">
                        Annuler
                    </a>

                    <button type="submit"
                            class="btn btn-violet">
                        <i class="bi bi-save me-1"></i>
                        Enregistrer
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@include('enseignant.sujet.partials.filtrage-script')

@endsection
