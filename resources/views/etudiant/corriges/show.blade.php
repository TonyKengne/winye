@extends('layouts.etudiant')

@section('content')
<div class="container-fluid my-5">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3 class="fw-bold text-success">
            <i class="bi bi-file-earmark-check"></i> Visualisation du corrigé
        </h3>
        <a href="{{ url()->previous() }}" class="btn btn-success btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            {{-- Infos du corrigé --}}
            <div class="mb-4">
                <h5>{{ $corrige->sujet->titre ?? 'Corrigé' }}</h5>
                <p class="mb-1"><strong>Matière :</strong> {{ $corrige->sujet->matiere->nom ?? '-' }}</p>
                <p class="mb-1"><strong>Statut :</strong> {{ ucfirst($corrige->statut) }}</p>
            </div>

            {{-- Viewer PDF --}}
             <div class="pdf-viewer" style="height:80vh; border:1px solid #ced4da;">
                @if($corrige->fichier)
                    <iframe 
                        src="{{ asset('storage/'.$corrige->fichier) }}" 
                        width="100%" 
                        height="100%" 
                        style="border:none;">
                    </iframe>
                @else
                    <p class="text-muted text-center my-3">
                        Aucun fichier disponible.
                    </p>
                @endif
            </div>

            @if(!$corrige->fichier)
                <p class="text-muted text-center my-3">Aucun fichier disponible.</p>
            @endif

        </div>
    </div>
</div>

{{-- PDF.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.10.120/pdf.min.js"></script>
<script>
@if($corrige->fichier)
const urlCorrige = "{{ asset('storage/'.$corrige->fichier) }}";
const containerCorrige = document.getElementById('pdf-corrige');

pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.10.120/pdf.worker.min.js';

pdfjsLib.getDocument(urlCorrige).promise.then(pdf => {
    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
        pdf.getPage(pageNum).then(page => {
            const viewport = page.getViewport({ scale: 1.3 });
            const canvas = document.createElement('canvas');
            containerCorrige.appendChild(canvas);
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            page.render({ canvasContext: context, viewport: viewport });
        });
    }
}).catch(() => {
    containerCorrige.innerHTML = '<p class="text-danger text-center mt-3">Impossible de charger le PDF.</p>';
});
@endif
</script>
@endsection
