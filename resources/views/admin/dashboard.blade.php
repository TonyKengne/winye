@extends('layouts.admin')

@section('content')
    <h3>Dashboard Administrateur</h3>
    <p>Bienvenue dans l’espace d’administration de Winye.</p>
    <a href="{{ route('admin.campus.index') }}">campus</a>
    <a href="{{ route('admin.cursus.index') }}">cursus</a>
    <a href="{{ route('admin.departement.index') }}">departement</a>
@endsection
