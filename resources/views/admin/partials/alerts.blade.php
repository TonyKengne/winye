@if (session('success') || session('error'))
    <div class="alert shadow-sm mb-1 d-flex align-items-center 
                {{ session('success') ? 'border-violet bg-light text-dark' : 'border-start border-1 border-danger bg-light text-dark' }}">
        <i class="me-2 fs-5
              {{ session('success') ? 'bi bi-check-circle-fill text-violet' : 'bi bi-exclamation-triangle-fill text-danger' }}">
        </i>
        <span>{{ session('success') ?? session('error') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
