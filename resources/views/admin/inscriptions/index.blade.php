@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <h3 class="mb-4">Demandes d'inscription</h3>

    {{-- MESSAGE SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= NOUVELLES DEMANDES ================= --}}
    <div class="card mb-5">
        <div class="card-header header-violet-light fw-bold">
            Nouvelles demandes d'inscription
        </div>

        <div class="card-body">
            <div class="row g-3">
                @forelse($nouvellesDemandes as $compte)
                    <div class="col-md-6 col-lg-4">
                        <div class="inscription-card">
                            <div class="inscription-info">
                                <strong>{{ $compte->utilisateur->nom }} {{ $compte->utilisateur->prenom }}</strong>
                                <span>{{ $compte->email }}</span>
                                <span>Rôle : {{ $compte->role->libelle }}</span>
                                <span>
                                    Matricule :
                                    {{ $compte->utilisateur->matricule ?? '—' }}
                                </span>
                            </div>

                            <form method="POST"
                                  action="{{ route('admin.inscriptions.valider', $compte->id) }}">
                                @csrf
                                <button class="btn btn-violet btn-sm w-100">
                                    Activer l'inscription
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">
                        Aucune nouvelle demande
                    </p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ================= INSCRIPTIONS ADMISES ================= --}}
    <div class="card">
        <div class="card-header header-violet fw-bold text-white">
            Inscriptions admises
        </div>

        <div class="card-body">
            <div class="row g-3">
                @forelse($inscriptionsAdmise as $compte)
                    <div class="col-md-6 col-lg-4">
                        <div class="inscription-card active">
                            <div class="inscription-info">
                                <strong>{{ $compte->utilisateur->nom }} {{ $compte->utilisateur->prenom }}</strong>
                                <span>{{ $compte->email }}</span>
                                <span>Rôle : {{ $compte->role->libelle }}</span>
                                <span>
                                    Matricule :
                                    {{ $compte->utilisateur->matricule ?? '—' }}
                                </span>
                            </div>

                            <form method="POST"
                                  action="{{ route('admin.inscriptions.desactiver', $compte->id) }}">
                                @csrf
                                <button class="btn btn-outline-danger btn-sm w-100">
                                    Désactiver
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">
                        Aucune inscription admise
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
/* =====================
   COULEURS PRINCIPALES
===================== */
:root {
    --violet-primary: #6f42c1;
    --violet-light: rgba(111, 66, 193, 0.15);
}

/* =====================
   HEADERS
===================== */
.header-violet {
    background-color: var(--violet-primary);
}

.header-violet-light {
    background-color: var(--violet-light);
    color: var(--violet-primary);
}

/* =====================
   BOUTONS
===================== */
.btn-violet {
    background-color: var(--violet-primary);
    color: #fff;
    border: none;
}

.btn-violet:hover {
    background-color: #5a34a0;
    color: #fff;
}

/* =====================
   CARDS
===================== */
.inscription-card {
    background: #fff;
    padding: 1rem;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 1rem;

    box-shadow: -4px 6px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.inscription-card:hover {
    transform: translateY(-2px);
    box-shadow: -6px 10px 22px rgba(0, 0, 0, 0.12);
}

/* Carte active */
.inscription-card.active {
    border-left: 4px solid var(--violet-primary);
}

/* =====================
   INFOS
===================== */
.inscription-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
    font-size: 0.9rem;
}

.inscription-info strong {
    font-size: 1rem;
    color: #1f2937;
}
</style>

@endsection
