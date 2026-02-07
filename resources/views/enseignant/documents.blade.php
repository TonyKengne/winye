@extends('layouts.enseignant')

@section('content')

<style>
    .page-title {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .actions-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 10px;
    }

    .btn-primary {
        background: #3498db;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background: #2980b9;
    }

    .search-box input {
        padding: 10px 12px;
        width: 100%;
        max-width: 260px;
        border-radius: 8px;
        border: 1px solid #dcdcdc;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    th, td {
        padding: 14px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    th {
        background: #f8f9fa;
        font-weight: 700;
        color: #34495e;
    }

    tr:hover {
        background: #f4faff;
    }

    .badge {
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-pdf { background: #e74c3c; color: white; }
    .badge-doc { background: #3498db; color: white; }
    .badge-img { background: #2ecc71; color: white; }
    .badge-other { background: #95a5a6; color: white; }
</style>

<div class="container">

    <h1 class="page-title">📄 Mes documents</h1>

    <div class="actions-bar">
        <div class="search-box">
            <input type="text" placeholder="Rechercher un document...">
        </div>

        <a href="{{ route('enseignant.upload') }}">
            <button class="btn-primary">+ Ajouter un document</button>
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Matière</th>
                    <th>Filière</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($documents as $doc)
                    <tr>
                        <td>{{ $doc->titre }}</td>
                        <td>{{ $doc->matiere->nom ?? 'Non définie' }}</td>
                        <td>{{ $doc->filiere->nom ?? 'Non définie' }}</td>

                        <td>
                            @php
                                $ext = strtolower(pathinfo($doc->chemin_fichier, PATHINFO_EXTENSION));
                            @endphp

                            @if($ext === 'pdf')
                                <span class="badge badge-pdf">PDF</span>
                            @elseif(in_array($ext, ['doc', 'docx']))
                                <span class="badge badge-doc">DOCX</span>
                            @elseif(in_array($ext, ['jpg','jpeg','png']))
                                <span class="badge badge-img">Image</span>
                            @else
                                <span class="badge badge-other">Fichier</span>
                            @endif
                        </td>

                        <td>{{ \Carbon\Carbon::parse($doc->date_upload)->format('d M Y') }}</td>

                        <td>
                            @if($doc->valide === 1)
                                <span class="badge badge-img" style="background:#27ae60;">Validé</span>
                            @elseif($doc->valide === 0)
                                <span class="badge badge-doc" style="background:#f39c12;">En attente</span>
                            @else
                                <span class="badge badge-pdf" style="background:#c0392b;">Rejeté</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('enseignant.document.show', $doc->id) }}">
                                <button class="btn-primary" style="padding:6px 12px;">Voir</button>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:20px;">
                            Aucun document trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
