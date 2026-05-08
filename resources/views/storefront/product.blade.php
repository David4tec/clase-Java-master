@extends('layouts.storefront')
@section('title', $product['name'] ?? 'Product')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">

    {{-- Breadcrumb --}}
    <nav class="kf-breadcrumb mb-6">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Catalog</a>
        <span class="mx-1">›</span>
        <a href="{{ route('shop') }}" class="hover:text-blue-600">Shop</a>
        <span class="mx-1">›</span>
        <a href="{{ route('shop', ['category' => $product['category'] ?? '']) }}"
           class="hover:text-blue-600">{{ ucwords(str_replace('-', ' ', $product['category'] ?? 'All')) }}</a>
        <span class="mx-1">›</span>
        <span class="text-gray-700">{{ $product['name'] }}</span>
    </nav>

    {{-- Product Layout --}}
    @php
        $models = $product['models'] ?? ['Standard'];
        $modelsJson = json_encode($models);
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16"
         x-data="{
             qty: 1,
             model: {{ json_encode($models[0]) }},
             models: {{ $modelsJson }},
             added: false,

             addToCart() {
                 for (let i = 0; i < this.qty; i++) {
                     $store.cart.add({
                         id: '{{ $product['slug'] ?? 'product' }}',
                         name: '{{ addslashes($product['name'] ?? 'Product') }}',
                         price: {{ $product['price'] ?? 19.99 }},
                         priceMxn: {{ $product['price_mxn'] ?? 339.99 }},
                         model: this.model,
                         icon: '{{ $product['icon'] ?? '📦' }}',
                         image: {{ isset($product['image']) && $product['image'] ? "'". $product['image'] ."'" : 'null' }},
                         eta: '{{ addslashes($product['eta'] ?? 'Arriving in 2-4 weeks') }}'
                     });
                 }
                 window.dispatchEvent(new CustomEvent('cart:added', { detail: { name: '{{ addslashes($product['name'] ?? 'Product') }}' } }));
                 this.added = true;
                 setTimeout(() => this.added = false, 1800);
             }
         }">

        {{-- LEFT: Product Image --}}
        <div class="rounded-2xl overflow-hidden flex items-center justify-center"
             style="background-color: #dce3f5; min-height: 380px;">
            @if(!empty($product['image']))
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                     class="w-full h-full object-cover">
            @else
                <div class="text-center p-12">
                    <div class="text-8xl mb-4">{{ $product['icon'] ?? '📦' }}</div>
                    <p class="text-xs text-gray-400 tracking-widest uppercase">Product Image</p>
                </div>
            @endif
        </div>

        {{-- RIGHT: Product Info --}}
        <div class="flex flex-col justify-center">

            <h1 class="text-2xl font-black tracking-wide uppercase text-gray-800 mb-2">
                {{ $product['name'] }}
            </h1>

            <p class="text-2xl font-bold text-gray-700 mb-0.5">
                ${{ number_format($product['price'] ?? 19.99, 2) }}
                <span class="text-sm font-normal text-gray-500">USD</span>
            </p>
            <p class="text-sm text-gray-400 mb-1">
                ${{ number_format($product['price_mxn'] ?? 339.99, 2) }} MXN
            </p>

            <p class="text-xs text-gray-500 mb-5">Shipping calculated at checkout.</p>

            {{-- Description --}}
            @if(!empty($product['description']))
            <div class="mb-5">
                <p class="text-xs font-semibold tracking-widest uppercase text-gray-600 mb-1">Description:</p>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $product['description'] }}</p>
            </div>
            @endif

            {{-- Model selector --}}
            <div class="mb-5">
                <label class="text-xs font-semibold tracking-widest uppercase text-gray-600 mb-2 block">
                    <span x-text="models.length > 1 ? (models[0].match(/^\d/) ? 'Size:' : 'Model:') : ''"></span>
                </label>
                <div class="flex items-center gap-3">
                    <template x-if="models.length > 1">
                        <select x-model="model" class="kf-input w-auto pr-8 text-sm">
                            <template x-for="m in models" :key="m">
                                <option :value="m" x-text="m"></option>
                            </template>
                        </select>
                    </template>

                    {{-- Quantity stepper --}}
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold tracking-widest uppercase text-gray-600">Qty:</span>
                        <button @click="qty = Math.max(1, qty - 1)" class="kf-qty-btn">−</button>
                        <span class="text-sm font-semibold w-6 text-center" x-text="qty"></span>
                        <button @click="qty++" class="kf-qty-btn">+</button>
                    </div>
                </div>
            </div>

            {{-- Add to Cart Button --}}
            <button @click="addToCart()"
                    :class="added ? 'bg-green-600 hover:bg-green-700' : ''"
                    class="kf-btn w-full text-base py-3 transition-colors">
                <span x-show="!added">Add to Cart</span>
                <span x-show="added" x-cloak class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Added!
                </span>
            </button>

            {{-- Wishlist / Share --}}
            <div class="flex items-center gap-4 mt-4 text-xs text-gray-500">
                <button class="flex items-center gap-1 hover:text-blue-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    Add to wishlist
                </button>
                <button class="flex items-center gap-1 hover:text-blue-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    Share
                </button>
            </div>
        </div>
    </div>

    {{-- ============ SUGGESTED FOR YOU ============ --}}
    @if(!empty($suggested))
    <section>
        <h2 class="kf-section-title mb-8">Suggested For You</h2>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
            @foreach($suggested as $s)
            <a href="{{ route('product.show', $s['slug']) }}" class="kf-product-card group">
                <div class="flex items-center justify-center p-6" style="background-color: #dce3f5; min-height: 140px;">
                    <div class="kf-product-img-circle w-24 h-24">
                        <div class="w-full h-full flex items-center justify-center text-3xl">{{ $s['icon'] }}</div>
                    </div>
                </div>
                <div class="px-3 pb-3 pt-1 text-center">
                    <p class="text-[10px] font-bold tracking-widest uppercase text-gray-800 group-hover:text-blue-600 transition-colors">{{ $s['name'] }}</p>
                    <p class="text-[10px] text-gray-700 font-semibold">${{ number_format($s['price'], 2) }} USD</p>
                    <p class="text-[9px] text-gray-400">${{ number_format($s['price_mxn'], 2) }} MXN</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection
