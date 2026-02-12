@extends('layouts.enseignant')

@section('content')
<link rel="stylesheet" href="{{ asset('css/matiere/create.css') }}">

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">  
        <h3 class="fw-bold">
            <i class="bi bi-file-earmark-check text-violet"></i>
            Visualisation du corrigé
        </h3>
        <a href="{{ route('enseignant.sujet.index') }}" class="btn btn-violet btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="mb-4">
                <h5>{{ $corrige->sujet->titre }}</h5>
                <p><strong>Matière :</strong> {{ $corrige->sujet->matiere->nom ?? '-' }}</p>
                <p><strong>Statut :</strong> {{ $corrige->statut }}</p>
            </div>

            <div class="pdf-viewer" style="height:80vh; border:1px solid #ced4da;">
                @if($corrige->fichier)
                    <iframe 
                        src="{{ asset('storage/'.$corrige->fichier) }}" 
                        width="100%" 
                        height="100%" 
                        style="border:none;">
                    </iframe>
                @else
                    <p class="text-muted text-center my-3">
                        Aucun fichier disponible.
                    </p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
