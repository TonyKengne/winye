@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <h3 class="mb-4">Gestion des notifications</h3>

    {{-- MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card notification-card">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.notifications.send') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Titre</label>
                    <input type="text" name="titre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Message</label>
                    <textarea name="message" rows="4" class="form-control" required></textarea>
                </div>

                {{-- CIBLE --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Envoyer à</label>
                    <select name="cible" id="cible" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="role">Un rôle</option>
                        <option value="utilisateur">Un utilisateur précis</option>
                    </select>
                </div>

                {{-- PAR RÔLE --}}
                <div class="mb-3 d-none" id="role-section">
                    <label class="form-label">Rôle</label>
                    <select name="role_id" class="form-select">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ ucfirst($role->libelle) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- PAR UTILISATEUR --}}
                <div class="mb-3 d-none" id="user-section">
                    <label class="form-label">Utilisateur</label>
                    <select name="compte_utilisateur_id" class="form-select">
                        @foreach($utilisateurs as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->email }} ({{ $user->role->libelle }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-violet mt-3">
                    <i class="bi bi-send"></i> Envoyer
                </button>

            </form>

        </div>
    </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
/* =====================
   COULEURS
===================== */
:root {
    --violet-primary: #6f42c1;
    --violet-light: rgba(111, 66, 193, 0.12);
}

/* =====================
   CARD
===================== */
.notification-card {
    border-radius: 14px;
    box-shadow: -4px 6px 15px rgba(0, 0, 0, 0.08);
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}

.notification-card:hover {
    transform: translateY(-2px);
    box-shadow: -6px 10px 22px rgba(0, 0, 0, 0.12);
}

/* =====================
   INPUTS / SELECTS
===================== */
.form-control,
.form-select {
    border-radius: 10px;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--violet-primary);
    box-shadow: 0 0 0 0.15rem var(--violet-light);
}

/* =====================
   BOUTON
===================== */
.btn-violet {
    background-color: var(--violet-primary);
    color: #fff;
    border: none;
    padding: 0.45rem 1.2rem;
}

.btn-violet:hover {
    background-color: #5a34a0;
    color: #fff;
}
</style>

{{-- ================= JS ================= --}}
<script>
    const cible = document.getElementById('cible');
    const roleSection = document.getElementById('role-section');
    const userSection = document.getElementById('user-section');

    cible.addEventListener('change', () => {
        roleSection.classList.add('d-none');
        userSection.classList.add('d-none');

        if (cible.value === 'role') {
            roleSection.classList.remove('d-none');
        }

        if (cible.value === 'utilisateur') {
            userSection.classList.remove('d-none');
        }
    });
</script>

@endsection
