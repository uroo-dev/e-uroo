@extends('Public.layout.app')
@section('title', 'Keranjang Belanja - E-UROO')
@section('content')
    <!-- ==================== Public Cart Page ==================== -->
    <section data-page="cart" class="page">
        <div class="max-w-7xl mx-auto px-4 py-6 lg:py-10">
            <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-emerald-700">Beranda</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
                <span class="font-semibold text-slate-800">Keranjang Belanja</span>
            </nav>
            <h1 class="text-2xl font-extrabold text-slate-900 mb-6 tracking-tight">Keranjang Belanja</h1>

            @if(isset($cart) && $cart->items->isNotEmpty())
                <div id="cart-filled" class="grid lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-4">
                        @foreach ($cart->items as $item)
                            <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex gap-4">
                                @if($item->product && $item->product->main_image)
                                    <img src="{{ asset('storage/' . $item->product->main_image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl object-cover shrink-0">
                                @else
                                    <span class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-box text-emerald-600 text-2xl"></i>
                                    </span>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-xs text-slate-400 font-medium">{{ $item->product->category->name ?? 'Produk' }}</p>
                                            <h3 class="font-semibold text-sm text-slate-800">{{ $item->product->name ?? 'Produk' }}</h3>
                                            <p class="text-xs text-slate-500 mt-1">Harga: Rp{{ number_format($item->product->price ?? 0, 0, ',', '.') }}</p>
                                        </div>
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition shrink-0" aria-label="Hapus item" title="Hapus dari keranjang">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="flex flex-wrap items-center justify-between gap-3 mt-3">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center border border-slate-200 rounded-xl overflow-hidden">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" onclick="adjustQty(this, -1)" class="px-3 py-2 text-slate-500 hover:bg-slate-50 transition" aria-label="Kurangi">
                                                <i data-lucide="minus" class="w-3.5 h-3.5"></i>
                                            </button>
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-12 text-center text-sm font-bold focus:outline-none border-x border-slate-200" onchange="this.form.submit()">
                                            <button type="button" onclick="adjustQty(this, 1)" class="px-3 py-2 text-slate-500 hover:bg-slate-50 transition" aria-label="Tambah">
                                                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                        <p class="font-extrabold text-emerald-800">
                                            Rp{{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i> Lanjut belanja
                        </a>
                    </div>

                    <!-- Cart Summary -->
                    <div class="lg:sticky lg:top-24 h-fit bg-white border border-slate-200 rounded-2xl p-5">
                        <h2 class="font-bold text-slate-900 mb-4">Ringkasan Belanja</h2>
                        @php
                            $subtotal = $cart->items->sum(function($item) {
                                return ($item->product->price ?? 0) * $item->quantity;
                            });
                        @endphp
                        <div class="space-y-2.5 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Total barang ({{ $cart->items->sum('quantity') }})</span>
                                <span class="font-semibold">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="border-t border-slate-100 mt-4 pt-4 flex justify-between items-baseline">
                            <span class="font-bold text-slate-900">Total Tagihan</span>
                            <span class="text-xl font-extrabold text-emerald-800">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <button class="mt-4 w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3.5 rounded-xl text-sm transition shadow-md shadow-emerald-700/20 flex items-center justify-center gap-2">
                            Lanjut ke Checkout <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            @else
                <div id="cart-empty" class="bg-white border border-slate-200 rounded-2xl py-16 px-6 text-center max-w-lg mx-auto">
                    <span class="w-16 h-16 mx-auto rounded-2xl bg-slate-50 flex items-center justify-center">
                        <i data-lucide="shopping-cart" class="w-8 h-8 text-slate-300"></i>
                    </span>
                    <h3 class="font-bold text-lg text-slate-900 mt-5">Keranjang masih kosong</h3>
                    <p class="text-sm text-slate-500 mt-2">Belum ada produk di keranjang Anda. Yuk jelajahi produk UMKM pilihan kami.</p>
                    <div class="flex justify-center gap-3 mt-6">
                        <a href="{{ route('home') }}" class="bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-sm px-6 py-3 rounded-xl transition">
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
    <script>
        function adjustQty(btn, delta) {
            const form = btn.closest('form');
            const input = form.querySelector('input[name="quantity"]');
            let val = parseInt(input.value) || 1;
            val = Math.max(1, val + delta);
            input.value = val;
            form.submit();
        }
    </script>
    @endpush
@endsection
