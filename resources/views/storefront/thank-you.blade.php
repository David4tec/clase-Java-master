@extends('layouts.storefront')
@section('title', 'Thank You!')

@push('styles')
<style>
    /* Animated checkmark */
    .kf-checkmark {
        width: 80px; height: 80px; border-radius: 50%; display: block;
        stroke-width: 4; stroke: #fff; stroke-miterlimit: 10;
        box-shadow: 0 0 0 #22c55e;
        animation: kf-check-fill 0.4s ease-in-out 0.4s forwards,
                   kf-check-scale 0.3s ease-in-out 0.9s both;
    }
    .kf-checkmark-circle {
        stroke-dasharray: 166; stroke-dashoffset: 166; stroke-width: 4;
        stroke-miterlimit: 10; stroke: #22c55e; fill: none;
        animation: kf-stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .kf-checkmark-check {
        transform-origin: 50% 50%; stroke-dasharray: 48; stroke-dashoffset: 48;
        animation: kf-stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }
    @keyframes kf-stroke { 100% { stroke-dashoffset: 0; } }
    @keyframes kf-check-scale { 0%, 100% { transform: none; } 50% { transform: scale3d(1.1, 1.1, 1); } }
    @keyframes kf-check-fill { 100% { box-shadow: inset 0 0 0 50px #22c55e; } }

    /* Confetti */
    @keyframes kf-confetti-fall {
        0%   { transform: translateY(-10px) rotate(0deg);   opacity: 1; }
        100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
    }
    .kf-confetti-piece {
        position: fixed; top: -20px;
        animation: kf-confetti-fall linear forwards;
        pointer-events: none; z-index: 100;
    }

    /* Fade in content */
    .kf-ty-content { animation: kf-fade-up 0.6s ease-out 0.3s both; }
    @keyframes kf-fade-up {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')

{{-- Confetti container --}}
<div id="kf-confetti" class="fixed inset-0 overflow-hidden pointer-events-none z-50"></div>

<div class="max-w-xl mx-auto px-6 py-16 text-center kf-ty-content"
     x-data
     x-init="$store.cart.clear()">

    {{-- Animated checkmark --}}
    <div class="flex justify-center mb-6">
        <svg class="kf-checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="kf-checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
            <path class="kf-checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
        </svg>
    </div>

    <h1 class="text-3xl font-black tracking-wide mb-3" style="color: #1e3a8a;">Thank You!</h1>
    <p class="text-base text-gray-700 mb-2">Your order has been confirmed and is being processed.</p>

    {{-- Order number --}}
    <div class="inline-flex items-center gap-2 bg-white/70 rounded-full px-5 py-2 mt-3 mb-6">
        <span class="text-xs text-gray-500 font-medium">Order</span>
        <span class="text-sm font-bold text-blue-700">#KF-{{ str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT) }}</span>
    </div>

    <p class="text-sm text-gray-500 mb-10 leading-relaxed">
        We'll send a confirmation e-mail with your order details shortly.
    </p>

    {{-- Action buttons --}}
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="{{ route('shop') }}" class="kf-btn flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            Continue Shopping
        </a>
        <a href="{{ route('home') }}" class="kf-btn-outline flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Back to Home
        </a>
    </div>

</div>

@push('scripts')
<script>
(function () {
    const container = document.getElementById('kf-confetti');
    const colors = ['#ff6b6b','#ffd93d','#6bcb77','#4d96ff','#ff922b','#cc5de8','#f06595','#74c0fc'];
    const shapes = ['50%', '0', '2px'];
    for (let i = 0; i < 90; i++) {
        const el = document.createElement('div');
        el.className = 'kf-confetti-piece';
        const size = Math.random() * 10 + 6, left = Math.random() * 100;
        const delay = Math.random() * 2.5, dur = Math.random() * 2.5 + 2;
        const color = colors[Math.floor(Math.random() * colors.length)];
        const radius = shapes[Math.floor(Math.random() * shapes.length)];
        el.style.cssText = `left:${left}%;width:${size}px;height:${size*(Math.random()+0.5)}px;background:${color};border-radius:${radius};animation-duration:${dur}s;animation-delay:${delay}s;`;
        container.appendChild(el);
    }
    setTimeout(() => container.remove(), 6000);
})();
</script>
@endpush

@endsection
