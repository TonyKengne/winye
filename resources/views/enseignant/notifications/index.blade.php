@extends('layouts.enseignant')

@section('title', 'Notifications')
@section('page-title', 'Notifications')
@section('page-subtitle', 'Vos notifications récentes')

@section('content')
<div class="container-fluid">

    {{-- Bouton contacter admin --}}
    <div class="mb-4">
        <a href="{{ route('enseignant.notifications.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-envelope me-2"></i>
            Contacter l’administrateur
        </a>
    </div>

    {{-- Liste notifications --}}
    @forelse($notifications as $notification)
        <div class="notification-card {{ $notification->is_lu ? 'read' : 'unread' }}">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="notification-title">
                        {{ $notification->titre }}
                    </h5>

                    <p class="notification-message">
                        {{ $notification->message }}
                    </p>

                    <small class="notification-date">
                        {{ $notification->created_at->diffForHumans() }}
                    </small>
                </div>

                @if(!$notification->is_lu)
                    <form method="POST"
                          action="{{ route('enseignant.notifications.read', $notification->id) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary rounded-pill">
                            Marquer comme lu
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-bell-slash fa-3x mb-3"></i>
            <p>Aucune notification pour le moment.</p>
        </div>
    @endforelse

</div>
@push('styles')
<style>

.notification-card {
    background: #fff;
    padding: 1.5rem;
    border-radius: 15px;
    margin-bottom: 1rem;
    box-shadow: 0 4px 12px rgba(93, 63, 211, 0.08);
    transition: all 0.3s ease;
}

.notification-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(93, 63, 211, 0.15);
}

.notification-card.unread {
    border-left: 4px solid #5D3FD3;
    background: #f8f7ff;
}

.notification-card.read {
    opacity: 0.8;
}

.notification-title {
    font-weight: 700;
    color: #2C3E50;
    margin-bottom: 0.5rem;
}

.notification-message {
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.notification-date {
    font-size: 0.85rem;
    color: #718096;
}

.empty-state {
    text-align: center;
    padding: 3rem;e
    color: #a0aec0;
}
.btn-primary{
    border: solid 1px #5D3FD3 ; 
    background: none;
    color: #5D3FD3;
}.btn-primary:hover{
    background: #5D3FD3;
    color: white;
}
</style>
@endpush

@endsection
