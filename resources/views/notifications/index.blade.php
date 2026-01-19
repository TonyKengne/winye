@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <h3 class="mb-4">Notifications</h3>

    {{-- Bouton contacter admin (étudiant & enseignant seulement) --}}
    @if(in_array(session('role_id'), [1, 2]))
        <div class="mb-4">
            <a href="{{ route('notifications.contact.admin') }}"
               class="btn btn-violet">
                <i class="bi bi-envelope"></i>
                Contacter l’administrateur
            </a>
        </div>
    @endif

    {{-- Messages --}}
    @forelse($notifications as $notification)
        <div class="card notification-item mb-3 {{ $notification->is_lu ? 'opacity-75' : 'unread' }}">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $notification->titre }}
                </h5>

                <p class="card-text">
                    {{ $notification->message }}
                </p>

                <small class="text-muted">
                    {{ $notification->created_at->diffForHumans() }}
                </small>

                @if(!$notification->is_lu)
                    <form method="POST"
                          action="{{ route('notifications.read', $notification->id) }}"
                          class="mt-2">
                        @csrf
                        <button class="btn btn-sm btn-outline-violet">
                            Marquer comme lu
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">Aucune notification.</p>
    @endforelse
</div>

{{-- ================= STYLE ================= --}}
<style>
/* =====================
   VARIABLES
===================== */
:root {
    --violet-primary: #6f42c1;
    --violet-light: rgba(111, 66, 193, 0.15);
}

/* =====================
   BOUTON PRINCIPAL
===================== */
.btn-violet {
    background-color: var(--violet-primary);
    color: #fff;
    border: none;
}

.btn-violet:hover {
    background-color: #5a34a0;
    color: #fff;
}

/* =====================
   BOUTON OUTLINE
===================== */
.btn-outline-violet {
    border: 1px solid var(--violet-primary);
    color: var(--violet-primary);
}

.btn-outline-violet:hover {
    background-color: var(--violet-primary);
    color: #fff;
}

/* =====================
   CARDS NOTIFICATIONS
===================== */
.notification-item {
    border-radius: 14px;
    background: #fff;
    box-shadow: -4px 6px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: -6px 10px 22px rgba(0, 0, 0, 0.12);
}

/* =====================
   NON LU
===================== */
.notification-item.unread {
    border-left: 4px solid var(--violet-primary);
    background-color: var(--violet-light);
}

/* =====================
   TITRE
===================== */
.notification-item .card-title {
    font-size: 1.05rem;
    font-weight: 600;
    color: #1f2937;
}
</style>

@endsection
