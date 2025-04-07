<div class="row">
    @forelse ($associations as $association)
        <div class="col-md-4 mb-4">
            <div class="ps-block--store p-4 border rounded h-100 text-center">

                {{-- Image --}}
                @if ($association->image)
                    <div class="mb-3">
                        <img src="{{ RvMedia::getImageUrl($association->image, 'thumb') }}"
                             alt="{{ $association->name }}"
                             class="img-fluid rounded"
                             style="max-height: 150px;">
                    </div>
                @else
                    <div class="mb-3">
                        <img src="{{ RvMedia::getImageUrl(null) }}"
                             alt="No Image"
                             class="img-fluid rounded"
                             style="max-height: 150px;">
                    </div>
                @endif

                {{-- Name --}}
                <h5 class="fw-bold">{{ $association->name }}</h5>

                {{-- Description --}}
                <p class="text-muted">{{ Str::limit($association->description, 100) }}</p>

                {{-- Location (optional) --}}
                @if ($association->location)
                    <p class="text-sm text-secondary">
                        <i class="fas fa-map-marker-alt me-1"></i> {{ $association->location }}
                    </p>
                @endif

                {{-- Visit Store Button --}}
                <a href="{{ route('association.detail', $association->id) }}" class="btn btn-primary">
                    View Details
                </a>
               



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
