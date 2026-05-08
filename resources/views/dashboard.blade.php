@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-black tracking-wide text-gray-800">Management Dashboard</h1>
    <p class="text-sm text-gray-500 mt-1">Welcome back, {{ auth()->user()->name }}</p>
</div>

{{-- Summary cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-10">
    @foreach([
        ['label' => 'Clients', 'value' => $totalClientes, 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'color' => 'blue'],
        ['label' => 'CRM Contacts', 'value' => $totalContactos, 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'indigo'],
        ['label' => 'Total Sales', 'value' => $totalVentas, 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald'],
    ] as $card)
    <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-{{ $card['color'] }}-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
            </svg>
        </div>
        <div>
            <p class="text-3xl font-black text-gray-800">{{ $card['value'] }}</p>
            <p class="text-xs text-gray-500 uppercase tracking-widest font-medium">{{ $card['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Sales by status --}}
<div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
    <h2 class="text-sm font-bold tracking-widest uppercase text-gray-600 mb-4">Sales by Status</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left py-3 px-4 text-xs font-bold uppercase tracking-widest text-gray-500">Status</th>
                    <th class="text-left py-3 px-4 text-xs font-bold uppercase tracking-widest text-gray-500">Count</th>
                    <th class="text-left py-3 px-4 text-xs font-bold uppercase tracking-widest text-gray-500">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach(['prospecto' => 'Prospect', 'negociacion' => 'Negotiation', 'cerrado' => 'Closed', 'perdido' => 'Lost'] as $status => $label)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center gap-1.5">
                            @if($status === 'prospecto')
                                <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                            @elseif($status === 'negociacion')
                                <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                            @elseif($status === 'cerrado')
                                <span class="w-2 h-2 rounded-full bg-green-400"></span>
                            @else
                                <span class="w-2 h-2 rounded-full bg-red-400"></span>
                            @endif
                            {{ $label }}
                        </span>
                    </td>
                    <td class="py-3 px-4 font-semibold">{{ $ventasPorEstado[$status]->total ?? 0 }}</td>
                    <td class="py-3 px-4 font-semibold">${{ number_format($ventasPorEstado[$status]->monto ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Recent activities --}}
<div class="bg-white rounded-2xl shadow-sm p-6">
    <h2 class="text-sm font-bold tracking-widest uppercase text-gray-600 mb-4">Recent Activities</h2>
    @forelse($actividadesRecientes as $actividad)
        <div class="flex items-start gap-3 py-3 border-b border-gray-50 last:border-0">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                {{ $actividad->type === 'llamada' ? 'bg-blue-50 text-blue-600' : '' }}
                {{ $actividad->type === 'email' ? 'bg-purple-50 text-purple-600' : '' }}
                {{ $actividad->type === 'reunion' ? 'bg-green-50 text-green-600' : '' }}
                {{ $actividad->type === 'nota' ? 'bg-yellow-50 text-yellow-600' : '' }}">
                @if($actividad->type === 'llamada')
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                @elseif($actividad->type === 'email')
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                @elseif($actividad->type === 'reunion')
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                @endif
            </div>
            <div class="flex-1">
                <p class="text-sm text-gray-800">
                    <span class="font-semibold">{{ ucfirst($actividad->type) }}</span> —
                    {{ $actividad->contact->user->name }}
                </p>
                <p class="text-xs text-gray-500 mt-0.5">{{ $actividad->description }}</p>
            </div>
            <span class="text-xs text-gray-400 flex-shrink-0">{{ $actividad->occurred_at->format('M d, Y H:i') }}</span>
        </div>
    @empty
        <p class="text-sm text-gray-400 italic py-4 text-center">No recent activities.</p>
    @endforelse
</div>

@endsection
