@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4">Validation des sujets</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Matière</th>
                        <th>Semestre</th>
                        <th>Année Académique</th>
                        <th>Auteur</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sujets as $sujet)
                        <tr>
                            <td>{{ $sujet->titre }}</td>
                            <td>{{ $sujet->matiere->nom }}</td>
                            <td>{{ $sujet->semestre }}</td>
                            <td>{{ $sujet->annee_academique }}</td>
                            <td>
                                {{ $sujet->audits->first()?->auteur?->utilisateur->prenom ?? '-' }}
                                {{ $sujet->audits->first()?->auteur?->utilisateur->nom ?? '' }}
                            </td>
                            <td>
                                @if($sujet->statut === 'en_attente')
                                    <span class="badge bg-warning">En attente</span>
                                @elseif($sujet->statut === 'valide')
                                    <span class="badge bg-success">Validé</span>
                                @else
                                    <span class="badge bg-danger">Refusé</span>
                                @endif
                            </td>
                            <td>
                                @if($sujet->statut === 'en_attente')
                                <div class="d-flex gap-1">
                                    <form method="POST" action="{{ route('admin.sujet.statut', $sujet->id) }}">
                                        @csrf
                                        <input type="hidden" name="statut" value="valide">
                                        <button class="btn btn-sm btn-success">Valider</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.sujet.statut', $sujet->id) }}">
                                        @csrf
                                        <input type="hidden" name="statut" value="refuse">
                                        <button class="btn btn-sm btn-danger">Refuser</button>
                                    </form>
                                </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
