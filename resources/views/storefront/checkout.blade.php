@extends('layouts.storefront')
@section('title', 'Checkout')

@section('content')
<script>
    const _purchaseUrl  = @json(route('purchase.store'));
    const _thankYouUrl  = @json(route('thank-you'));
    const _csrfToken    = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
    const _authName     = @json(auth()->user()?->name ?? '');
    const _authEmail    = @json(auth()->user()?->email ?? '');

    function checkoutData() {
        return {
            isProcessing: false,
            customerName: _authName,
            customerEmail: _authEmail,

            async completePurchase() {
                if (!this.customerName.trim()) { alert('Please enter your name.'); return; }
                if (!this.customerEmail.trim()) { alert('Please enter your email.'); return; }

                const cartStore = Alpine.store('cart');
                if (!cartStore?.items?.length) { alert('Your cart is empty.'); return; }

                this.isProcessing = true;
                try {
                    const res = await fetch(_purchaseUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': _csrfToken },
                        body: JSON.stringify({
                            items: cartStore.items,
                            total: cartStore.total,
                            customer_name: this.customerName.trim(),
                            customer_email: this.customerEmail.trim(),
                        }),
                    });
                    const data = await res.json();
                    if (data.success) {
                        Alpine.store('cart').clear();
                        window.location.href = _thankYouUrl;
                    } else {
                        alert('Error: ' + (data.message || 'Unknown error'));
                        this.isProcessing = false;
                    }
                } catch (err) {
                    alert('Error: ' + err.message);
                    this.isProcessing = false;
                }
            }
        };
    }
</script>

<div class="max-w-6xl mx-auto px-6 py-10" x-data="checkoutData()">

    <h1 class="text-xl font-black tracking-[0.3em] uppercase text-center text-gray-800 mb-10">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- LEFT: User info + Payment --}}
        <div class="space-y-5">

            {{-- User Info Card --}}
            <div class="kf-card">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl overflow-hidden"
                             style="background-color: #dce3f5;">
                            @auth
                                <span class="font-bold text-blue-700 text-lg">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            @else
                                👤
                            @endauth
                        </div>
                        <div>
                            @auth
                                <p class="font-bold text-sm text-gray-800">{{ auth()->user()->name }}</p>
                            @else
                                <p class="font-bold text-sm text-gray-800" x-text="customerName || 'Enter your name'"></p>
                            @endauth
                        </div>
                    </div>
                    @auth
                    <a href="{{ route('profile.edit') }}"
                       class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Change info
                    </a>
                    @endauth
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs text-gray-600">
                    @auth
                    <div>
                        <p class="font-semibold text-gray-500 uppercase tracking-wide text-[10px] mb-0.5">Email</p>
                        <p>{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-500 uppercase tracking-wide text-[10px] mb-0.5">Phone</p>
                        <p>••••••••••</p>
                    </div>
                    <div class="col-span-2">
                        <p class="font-semibold text-gray-500 uppercase tracking-wide text-[10px] mb-0.5">Address</p>
                        <p>City, State, Country</p>
                    </div>
                    @else
                    <div class="col-span-2">
                        <p class="font-semibold text-gray-500 uppercase tracking-wide text-[10px] mb-0.5">Full Name</p>
                        <input type="text" x-model="customerName" placeholder="John Doe" class="kf-input" />
                    </div>
                    <div class="col-span-2">
                        <p class="font-semibold text-gray-500 uppercase tracking-wide text-[10px] mb-0.5">Email</p>
                        <input type="email" x-model="customerEmail" placeholder="john@example.com" class="kf-input" />
                    </div>
                    @endauth
                </div>
            </div>

            {{-- Payment Form --}}
            <div class="kf-card">
                <h3 class="text-xs font-bold tracking-widest uppercase text-gray-600 mb-4">Payment</h3>

                <div class="space-y-3">
                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span>Debit / Credit card</span>
                    </div>

                    <input type="text" placeholder="1234 5678 9012 3456" maxlength="19"
                           class="kf-input"
                           oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/(.{4})/g,'$1 ').trim()"/>

                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" placeholder="MM / YY" maxlength="7" class="kf-input" />
                        <input type="text" placeholder="CVV" maxlength="4" class="kf-input" />
                    </div>

                    <input type="text" placeholder="Name of the card holder" class="kf-input" />

                    <div class="flex items-center gap-3 pt-1">
                        <div class="px-2 py-1 bg-blue-700 rounded text-white text-[10px] font-bold tracking-widest">VISA</div>
                        <div class="flex">
                            <div class="w-6 h-6 rounded-full bg-red-500 opacity-90"></div>
                            <div class="w-6 h-6 rounded-full bg-yellow-400 -ml-3 opacity-90"></div>
                        </div>
                        <div class="px-2 py-1 bg-blue-400 rounded text-white text-[10px] font-bold">AMEX</div>
                        <div class="px-2 py-1 bg-yellow-400 rounded text-blue-800 text-[10px] font-bold">PayPal</div>
                    </div>
                </div>

                <button @click="completePurchase()"
                        :disabled="isProcessing"
                        :class="isProcessing ? 'opacity-60 cursor-not-allowed' : ''"
                        class="kf-btn w-full mt-5 flex items-center justify-center gap-2 transition-opacity"
                        x-text="isProcessing ? 'Processing...' : 'Complete purchase'">
                </button>
            </div>
        </div>

        {{-- RIGHT: Summary + Shipping --}}
        <div class="space-y-5">

            {{-- Order Summary --}}
            <div class="kf-card">
                <h3 class="text-xs font-bold tracking-widest uppercase text-gray-600 mb-4">Summary</h3>

                <div class="kf-summary-row text-gray-600">
                    <span>Items in the Cart</span>
                    <span>$<span x-text="$store.cart.subtotal.toFixed(2)"></span> USD</span>
                </div>
                <div class="kf-summary-row text-green-600">
                    <span>Saving</span>
                    <span>- $0.00</span>
                </div>
                <div class="kf-summary-total text-gray-800">
                    <span>Total</span>
                    <span>$<span x-text="$store.cart.total.toFixed(2)"></span> USD</span>
                </div>
            </div>

            {{-- Shipping Details --}}
            <div class="kf-card">
                <h3 class="text-xs font-bold tracking-widest uppercase text-gray-600 mb-4">Shipping Details</h3>

                <template x-if="$store.cart.items.length === 0">
                    <p class="text-xs text-gray-400 italic text-center py-4">No items in cart</p>
                </template>

                <template x-for="item in $store.cart.items" :key="item.id + item.model">
                    <div class="flex items-start gap-4 py-3 border-b border-gray-100 last:border-0">
                        <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center text-2xl"
                             style="background-color: #dce3f5;">
                            <template x-if="item.image">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover rounded-xl">
                            </template>
                            <template x-if="!item.image">
                                <span x-text="item.icon ?? '📦'"></span>
                            </template>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold tracking-widest uppercase text-gray-800" x-text="item.name"></p>
                            <p class="text-xs text-gray-500 mt-0.5" x-text="item.model"></p>
                            <p class="text-xs text-gray-400 italic mt-1" x-text="item.eta"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">$<span x-text="(item.price * item.qty).toFixed(2)"></span></p>
                            <p class="text-xs text-gray-400 mt-0.5">× <span x-text="item.qty"></span></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

    </div>
</div>
@endsection
