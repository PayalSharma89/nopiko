<div class="row">
    @forelse ($associations as $association)
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition rounded-4 text-center">

                {{-- Image --}}
                <div class="position-relative overflow-hidden rounded-top-4" style="height: 180px; background-color: #f9f9f9;">
                    <img src="{{ RvMedia::getImageUrl($association->image, 'thumb') }}"
                         alt="{{ $association->name }}"
                         class="img-fluid h-100 w-100 object-fit-cover">
                </div>

                <div class="card-body p-4 d-flex flex-column justify-content-between">

                    {{-- Name --}}
                    <h5 class="fw-semibold mb-2">{{ $association->name }}</h5>

                    {{-- Description --}}
                    <p class="text-muted small mb-3">{{ Str::limit($association->description, 100) }}</p>

                    {{-- Location --}}
                    @if ($association->location)
                        <p class="text-secondary small">
                            <i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $association->location }}
                        </p>
                    @endif

                    {{-- Button --}}
                    <a href="{{ route('association.detail', $association->id) }}" class="btn btn-outline-primary w-100 mt-3 rounded-pill">
                        View Details
                    </a>

                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                {{ __('No associations found.') }}
            </div>
        </div>
    @endforelse
</div>
