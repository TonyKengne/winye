@extends('layouts.etudiant')

@section('content')

<div class="container-fluid">
    <h3 class="mb-4">Contacter l'administration</h3>

    {{-- Message succès --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Message erreur validation --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm rounded-4">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('etudiant.notifications.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Titre</label>
                    <input type="text"
                           name="titre"
                           class="form-control"
                           value="{{ old('titre') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Message</label>
                    <textarea name="message"
                              rows="4"
                              class="form-control"
                              required>{{ old('message') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Destinataire</label>
                    <select name="role_id" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="4">Administrateur</option>
                        <option value="3">Secrétaire</option>
                    </select>
                </div>

                <button class="btn btn-primary mt-3 px-4 rounded-pill">
                    <i class="bi bi-send me-1"></i> Envoyer
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
}
.btn-primary:hover{
    background: #5D3FD3;
    color: white;
}
</style>

@endsection
