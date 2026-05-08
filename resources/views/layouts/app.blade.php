<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kittfill — @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased" style="background-color: #f1f5f9;">

    {{-- Navbar --}}
    <nav class="kf-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center" style="text-decoration:none;">
                <img src="{{ asset('image/logo.png') }}" alt="Kittfill" class="h-8"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                <span class="kf-logo text-xl" style="display:none;">KITTFILL</span>
            </a>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="kf-nav-link">Store</a>
                @auth
                    <a href="{{ route('profile.edit') }}" class="kf-nav-link">My Profile</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('management.index') }}" class="kf-nav-link text-yellow-300 hover:text-yellow-200">
                            Management
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="kf-nav-link">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="kf-nav-link">Log in</a>
                    <a href="{{ route('register') }}" class="kf-nav-link">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @yield('content')

</body>
</html>
