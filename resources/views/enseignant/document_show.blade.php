@extends('layouts.enseignant')

@section('content')

<div class="container">
    <h1>{{ $document->titre }}</h1>

    <p><strong>Matière :</strong> {{ $document->matiere->nom ?? 'Non définie' }}</p>
    <p><strong>Description :</strong> {{ $document->description ?? 'Aucune description disponible' }}</p>

    <p><strong>Fichier :</strong></p>
    <a href="{{ asset('storage/' . $document->chemin_fichier) }}" target="_blank" class="btn btn-primary">
        📂 Ouvrir le document
    </a>



</div>

@endsection

    