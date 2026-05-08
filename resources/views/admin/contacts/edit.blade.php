@extends('layouts.admin')
@section('title', 'Edit Contact')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.contacts.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-black tracking-wide text-gray-800">Edit Contact — {{ $contact->user->name }}</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-8">
        <form action="{{ route('admin.contacts.update', $contact) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $contact->phone) }}" class="kf-input">
                </div>
                <div>
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Company</label>
                    <input type="text" name="company" value="{{ old('company', $contact->company) }}" class="kf-input">
                </div>
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Position</label>
                <input type="text" name="position" value="{{ old('position', $contact->position) }}" class="kf-input">
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Notes</label>
                <textarea name="notes" rows="4" class="kf-input resize-none">{{ old('notes', $contact->notes) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="submit" class="kf-btn">Save Changes</button>
                <a href="{{ route('admin.contacts.index') }}" class="kf-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
