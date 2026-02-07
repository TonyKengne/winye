@extends('layouts.enseignant')

@section('content')
<style>
    .upload-container {
        max-width: 700px;
        margin: auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .upload-title {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #2c3e50;
        text-align: center;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        font-weight: 600;
        color: #34495e;
    }

    input, select, textarea {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #dcdcdc;
        margin-top: 6px;
        font-size: 15px;
    }

    textarea {
        height: 120px;
        resize: none;
    }

    input:focus, select:focus, textarea:focus {
        border-color: #3498db;
        outline: none;
        box-shadow: 0 0 5px rgba(52,152,219,0.3);
    }

    .btn-primary {
        background: #3498db;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        width: 100%;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background: #2980b9;
    }
</style>

<div class="container mt-5">
    {{-- Notification de succès ou erreurs --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            📤 Ajouter un document académique
        </div>
        <div class="card-body">
            <form action="{{ route('enseignant.storeDocument') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Titre --}}
                <div class="form-group mb-3">
                    <label for="titre">Titre du document</label>
                    <input type="text" name="titre" id="titre" class="form-control" placeholder="Ex : Examen de programmation" required>
                </div>

                {{-- Description --}}
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Décrivez brièvement le contenu..."></textarea>
                </div>

                {{-- Année académique --}}
                <div class="form-group mb-3">
                    <label for="annee">Année académique</label>
                    <input type="text" name="annee" id="annee" class="form-control" value="{{ date('Y') }}/{{ date('Y')+1 }}" readonly>
                </div>

                {{-- Semestre --}}
                <div class="form-group mb-3">
                    <label for="semestre">Semestre</label>
                    <select name="semestre" id="semestre" class="form-control" required>
                        <option value="">-- Choisir --</option>
                        <option value="1">Semestre 1</option>
                        <option value="2">Semestre 2</option>
                    </select>
                </div>

                {{-- Type examen --}}
                <div class="form-group mb-3">
                    <label for="type_examen">Type d’examen</label>
                    <select name="type_examen" id="type_examen" class="form-control" required>
                        <option value="">-- Choisir --</option>
                        <option value="Examen">Examen</option>
                        <option value="TP">Travaux Pratiques</option>
                        <option value="TD">Travaux Dirigés</option>
                        <option value="CC">Contrôle Continu</option>
                    </select>
                </div>

                {{-- Durée --}}
                <div class="form-group mb-3">
                    <label for="duree">Durée</label>
                    <input type="text" name="duree" id="duree" class="form-control" placeholder="Ex : 2h">
                </div>

                {{-- Coefficient --}}
                <div class="form-group mb-3">
                    <label for="coefficient">Coefficient</label>
                    <input type="number" name="coefficient" id="coefficient" class="form-control" min="1" max="10">
                </div>

                {{-- Matière --}}
                <div class="form-group mb-3">
                    <label for="matiere_id">Matière</label>
                    <select name="matiere_id" id="matiere_id" class="form-control" required>
                        <option value="">-- Sélectionner une matière --</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filière --}}
                <div class="form-group mb-3">
                    <label for="filliere_id">Filière</label>
                    <select name="filliere_id" id="filliere_id" class="form-control" required>
                        <option value="">-- Sélectionner une filière --</option>
                        @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Sujet (si photo de sujet) --}}
                <div class="form-group mb-3">
                    <label for="sujet_id">Sujet lié (optionnel)</label>
                    <select name="sujet_id" id="sujet_id" class="form-control">
                        <option value="">-- Aucun --</option>
                        @foreach($sujets as $sujet)
                            <option value="{{ $sujet->id }}">{{ $sujet->type_examen }} - {{ $sujet->annee }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Fichier --}}
                <div class="form-group mb-3">
                    <label for="document">Fichier</label>
                    <input type="file" name="document" id="document" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.png" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">📤 Téléverser le document</button>
            </form>
        </div>
    </div>
</div>


@endsection
