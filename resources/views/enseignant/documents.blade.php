@extends('layouts.enseignant')

@section('title', 'Mes Documents')
@section('page-title', 'Mes Documents')
@section('page-subtitle', 'Gérer vos épreuves et documents')

@push('styles')
<style>
    .documents-container {
        padding: 0;
    }

    .actions-toolbar {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(93, 63, 211, 0.1);
        margin-bottom: 1.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
        justify-content: space-between;
    }

    .search-wrapper {
        flex: 1;
        min-width: 250px;
        max-width: 400px;
        position: relative;
    }

    .search-wrapper input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .search-wrapper input:focus {
        border-color: #5D3FD3;
        outline: none;
        box-shadow: 0 0 0 3px rgba(93, 63, 211, 0.1);
    }

    .search-wrapper i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #718096;
        font-size: 1rem;
    }

    .filter-group {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        background: white;
        color: #2C3E50;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-btn:hover {
        border-color: #5D3FD3;
        color: #5D3FD3;
    }

    .filter-btn.active {
        background: #5D3FD3;
        color: white;
        border-color: #5D3FD3;
    }

    .btn-add-document {
        background: linear-gradient(135deg, #5D3FD3 0%, #7B68EE 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-add-document:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(93, 63, 211, 0.3);
        color: white;
    }

    .documents-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(93, 63, 211, 0.1);
        overflow: hidden;
    }

    .table-modern {
        width: 100%;
        margin: 0;
    }

    .table-modern thead {
        background: #f8f9fa;
    }

    .table-modern thead th {
        padding: 1.25rem 1.5rem;
        font-weight: 700;
        color: #2C3E50;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e9ecef;
    }

    .table-modern tbody td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        color: #495057;
    }

    .table-modern tbody tr {
        transition: all 0.3s;
    }

    .table-modern tbody tr:hover {
        background: #f8f7ff;
    }

    .document-title {
        font-weight: 600;
        color: #2C3E50;
        margin-bottom: 0.25rem;
    }

    .document-meta {
        font-size: 0.85rem;
        color: #718096;
    }

    .badge-file {
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-pdf {
        background: #fee;
        color: #e74c3c;
    }

    .badge-doc {
        background: #e3f2fd;
        color: #2196f3;
    }

    .badge-ppt {
        background: #fff3e0;
        color: #ff9800;
    }

    .badge-img {
        background: #e8f5e9;
        color: #4caf50;
    }

    .badge-other {
        background: #f5f5f5;
        color: #757575;
    }

    .badge-status {
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-valide {
        background: #d4edda;
        color: #155724;
    }

    .status-attente {
        background: #fff3cd;
        color: #856404;
    }

    .status-rejete {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        background: white;
        color: #5D3FD3;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action:hover {
        background: #5D3FD3;
        color: white;
        border-color: #5D3FD3;
        transform: translateY(-2px);
    }

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
        margin-bottom: 2rem;
        font-size: 1.05rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .table-modern {
            font-size: 0.9rem;
        }

        .table-modern thead th,
        .table-modern tbody td {
            padding: 1rem;
        }
    }

    @media (max-width: 768px) {
        .actions-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-wrapper {
            max-width: 100%;
        }

        .filter-group {
            justify-content: center;
        }

        .btn-add-document {
            width: 100%;
            justify-content: center;
        }

        .documents-card {
            overflow-x: auto;
        }

        .table-modern {
            min-width: 800px;
        }
    }

    @media (max-width: 576px) {
        .table-modern thead th,
        .table-modern tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.85rem;
        }

        .badge-file,
        .badge-status {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
        }

        .btn-action {
            padding: 0.4rem 0.75rem;
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid documents-container">
    {{-- Toolbar --}}
    <div class="actions-toolbar">
        <div class="search-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" 
                   id="searchInput" 
                   placeholder="Rechercher un document..."
                   autocomplete="off">
        </div>

        <div class="filter-group">
            <button class="filter-btn active" data-filter="all">
                <i class="fas fa-th"></i>
                Tous
            </button>
            <button class="filter-btn" data-filter="valide">
                <i class="fas fa-check-circle"></i>
                Validés
            </button>
            <button class="filter-btn" data-filter="attente">
                <i class="fas fa-clock"></i>
                En attente
            </button>
            <button class="filter-btn" data-filter="rejete">
                <i class="fas fa-times-circle"></i>
                Rejetés
            </button>
        </div>

        <a href="{{ route('enseignant.upload') }}" class="btn-add-document">
            <i class="fas fa-plus"></i>
            Ajouter un document
        </a>
    </div>

    {{-- Documents Table --}}
    <div class="documents-card">
        @if($documents->count() > 0)
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th style="width: 35%;">Document</th>
                            <th style="width: 15%;">Matière</th>
                            <th style="width: 15%;">Filière</th>
                            <th style="width: 10%;">Type</th>
                            <th style="width: 12%;">Date</th>
                            <th style="width: 10%;">Statut</th>
                            <th style="width: 8%;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="documentsTableBody">
                        @foreach($documents as $doc)
                            <tr class="document-row" 
                                data-status="{{ $doc->valide === 1 ? 'valide' : ($doc->valide === 0 ? 'attente' : 'rejete') }}"
                                data-title="{{ strtolower($doc->titre) }}"
                                data-matiere="{{ strtolower($doc->matiere->nom ?? '') }}"
                                data-filiere="{{ strtolower($doc->filiere->nom ?? '') }}">
                                <td>
                                    <div class="document-title">
                                        {{ Str::limit($doc->titre, 50) }}
                                    </div>
                                    @if($doc->sujet)
                                        <div class="document-meta">
                                            <i class="far fa-calendar me-1"></i>
                                            {{ $doc->sujet->annee }} • {{ $doc->sujet->type_examen }}
                                            @if($doc->sujet->corrige_disponible)
                                                • <span style="color: #27ae60;"><i class="fas fa-check-circle"></i> Avec corrigé</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <span class="text-muted">
                                        <i class="fas fa-book me-1" style="color: #5D3FD3;"></i>
                                        {{ $doc->matiere->nom ?? 'Non définie' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="text-muted">
                                        {{ $doc->filiere->nom ?? 'Non définie' }}
                                    </span>
                                </td>

                                <td>
                                    @php
                                        $ext = strtolower($doc->type ?? pathinfo($doc->chemin_fichier, PATHINFO_EXTENSION));
                                    @endphp

                                    @if($ext === 'pdf')
                                        <span class="badge-file badge-pdf">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </span>
                                    @elseif(in_array($ext, ['doc', 'docx']))
                                        <span class="badge-file badge-doc">
                                            <i class="fas fa-file-word"></i> DOCX
                                        </span>
                                    @elseif(in_array($ext, ['ppt', 'pptx']))
                                        <span class="badge-file badge-ppt">
                                            <i class="fas fa-file-powerpoint"></i> PPT
                                        </span>
                                    @elseif(in_array($ext, ['jpg', 'jpeg', 'png']))
                                        <span class="badge-file badge-img">
                                            <i class="fas fa-file-image"></i> Image
                                        </span>
                                    @else
                                        <span class="badge-file badge-other">
                                            <i class="fas fa-file"></i> Fichier
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($doc->date_upload)->format('d M Y') }}
                                    </small>
                                </td>

                                <td>
                                    @if($doc->valide === 1)
                                        <span class="badge-status status-valide">
                                            <i class="fas fa-check-circle"></i> Validé
                                        </span>
                                    @elseif($doc->valide === 0)
                                        <span class="badge-status status-attente">
                                            <i class="fas fa-clock"></i> En attente
                                        </span>
                                    @else
                                        <span class="badge-status status-rejete">
                                            <i class="fas fa-times-circle"></i> Rejeté
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('enseignant.document.show', $doc->id) }}" class="btn-action">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Message "Aucun résultat" --}}
            <div id="noResults" style="display: none;" class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="empty-state-title">Aucun document trouvé</div>
                <div class="empty-state-text">Essayez de modifier vos critères de recherche ou vos filtres.</div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <div class="empty-state-title">Aucun document uploadé</div>
                <div class="empty-state-text">Commencez par ajouter votre premier document.</div>
                <a href="{{ route('enseignant.upload') }}" class="btn-add-document" style="width: auto; display: inline-flex;">
                    <i class="fas fa-plus"></i>
                    Ajouter un document
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const documentRows = document.querySelectorAll('.document-row');
        const noResults = document.getElementById('noResults');
        const tableBody = document.getElementById('documentsTableBody');

        let currentFilter = 'all';

        // Recherche
        if (searchInput) {
            searchInput.addEventListener('input', filterDocuments);
        }

        // Filtres
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.dataset.filter;
                filterDocuments();
            });
        });

        function filterDocuments() {
            const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
            let visibleCount = 0;

            documentRows.forEach(row => {
                const title = row.dataset.title || '';
                const matiere = row.dataset.matiere || '';
                const filiere = row.dataset.filiere || '';
                const status = row.dataset.status || '';

                const matchesSearch = title.includes(searchTerm) || 
                                    matiere.includes(searchTerm) || 
                                    filiere.includes(searchTerm);
                
                const matchesFilter = currentFilter === 'all' || status === currentFilter;

                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Afficher/masquer le message "Aucun résultat"
            if (noResults && tableBody) {
                if (visibleCount === 0) {
                    tableBody.style.display = 'none';
                    noResults.style.display = 'block';
                } else {
                    tableBody.style.display = '';
                    noResults.style.display = 'none';
                }
            }
        }
    });
</script>
@endpush