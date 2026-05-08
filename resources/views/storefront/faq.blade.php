@extends('layouts.storefront')
@section('title', 'FAQ')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-14">

    <h1 class="text-2xl font-black tracking-[0.2em] uppercase text-center mb-12" style="color: #1e3a8a;">Frequently Asked Questions</h1>

    @php
    $faqs = [
        ['q' => 'I put in the wrong shipping info. What do I do?', 'a' => 'Contact us via e-mail with your order number, and correct name and address within 24 hours of making your order. If your order has already shipped, please try to contact the shipping company. If the item is shipped back to our warehouse, we can ship it again for an additional shipping fee.'],
        ['q' => 'How long will it take for my order to arrive?', 'a' => 'Orders typically take 2-4 weeks to arrive, depending on your location. Since we ship our orders out from Mexico, most of the time, international shipping is required, which can take longer due to customs.'],
        ['q' => 'Why is international shipping so expensive?', 'a' => 'Since we ship our orders out from Mexico, most of the time, international shipping is required, which can stack up additional fees due to customs, distance, etc. This is not dictated by us but by the shipping service and the destination country\'s law.'],
        ['q' => 'Do you take commissions?', 'a' => 'Yes, Kittfill is still offering personal illustration services. If interested feel free to contact her at: kittfill@hotmail.com or visit https://ko-fi.com/kittfill for more information.'],
    ];
    @endphp

    <div class="space-y-4">
        @foreach($faqs as $i => $faq)
        <div x-data="{ open: false }"
             class="rounded-2xl overflow-hidden shadow-sm"
             style="background-color: #b8c2dc;">
            <button @click="open = !open"
                    class="w-full flex items-center justify-between px-6 py-5 text-left font-black tracking-wider uppercase text-sm text-gray-800 hover:text-blue-800 transition-colors">
                <span>{{ $faq['q'] }}</span>
                <span :class="open ? 'rotate-180' : ''" class="flex-shrink-0 ml-4 transition-transform duration-300">
                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-cloak
                 class="px-6 pb-6">
                <div class="border-t border-blue-300/40 pt-4">
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-12 text-center kf-card">
        <p class="text-sm text-gray-600 mb-4">Still have questions?</p>
        <a href="{{ route('contact') }}" class="kf-btn inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Contact Us
        </a>
    </div>
</div>
@endsection
