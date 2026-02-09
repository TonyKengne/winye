@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-check2-square text-primary"></i>
                Validation des corrigés
            </h3>
            <small class="text-muted">
                {{ $sujets->count() }} corrigé(s) à examiner
            </small>
        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Corrigé</th>
                        <th>Auteur</th>
                        <th>Statut</th>
                        <th>Visibilité</th>
                        <th>Date dépôt</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($sujets as $sujet)

                    @php
                        $corrige = $sujet->corrige;
                    @endphp

                    <tr>

                        {{-- INDEX --}}
                        <td>{{ $loop->iteration }}</td>

                        {{-- SUJET --}}
                        <td>
                            <div class="fw-semibold">
                                {{ $sujet->titre }}
                            </div>
                            <small class="text-muted">
                                {{ $sujet->matiere->nom ?? '' }}
                                @if(isset($sujet->filiere))
                                    • {{ $sujet->filiere->nom }}
                                @endif
                            </small>
                        </td>

                        {{-- AUTEUR --}}
                        <td>
                            {{ $sujet->audits()->where('sujet_id', $sujet->id)->first()?->auteur?->utilisateur?->prenom ?? '—'  }}
                            {{ $sujet->audits()->where('sujet_id', $sujet->id)->first()?->auteur?->utilisateur?->nom ?? '—'  }}

                        </td>

                          {{-- STATUT --}}
                        <td>
                            @if($corrige->isValide())
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Validé
                                </span>
                            @elseif($corrige->statut === 'refuse')
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle"></i> Refusé
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-hourglass-split"></i> En attente
                                </span>
                            @endif
                        </td>

                        {{-- VISIBILITE --}}
                        <td>
                            @if($corrige->isPublic())
                                <span class="badge bg-primary">
                                    Public
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Privé
                                </span>
                            @endif
                        </td>

                        {{-- DATE --}}
                        <td>
                            <small class="text-muted">
                                {{ $corrige->created_at->format('d/m/Y') }}
                            </small>
                        </td>

                        {{-- ACTIONS --}}
                        <td class="text-end">

                            <div class="btn-group">

                                {{-- VOIR --}}
                                <a href="{{ route('admin.corrige.show', $corrige->id) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>

                                {{-- VALIDER --}}
                                @if($corrige->statut !== 'valide')
                                    <form method="POST"
                                          action="{{ route('admin.corrige.updateStatut', $corrige->id) }}">
                                        @csrf
                                        <input type="hidden" name="statut" value="valide">
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- REFUSER --}}
                                @if($corrige->statut !== 'refuse')
                                    <form method="POST"
                                          action="{{ route('admin.corrige.updateStatut', $corrige->id) }}">
                                        @csrf
                                        <input type="hidden" name="statut" value="refuse">
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </form>
                                @endif

                            </div>

                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox"></i>
                            Aucun corrigé à valider pour le moment
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
