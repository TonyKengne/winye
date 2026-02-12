@extends('layouts.etudiant')

@section('content')
<div class="container-fluid my-5">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3 class="fw-bold text-violet">
            <i class="bi bi-file-earmark-pdf"></i> Visualisation du sujet
        </h3>
        <a href="{{ url()->previous() }}" class="btn btn-violet btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            {{-- Infos du sujet --}}
            <div class="mb-4">
                <h5>{{ $sujet->titre }}</h5>
                <p class="mb-1"><strong>Matière :</strong> {{ $sujet->matiere->nom ?? '-' }}</p>
                <p class="mb-1"><strong>Type :</strong> {{ ucfirst($sujet->type) }}</p>
                <p class="mb-1"><strong>Semestre :</strong> Semestre {{ $sujet->semestre }}</p>
                <p class="mb-1"><strong>Année académique :</strong> {{ $sujet->annee_academique }}</p>
            </div>

            {{-- Viewer PDF --}}
            <div class="pdf-viewer" style="height:80vh; border:1px solid #ced4da;">
                @if($sujet->fichier)
                    <iframe 
                        src="{{ asset('storage/'.$sujet->fichier) }}" 
                        width="100%" 
                        height="100%" 
                        style="border:none;">
                    </iframe>
    
                @endif
            </div>

            @if(!$sujet->fichier)
                <p class="text-muted text-center my-3">Aucun fichier disponible.</p>
            @endif

        </div>
    </div>
</div>

{{-- PDF.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.10.120/pdf.min.js"></script>
<script>
@if($sujet->fichier)
const urlSujet = "{{ asset('storage/'.$sujet->fichier) }}";
const containerSujet = document.getElementById('pdf-sujet');

pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.10.120/pdf.worker.min.js';

pdfjsLib.getDocument(urlSujet).promise.then(pdf => {
    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
        pdf.getPage(pageNum).then(page => {
            const viewport = page.getViewport({ scale: 1.3 });
            const canvas = document.createElement('canvas');
            containerSujet.appendChild(canvas);
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            page.render({ canvasContext: context, viewport: viewport });
        });
    }
}).catch(() => {
    containerSujet.innerHTML = '<p class="text-danger text-center mt-3">Impossible de charger le PDF.</p>';
});
@endif
</script>
@endsection
