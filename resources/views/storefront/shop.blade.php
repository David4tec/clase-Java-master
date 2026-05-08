@extends('layouts.storefront')
@section('title', 'Shop')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    {{-- Title + Filters --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-10">
        <h1 class="text-xl font-black tracking-[0.3em] uppercase text-gray-800">All Products</h1>

        <div class="flex items-center gap-3">
            <select class="kf-input text-sm" style="min-width: 9rem;"
                    onchange="var params = new URLSearchParams(window.location.search); if(this.value) { params.set('category', this.value); } else { params.delete('category'); } var qs = params.toString(); window.location = window.location.pathname + (qs ? '?' + qs : '');">
                <option value="">All Categories</option>
                <option value="phone-cases" {{ request('category') === 'phone-cases' ? 'selected' : '' }}>Phone Cases</option>
                <option value="hoodies"     {{ request('category') === 'hoodies'     ? 'selected' : '' }}>Hoodies</option>
                <option value="apparel"     {{ request('category') === 'apparel'     ? 'selected' : '' }}>Apparel</option>
                <option value="caps"        {{ request('category') === 'caps'        ? 'selected' : '' }}>Caps</option>
                <option value="stickers"    {{ request('category') === 'stickers'    ? 'selected' : '' }}>Stickers</option>
                <option value="wallpapers"  {{ request('category') === 'wallpapers'  ? 'selected' : '' }}>Wallpapers</option>
                <option value="accessories" {{ request('category') === 'accessories' ? 'selected' : '' }}>Accessories</option>
                <option value="bundles"     {{ request('category') === 'bundles'     ? 'selected' : '' }}>Bundles</option>
            </select>

            <select class="kf-input text-sm" style="min-width: 8rem;"
                    onchange="var params = new URLSearchParams(window.location.search); params.set('sort', this.value); var qs = params.toString(); window.location = window.location.pathname + (qs ? '?' + qs : '');">
                <option value="featured" {{ request('sort', 'featured') === 'featured' ? 'selected' : '' }}>Featured</option>
                <option value="price-asc" {{ request('sort') === 'price-asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price-desc" {{ request('sort') === 'price-desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
            </select>
        </div>
    </div>

    {{-- Product Grid --}}
    @php
        $allProducts = config('products');

        // Filter by category
        $products = request('category')
            ? array_values(array_filter($allProducts, fn($p) => $p['category'] === request('category')))
            : $allProducts;

        // Sort
        $sort = request('sort', 'featured');
        if ($sort === 'price-asc') {
            usort($products, fn($a, $b) => $a['price'] <=> $b['price']);
        } elseif ($sort === 'price-desc') {
            usort($products, fn($a, $b) => $b['price'] <=> $a['price']);
        } elseif ($sort === 'newest') {
            // New items first
            usort($products, fn($a, $b) => ($b['new'] ?? false) <=> ($a['new'] ?? false));
        }
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
        @foreach($products as $prod)
            <div class="kf-product-card group">
                {{-- Image area (clickable -> product page) --}}
                <a href="{{ route('product.show', $prod['slug']) }}" class="block">
                    <div class="flex items-center justify-center p-6" style="background-color: #dce3f5; min-height: 160px;">
                        <div class="kf-product-img-circle w-28 h-28">
                            <div class="w-full h-full flex items-center justify-center text-4xl">{{ $prod['icon'] }}</div>
                        </div>
                    </div>
                </a>

                {{-- Info + Add to Cart --}}
                <div class="px-3 pb-3 pt-2 text-center">
                    <a href="{{ route('product.show', $prod['slug']) }}"
                       class="text-xs font-bold tracking-widest uppercase text-gray-800 group-hover:text-blue-600 transition-colors leading-tight block">
                        {{ $prod['name'] }}
                    </a>
                    <p class="text-xs text-gray-700 font-semibold mt-1">${{ number_format($prod['price'], 2) }} USD</p>
                    <p class="text-[10px] text-gray-400">${{ number_format($prod['price_mxn'], 2) }} MXN</p>

                    <a href="{{ route('product.show', $prod['slug']) }}"
                       class="mt-2 w-full inline-block text-center bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-semibold tracking-wider uppercase py-1.5 rounded-lg transition-colors">
                        View Product
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Empty state --}}
    @if(empty($products))
        <div class="text-center py-24">
            <div class="text-6xl mb-4">🛍️</div>
            <p class="text-gray-500 font-medium">No products found in this category.</p>
            <a href="{{ route('shop') }}" class="kf-btn mt-6 inline-block">View All</a>
        </div>
    @endif

</div>
@endsection
