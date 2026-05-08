@extends('layouts.admin')
@section('title', 'New Contact')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.contacts.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-black tracking-wide text-gray-800">New Contact</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-8">
        <form action="{{ route('admin.contacts.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Client</label>
                <select name="user_id" class="kf-input" required>
                    <option value="">-- Select a client --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="kf-input" placeholder="+52 ...">
                </div>
                <div>
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Company</label>
                    <input type="text" name="company" value="{{ old('company') }}" class="kf-input" placeholder="Company name">
                </div>
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Position</label>
                <input type="text" name="position" value="{{ old('position') }}" class="kf-input" placeholder="Job title">
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Notes</label>
                <textarea name="notes" rows="4" class="kf-input resize-none" placeholder="Additional notes...">{{ old('notes') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="submit" class="kf-btn">Save Contact</button>
                <a href="{{ route('admin.contacts.index') }}" class="kf-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
