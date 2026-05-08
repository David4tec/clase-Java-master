<x-guest-layout>
    <div class="w-full max-w-md">
        {{-- Card --}}
        <div class="rounded-2xl shadow-lg overflow-hidden" style="background-color: #b8c2dc;">
            <div class="px-8 py-8">
                {{-- Title --}}
                <h1 class="text-2xl font-bold text-center mb-6" style="color: #1e3a8a;">Create Account</h1>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <input id="name"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Full Name"
                               required autofocus autocomplete="name"
                               class="kf-input @error('name') border-red-400 @enderror" />
                        @error('name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="Email"
                               required autocomplete="username"
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
                               required autocomplete="new-password"
                               class="kf-input @error('password') border-red-400 @enderror" />
                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <input id="password_confirmation"
                               type="password"
                               name="password_confirmation"
                               placeholder="Confirm Password"
                               required autocomplete="new-password"
                               class="kf-input @error('password_confirmation') border-red-400 @enderror" />
                        @error('password_confirmation')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="kf-btn w-full">
                        Create Account
                    </button>
                </form>
            </div>

            {{-- Already have account --}}
            <div class="px-8 pb-6 text-center">
                <a href="{{ route('login') }}"
                   class="kf-btn-outline w-full block text-center text-sm"
                   style="border-color: #1e3a8a; color: #1e3a8a;">
                    Already have an account? Log in
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
