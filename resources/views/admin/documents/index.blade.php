@extends('layouts.admin')

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
    <h1>📂 Gestion des documents</h1>

    <h2>En attente de validation</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Matière</th>
                <th>Enseignant</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentsEnAttente as $doc)
                <tr>
                    <td>{{ $doc->titre }}</td>
                    <td>{{ $doc->matiere->nom ?? 'N/A' }}</td>
                    <td>{{ $doc->enseignant->email ?? 'N/A' }}</td>
                    <td>{{ $doc->date_upload }}</td>
                    <td>
                        <form action="{{ route('admin.documents.valider', $doc->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">✅ Valider</button>
                        </form>
                        <form action="{{ route('admin.documents.rejeter', $doc->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">❌ Rejeter</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Aucun document en attente</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Documents validés</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Matière</th>
                <th>Enseignant</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentsValides as $doc)
                <tr>
                    <td>{{ $doc->titre }}</td>
                    <td>{{ $doc->matiere->nom ?? 'N/A' }}</td>
                    <td>{{ $doc->enseignant->email ?? 'N/A' }}</td>
                    <td>{{ $doc->date_upload }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Aucun document validé</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
