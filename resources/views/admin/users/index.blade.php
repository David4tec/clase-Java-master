@extends('layouts.admin')
@section('title', 'Clients')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-black tracking-wide text-gray-800">Client Management</h1>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100" style="background-color: #f1f5f9;">
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">ID</th>
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Name</th>
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Email</th>
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Role</th>
                    <th class="text-right py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b border-gray-50 hover:bg-blue-50/30 transition-colors">
                    <td class="py-3 px-5 text-gray-400 font-mono text-xs">{{ $user->id }}</td>
                    <td class="py-3 px-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs
                                {{ $user->role === 'admin' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-5 text-gray-600">{{ $user->email }}</td>
                    <td class="py-3 px-5">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            {{ $user->role === 'admin' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="py-3 px-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-800 text-xs font-medium">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this user?')"
                                        class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-400 text-sm italic">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-5 py-3 border-t border-gray-100">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection
