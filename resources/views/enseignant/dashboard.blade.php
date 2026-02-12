@extends('layouts.enseignant')
@section('page-subtitle', 'Bienvenue, ' . (Auth::user()->utilisateur->prenom ?? ''))

<link rel="stylesheet" href="{{ asset('css/enseignant/dashboard.css') }}">

@section('content')
<div class="container-fluid">

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Documents Uploadés -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card border-left-primary">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Documents Uploadés</div>
                        <div class="stat-value">{{ $stats['documents'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-primary-light text-primary">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Corrigés Proposés -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card border-left-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Corrigés Proposés</div>
                        <div class="stat-value">{{ $stats['corriges'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-success-light text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Matières -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card border-left-info">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Matières</div>
                        <div class="stat-value">{{ $stats['matieres'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-info-light text-info">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vues Total -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card border-left-warning">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Vues Total</div>
                        <div class="stat-value">{{ $stats['vues'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-warning-light text-warning">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Rapides -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="section-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6>Actions Rapides</h6>
                    <button class="toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#actionsRapides" aria-expanded="true">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse show" id="actionsRapides">
                    <div class="card-body py-4">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('enseignant.sujet.create') }}" class="btn btn-outline-primary action-btn w-100">
                                    <i class="fas fa-upload"></i> <span>Uploader document</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('enseignant.documents') }}" class="btn btn-outline-success action-btn w-100">
                                    <i class="fas fa-folder-open"></i> <span>Mes documents</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('enseignant.notification') }}" class="btn btn-outline-info action-btn w-100">
                                    <i class="fas fa-bell"></i> <span>Mes Notifications</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('enseignant.statistiques') }}" class="btn btn-outline-warning action-btn w-100">
                                    <i class="fas fa-chart-bar"></i> <span>Statistiques</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Récents -->
    <div class="row">
        <div class="col-12">
            <div class="section-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6>Documents Récents</h6>
                    <button class="toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#recentDocs" aria-expanded="true">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse show" id="recentDocs">
                    <div class="card-body p-0">
                        @if($recentDocuments->count())
                            <div class="table-responsive">
                                <table class="table table-modern mb-0">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Matière</th>
                                            <th>Filières</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th class="text-center">Statut</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentDocuments as $document)
                                        <tr>
                                            <td><strong>{{ Str::limit($document->sujet->titre ?? $document->nom, 40) }}</strong></td>
                                            <td>{{ $document->sujet->matiere->nom ?? 'N/A' }}</td>
                                            <td>
                                                @if($document->sujet->filieres->count())
                                                    {{ $document->sujet->filieres->pluck('nom')->join(', ') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ ucfirst($document->sujet->type ?? 'N/A') }}</td>
                                            <td>{{ $document->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center">
                                                @if($document->valide === 1)
                                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Validé</span>
                                                @else
                                                    <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>En attente</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('enseignant.document.show', $document->id) }}" 
                                                   class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    <i class="fas fa-eye me-1"></i>Voir
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state text-center p-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Aucun document uploadé pour le moment.</p>
                                <a href="{{ route('enseignant.sujet.create') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                                    <i class="fas fa-upload me-2"></i>Uploader votre premier document
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des stats cards
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 50);
        }, index * 100);
    });

    // Toggle buttons collapse
    const toggleButtons = document.querySelectorAll('.toggle-btn');
    toggleButtons.forEach(button => {
        const target = document.querySelector(button.getAttribute('data-bs-target'));
        target.addEventListener('hide.bs.collapse', () => button.classList.add('collapsed'));
        target.addEventListener('show.bs.collapse', () => button.classList.remove('collapsed'));
    });
});
</script>
@endpush
