@extends('layouts.storefront')
@section('title', 'Cart')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10" x-data>

    <h1 class="text-xl font-black tracking-[0.3em] uppercase text-center text-gray-800 mb-10">Shopping Cart</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Items --}}
        <div class="lg:col-span-2">
            <h2 class="text-xs font-bold tracking-widest uppercase text-gray-600 mb-4">Your Order</h2>

            <template x-if="$store.cart.items.length === 0">
                <div class="kf-card text-center py-16">
                    <div class="text-5xl mb-4">🛒</div>
                    <p class="text-gray-500 font-medium text-sm">Your cart is empty</p>
                    <a href="{{ route('shop') }}" class="kf-btn mt-6 inline-block">Go to the store</a>
                </div>
            </template>

            <template x-for="item in $store.cart.items" :key="item.id + '_' + (item.model ?? '')">
                <div class="kf-cart-item">
                    <div class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden flex items-center justify-center text-3xl"
                         style="background-color: #dce3f5;">
                        <template x-if="item.image">
                            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!item.image">
                            <span x-text="item.icon ?? '📦'"></span>
                        </template>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold tracking-widest uppercase text-gray-800" x-text="item.name"></p>
                        <p class="text-xs text-gray-500 mt-0.5" x-text="item.model ?? ''"></p>
                        <p class="text-xs text-gray-400 mt-1 italic" x-text="item.eta ?? ''"></p>
                        <div class="flex items-center gap-2 mt-3">
                            <button @click="$store.cart.setQty(item.id, item.model, item.qty - 1)" class="kf-qty-btn">−</button>
                            <span class="text-sm font-semibold w-6 text-center" x-text="item.qty"></span>
                            <button @click="$store.cart.setQty(item.id, item.model, item.qty + 1)" class="kf-qty-btn">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col items-end justify-between gap-2 self-stretch">
                        <button @click="$store.cart.remove(item.id, item.model)"
                                class="text-gray-400 hover:text-red-500 transition-colors text-lg leading-none">&#10005;</button>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">
                                $<span x-text="(parseFloat(item.price) * item.qty).toFixed(2)"></span> <span class="text-[10px] text-gray-400">USD</span>
                            </p>
                            <p class="text-[10px] text-gray-400" x-show="item.priceMxn">
                                $<span x-text="(parseFloat(item.priceMxn || 0) * item.qty).toFixed(2)"></span> MXN
                            </p>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="$store.cart.items.length > 0">
                <div class="mt-4 text-right">
                    <button @click="$store.cart.clear()"
                            class="text-xs text-gray-500 hover:text-red-500 underline transition-colors">Clear cart</button>
                </div>
            </template>
        </div>

        {{-- Summary --}}
        <div class="lg:col-span-1">
            <div class="kf-card sticky top-24">
                <h2 class="text-xs font-bold tracking-widest uppercase text-gray-600 mb-4">Summary</h2>

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

                <template x-if="$store.cart.items.length > 0">
                    <a href="{{ route('checkout') }}"
                       class="kf-btn w-full mt-5 text-center block">Go to checkout</a>
                </template>
                <template x-if="$store.cart.items.length === 0">
                    <button disabled class="kf-btn w-full mt-5 opacity-40 cursor-not-allowed">Go to checkout</button>
                </template>

                <a href="{{ route('shop') }}"
                   class="block text-center text-xs text-gray-500 hover:text-blue-600 mt-3 underline">Continue shopping</a>
            </div>
        </div>
    </div>
</div>
@endsection
