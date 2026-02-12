@extends('layouts.etudiant')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-violet">
            <i class="bi bi-heart-fill text-danger"></i>
            Mes Favoris
        </h3>

        <a href="{{ route('utilisateur.dashboard') }}" class="btn btn-outline-violet btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    {{-- LISTE --}}
    <div class="row g-4">

        @forelse($sujets as $sujet)

        <div class="col-md-6 col-lg-4 favori-item">
            <div class="card shadow-sm border-0 h-100 favori-card">

                <div class="card-body d-flex flex-column justify-content-between">

                    <div>
                        <h6 class="fw-bold text-dark">
                            {{ $sujet->titre }}
                        </h6>

                        <div class="small text-muted mb-2">
                            {{ $sujet->matiere->nom ?? '-' }} •
                            {{ $sujet->type }} •
                            {{ $sujet->annee_academique }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="d-flex gap-2">
                            <a href="{{ route('sujets.voir', $sujet->id) }}"
                               class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-eye"></i>
                            </a>

                            @if($sujet->corrige)
                                <a href="{{ route('corriges.voir', $sujet->corrige->id) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                            @endif
                        </div>

                        {{-- COEUR ROUGE --}}
                        <button class="btn border-0 toggle-favori"
                                data-id="{{ $sujet->id }}">
                            <i class="bi bi-heart-fill text-danger fs-5"></i>
                        </button>

                    </div>

                </div>
            </div>
        </div>

        @empty
        <div class="col-12">
            <div class="alert alert-light text-center shadow-sm">
                <i class="bi bi-heart text-danger"></i>
                Vous n'avez aucun favori pour le moment.
            </div>
        </div>
        @endforelse

    </div>

</div>

{{-- AJAX --}}
<script>
document.querySelectorAll('.toggle-favori').forEach(btn => {
    btn.addEventListener('click', function () {

        let sujetId = this.dataset.id;
        let card = this.closest('.favori-item');

        fetch("{{ route('etudiant.favoris.toggle') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                sujet_id: sujetId
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.removed){
                card.remove();
            }
        });

    });
});
</script>

<style>
.favori-card {
    border-radius: 15px;
    transition: 0.3s ease;
}

.favori-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.text-violet {
    color: #5D3FD3;
}

.btn-outline-violet {
    border: 1px solid #5D3FD3;
    color: #5D3FD3;
}

.btn-outline-violet:hover {
    background: #5D3FD3;
    color: white;
}
</style>

@endsection
