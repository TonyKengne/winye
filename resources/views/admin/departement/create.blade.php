@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/cursus/create.css') }}"> {{-- inclut ton CSS violet existant --}}

<div class="container-fluid">

    {{-- TITRE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">
            <i class="bi bi-plus-circle text-violet"></i>
            Nouveau département
        </h3>

        <a href="{{ route('admin.departement.index') }}"
           class="btn btn-sm btn-outline-violet">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    {{-- FORMULAIRE --}}
    <div class="card shadow-sm border-0 bg-white">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.departement.store') }}">
                @csrf

                {{-- CAMPUS --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Campus</label>
                    <select id="campusSelect"
                            class="form-select border-violet-focus"
                            required>
                        <option value="">-- Sélectionner un campus --</option>
                        @foreach($campuses as $campus)
                            <option value="{{ $campus->id }}">
                                {{ $campus->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- CURSUS --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Cursus</label>
                    <select name="cursus_id"
                            id="cursusSelect"
                            class="form-select border-violet-focus"
                            disabled
                            required>
                        <option value="">-- Sélectionner un cursus --</option>
                    </select>
                </div>

                {{-- NOM --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom du département</label>
                    <input type="text"
                           name="nom"
                           id="nomDepartement"
                           class="form-control border-violet-focus"
                           disabled
                           required>
                </div>

                {{-- ACTIONS --}}
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <button type="reset" class="btn btn-outline">
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-violet">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

{{-- JS --}}
<script>
const campusSelect = document.getElementById('campusSelect');
const cursusSelect = document.getElementById('cursusSelect');
const nomInput = document.getElementById('nomDepartement');

campusSelect.addEventListener('change', function () {
    cursusSelect.disabled = true;
    nomInput.disabled = true;

    fetch(`/admin/campus/${this.value}/cursus`)
        .then(res => res.json())
        .then(data => {
            cursusSelect.innerHTML =
                '<option value="">-- Sélectionner un cursus --</option>';

            data.forEach(c => {
                cursusSelect.innerHTML +=
                    `<option value="${c.id}">${c.nom}</option>`;
            });

            cursusSelect.disabled = false;
        });
});

cursusSelect.addEventListener('change', function () {
    nomInput.disabled = !this.value;
});
</script>

@endsection
