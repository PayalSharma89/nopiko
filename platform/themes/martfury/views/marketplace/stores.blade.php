<div class="ps-page--single ps-page--vendor">
    <section class="ps-store-list">
        <div class="container">
            <div class="ps-section__header">
                <h3>{{ __('Our Associations') }}</h3>
            </div>

            <div class="ps-section__content">
                <div class="ps-section__search row">
                    {{-- Search by Association Name --}}
                    <div class="col-md-4">
                        <form action="{{ route('public.stores') }}" method="get">
                            <div class="form-group mb-3">
                                <button><i class="icon-magnifier"></i></button>
                                <input class="form-control" name="q" value="{{ request('q') }}" placeholder="{{ __('Search association...') }}">
                            </div>
                        </form>
                    </div>

                    {{-- Filter by Cause --}}
                    <div class="col-md-4">
                        <form action="{{ route('public.stores') }}" method="get">
                            <div class="form-group mb-3">
                                <select class="form-control" name="cause" onchange="this.form.submit()">
                                    <option value="">{{ __('Filter by Cause') }}</option>
                                    @foreach ($causesList as $cause)
                                        <option value="{{ $cause }}" {{ request('cause') == $cause ? 'selected' : '' }}>
                                            {{ $cause }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Associations List --}}
                @include(Theme::getThemeNamespace('views.marketplace.includes.association-items'), ['associations' => $associations])

                <div class="ps-pagination">
                    {!! $associations->withQueryString()->links() !!}
                </div>
            </div>
        </div>
    </section>
</div>
