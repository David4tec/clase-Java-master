<x-guest-layout>
    <div class="w-full max-w-md">
        {{-- Card --}}
        <div class="rounded-2xl shadow-lg overflow-hidden" style="background-color: #b8c2dc;">
            <div class="px-8 py-8">
                {{-- Title --}}
                <h1 class="text-2xl font-bold text-center mb-6" style="color: #1e3a8a;">Log into</h1>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="mb-4 text-sm text-green-700 bg-green-100 rounded-lg px-4 py-2">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="Email"
                               required autofocus autocomplete="username"
                               class="kf-input @error('email') border-red-400 @enderror" />
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <input id="password"
                               type="password"
                               name="password"
                               placeholder="Password"
                               required autocomplete="current-password"
                               class="kf-input @error('password') border-red-400 @enderror" />
                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Forgot password --}}
                    @if (Route::has('password.request'))
                        <div class="text-right">
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-gray-600 hover:text-blue-700 underline">
                                Forgot password?
                            </a>
                        </div>
                    @endif

                    {{-- Submit --}}
                    <button type="submit" class="kf-btn w-full">
                        Log in
                    </button>

                    {{-- Remember me --}}
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember"
                               class="rounded border-gray-400 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="text-xs text-gray-600">Remember me</span>
                    </label>
                </form>
            </div>

            {{-- New Account divider --}}
            <div class="px-8 pb-6 text-center">
                <a href="{{ route('register') }}"
                   class="kf-btn-outline w-full block text-center text-sm"
                   style="border-color: #1e3a8a; color: #1e3a8a;">
                    New Account
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
