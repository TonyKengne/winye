@extends('layouts.enseignant')

@section('title', 'Statistiques')
@section('page-title', 'Statistiques')
@section('page-subtitle', 'Vue d\'ensemble de vos activités')

@push('styles')
<style>
    .stats-container {
        padding: 0;
    }

    /* Cards de statistiques principales */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(93, 63, 211, 0.1);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(93, 63, 211, 0.2);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(135deg, #5D3FD3 0%, #7B68EE 100%);
    }

    .stat-card.card-documents::before {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    }

    .stat-card.card-matieres::before {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    }

    .stat-card.card-valides::before {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
    }

    .stat-card.card-attente::before {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
    }

    .card-total .stat-icon {
        background: linear-gradient(135deg, #5D3FD3 0%, #7B68EE 100%);
        color: white;
    }

    .card-documents .stat-icon {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
    }

    .card-matieres .stat-icon {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }

    .card-valides .stat-icon {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        color: white;
    }

    .card-attente .stat-icon {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2C3E50;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.95rem;
        color: #718096;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-trend {
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .trend-up {
        color: #27ae60;
    }

    .trend-down {
        color: #e74c3c;
    }

    /* Graphiques */
    .charts-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .chart-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(93, 63, 211, 0.1);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .chart-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2C3E50;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .chart-title i {
        color: #5D3FD3;
    }

    .chart-body {
        min-height: 300px;
    }

    /* Tableau des matières populaires */
    .table-section {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(93, 63, 211, 0.1);
        margin-bottom: 2rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2C3E50;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: #5D3FD3;
    }

    .table-modern {
        width: 100%;
        margin: 0;
    }

    .table-modern thead {
        background: #f8f9fa;
    }

    .table-modern thead th {
        padding: 1rem 1.5rem;
        font-weight: 700;
        color: #2C3E50;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e9ecef;
    }

    .table-modern tbody td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        color: #495057;
    }

    .table-modern tbody tr:hover {
        background: #f8f7ff;
    }

    .progress-bar-wrapper {
        width: 100%;
        height: 8px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(135deg, #5D3FD3 0%, #7B68EE 100%);
        border-radius: 10px;
        transition: width 0.3s ease;
    }

    .badge-rank {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .rank-1 {
        background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
        color: white;
    }

    .rank-2 {
        background: linear-gradient(135deg, #C0C0C0 0%, #A8A8A8 100%);
        color: white;
    }

    .rank-3 {
        background: linear-gradient(135deg, #CD7F32 0%, #B8733F 100%);
        color: white;
    }

    .rank-other {
        background: #f8f9fa;
        color: #718096;
    }

    /* Section activité récente */
    .activity-timeline {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(93, 63, 211, 0.1);
    }

    .timeline-item {
        display: flex;
        gap: 1.5rem;
        padding: 1.5rem 0;
        border-bottom: 1px solid #f0f0f0;
        position: relative;
    }

    .timeline-item:last-child {
        border-bottom: none;
    }

    .timeline-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1.2rem;
    }

    .timeline-icon.upload {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
    }

    .timeline-icon.validate {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        color: white;
    }

    .timeline-icon.reject {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-title {
        font-weight: 600;
        color: #2C3E50;
        margin-bottom: 0.25rem;
    }

    .timeline-meta {
        font-size: 0.85rem;
        color: #718096;
    }

    .timeline-time {
        font-size: 0.85rem;
        color: #a0aec0;
        text-align: right;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        font-size: 5rem;
        color: #e9ecef;
        margin-bottom: 1.5rem;
    }

    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2C3E50;
        margin-bottom: 0.75rem;
    }

    .empty-state-text {
        color: #718096;
        font-size: 1.05rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .charts-section {
            grid-template-columns: 1fr;
        }

        .stat-value {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .table-section {
            overflow-x: auto;
        }

        .table-modern {
            min-width: 600px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid stats-container">
    {{-- Statistiques principales --}}
    <div class="stats-grid">
        <div class="stat-card card-total">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-value">{{ $totalDocuments ?? 0 }}</div>
            <div class="stat-label">Total Documents</div>
            @if(isset($documentsTrend))
                <div class="stat-trend {{ $documentsTrend >= 0 ? 'trend-up' : 'trend-down' }}">
                    <i class="fas fa-arrow-{{ $documentsTrend >= 0 ? 'up' : 'down' }}"></i>
                    {{ abs($documentsTrend) }}% ce mois
                </div>
            @endif
        </div>

        <div class="stat-card card-documents">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-value">{{ $totalMatieres ?? 0 }}</div>
            <div class="stat-label">Matières Enseignées</div>
        </div>

        <div class="stat-card card-valides">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $documentsValides ?? 0 }}</div>
            <div class="stat-label">Documents Validés</div>
        </div>

        <div class="stat-card card-attente">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $documentsEnAttente ?? 0 }}</div>
            <div class="stat-label">En Attente</div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="charts-section">
        {{-- Graphique des documents par statut --}}
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <i class="fas fa-chart-pie"></i>
                    Documents par Statut
                </div>
            </div>
            <div class="chart-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        {{-- Graphique des documents par mois --}}
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <i class="fas fa-chart-bar"></i>
                    Documents Uploadés (6 derniers mois)
                </div>
            </div>
            <div class="chart-body">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Matières les plus populaires --}}
    <div class="table-section">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-fire"></i>
                Matières les Plus Actives
            </div>
        </div>

        @if(isset($topMatieres) && $topMatieres->count() > 0)
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th style="width: 10%;" class="text-center">Rang</th>
                            <th style="width: 40%;">Matière</th>
                            <th style="width: 20%;">Filière</th>
                            <th style="width: 15%;" class="text-center">Documents</th>
                            <th style="width: 15%;">Progression</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topMatieres as $index => $matiere)
                            <tr>
                                <td class="text-center">
                                    @if($index === 0)
                                        <span class="badge-rank rank-1">
                                            <i class="fas fa-trophy"></i>
                                        </span>
                                    @elseif($index === 1)
                                        <span class="badge-rank rank-2">
                                            <i class="fas fa-medal"></i>
                                        </span>
                                    @elseif($index === 2)
                                        <span class="badge-rank rank-3">
                                            <i class="fas fa-award"></i>
                                        </span>
                                    @else
                                        <span class="badge-rank rank-other">
                                            {{ $index + 1 }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #2C3E50;">
                                        <i class="fas fa-book me-2" style="color: #5D3FD3;"></i>
                                        {{ $matiere->nom }}
                                    </div>
                                </td>
                                <td>
                                    <span style="color: #718096;">
                                        {{ $matiere->filiere->nom ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span style="font-weight: 700; font-size: 1.1rem; color: #5D3FD3;">
                                        {{ $matiere->documents_count }}
                                    </span>
                                </td>
                                <td>
                                    <div class="progress-bar-wrapper">
                                        <div class="progress-bar-fill" 
                                             style="width: {{ isset($maxDocuments) && $maxDocuments > 0 ? ($matiere->documents_count / $maxDocuments * 100) : 0 }}%">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="empty-state-title">Aucune donnée disponible</div>
                <div class="empty-state-text">Commencez par ajouter des documents pour voir vos statistiques.</div>
            </div>
        @endif
    </div>

    {{-- Activité récente --}}
    <div class="activity-timeline">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-history"></i>
                Activité Récente
            </div>
        </div>

        @if(isset($recentActivities) && $recentActivities->count() > 0)
            @foreach($recentActivities as $activity)
                <div class="timeline-item">
                    <div class="timeline-icon {{ $activity->type }}">
                        @if($activity->type === 'upload')
                            <i class="fas fa-upload"></i>
                        @elseif($activity->type === 'validate')
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-times"></i>
                        @endif
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">{{ $activity->titre }}</div>
                        <div class="timeline-meta">
                            {{ $activity->matiere->nom ?? 'N/A' }} • {{ $activity->filiere->nom ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="timeline-time">
                        {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <div class="empty-state-title">Aucune activité récente</div>
                <div class="empty-state-text">Vos activités récentes apparaîtront ici.</div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique des statuts
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Validés', 'En Attente', 'Rejetés'],
                    datasets: [{
                        data: [
                            {{ $documentsValides ?? 0 }},
                            {{ $documentsEnAttente ?? 0 }},
                            {{ $documentsRejetes ?? 0 }}
                        ],
                        backgroundColor: [
                            '#27ae60',
                            '#f39c12',
                            '#e74c3c'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 13,
                                    weight: 600
                                }
                            }
                        }
                    }
                }
            });
        }

        // Graphique mensuel
        const monthlyCtx = document.getElementById('monthlyChart');
        if (monthlyCtx) {
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthLabels ?? []) !!},
                    datasets: [{
                        label: 'Documents uploadés',
                        data: {!! json_encode($monthData ?? []) !!},
                        backgroundColor: 'rgba(93, 63, 211, 0.8)',
                        borderColor: '#5D3FD3',
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush