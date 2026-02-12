@extends('layouts.etudiant')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid">

    {{-- Bouton contacter admin --}}
    <div class="mb-4">
        <a href="{{ route('etudiant.notifications.create') }}" 
           class="btn btn-violet rounded-pill px-4">
            <i class="fas fa-envelope me-2"></i>
            Contacter l’administrateur
        </a>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
                          action="{{ route('etudiant.notifications.read', $notification->id) }}">
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
@endsection
