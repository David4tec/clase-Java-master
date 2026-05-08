@extends('layouts.admin')
@section('title', 'Sales')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-black tracking-wide text-gray-800">Sales Tracking</h1>
    <a href="{{ route('admin.sales.create') }}" class="kf-btn text-sm">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        New Sale
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100" style="background-color: #f1f5f9;">
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Title</th>
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Client</th>
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Amount</th>
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Status</th>
                    <th class="text-left py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Expected Close</th>
                    <th class="text-right py-3 px-5 text-xs font-bold uppercase tracking-widest text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr class="border-b border-gray-50 hover:bg-blue-50/30 transition-colors">
                    <td class="py-3 px-5 font-semibold text-gray-800">{{ $sale->title }}</td>
                    <td class="py-3 px-5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-[10px]">
                                {{ strtoupper(substr($sale->contact->user->name, 0, 1)) }}
                            </div>
                            <span class="text-gray-600">{{ $sale->contact->user->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-5 font-semibold text-gray-700">${{ number_format($sale->amount, 2) }}</td>
                    <td class="py-3 px-5">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            {{ $sale->status === 'cerrado' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $sale->status === 'perdido' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $sale->status === 'negociacion' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $sale->status === 'prospecto' ? 'bg-blue-100 text-blue-700' : '' }}">
                            {{ ucfirst($sale->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-5 text-gray-500">{{ $sale->expected_close ?? '—' }}</td>
                    <td class="py-3 px-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.sales.edit', $sale) }}" class="text-yellow-600 hover:text-yellow-800 text-xs font-medium">Edit</a>
                            <form action="{{ route('admin.sales.destroy', $sale) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this sale?')"
                                        class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-gray-400 text-sm italic">No sales registered yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sales->hasPages())
    <div class="px-5 py-3 border-t border-gray-100">
        {{ $sales->links() }}
    </div>
    @endif
</div>

@endsection
