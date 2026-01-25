@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/filiere/create.css') }}">

<div class="container-fluid">

    {{-- TITRE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-diagram-3 text-violet"></i> Nouvelle filière
        </h3>
        <a href="{{ route('admin.filiere.index') }}" class="btn btn-outline-violet btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    {{-- ERREURS --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULAIRE --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.filiere.store') }}">
                @csrf

                {{-- CAMPUS --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Campus</label>
                    <select id="campusSelect" name="campus_id"
                            class="form-select border-violet-focus" required>
                        <option value="">-- Sélectionner un campus --</option>
                        @foreach($campus as $c)
                            <option value="{{ $c->id }}">{{ $c->nom }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- CURSUS --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Cursus</label>
                    <select id="cursusSelect" name="cursus_id"
                            class="form-select border-violet-focus" disabled required>
                        <option value="">-- Sélectionner un cursus --</option>
                    </select>
                </div>

                {{-- DÉPARTEMENT --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Département</label>
                    <select id="departementSelect" name="departement_id"
                            class="form-select border-violet-focus" disabled required>
                        <option value="">-- Sélectionner un département --</option>
                    </select>
                </div>

                {{-- NIVEAU (STATIQUE DEPUIS LA BD) --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Niveau</label>
                    <select id="niveauSelect" name="niveau_id"
                            class="form-select border-violet-focus"  required>
                        <option value="">-- Sélectionner un niveau --</option>
                        @foreach($niveaux as $niveau)
                            <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- NOM FILIÈRE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom de la filière</label>
                    <input type="text" name="nom"
                           class="form-control border-violet-focus"
                           placeholder="Ex : Génie Logiciel"
                           disabled required>
                </div>

                {{-- BOUTONS --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.filiere.index') }}" class="btn btn-outline">
                        Annuler
                    </a>
                    <button class="btn btn-violet">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- JS SIMPLIFIÉ ET STABLE --}}
<script>
const campusSelect = document.getElementById('campusSelect');
const cursusSelect = document.getElementById('cursusSelect');
const departementSelect = document.getElementById('departementSelect');
const niveauSelect = document.getElementById('niveauSelect');
const nomInput = document.querySelector('input[name="nom"]');

// CAMPUS → CURSUS
campusSelect.addEventListener('change', function () {
    cursusSelect.innerHTML = '<option value="">-- Sélectionner un cursus --</option>';
    departementSelect.innerHTML = '<option value="">-- Sélectionner un département --</option>';

    cursusSelect.disabled = true;
    departementSelect.disabled = true;
    niveauSelect.disabled = true;
    nomInput.disabled = true;

    if (this.value) {
        fetch(`/admin/campus/${this.value}/cursus`)
            .then(res => res.json())
            .then(data => {
                data.forEach(c => {
                    cursusSelect.innerHTML += `<option value="${c.id}">${c.nom}</option>`;
                });
                cursusSelect.disabled = false;
            });
    }
});

// CURSUS → DÉPARTEMENTS + ACTIVER NIVEAU
cursusSelect.addEventListener('change', function () {
    departementSelect.innerHTML = '<option value="">-- Sélectionner un département --</option>';
    departementSelect.disabled = true;
    niveauSelect.disabled = true;
    nomInput.disabled = true;

    if (this.value) {
        fetch(`/admin/cursus/${this.value}/departements`)
            .then(res => res.json())
            .then(data => {
                data.forEach(d => {
                    departementSelect.innerHTML += `<option value="${d.id}">${d.nom}</option>`;
                });
                departementSelect.disabled = false;
                niveauSelect.disabled = false; // 
            });
    }
});

// DÉPARTEMENT → ACTIVER NOM
departementSelect.addEventListener('change', function () {
    nomInput.disabled = !this.value;
});
</script>

@endsection
