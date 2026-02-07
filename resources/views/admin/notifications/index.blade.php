@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <h3 class="mb-4">Gestion des notifications</h3>

    {{-- MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card notification-card">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.notifications.send') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Titre</label>
                    <input type="text" name="titre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Message</label>
                    <textarea name="message" rows="4" class="form-control" required></textarea>
                </div>

                {{-- CIBLE --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Envoyer à</label>
                    <select name="cible" id="cible" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="role">Un rôle</option>
                        <option value="utilisateur">Un utilisateur précis</option>
                    </select>
                </div>

                {{-- PAR RÔLE --}}
                <div class="mb-3 d-none" id="role-section">
                    <label class="form-label">Rôle</label>
                    <select name="role_id" class="form-select">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ ucfirst($role->libelle) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- PAR UTILISATEUR --}}
                <div class="mb-3 d-none" id="user-section">
                    <label class="form-label">Utilisateur</label>
                    <select name="compte_utilisateur_id" class="form-select">
                        @foreach($utilisateurs as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->email }} ({{ $user->role->libelle }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-violet mt-3">
                    <i class="bi bi-send"></i> Envoyer
                </button>

            </form>

        </div>
    </div>
</div>


<div class="container mt-5">
    @foreach($notifications as $notif)
        <div class="alert alert-info">
            <strong>{{ $notif->titre }}</strong><br>
            {{ $notif->message }} <br>
            <small>{{ $notif->date_envoi }}</small>
        </div>
    @endforeach

    <h1>📂 Gestion des documents</h1>

    <h2>En attente de validation</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Matière</th>
                <th>Enseignant</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentsEnAttente as $doc)
                <tr>
                    <td>{{ $doc->titre }}</td>
                    <td>{{ $doc->matiere->nom ?? 'N/A' }}</td>
                    <td>{{ $doc->enseignant->email ?? 'N/A' }}</td>
                    <td>{{ $doc->date_upload }}</td>
                    <td>
                        <form action="{{ route('admin.documents.valider', $doc->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">✅ Valider</button>
                        </form>
                        <form action="{{ route('admin.documents.rejeter', $doc->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">❌ Rejeter</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Aucun document en attente</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Documents validés</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Matière</th>
                <th>Enseignant</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentsValides as $doc)
                <tr>
                    <td>{{ $doc->titre }}</td>
                    <td>{{ $doc->matiere->nom ?? 'N/A' }}</td>
                    <td>{{ $doc->enseignant->email ?? 'N/A' }}</td>
                    <td>{{ $doc->date_upload }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Aucun document validé</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
