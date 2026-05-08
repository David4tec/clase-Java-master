@extends('layouts.storefront')
@section('title', 'About Us')

@section('content')

{{-- Hero banner --}}
<div class="relative overflow-hidden" style="min-height: 260px; background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 40%, #1d4ed8 70%, #c9d1ea 100%);">
    <div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none select-none">
        <span style="font-size: 10rem; line-height: 1;">🐱🎨🐱</span>
    </div>
    <div class="absolute inset-0" style="background: linear-gradient(to bottom, transparent 60%, #c9d1ea 100%);"></div>
</div>

{{-- About the Brand --}}
<section class="py-14 px-6 max-w-3xl mx-auto text-center">
    <h2 class="text-xl font-black tracking-[0.2em] uppercase mb-6" style="color: #1e3a8a;">About The Brand</h2>
    <p class="text-sm text-gray-700 leading-relaxed mb-4">KITTFILL started as a small freelance business in 2015, focusing mostly on illustration work done for independent clients.</p>
    <p class="text-sm text-gray-700 leading-relaxed">Our main goal is to help others feel represented in our work, and give them the ability to express themselves and what makes them unique.</p>
</section>

{{-- About the Artist --}}
<section class="py-10 px-6 max-w-5xl mx-auto">
    <h2 class="text-xl font-black tracking-[0.2em] uppercase text-center mb-10" style="color: #1e3a8a;">About The Artist</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
        {{-- Photo placeholder --}}
        <div class="flex justify-center md:justify-end">
            <div class="w-64 h-64 md:w-72 md:h-72 rounded-2xl overflow-hidden bg-white shadow-sm flex items-center justify-center"
                 style="border: 2px solid #d4dbed;">
                <div class="text-center text-gray-300">
                    <svg class="w-24 h-24 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p class="text-xs tracking-widest uppercase">Artist Photo</p>
                </div>
            </div>
        </div>

        {{-- Bio card --}}
        <div class="rounded-2xl p-8 shadow-sm" style="background-color: #b8c2dc;">
            <h3 class="text-lg font-black tracking-[0.15em] uppercase text-gray-800 mb-4">Valeria Lopez</h3>
            <p class="text-sm text-gray-700 leading-relaxed mb-4">22 year old Mexican illustrator, Valeria Lopez, started working under the name Kittfill online, producing illustrated work depicting clients' characters.</p>
            <p class="text-sm text-gray-700 leading-relaxed">As the years went by, she refined her skills and grew her client base, eventually moving into creating physical merchandise.</p>
        </div>
    </div>
</section>

{{-- Contact anchor --}}
<section id="contact" class="py-14 px-6 max-w-2xl mx-auto text-center">
    <h2 class="text-xl font-black tracking-[0.2em] uppercase mb-4" style="color: #1e3a8a;">Contact</h2>
    <p class="text-sm text-gray-600 leading-relaxed mb-6">Have questions, custom orders or just want to say hi? Feel free to reach out.</p>
    <a href="{{ route('contact') }}" class="kf-btn inline-flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        Contact Us
    </a>
</section>

@endsection
