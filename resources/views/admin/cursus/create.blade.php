@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/cursus/create.css') }}">
<div class="container-fluid">

    {{-- TITRE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">
            <i class="bi bi-plus-circle text-violet"></i> Nouveau cursus
        </h3>

        <a href="{{ route('admin.cursus.index') }}"
           class="btn btn-sm btn-outline-violet">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    {{-- FORMULAIRE --}}
    <div class="card shadow-sm border-0 bg-white">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.cursus.store') }}">
                @csrf

                {{-- CAMPUS --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Campus</label>
                    <select name="campus_id" id="campusSelect" class="form-select border-violet-focus"required>
                        <option value="">-- Sélectionner un campus --</option>
                        @foreach($campuses as $campus)
                            <option value="{{ $campus->id }}">
                                {{ $campus->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- NOM CURSUS --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom du cursus</label>
                    <input type="text"
                           name="nom"
                           id="nomCursus"
                           class="form-control border-violet-focus"
                           placeholder="Ex: Licence Professionnelle"
                           disabled
                           required>
                </div>

                {{-- ACTIONS --}}
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('admin.cursus.index') }}"
                       class="btn btn-outline">
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

{{-- SCRIPT ACTIVATION NOM --}}
<script>
document.getElementById('campusSelect').addEventListener('change', function () {
    document.getElementById('nomCursus').disabled = !this.value;
});
</script>



@endsection
