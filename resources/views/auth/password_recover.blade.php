@extends('layouts.app') {{-- ou layouts.etudiant si tu veux utiliser celui des étudiants --}}

@section('title', 'Récupération du mot de passe')

@section('content')
<div class="container">
    <h3>Récupération du mot de passe</h3>
    <form method="POST" action="{{ route('password.recover.verify') }}">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Matricule (si étudiant)</label>
            <input type="text" name="matricule" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Vérifier</button>
    </form>
</div>
@endsection
