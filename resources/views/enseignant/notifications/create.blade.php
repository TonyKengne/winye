@extends('layouts.enseignant')

@section('content')

<div class="container-fluid">
    <h3 class="mb-4">Contacter l'administration</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('enseignant.notifications.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Titre</label>
                    <input type="text" name="titre" class="form-control" required>
                </div>
                

                <div class="mb-3">
                    <label class="form-label fw-bold">Message</label>
                    <textarea name="message" rows="4" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Destinataire</label>
                    <select name="role_id" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="4">Administrateur</option>
                        <option value="3">Secrétaire</option>
                    </select>
                </div>

                <button class="btn btn-primary mt-3">
                    <i class="bi bi-send"></i> Envoyer
                </button>

            </form>

        </div>
    </div>
</div>
 <style>
    .btn-primary{
    border: solid 1px #5D3FD3 ; 
    background: none;
    color: #5D3FD3;
}.btn-primary:hover{
    background: #5D3FD3;
    color: white;
}
 </style>

@endsection
