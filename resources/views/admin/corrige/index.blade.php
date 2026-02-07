@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-check2-square text-primary"></i>
            Validation des corrigés
        </h3>
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

    {{-- TABLE --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Sujet</th>
                        <th>Corrigé</th>
                        <th>Statut</th>
                        <th>Visibilité</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($sujets as $sujet)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <div class="fw-semibold">{{ $sujet->titre }}</div>
                            <small class="text-muted">
                                Auteur : {{ $sujet->auteur->nom ?? '—' }}
                            </small>
                        </td>

                        <td>
                            {{ $sujet->corrige->titre }}
                        </td>

                        {{-- STATUT --}}
                        <td>
                            @switch($sujet->corrige->statut)
                                @case('valide')
                                    <span class="badge bg-success">Validé</span>
                                    @break
                                @case('refuse')
                                    <span class="badge bg-danger">Refusé</span>
                                    @break
                                @default
                                    <span class="badge bg-warning text-dark">En attente</span>
                            @endswitch
                        </td>

                        {{-- PUBLIC --}}
                        <td>
                            @if($sujet->corrige->is_public)
                                <span class="badge bg-primary">Public</span>
                            @else
                                <span class="badge bg-secondary">Privé</span>
                            @endif
                        </td>

                        {{-- ACTIONS --}}
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end shadow">

                                    {{-- VOIR CORRIGE --}}
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('admin.corrige.show', $sujet->corrige->id) }}"
                                           target="_blank">
                                            <i class="bi bi-file-earmark-pdf"></i> Voir le corrigé
                                        </a>
                                    </li>

                                    <li><hr class="dropdown-divider"></li>

                                    {{-- VALIDER --}}
                                    @if($sujet->corrige->statut !== 'valide')
                                    <li>
                                        <form method="POST"
                                              action="{{ route('admin.corrige.valider', $sujet->corrige->id) }}">
                                            @csrf
                                            <button class="dropdown-item text-success">
                                                <i class="bi bi-check-circle"></i> Valider
                                            </button>
                                        </form>
                                    </li>
                                    @endif

                                    {{-- REFUSER --}}
                                    @if($sujet->corrige->statut !== 'refuse')
                                    <li>
                                        <form method="POST"
                                              action="{{ route('admin.corrige.refuser', $sujet->corrige->id) }}">
                                            @csrf
                                            <button class="dropdown-item text-danger">
                                                <i class="bi bi-x-circle"></i> Refuser
                                            </button>
                                        </form>
                                    </li>
                                    @endif

                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox"></i> Aucun corrigé à valider
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
