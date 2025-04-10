<div class="ps-page--single ps-page--vendor">
    <section class="ps-store-list">
        <div class="container">
            <div class="ps-section__header py-2">
                <h3>{{ __('Our Associations') }}</h3>
            </div>

            {{-- Search Bar --}}
            <div class="ps-section__search mb-4">
                <form action="{{ route('public.stores') }}" method="get">
                    <div class="form-group" style="width: 45%;">
                        <div class="input-group">
                            <input class="form-control" name="q" value="{{ request('q') }}" placeholder="{{ __('Search association...') }}">
                            <button class="btn btn-primary"><i class="icon-magnifier"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="ps-section__content">
                <div class="row">

                    {{-- Left Sidebar: Causes Filter --}}
                    <div class="col-md-3">
                        <form action="{{ route('public.stores') }}" method="get">
                            @if (request('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif

                            <div class="bb-product-filter">
                                <h4 class="bb-product-filter-title">{{ __('Causes') }}</h4>

                                <div class="bb-product-filter-content">
                                    <ul class="bb-product-filter-items filter-checkbox">
                                        @foreach ($causesList as $id => $name)
                                            <li class="bb-product-filter-item">
                                                <input 
                                                    id="cause-{{ $id }}" 
                                                    type="checkbox" 
                                                    name="cause" 
                                                    value="{{ $id }}" 
                                                    onchange="this.form.submit();" 
                                                    {{ request('cause') == $id ? 'checked' : '' }}>
                                                <label for="cause-{{ $id }}">{{ $name }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Right Side: Associations List --}}
                    <div class="col-md-9">
                        @include(Theme::getThemeNamespace('views.marketplace.includes.association-items'), ['associations' => $associations])

                        <div class="ps-pagination">
                            {!! $associations->withQueryString()->links() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
