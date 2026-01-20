@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/campus/create.css') }}">
<div class="container-fluid">

    {{-- TITRE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">
            <i class="bi bi-building text-violet"></i> Nouveau campus
        </h3>

        <a href="{{ route('admin.campus.index') }}"
           class="btn btn-sm btn-outline-violet">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    {{-- MESSAGE ERREUR --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULAIRE --}}
    <div class="card shadow-sm border-0 bg-white">
        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.campus.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="row g-4 align-items-center">

                    {{-- PHOTO CAMPUS --}}
                    <div class="col-md-4 text-center">
                        <img
                            id="previewCampus"
                            src="{{ asset('images/campus-placeholder.png') }}"
                            class="rounded shadow-sm mb-3 border"
                            width="200"
                            height="140"
                            style="object-fit: cover;"
                        >

                        <input type="file"
                               name="photo_campus"
                               class="form-control form-control-sm"
                               accept="image/*"
                               onchange="previewCampusImage(event)">

                        <small class="text-muted">
                            Image du campus (optionnelle)
                        </small>
                    </div>

                    {{-- INFOS CAMPUS --}}
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nom du campus
                            </label>
                            <input type="text"
                                   name="nom"
                                   class="form-control form-control-lg border-violet-focus"
                                   placeholder="Ex : Campus Principal Yaoundé"
                                   required>
                        </div>

                        <div class="alert alert-light border-start border-4 border-violet small">
                            <i class="bi bi-info-circle text-violet"></i>
                            Ce campus pourra ensuite contenir plusieurs cursus,
                            départements, filières et niveaux.
                        </div>
                    </div>

                </div>

                {{-- ACTIONS --}}
                <div class="d-flex justify-content-end mt-4 gap-2">
                    <button type="reset"
                            class="btn btn-outline">
                        Annuler
                    </button>

                    <button type="submit"
                            class="btn btn-violet">
                        <i class="bi bi-check-circle"></i>
                        Enregistrer le campus
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

{{-- PREVIEW IMAGE --}}
<script>
function previewCampusImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('previewCampus').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>



@endsection
