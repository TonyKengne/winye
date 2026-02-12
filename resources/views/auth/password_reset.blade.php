@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Définir un nouveau mot de passe</h3>
    <form method="POST" action="{{ route('password.reset') }}">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <div class="mb-3">
            <label>Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Changer le mot de passe</button>
    </form>
</div>
@endsection
