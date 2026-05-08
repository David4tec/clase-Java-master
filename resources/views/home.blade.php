@extends('layouts.storefront')
@section('title', 'Home')

@section('content')

{{-- ============================================================
     HERO CAROUSEL (auto-rotates every 15 seconds)
     ============================================================ --}}
<section class="kf-hero-section"
         x-data="{
            slide: 0,
            slides: [
                { heading: 'NEW 2026 DESIGNS', sub: 'AVAILABLE FOR PREORDER', img: '{{ asset('image/NEW 2026 DESIGNS.png') }}' },
                { heading: 'EXCLUSIVE MERCH', sub: 'LIMITED EDITION DROPS', img: '{{ asset('image/EXCLUSIVE MERCH.png') }}' },
                { heading: 'SUMMER COLLECTION', sub: 'FRESH LOOKS FOR THE SEASON', img: '{{ asset('image/SUMMER COLLECTION.png') }}' },
                { heading: 'FAN FAVORITES', sub: 'BESTSELLERS BACK IN STOCK', img: '{{ asset('image/FAN FAVORITES.png') }}' }
            ],
            timer: null,
            next() { this.slide = (this.slide + 1) % this.slides.length; this.resetTimer(); },
            prev() { this.slide = (this.slide - 1 + this.slides.length) % this.slides.length; this.resetTimer(); },
            goTo(i) { this.slide = i; this.resetTimer(); },
            resetTimer() {
                clearInterval(this.timer);
                this.timer = setInterval(() => { this.slide = (this.slide + 1) % this.slides.length; }, 10000);
            },
            init() { this.resetTimer(); }
         }"
         style="min-height: 360px;">

    {{-- Slides --}}
    <div class="relative overflow-hidden" style="min-height: 360px;">
        <template x-for="(s, i) in slides" :key="i">
            <div x-show="slide === i"
                 x-transition:enter="transition-opacity duration-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0">

                {{-- Background image --}}
                <img :src="s.img" :alt="s.heading"
                     class="absolute inset-0 w-full h-full object-cover"
                     onerror="this.style.display='none'">

                {{-- Overlay gradient for text readability --}}
                <div class="absolute inset-0" style="background: linear-gradient(to right, rgba(201,209,234,0.85) 0%, rgba(201,209,234,0.5) 50%, rgba(201,209,234,0.3) 100%);"></div>

                {{-- Text content --}}
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-6 z-10">
                    <h1 class="text-3xl md:text-5xl font-black tracking-wider text-gray-800 uppercase mb-3"
                        x-text="s.heading"></h1>
                    <p class="text-sm md:text-base font-bold tracking-[0.3em] text-gray-600 uppercase mb-6"
                       x-text="s.sub"></p>
                    <a href="{{ route('shop') }}" class="kf-btn">Shop Now</a>
                </div>
            </div>
        </template>
    </div>

    {{-- Arrow: Prev --}}
    <button @click="prev()"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/70 hover:bg-white shadow flex items-center justify-center text-gray-700 hover:text-blue-600 transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    {{-- Arrow: Next --}}
    <button @click="next()"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/70 hover:bg-white shadow flex items-center justify-center text-gray-700 hover:text-blue-600 transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2 z-20">
        <template x-for="(s, i) in slides" :key="i">
            <button @click="goTo(i)"
                    :class="slide === i ? 'bg-blue-600 w-6 h-2.5' : 'bg-gray-400/60 w-2.5 h-2.5 hover:bg-gray-500'"
                    class="rounded-full transition-all duration-300"></button>
        </template>
    </div>
</section>

{{-- ============================================================
     NEW ARRIVALS
     ============================================================ --}}
<section class="py-12 px-6">
    <h2 class="kf-section-title mb-8">Shop Our New Arrivals</h2>

    @php
    $newArrivals = collect(config('products'))->where('new', true)->take(3)->values()->all();
    @endphp

    <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($newArrivals as $prod)
        <div class="kf-product-card group">
            <a href="{{ route('product.show', $prod['slug']) }}" class="block">
                <div class="kf-product-img flex items-center justify-center p-8" style="min-height: 190px;">
                    <div class="kf-product-img-circle w-32 h-32">
                        <div class="w-full h-full flex items-center justify-center text-4xl">{{ $prod['icon'] }}</div>
                    </div>
                </div>
            </a>
            <div class="px-4 pb-4 pt-2 text-center">
                <a href="{{ route('product.show', $prod['slug']) }}"
                   class="text-xs font-bold tracking-widest uppercase text-gray-800 group-hover:text-blue-600 transition-colors block">
                    {{ $prod['name'] }}
                </a>
                <p class="text-xs text-gray-700 font-semibold mt-0.5">${{ number_format($prod['price'], 2) }} USD</p>
                <p class="text-[10px] text-gray-400">${{ number_format($prod['price_mxn'], 2) }} MXN</p>
                <a href="{{ route('product.show', $prod['slug']) }}"
                   class="mt-2 w-full inline-block text-center bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-semibold tracking-wider uppercase py-1.5 rounded-lg transition-colors">
                    View Product
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ============================================================
     SHOP ALL
     ============================================================ --}}
<section class="py-6 px-6 pb-16">
    <h2 class="kf-section-title mb-8">Shop All</h2>

    @php
    $shopAll = collect(config('products'))->where('new', false)->take(3)->values()->all();
    @endphp

    <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($shopAll as $prod)
        <div class="kf-product-card group">
            <a href="{{ route('product.show', $prod['slug']) }}" class="block">
                <div class="kf-product-img flex items-center justify-center p-8" style="min-height: 190px;">
                    <div class="kf-product-img-circle w-32 h-32">
                        <div class="w-full h-full flex items-center justify-center text-4xl">{{ $prod['icon'] }}</div>
                    </div>
                </div>
            </a>
            <div class="px-4 pb-4 pt-2 text-center">
                <a href="{{ route('product.show', $prod['slug']) }}"
                   class="text-xs font-bold tracking-widest uppercase text-gray-800 group-hover:text-blue-600 transition-colors block">
                    {{ $prod['name'] }}
                </a>
                <p class="text-xs text-gray-700 font-semibold mt-0.5">${{ number_format($prod['price'], 2) }} USD</p>
                <p class="text-[10px] text-gray-400">${{ number_format($prod['price_mxn'], 2) }} MXN</p>
                <a href="{{ route('product.show', $prod['slug']) }}"
                   class="mt-2 w-full inline-block text-center bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-semibold tracking-wider uppercase py-1.5 rounded-lg transition-colors">
                    View Product
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-10">
        <a href="{{ route('shop') }}" class="kf-btn">View Full Catalog</a>
    </div>
</section>

@endsection
