@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/matiere/show.css') }}">

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-file-earmark-pdf text-violet"></i>
            Visualisation du sujet
        </h3>
        <a href="{{ route('admin.sujet.index') }}" class="btn btn-outline-violet btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            {{-- Infos du sujet --}}
            <div class="mb-4">
                <h5>{{ $sujet->titre }}</h5>
                <p class="mb-1"><strong>Matière :</strong> {{ $sujet->matiere->nom ?? '-' }}</p>
                <p class="mb-1"><strong>Type :</strong> {{ $sujet->type }}</p>
                <p class="mb-1"><strong>Semestre :</strong> Semestre {{ $sujet->semestre }}</p>
                <p class="mb-1"><strong>Année académique :</strong> {{ $sujet->annee_academique }}</p>
            </div>

            {{-- PDF --}}
            <div class="pdf-viewer" style="height:80vh; border:1px solid #ced4da;">
                @if($sujet->fichier)
                    <iframe 
                        src="{{ asset('storage/'.$sujet->fichier) }}" 
                        width="100%" 
                        height="100%" 
                        style="border:none;">
                    </iframe>
                @else
                    <p>Aucun fichier disponible.</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
