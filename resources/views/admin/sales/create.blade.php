@extends('layouts.admin')
@section('title', 'New Sale')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.sales.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-black tracking-wide text-gray-800">New Sale</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-8">
        <form action="{{ route('admin.sales.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Contact</label>
                <select name="contact_id" class="kf-input" required>
                    <option value="">-- Select a contact --</option>
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}" {{ old('contact_id') == $contact->id ? 'selected' : '' }}>
                            {{ $contact->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="kf-input" placeholder="Sale title" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Amount</label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount', 0) }}" class="kf-input" required>
                </div>
                <div>
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Status</label>
                    <select name="status" class="kf-input">
                        <option value="prospecto" {{ old('status') === 'prospecto' ? 'selected' : '' }}>Prospect</option>
                        <option value="negociacion" {{ old('status') === 'negociacion' ? 'selected' : '' }}>Negotiation</option>
                        <option value="cerrado" {{ old('status') === 'cerrado' ? 'selected' : '' }}>Closed</option>
                        <option value="perdido" {{ old('status') === 'perdido' ? 'selected' : '' }}>Lost</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Expected Close Date</label>
                <input type="date" name="expected_close" value="{{ old('expected_close') }}" class="kf-input">
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Notes</label>
                <textarea name="notes" rows="4" class="kf-input resize-none" placeholder="Additional notes...">{{ old('notes') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="submit" class="kf-btn">Save Sale</button>
                <a href="{{ route('admin.sales.index') }}" class="kf-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
