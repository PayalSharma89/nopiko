<div class="ps-product-list">
    <div class="ps-container">
        <div class="ps-section__header">
            <h3>{{ $category->name }}</h3>
            <ul class="ps-section__links">
                @foreach($category->children as $item)
                    <li class="nav-item">
                        <a class="@if ($loop->first) active @endif" href="#" data-url="{{ route('public.ajax.products-by-category', $item->id, ['limit' => $limit]) }}">{{ $item->name }}</a>
                    </li>
                @endforeach
                <li><a href="{{ $category->url }}">{{ __('View All') }}</a></li>
            </ul>
        </div>
        <div class="ps-section__content">
            <div class="half-circle-spinner loading-spinner d-none">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
            </div>
            <div class="tab-pane fade show active" id="product-categories-product" role="tabpanel" aria-labelledby="product-categories-product-tab">
                <div class="ps-carousel--nav owl-slider"
                     data-owl-auto="false"
                     data-owl-loop="false"
                     data-owl-speed="10000"
                     data-owl-gap="0"
                     data-owl-nav="true"
                     data-owl-dots="true"
                     data-owl-item="7"
                     data-owl-item-xs="2"
                     data-owl-item-sm="2"
                     data-owl-item-md="3"
                     data-owl-item-lg="4"
                     data-owl-item-xl="6"
                     data-owl-duration="1000"
                     data-owl-mousedrag="on"
                >
                    @foreach($products as $product)
                        <div class="ps-product">
                            {!! Theme::partial('product-item', compact('product')) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
