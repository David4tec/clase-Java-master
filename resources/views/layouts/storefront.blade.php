<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kittfill — @yield('title', 'Store')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col font-sans antialiased" style="background-color: #c9d1ea;">

    {{-- ==================== NAVIGATION ==================== --}}
    <nav class="kf-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center" style="text-decoration:none;">
                <img src="{{ asset('image/logo.png') }}" alt="Kittfill" class="h-9"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                <span class="kf-logo" style="display:none;">KITTFILL</span>
            </a>

            {{-- Nav Links (desktop) --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}"  class="kf-nav-link {{ request()->routeIs('home')  ? '!text-white font-semibold' : '' }}">Home</a>
                <a href="{{ route('shop') }}"  class="kf-nav-link {{ request()->routeIs('shop')  ? '!text-white font-semibold' : '' }}">Shop</a>
                <a href="{{ route('about') }}" class="kf-nav-link {{ request()->routeIs('about') ? '!text-white font-semibold' : '' }}">About Us</a>
                <a href="{{ route('faq') }}"   class="kf-nav-link {{ request()->routeIs('faq')   ? '!text-white font-semibold' : '' }}">FAQ</a>
                <a href="{{ route('contact') }}" class="kf-nav-link {{ request()->routeIs('contact') ? '!text-white font-semibold' : '' }}">Contact</a>
            </div>

            {{-- Right icons --}}
            <div class="flex items-center gap-4" x-data>

                {{-- Cart icon with badge --}}
                <a href="{{ route('cart') }}" class="kf-icon-btn relative" title="Cart">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="$store.cart.count > 0"
                          x-text="$store.cart.count > 9 ? '9+' : $store.cart.count"
                          x-cloak
                          class="absolute -top-2 -right-2 min-w-[18px] h-[18px] bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center px-0.5 leading-none">
                    </span>
                </a>

                {{-- User / Auth --}}
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="kf-icon-btn" title="{{ auth()->user()->name }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                            <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100 truncate">{{ auth()->user()->name }}</div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Profile</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('management.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-yellow-600 hover:bg-gray-50 font-medium">
                                    ⚙ Management
                                </a>
                            @endif
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Log out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="kf-icon-btn" title="Log in">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </a>
                @endauth

                {{-- Mobile menu --}}
                <button class="md:hidden kf-icon-btn" @click="$dispatch('toggle-menu')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-data="{ open: false }" @toggle-menu.window="open = !open" x-show="open" x-cloak
             class="md:hidden bg-blue-900 border-t border-blue-800 px-6 py-4 space-y-3">
            <a href="{{ route('home') }}"    class="block text-white/90 hover:text-white text-sm font-medium">Home</a>
            <a href="{{ route('shop') }}"    class="block text-white/90 hover:text-white text-sm font-medium">Shop</a>
            <a href="{{ route('about') }}"   class="block text-white/90 hover:text-white text-sm font-medium">About Us</a>
            <a href="{{ route('faq') }}"     class="block text-white/90 hover:text-white text-sm font-medium">FAQ</a>
            <a href="{{ route('contact') }}" class="block text-white/90 hover:text-white text-sm font-medium">Contact</a>
            @auth
                <a href="{{ route('profile.edit') }}" class="block text-white/90 hover:text-white text-sm font-medium">My Profile</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-300 hover:text-red-200 text-sm font-medium">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}"    class="block text-white/90 hover:text-white text-sm font-medium">Log in</a>
                <a href="{{ route('register') }}" class="block text-white/90 hover:text-white text-sm font-medium">Register</a>
            @endauth
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="bg-green-100 border-b border-green-200 text-green-800 px-6 py-3 text-sm text-center">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-b border-red-200 text-red-800 px-6 py-3 text-sm text-center">
            {{ session('error') }}
        </div>
    @endif

    {{-- Global toast: "Added to cart" --}}
    <div x-data="{ show: false, msg: '' }"
         @cart:added.window="show = true; msg = $event.detail.name; setTimeout(() => show = false, 2500)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak
         class="fixed bottom-6 right-6 z-50 bg-blue-700 text-white text-sm font-medium px-5 py-3 rounded-xl shadow-xl flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span><span x-text="msg"></span> added to cart!</span>
    </div>

    {{-- Page content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ==================== FOOTER ==================== --}}
    <footer style="background-color: #c9d1ea;" class="mt-auto border-t border-blue-200/40">
        <div class="max-w-7xl mx-auto px-6 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <img src="{{ asset('image/logo.png') }}" alt="Kittfill" class="h-8 mb-3"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div class="kf-logo" style="display:none; color:#0f2460; -webkit-text-stroke-color:#0f2460; font-size:1.2rem;">KITTFILL</div>
                    <p class="text-xs text-gray-600 leading-relaxed mt-2">Unique designs for unique fans. Official quality merch.</p>
                </div>
                <div class="flex flex-col gap-2">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-gray-700 mb-1">Information</h4>
                    <a href="#" class="text-xs text-gray-600 hover:text-blue-700 underline">Terms and Conditions</a>
                    <a href="#" class="text-xs text-gray-600 hover:text-blue-700 underline">Shipping policy</a>
                    <a href="#" class="text-xs text-gray-600 hover:text-blue-700 underline">Privacy policy</a>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-gray-700 mb-3">Follow our socials</h4>
                    <div class="flex items-center gap-4">
                        <a href="#" class="text-gray-600 hover:text-pink-600 transition-colors"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                        <a href="#" class="text-gray-600 hover:text-black transition-colors"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.76a4.85 4.85 0 01-1.01-.07z"/></svg></a>
                        <a href="#" class="text-gray-600 hover:text-blue-600 transition-colors"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                        <a href="#" class="text-gray-600 hover:text-black transition-colors"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                    </div>
                </div>
            </div>
        </div>
        <div style="background-color: #b8c2dc;" class="border-t border-blue-200/40">
            <div class="max-w-7xl mx-auto px-6 py-3 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-600">
                <div class="flex items-center gap-2">
                    <span>Country/Region</span>
                    <select class="text-xs border border-gray-400 rounded px-2 py-1 bg-transparent">
                        <option>USD$ | United States</option>
                        <option>MXN$ | Mexico</option>
                        <option>EUR€ | Europe</option>
                    </select>
                </div>
                <div class="text-center">
                    ©{{ date('Y') }} Kittfill. All rights reserved.
                    <a href="#" class="underline hover:text-blue-700">Terms and Conditions</a>.
                    <a href="#" class="underline hover:text-blue-700">Shipping policy</a>.
                    <a href="#" class="underline hover:text-blue-700">Privacy policy</a>
                </div>
                <div class="flex items-center gap-3">
                    <a href="#" class="text-gray-600 hover:text-pink-600"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    <a href="#" class="text-gray-600 hover:text-black"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.76a4.85 4.85 0 01-1.01-.07z"/></svg></a>
                    <a href="#" class="text-gray-600 hover:text-blue-600"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    <a href="#" class="text-gray-600 hover:text-black"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
