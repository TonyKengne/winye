@extends('layouts.enseignant')

@section('title', 'Tableau de Bord')
@section('page-title', 'Tableau de Bord')
@section('page-subtitle', 'Bienvenue, ' . Auth::user()->prenom)

@section('content')

<!-- Bouton toggle sidebar -->
<div class="row">
    <!-- Stats Cards -->
    <div class="row">
    <!-- Documents Uploadés -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Documents Uploadés
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $stats['document'] ?? 0 }}
                    </div>
                </div>
                <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

    <!-- Corrigés Proposés -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Corrigés Proposés
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $stats['corriges'] ?? 0 }}
                    </div>
                </div>
                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

    <!-- Matières -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Matières
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $stats['matiere'] ?? 0 }}
                    </div>
                </div>
                <i class="fas fa-book fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

    <!-- Vues Total -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Vues Total
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $stats['vues'] ?? 0 }}
                    </div>
                </div>
                <i class="fas fa-eye fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
</div>

<!-- Actions Rapides avec toggle -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Actions Rapides</h6>
                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#actionsRapides" aria-expanded="true" aria-controls="actionsRapides">
                     <i class="fas fa-chevron-down ms-1"></i>
                </button>
            </div>
            <div class="collapse show" id="actionsRapides">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('enseignant.upload') }}" class="btn btn-primary w-100">
                                <i class="fas fa-upload me-2"></i>Uploader un document
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('enseignant.documents') }}" class="btn btn-success w-100">
                                <i class="fas fa-folder-open me-2"></i>Voir mes documents
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('enseignant.matieres') }}" class="btn btn-info w-100">
                                <i class="fas fa-book me-2"></i>Gérer mes matières
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('enseignant.statistiques') }}" class="btn btn-warning w-100">
                                <i class="fas fa-chart-bar me-2"></i>Voir statistiques
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Documents Récents avec toggle -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Documents Récents</h6>
                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#recentDocs" aria-expanded="true" aria-controls="recentDocs">
                     <i class="fas fa-chevron-down ms-1"></i>
                </button>
            </div>
            <div class="collapse show" id="recentDocs">
                <div class="card-body">
                    @if(isset($recentDocuments) && $recentDocuments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Matière</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Vues</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentDocuments as $document)
                                        <tr>
                                            <td>{{ $document->titre }}</td>
                                            <td>{{ $document->matiere->nom ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $document->type == 'sujet' ? 'primary' : ($document->type == 'corrige' ? 'success' : 'info') }}">
                                                    {{ ucfirst($document->type) }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($document->date_upload)->format('d/m/Y') }}</td>
                                            <td>{{ $document->vues }}</td>
                                            <td>
                                                <a href="{{ route('enseignant.document.show', $document->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucun document uploadé pour le moment.</p>
                            <a href="{{ route('enseignant.upload') }}" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Uploader votre premier document
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
