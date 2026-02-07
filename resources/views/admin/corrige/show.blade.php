@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/matiere/show.css') }}">

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-file-earmark-check text-success"></i>
            Corrigé du sujet
        </h3>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.sujet.show', $corrige->sujet_id) }}"
               class="btn btn-outline-violet btn-sm">
                <i class="bi bi-eye"></i> Voir le sujet
            </a>

            <a href="{{ route('admin.sujet.index') }}"
               class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            {{-- INFOS --}}
            <div class="mb-4">
                <h5 class="fw-bold mb-2">{{ $corrige->sujet->titre }}</h5>

                <div class="text-muted small">
                    <span>{{ $corrige->sujet->matiere->nom ?? '-' }}</span> •
                    <span>{{ $corrige->sujet->type }}</span> •
                    <span>Semestre {{ $corrige->sujet->semestre }}</span> •
                    <span>{{ $corrige->sujet->annee_academique }}</span>
                </div>
            </div>

            {{-- PDF --}}
            <div style="height:80vh; border:1px solid #dee2e6;">
                @if($corrige->fichier)
                    <iframe
                        src="{{ asset('storage/'.$corrige->fichier) }}"
                        width="100%"
                        height="100%"
                        style="border:none;">
                    </iframe>
                @else
                    <div class="alert alert-light">
                        <i class="bi bi-info-circle"></i>
                        Aucun fichier de corrigé disponible.
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
 