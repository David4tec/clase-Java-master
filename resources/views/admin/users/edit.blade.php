@extends('layouts.admin')
@section('title', 'Edit Client')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-black tracking-wide text-gray-800">Edit Client — {{ $user->name }}</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-8">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="kf-input" required>
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="kf-input" required>
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-600 mb-1.5 block">Role</label>
                <select name="role" class="kf-input">
                    <option value="cliente" {{ old('role', $user->role) === 'cliente' ? 'selected' : '' }}>Client</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="submit" class="kf-btn">Save Changes</button>
                <a href="{{ route('admin.users.index') }}" class="kf-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
