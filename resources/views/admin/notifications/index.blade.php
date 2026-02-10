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
@endsection
