<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kittfill Admin — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased" style="background-color: #f1f5f9;">

    {{-- Admin Navbar --}}
    <nav class="kf-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

            {{-- Logo + Admin badge --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center" style="text-decoration:none;">
                    <img src="{{ asset('image/logo.png') }}" alt="Kittfill" class="h-8"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                    <span class="kf-logo text-xl" style="display:none;">KITTFILL</span>
                </a>
                <span class="text-[10px] font-bold uppercase tracking-widest bg-yellow-400 text-yellow-900 px-2 py-0.5 rounded-full">Admin</span>
            </div>

            {{-- Nav Links --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('management.index') }}" class="kf-nav-link {{ request()->routeIs('management.index') ? '!text-white font-semibold' : '' }}">Dashboard</a>
                <a href="{{ route('admin.contacts.index') }}" class="kf-nav-link {{ request()->routeIs('admin.contacts.*') ? '!text-white font-semibold' : '' }}">Contacts</a>
                <a href="{{ route('admin.sales.index') }}" class="kf-nav-link {{ request()->routeIs('admin.sales.*') ? '!text-white font-semibold' : '' }}">Sales</a>
                <a href="{{ route('admin.users.index') }}" class="kf-nav-link {{ request()->routeIs('admin.users.*') ? '!text-white font-semibold' : '' }}">Clients</a>
                <span class="text-white/30">|</span>
                <a href="{{ route('home') }}" class="kf-nav-link">Store</a>
            </div>

            {{-- Right --}}
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 text-white/70 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    {{ auth()->user()->name }}
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="kf-icon-btn" title="Log out">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Page content --}}
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

</body>
</html>
