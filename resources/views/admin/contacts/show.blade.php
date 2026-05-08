@extends('layouts.admin')
@section('title', 'Contact — ' . $contact->user->name)

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.contacts.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-black tracking-wide text-gray-800">{{ $contact->user->name }}</h1>
                <p class="text-sm text-gray-500">{{ $contact->user->email }}</p>
            </div>
        </div>
        <a href="{{ route('admin.contacts.edit', $contact) }}" class="kf-btn text-sm">Edit</a>
    </div>

    {{-- Contact Info Card --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Company</p>
                <p class="text-sm text-gray-800 font-medium">{{ $contact->company ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Phone</p>
                <p class="text-sm text-gray-800 font-medium">{{ $contact->phone ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Position</p>
                <p class="text-sm text-gray-800 font-medium">{{ $contact->position ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Notes</p>
                <p class="text-sm text-gray-800 font-medium">{{ $contact->notes ?? '—' }}</p>
            </div>
        </div>
    </div>

    {{-- Sales --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold tracking-widest uppercase text-gray-600">Sales</h2>
            <a href="{{ route('admin.sales.create') }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">+ New Sale</a>
        </div>

        @forelse($contact->sales as $sale)
        <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
            <div>
                <p class="text-sm font-semibold text-gray-800">{{ $sale->title }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $sale->expected_close ?? 'No date' }}</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm font-bold text-gray-700">${{ number_format($sale->amount, 2) }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full font-medium
                    {{ $sale->status === 'cerrado' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $sale->status === 'perdido' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $sale->status === 'negociacion' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $sale->status === 'prospecto' ? 'bg-blue-100 text-blue-700' : '' }}">
                    {{ ucfirst($sale->status) }}
                </span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.sales.edit', $sale) }}" class="text-yellow-600 hover:text-yellow-800 text-xs">Edit</a>
                    <form action="{{ route('admin.sales.destroy', $sale) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete?')" class="text-red-500 hover:text-red-700 text-xs">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-400 italic text-center py-4">No sales registered.</p>
        @endforelse
    </div>

    {{-- Log Activity --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <h2 class="text-sm font-bold tracking-widest uppercase text-gray-600 mb-4">Log Activity</h2>
        <form action="{{ route('admin.activities.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
            @csrf
            <input type="hidden" name="contact_id" value="{{ $contact->id }}">

            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-1 block">Type</label>
                <select name="type" class="kf-input text-sm">
                    <option value="llamada">Call</option>
                    <option value="email">Email</option>
                    <option value="reunion">Meeting</option>
                    <option value="nota">Note</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-1 block">Description</label>
                <input type="text" name="description" class="kf-input text-sm" placeholder="Brief description" required>
            </div>
            <div>
                <label class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-1 block">Date</label>
                <input type="datetime-local" name="occurred_at" class="kf-input text-sm" required>
            </div>
            <button type="submit" class="kf-btn text-sm h-[42px]">Log</button>
        </form>
    </div>

    {{-- Activity History --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-sm font-bold tracking-widest uppercase text-gray-600 mb-4">Activity History</h2>
        @forelse($contact->activities->sortByDesc('occurred_at') as $activity)
        <div class="flex items-start justify-between py-3 border-b border-gray-50 last:border-0">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5
                    {{ $activity->type === 'llamada' ? 'bg-blue-50 text-blue-600' : '' }}
                    {{ $activity->type === 'email' ? 'bg-purple-50 text-purple-600' : '' }}
                    {{ $activity->type === 'reunion' ? 'bg-green-50 text-green-600' : '' }}
                    {{ $activity->type === 'nota' ? 'bg-yellow-50 text-yellow-600' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $activity->type === 'llamada' ? 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z' : '' }}{{ $activity->type === 'email' ? 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' : '' }}{{ $activity->type === 'reunion' ? 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z' : '' }}{{ $activity->type === 'nota' ? 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z' : '' }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ ucfirst($activity->type) }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $activity->description }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400">{{ $activity->occurred_at->format('M d, Y H:i') }}</span>
                <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600 text-xs">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-400 italic text-center py-4">No activities registered.</p>
        @endforelse
    </div>

</div>

@endsection
