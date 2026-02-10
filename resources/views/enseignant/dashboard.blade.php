@extends('layouts.enseignant')

@section('title', 'Tableau de Bord')
@section('page-title', 'Tableau de Bord')
@section('page-subtitle', 'Bienvenue, ' . Auth::user()->prenom)

@push('styles')
<style>
    .stats-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 12px rgba(93, 63, 211, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(93, 63, 211, 0.2);
    }

    .stats-card .card-body {
        padding: 1.5rem;
    }

    .stats-card .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stats-card .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin: 0.5rem 0 0.25rem 0;
        color: #2C3E50;
    }

    .stats-card .stat-label {
        font-size: 0.85rem;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .border-left-primary {
        border-left: 4px solid #5D3FD3 !important;
    }

    .border-left-success {
        border-left: 4px solid #28a745 !important;
    }

    .border-left-info {
        border-left: 4px solid #17a2b8 !important;
    }

    .border-left-warning {
        border-left: 4px solid #ffc107 !important;
    }

    .section-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 12px rgba(93, 63, 211, 0.1);
        margin-bottom: 1.5rem;
    }

    .section-card .card-header {
        background: linear-gradient(135deg, #5D3FD3 0%, #7B68EE 100%);
        color: white;
        border: none;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.25rem 1.5rem;
    }

    .section-card .card-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .section-card .card-header .toggle-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        padding: 0.4rem 0.75rem;
        border-radius: 8px;
        transition: all 0.3s;
        cursor: pointer;
    }

    .section-card .card-header .toggle-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .section-card .card-header .toggle-btn i {
        transition: transform 0.3s;
    }

    .section-card .card-header .toggle-btn.collapsed i {
        transform: rotate(-90deg);
    }

    .action-btn {
        padding: 1rem;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .table-modern {
        margin: 0;
    }

    .table-modern thead th {
        background-color: #f8f9fa;
        color: #2C3E50;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        padding: 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-modern tbody tr {
        transition: all 0.3s;
    }

    .table-modern tbody tr:hover {
        background-color: #f8f7ff;
        transform: scale(1.01);
    }

    .table-modern tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #495057;
    }

    .badge-type {
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }

    .empty-state p {
        color: #6c757d;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .stats-card .stat-value {
            font-size: 1.5rem;
        }

        .stats-card .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }

        .action-btn {
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .table-responsive {
            font-size: 0.85rem;
        }

        .section-card .card-header h6 {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .stats-card {
            margin-bottom: 1rem;
        }

        .stats-card .card-body {
            padding: 1.25rem;
        }

        .action-btn span {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- Documents Uploadés -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card border-left-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Documents Uploadés</div>
                            <div class="stat-value">{{ $stats['documents'] ?? 0 }}</div>
                        </div>
                        <div class="stat-icon" style="background: rgba(93, 63, 211, 0.1); color: #5D3FD3;">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Corrigés Proposés -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card border-left-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Corrigés Proposés</div>
                            <div class="stat-value">{{ $stats['corriges'] ?? 0 }}</div>
                        </div>
                        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Matières -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card border-left-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Matières</div>
                            <div class="stat-value">{{ $stats['matieres'] ?? 0 }}</div>
                        </div>
                        <div class="stat-icon" style="background: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vues Total -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card border-left-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Vues Total</div>
                            <div class="stat-value">{{ $stats['vues'] ?? 0 }}</div>
                        </div>
                        <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="fas fa-eye"></i>
                        </div>
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
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('enseignant.upload') }}" class="btn btn-primary action-btn w-100">
                                    <i class="fas fa-upload"></i>
                                    <span>Uploader document</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('enseignant.documents') }}" class="btn btn-success action-btn w-100">
                                    <i class="fas fa-folder-open"></i>
                                    <span>Mes documents</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('enseignant.matieres') }}" class="btn btn-info action-btn w-100">
                                    <i class="fas fa-book"></i>
                                    <span>Mes matières</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('enseignant.statistiques') }}" class="btn btn-warning action-btn w-100">
                                    <i class="fas fa-chart-bar"></i>
                                    <span>Statistiques</span>
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
                        @if(isset($recentDocuments) && $recentDocuments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-modern">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Matière</th>
                                            <th>Filière</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th class="text-center">Statut</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentDocuments as $document)
                                            <tr>
                                                <td>
                                                    <strong>{{ Str::limit($document->titre, 40) }}</strong>
                                                </td>
                                                <td>
                                                    <span class="text-muted">
                                                        <i class="fas fa-book me-1"></i>
                                                        {{ $document->matiere->nom ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">
                                                        {{ $document->filiere->nom ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($document->sujet && $document->sujet->type_examen)
                                                        <span class="badge badge-type bg-primary">
                                                            {{ ucfirst($document->sujet->type_examen) }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-type bg-secondary">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <i class="far fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($document->date_upload)->format('d/m/Y') }}
                                                    </small>
                                                </td>
                                                <td class="text-center">
                                                    @if($document->valide)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle me-1"></i>Validé
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock me-1"></i>En attente
                                                        </span>
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
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Aucun document uploadé pour le moment.</p>
                                <a href="{{ route('enseignant.upload') }}" class="btn btn-primary btn-lg rounded-pill px-4">
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
        // Animation des cartes de statistiques au chargement
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

        // Gérer l'icône de rotation des boutons de collapse
        const toggleButtons = document.querySelectorAll('.toggle-btn');
        toggleButtons.forEach(button => {
            const target = document.querySelector(button.getAttribute('data-bs-target'));
            
            target.addEventListener('hide.bs.collapse', () => {
                button.classList.add('collapsed');
            });
            
            target.addEventListener('show.bs.collapse', () => {
                button.classList.remove('collapsed');
            });
        });
    });
</script>
@endpush