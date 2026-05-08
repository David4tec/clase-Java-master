@extends('layouts.admin')
@section('title', 'Edit Sale')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.sales.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-black tracking-wide text-gray-800">Edit Sale — {{ $sale->title }}</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-8">
        <form action="{{ route('admin.sales.update', $sale) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Contact</label>
                <select name="contact_id" class="kf-input">
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}" {{ $sale->contact_id == $contact->id ? 'selected' : '' }}>
                            {{ $contact->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Title</label>
                <input type="text" name="title" value="{{ old('title', $sale->title) }}" class="kf-input" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Amount</label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount', $sale->amount) }}" class="kf-input" required>
                </div>
                <div>
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Status</label>
                    <select name="status" class="kf-input">
                        @foreach(['prospecto' => 'Prospect', 'negociacion' => 'Negotiation', 'cerrado' => 'Closed', 'perdido' => 'Lost'] as $val => $label)
                            <option value="{{ $val }}" {{ old('status', $sale->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Expected Close Date</label>
                <input type="date" name="expected_close" value="{{ old('expected_close', $sale->expected_close) }}" class="kf-input">
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Notes</label>
                <textarea name="notes" rows="4" class="kf-input resize-none">{{ old('notes', $sale->notes) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="submit" class="kf-btn">Save Changes</button>
                <a href="{{ route('admin.sales.index') }}" class="kf-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
