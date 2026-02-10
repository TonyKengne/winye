@extends('layouts.enseignant')

@section('title', 'Uploader un Document')
@section('page-title', 'Uploader un Document')
@section('page-subtitle', 'Ajouter une nouvelle épreuve')

@push('styles')
<style>
    .upload-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .upload-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(93, 63, 211, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .upload-card-header {
        background: linear-gradient(135deg, #5D3FD3 0%, #7B68EE 100%);
        color: white;
        padding: 1.75rem 2rem;
        border: none;
    }

    .upload-card-header h4 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .upload-card-body {
        padding: 2rem;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #e9ecef;
    }

    .form-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2C3E50;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-section-title i {
        color: #5D3FD3;
        font-size: 1.2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        font-weight: 600;
        color: #34495e;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.95rem;
    }

    .form-group label .required {
        color: #e74c3c;
        margin-left: 3px;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        font-size: 0.95rem;
        transition: all 0.3s;
        background: white;
    }

    .form-control:focus, .form-select:focus {
        border-color: #5D3FD3;
        outline: none;
        box-shadow: 0 0 0 3px rgba(93, 63, 211, 0.1);
    }

    .form-control::placeholder {
        color: #a0aec0;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .file-upload-area {
        border: 2px dashed #5D3FD3;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background: #f8f7ff;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
    }

    .file-upload-area:hover {
        background: #f0edff;
        border-color: #7B68EE;
    }

    .file-upload-area.dragover {
        background: #e8e6ff;
        border-color: #5D3FD3;
    }

    .file-upload-icon {
        font-size: 3rem;
        color: #5D3FD3;
        margin-bottom: 1rem;
    }

    .file-upload-text {
        color: #2C3E50;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .file-upload-hint {
        color: #718096;
        font-size: 0.9rem;
    }

    .file-input-hidden {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        overflow: hidden;
    }

    .file-preview {
        margin-top: 1rem;
        padding: 1rem;
        background: white;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        display: none;
    }

    .file-preview.active {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .file-preview-icon {
        font-size: 2rem;
        color: #5D3FD3;
    }

    .file-preview-info {
        flex: 1;
    }

    .file-preview-name {
        font-weight: 600;
        color: #2C3E50;
        margin-bottom: 0.25rem;
    }

    .file-preview-size {
        font-size: 0.85rem;
        color: #718096;
    }

    .file-preview-remove {
        background: #fee;
        color: #e74c3c;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .file-preview-remove:hover {
        background: #e74c3c;
        color: white;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 1rem;
        background: #f8f7ff;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .checkbox-wrapper:hover {
        background: #f0edff;
    }

    .checkbox-wrapper input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #5D3FD3;
    }

    .checkbox-wrapper label {
        margin: 0;
        cursor: pointer;
        font-weight: 500;
        color: #2C3E50;
    }

    .btn-submit {
        background: linear-gradient(135deg, #5D3FD3 0%, #7B68EE 100%);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        font-size: 1.05rem;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(93, 63, 211, 0.3);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .alert {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: none;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .alert ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .upload-card-header {
            padding: 1.25rem 1.5rem;
        }

        .upload-card-header h4 {
            font-size: 1.25rem;
        }

        .upload-card-body {
            padding: 1.5rem;
        }

        .form-section-title {
            font-size: 1rem;
        }

        .file-upload-area {
            padding: 1.5rem;
        }

        .file-upload-icon {
            font-size: 2.5rem;
        }

        .btn-submit {
            padding: 0.875rem 2rem;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .upload-card-body {
            padding: 1rem;
        }

        .form-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="upload-container">
        {{-- Notifications --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong><i class="fas fa-exclamation-triangle me-2"></i>Erreurs détectées :</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulaire --}}
        <div class="upload-card">
            <div class="upload-card-header">
                <h4>
                    <i class="fas fa-file-upload"></i>
                    Ajouter une épreuve
                </h4>
            </div>

            <div class="upload-card-body">
                <form action="{{ route('enseignant.storeDocument') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf

                    {{-- Section 1: Informations générales --}}
                    <div class="form-section">
                        <h5 class="form-section-title">
                            <i class="fas fa-info-circle"></i>
                            Informations générales
                        </h5>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="titre">
                                        Titre du document
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" 
                                           name="titre" 
                                           id="titre" 
                                           class="form-control" 
                                           placeholder="Ex: Examen final de Programmation Web"
                                           value="{{ old('titre') }}"
                                           required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" 
                                              id="description" 
                                              class="form-control"
                                              placeholder="Décrivez brièvement le contenu de l'épreuve...">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Détails de l'épreuve --}}
                    <div class="form-section">
                        <h5 class="form-section-title">
                            <i class="fas fa-clipboard-list"></i>
                            Détails de l'épreuve
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="annee">
                                        Année académique
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" 
                                           name="annee" 
                                           id="annee" 
                                           class="form-control" 
                                           value="{{ date('Y') }}/{{ date('Y')+1 }}"
                                           required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="semestre">
                                        Semestre
                                        <span class="required">*</span>
                                    </label>
                                    <select name="semestre" id="semestre" class="form-select" required>
                                        <option value="">-- Sélectionner --</option>
                                        <option value="1" {{ old('semestre') == '1' ? 'selected' : '' }}>Semestre 1</option>
                                        <option value="2" {{ old('semestre') == '2' ? 'selected' : '' }}>Semestre 2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type_examen">
                                        Type d'examen
                                        <span class="required">*</span>
                                    </label>
                                    <select name="type_examen" id="type_examen" class="form-select" required>
                                        <option value="">-- Sélectionner --</option>
                                        <option value="Examen" {{ old('type_examen') == 'Examen' ? 'selected' : '' }}>Examen</option>
                                        <option value="TP" {{ old('type_examen') == 'TP' ? 'selected' : '' }}>Travaux Pratiques (TP)</option>
                                        <option value="TD" {{ old('type_examen') == 'TD' ? 'selected' : '' }}>Travaux Dirigés (TD)</option>
                                        <option value="CC" {{ old('type_examen') == 'CC' ? 'selected' : '' }}>Contrôle Continu (CC)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duree">Durée</label>
                                    <input type="text" 
                                           name="duree" 
                                           id="duree" 
                                           class="form-control" 
                                           placeholder="Ex: 2h, 3h30"
                                           value="{{ old('duree') }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="coefficient">Coefficient</label>
                                    <input type="number" 
                                           name="coefficient" 
                                           id="coefficient" 
                                           class="form-control" 
                                           placeholder="Ex: 3"
                                           min="1" 
                                           max="10"
                                           step="0.5"
                                           value="{{ old('coefficient') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Classification --}}
                    <div class="form-section">
                        <h5 class="form-section-title">
                            <i class="fas fa-tags"></i>
                            Classification
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="matiere_id">
                                        Matière
                                        <span class="required">*</span>
                                    </label>
                                    <select name="matiere_id" id="matiere_id" class="form-select" required>
                                        <option value="">-- Sélectionner une matière --</option>
                                        @foreach($matieres as $matiere)
                                            <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                                {{ $matiere->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="filliere_id">
                                        Filière
                                        <span class="required">*</span>
                                    </label>
                                    <select name="filliere_id" id="filliere_id" class="form-select" required>
                                        <option value="">-- Sélectionner une filière --</option>
                                        @foreach($filieres as $filiere)
                                            <option value="{{ $filiere->id }}" {{ old('filliere_id') == $filiere->id ? 'selected' : '' }}>
                                                {{ $filiere->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="checkbox-wrapper">
                            <input type="checkbox" 
                                   name="est_corrige" 
                                   id="est_corrige" 
                                   value="1"
                                   {{ old('est_corrige') ? 'checked' : '' }}>
                            <label for="est_corrige">
                                <i class="fas fa-check-circle me-1"></i>
                                Ce document contient le corrigé
                            </label>
                        </div>
                    </div>

                    {{-- Section 4: Fichier --}}
                    <div class="form-section">
                        <h5 class="form-section-title">
                            <i class="fas fa-file"></i>
                            Document
                        </h5>

                        <div class="file-upload-area" id="fileUploadArea">
                            <div class="file-upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="file-upload-text">
                                Cliquez pour sélectionner ou glissez-déposez le fichier
                            </div>
                            <div class="file-upload-hint">
                                Formats acceptés: PDF, DOC, DOCX, PPT, PPTX, JPG, PNG (Max: 5 MB)
                            </div>
                            <input type="file" 
                                   name="document" 
                                   id="document" 
                                   class="file-input-hidden"
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png"
                                   required>
                        </div>

                        <div class="file-preview" id="filePreview">
                            <div class="file-preview-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="file-preview-info">
                                <div class="file-preview-name" id="fileName"></div>
                                <div class="file-preview-size" id="fileSize"></div>
                            </div>
                            <button type="button" class="file-preview-remove" id="removeFile">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Bouton Submit --}}
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-upload"></i>
                        Téléverser le document
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('document');
        const fileUploadArea = document.getElementById('fileUploadArea');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const removeFile = document.getElementById('removeFile');

        // Click sur la zone de upload
        fileUploadArea.addEventListener('click', () => fileInput.click());

        // Drag & Drop
        fileUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileUploadArea.classList.add('dragover');
        });

        fileUploadArea.addEventListener('dragleave', () => {
            fileUploadArea.classList.remove('dragover');
        });

        fileUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            fileUploadArea.classList.remove('dragover');
            
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                handleFileSelect(e.dataTransfer.files[0]);
            }
        });

        // Sélection de fichier
        fileInput.addEventListener('change', function() {
            if (this.files.length) {
                handleFileSelect(this.files[0]);
            }
        });

        // Afficher le fichier sélectionné
        function handleFileSelect(file) {
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            filePreview.classList.add('active');
            
            // Changer l'icône selon le type
            const ext = file.name.split('.').pop().toLowerCase();
            const icon = filePreview.querySelector('.file-preview-icon i');
            
            if (ext === 'pdf') {
                icon.className = 'fas fa-file-pdf';
                icon.style.color = '#e74c3c';
            } else if (['doc', 'docx'].includes(ext)) {
                icon.className = 'fas fa-file-word';
                icon.style.color = '#2980b9';
            } else if (['ppt', 'pptx'].includes(ext)) {
                icon.className = 'fas fa-file-powerpoint';
                icon.style.color = '#e67e22';
            } else if (['jpg', 'jpeg', 'png'].includes(ext)) {
                icon.className = 'fas fa-file-image';
                icon.style.color = '#27ae60';
            } else {
                icon.className = 'fas fa-file-alt';
                icon.style.color = '#5D3FD3';
            }
        }

        // Supprimer le fichier
        removeFile.addEventListener('click', function(e) {
            e.stopPropagation();
            fileInput.value = '';
            filePreview.classList.remove('active');
        });

        // Formater la taille du fichier
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }
    });
</script>
@endpush