@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <link rel="stylesheet" href="{{ asset('css/campus/index.css') }}">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">
            <i class="bi bi-buildings text-violet"></i>
            Liste des campus
        </h3>

        <div class="d-flex gap-2">
            {{-- RETOUR --}}
            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-sm btn-outline-violet">
                <i class="bi bi-arrow-left"></i>
                <span class="d-none d-md-inline">Retour</span>
            </a>

            {{-- AJOUTER CAMPUS --}}
            <a href="{{ route('admin.campus.create') }}"
               class="btn btn-violet btn-sm">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">
                    Ajouter un campus
                </span>
            </a>
        </div>
    </div>

    {{-- LISTE DES CAMPUS --}}
    <div class="row g-4">

        @forelse ($campus as $campus)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 campus-card">

                    {{-- IMAGE --}}
                    <img
                        src="{{ $campus->photo_campus
                                ? asset('storage/'.$campus->photo_campus)
                                : asset('images/campus-placeholder.png') }}"
                        class="card-img-top"
                        style="height: 160px; object-fit: cover;"
                    >

                    {{-- CONTENU --}}
                    <div class="card-body text-center">
                        <h6 class="fw-semibold mb-0">
                            {{ $campus->nom }}
                        </h6>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border-start border-4 border-violet">
                    <i class="bi bi-info-circle text-violet"></i>
                    Aucun campus enregistré pour le moment.
                </div>
            </div>
        @endforelse

    </div>

</div>


@endsection
