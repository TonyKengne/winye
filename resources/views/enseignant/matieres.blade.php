@extends('layouts.enseignant')

@section('title', 'Mes Matières')
@section('page-title', 'Mes Matières')
@section('page-subtitle', 'Gérer vos matières d\'enseignement')

@push('styles')
<style>
    .matieres-container {
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

    .btn-add-matiere {
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

    .btn-add-matiere:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(93, 63, 211, 0.3);
        color: white;
    }

    .matieres-card {
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

    .matiere-name {
        font-weight: 600;
        color: #2C3E50;
        margin-bottom: 0.25rem;
        font-size: 1.05rem;
    }

    .matiere-code {
        font-size: 0.85rem;
        color: #718096;
        font-family: 'Courier New', monospace;
        background: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 5px;
        display: inline-block;
    }

    .matiere-description {
        font-size: 0.9rem;
        color: #718096;
        margin-top: 0.5rem;
        line-height: 1.5;
    }

    .badge-coefficient {
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.95rem;
        background: linear-gradient(135deg, #5D3FD3 0%, #7B68EE 100%);
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-filiere {
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        background: #e3f2fd;
        color: #2196f3;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .stats-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: #f8f9fa;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .stat-item i {
        color: #5D3FD3;
    }

    .stat-value {
        font-weight: 700;
        color: #2C3E50;
    }

    .stat-label {
        color: #718096;
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
        margin: 0 0.25rem;
    }

    .btn-action:hover {
        background: #5D3FD3;
        color: white;
        border-color: #5D3FD3;
        transform: translateY(-2px);
    }

    .btn-action.btn-edit {
        border-color: #3498db;
        color: #3498db;
    }

    .btn-action.btn-edit:hover {
        background: #3498db;
        color: white;
    }

    .btn-action.btn-delete {
        border-color: #e74c3c;
        color: #e74c3c;
    }

    .btn-action.btn-delete:hover {
        background: #e74c3c;
        color: white;
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

    /* Modal Styles */
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, #5D3FD3 0%, #7B68EE 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 1.5rem;
        border: none;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.3rem;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #2C3E50;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #5D3FD3;
        outline: none;
        box-shadow: 0 0 0 3px rgba(93, 63, 211, 0.1);
    }

    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .form-select:focus {
        border-color: #5D3FD3;
        outline: none;
        box-shadow: 0 0 0 3px rgba(93, 63, 211, 0.1);
    }

    .btn-submit {
        background: linear-gradient(135deg, #5D3FD3 0%, #7B68EE 100%);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(93, 63, 211, 0.3);
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

        .btn-add-matiere {
            width: 100%;
            justify-content: center;
        }

        .matieres-card {
            overflow-x: auto;
        }

        .table-modern {
            min-width: 900px;
        }

        .stats-group {
            flex-direction: column;
        }
    }

    @media (max-width: 576px) {
        .table-modern thead th,
        .table-modern tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.85rem;
        }

        .btn-action {
            padding: 0.4rem 0.75rem;
            font-size: 0.85rem;
        }

        .badge-coefficient,
        .badge-filiere {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid matieres-container">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" 
             style="background: #d4edda; color: #155724; border: none; border-radius: 10px; padding: 1rem 1.5rem; margin-bottom: 1.5rem;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert"
             style="background: #f8d7da; color: #721c24; border: none; border-radius: 10px; padding: 1rem 1.5rem; margin-bottom: 1.5rem;">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert"
             style="background: #f8d7da; color: #721c24; border: none; border-radius: 10px; padding: 1rem 1.5rem; margin-bottom: 1.5rem;">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Erreurs de validation :</strong>
            <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Toolbar --}}
    <div class="actions-toolbar">
        <div class="search-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" 
                   id="searchInput" 
                   placeholder="Rechercher une matière..."
                   autocomplete="off">
        </div>

        <div class="filter-group">
            <button class="filter-btn active" data-filter="all">
                <i class="fas fa-th"></i>
                Toutes
            </button>
            @if(isset($filieres) && $filieres->count() > 0)
                @foreach($filieres as $filiere)
                    <button class="filter-btn" data-filter="{{ $filiere->id }}">
                        <i class="fas fa-graduation-cap"></i>
                        {{ $filiere->nom }}
                    </button>
                @endforeach
            @endif
        </div>

        <button type="button" class="btn-add-matiere" data-bs-toggle="modal" data-bs-target="#addMatiereModal">
            <i class="fas fa-plus"></i>
            Ajouter une matière
        </button>
    </div>

    {{-- Matières Table --}}
    <div class="matieres-card">
        @if(isset($matieres) && $matieres->count() > 0)
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Matière</th>
                            <th style="width: 15%;">Code</th>
                            <th style="width: 20%;">Filière</th>
                            <th style="width: 10%;" class="text-center">Coefficient</th>
                            <th style="width: 15%;">Statistiques</th>
                            <th style="width: 10%;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="matieresTableBody">
                        @foreach($matieres as $matiere)
                            <tr class="matiere-row" 
                                data-filiere="{{ $matiere->filliere_id ?? '' }}"
                                data-nom="{{ strtolower($matiere->nom) }}"
                                data-code="{{ strtolower($matiere->code ?? '') }}">
                                <td>
                                    <div class="matiere-name">
                                        <i class="fas fa-book me-2" style="color: #5D3FD3;"></i>
                                        {{ $matiere->nom }}
                                    </div>
                                    @if($matiere->description)
                                        <div class="matiere-description">
                                            {{ Str::limit($matiere->description, 100) }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    @if($matiere->code)
                                        <span class="matiere-code">
                                            {{ $matiere->code }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge-filiere">
                                        <i class="fas fa-graduation-cap"></i>
                                        {{ $matiere->filiere->nom ?? 'Non définie' }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="badge-coefficient">
                                        <i class="fas fa-star"></i>
                                        {{ number_format($matiere->coefficient, 1) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="stats-group">
                                        <div class="stat-item" title="Nombre de documents">
                                            <i class="fas fa-file-alt"></i>
                                            <span class="stat-value">{{ $matiere->documents->count() }}</span>
                                            <span class="stat-label">docs</span>
                                        </div>
                                        <div class="stat-item" title="Nombre de sujets">
                                            <i class="fas fa-clipboard-list"></i>
                                            <span class="stat-value">{{ $matiere->sujets->count() }}</span>
                                            <span class="stat-label">sujets</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <button type="button" 
                                            class="btn-action btn-edit" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editMatiereModal"
                                            data-id="{{ $matiere->id }}"
                                            data-nom="{{ $matiere->nom }}"
                                            data-code="{{ $matiere->code }}"
                                            data-description="{{ $matiere->description }}"
                                            data-coefficient="{{ $matiere->coefficient }}"
                                            data-filiere="{{ $matiere->filliere_id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form action="{{ route('enseignant.matiere.destroy', $matiere->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
                <div class="empty-state-title">Aucune matière trouvée</div>
                <div class="empty-state-text">Essayez de modifier vos critères de recherche ou vos filtres.</div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="empty-state-title">Aucune matière enregistrée</div>
                <div class="empty-state-text">Commencez par ajouter votre première matière d'enseignement.</div>
                <button type="button" 
                        class="btn-add-matiere" 
                        style="width: auto; display: inline-flex;"
                        data-bs-toggle="modal" 
                        data-bs-target="#addMatiereModal">
                    <i class="fas fa-plus"></i>
                    Ajouter une matière
                </button>
            </div>
        @endif
    </div>
</div>

{{-- Modal Ajouter Matière --}}
<div class="modal fade" id="addMatiereModal" tabindex="-1" aria-labelledby="addMatiereModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMatiereModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>
                    Ajouter une nouvelle matière
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('enseignant.matiere.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nom" class="form-label">
                                    <i class="fas fa-book me-1"></i> Nom de la matière *
                                </label>
                                <input type="text" 
                                       class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom') }}"
                                       placeholder="Ex: Mathématiques, Physique..."
                                       required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="code" class="form-label">
                                    <i class="fas fa-hashtag me-1"></i> Code matière
                                </label>
                                <input type="text" 
                                       class="form-control @error('code') is-invalid @enderror" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code') }}"
                                       placeholder="Ex: MATH101"
                                       maxlength="20">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="filliere_id" class="form-label">
                                    <i class="fas fa-graduation-cap me-1"></i> Filière *
                                </label>
                                <select class="form-select @error('filliere_id') is-invalid @enderror" 
                                        id="filliere_id" 
                                        name="filliere_id" 
                                        required>
                                    <option value="">Sélectionnez une filière</option>
                                    @if(isset($filieres))
                                        @foreach($filieres as $filiere)
                                            <option value="{{ $filiere->id }}" {{ old('filliere_id') == $filiere->id ? 'selected' : '' }}>
                                                {{ $filiere->nom }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('filliere_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="coefficient" class="form-label">
                                    <i class="fas fa-star me-1"></i> Coefficient *
                                </label>
                                <input type="number" 
                                       class="form-control @error('coefficient') is-invalid @enderror" 
                                       id="coefficient" 
                                       name="coefficient" 
                                       value="{{ old('coefficient', 1) }}"
                                       step="0.5"
                                       min="0.5"
                                       max="10"
                                       required>
                                @error('coefficient')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i> Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3"
                                  placeholder="Description optionnelle de la matière...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer" style="border: none; padding: 1.5rem;">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save me-2"></i>
                        Enregistrer la matière
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Modifier Matière --}}
<div class="modal fade" id="editMatiereModal" tabindex="-1" aria-labelledby="editMatiereModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMatiereModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    Modifier la matière
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editMatiereForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="edit_nom" class="form-label">
                                    <i class="fas fa-book me-1"></i> Nom de la matière *
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="edit_nom" 
                                       name="nom" 
                                       required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_code" class="form-label">
                                    <i class="fas fa-hashtag me-1"></i> Code matière
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="edit_code" 
                                       name="code" 
                                       maxlength="20">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="edit_filliere_id" class="form-label">
                                    <i class="fas fa-graduation-cap me-1"></i> Filière *
                                </label>
                                <select class="form-select" 
                                        id="edit_filliere_id" 
                                        name="filliere_id" 
                                        required>
                                    <option value="">Sélectionnez une filière</option>
                                    @if(isset($filieres))
                                        @foreach($filieres as $filiere)
                                            <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_coefficient" class="form-label">
                                    <i class="fas fa-star me-1"></i> Coefficient *
                                </label>
                                <input type="number" 
                                       class="form-control" 
                                       id="edit_coefficient" 
                                       name="coefficient" 
                                       step="0.5"
                                       min="0.5"
                                       max="10"
                                       required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_description" class="form-label">
                            <i class="fas fa-align-left me-1"></i> Description
                        </label>
                        <textarea class="form-control" 
                                  id="edit_description" 
                                  name="description" 
                                  rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border: none; padding: 1.5rem;">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save me-2"></i>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const matiereRows = document.querySelectorAll('.matiere-row');
        const noResults = document.getElementById('noResults');
        const tableBody = document.getElementById('matieresTableBody');

        let currentFilter = 'all';

        // Recherche
        if (searchInput) {
            searchInput.addEventListener('input', filterMatieres);
        }

        // Filtres
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.dataset.filter;
                filterMatieres();
            });
        });

        function filterMatieres() {
            const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
            let visibleCount = 0;

            matiereRows.forEach(row => {
                const nom = row.dataset.nom || '';
                const code = row.dataset.code || '';
                const filiere = row.dataset.filiere || '';

                const matchesSearch = nom.includes(searchTerm) || code.includes(searchTerm);
                const matchesFilter = currentFilter === 'all' || filiere === currentFilter;

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

        // Remplir le formulaire de modification
        const editButtons = document.querySelectorAll('.btn-edit');
        const editForm = document.getElementById('editMatiereForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const nom = this.dataset.nom;
                const code = this.dataset.code;
                const description = this.dataset.description;
                const coefficient = this.dataset.coefficient;
                const filiere = this.dataset.filiere;

                // Mettre à jour l'action du formulaire
                editForm.action = `/enseignant/matiere/${id}`;

                // Remplir les champs
                document.getElementById('edit_nom').value = nom;
                document.getElementById('edit_code').value = code || '';
                document.getElementById('edit_description').value = description || '';
                document.getElementById('edit_coefficient').value = coefficient;
                document.getElementById('edit_filliere_id').value = filiere || '';
            });
        });
    });
</script>
@endpush