@extends('layouts.admin')
@section('title', 'Contacts')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-black tracking-wide text-gray-800">Contacts</h1>
    <a href="{{ route('admin.contacts.create') }}" class="kf-btn text-sm">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        New Contact
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100" style="background-color: #f1f5f9;">
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Client</th>
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Company</th>
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Phone</th>
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Position</th>
                    <th class="text-right py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                <tr class="border-b border-gray-50 hover:bg-blue-50/30 transition-colors">
                    <td class="py-3 px-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs">
                                {{ strtoupper(substr($contact->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $contact->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $contact->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-5 text-gray-600">{{ $contact->company ?? '—' }}</td>
                    <td class="py-3 px-5 text-gray-600">{{ $contact->phone ?? '—' }}</td>
                    <td class="py-3 px-5 text-gray-600">{{ $contact->position ?? '—' }}</td>
                    <td class="py-3 px-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">View</a>
                            <a href="{{ route('admin.contacts.edit', $contact) }}" class="text-yellow-600 hover:text-yellow-800 text-xs font-medium">Edit</a>
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this contact?')"
                                        class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-400 text-sm italic">No contacts registered yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($contacts->hasPages())
    <div class="px-5 py-3 border-t border-gray-100">
        {{ $contacts->links() }}
    </div>
    @endif
</div>

@endsection
