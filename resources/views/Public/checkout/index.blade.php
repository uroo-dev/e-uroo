@extends('Public.layout.app')

@section('title', 'Checkout Pesanan - E-UROO')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 lg:py-10">
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('cart') }}" class="hover:text-emerald-700">Keranjang</a>
        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
        <span class="font-semibold text-slate-800">Checkout</span>
    </nav>
    <h1 class="text-2xl font-extrabold text-slate-900 mb-6 tracking-tight">Checkout Pesanan</h1>

    @include('Admin.partials.alert')

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">

                <!-- 1. Alamat Pengiriman (Wajib) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-7 h-7 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-extrabold flex items-center justify-center">1</span>
                            Alamat Pengiriman
                        </h2>
                        <a href="{{ route('profile') }}" class="text-xs font-bold text-emerald-700 hover:underline">Kelola Alamat</a>
                    </div>

                    @if($allAddresses->count() > 1)
                        <div class="space-y-3 mb-4">
                            @foreach($allAddresses as $addrOption)
                                <label class="flex items-start gap-3 border rounded-xl p-3.5 cursor-pointer transition {{ $addrOption->id === $address->id ? 'border-emerald-600 bg-emerald-50/30' : 'border-slate-200 hover:border-slate-300' }}">
                                    <input type="radio" name="address_id" value="{{ $addrOption->id }}" {{ $addrOption->id === $address->id ? 'checked' : '' }} class="mt-1 text-emerald-600 focus:ring-emerald-500">
                                    <div class="text-sm">
                                        <p class="font-bold text-slate-800">{{ $addrOption->recipient_name }} ({{ $addrOption->phone }})</p>
                                        <p class="text-xs text-slate-600 mt-0.5">{{ $addrOption->full_address }}, {{ $addrOption->district }}, {{ $addrOption->city }}, {{ $addrOption->province }} {{ $addrOption->postal_code }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <input type="hidden" name="address_id" value="{{ $address->id }}">
                        <div class="border border-emerald-200 bg-emerald-50/40 rounded-xl p-4 text-sm">
                            <p class="font-bold text-slate-900">{{ $address->recipient_name }} - {{ $address->phone }}</p>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                {{ $address->full_address }}, {{ $address->district }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                            </p>
                        </div>
                    @endif

                    <div class="mt-4">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Catatan Tambahan untuk Petugas Kebun / Kurir</label>
                        <textarea name="notes" rows="2" placeholder="Contoh: Titipkan di pos satpam, atau instruksi waktu pengiriman..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>
                </div>

                <!-- 2. Metode Pembayaran (COD atau Transfer Bank/QRIS) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6">
                    <h2 class="font-bold text-slate-900 flex items-center gap-2 mb-4">
                        <span class="w-7 h-7 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-extrabold flex items-center justify-center">2</span>
                        Pilih Metode Pembayaran
                    </h2>

                    <div class="grid sm:grid-cols-2 gap-3">
                        <!-- Pilihan 1: COD (Bayar di Tempat) -->
                        <label class="flex items-start gap-3 border-2 border-slate-200 rounded-xl p-4 cursor-pointer hover:border-emerald-400 transition" id="label-method-cod">
                            <input type="radio" name="payment_method" value="cod" checked onchange="highlightPaymentMethod('cod')" class="mt-1 text-emerald-600 focus:ring-emerald-500">
                            <div>
                                <p class="font-bold text-sm text-slate-900 flex items-center gap-2">
                                    <i data-lucide="banknote" class="w-4 h-4 text-emerald-700"></i> COD (Bayar di Tempat)
                                </p>
                                <p class="text-xs text-slate-500 mt-1">Bayar langsung secara tunai saat produk hasil kebun tiba di lokasi Anda.</p>
                            </div>
                        </label>

                        <!-- Pilihan 2: Transfer Bank / QRIS -->
                        <label class="flex items-start gap-3 border-2 border-slate-200 rounded-xl p-4 cursor-pointer hover:border-emerald-400 transition" id="label-method-transfer">
                            <input type="radio" name="payment_method" value="transfer" onchange="highlightPaymentMethod('transfer')" class="mt-1 text-emerald-600 focus:ring-emerald-500">
                            <div>
                                <p class="font-bold text-sm text-slate-900 flex items-center gap-2">
                                    <i data-lucide="qr-code" class="w-4 h-4 text-emerald-700"></i> Transfer Bank / QRIS
                                </p>
                                <p class="text-xs text-slate-500 mt-1">Scan kode QR atau transfer rekening resmi PT, lalu upload bukti transfer.</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Checkout -->
            <div class="lg:sticky lg:top-24 h-fit space-y-4">
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <h2 class="font-bold text-slate-900 mb-4">Ringkasan Pesanan ({{ $cart->items->sum('quantity') }} produk)</h2>
                    <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                        @php $subtotal = 0; @endphp
                        @foreach($cart->items as $item)
                            @php
                                $itemTotal = $item->product->price * $item->quantity;
                                $subtotal += $itemTotal;
                            @endphp
                            <div class="flex items-center gap-3">
                                @if($item->product->main_image)
                                    <img src="{{ asset('storage/' . $item->product->main_image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 rounded-xl object-cover">
                                @else
                                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=120&q=80&auto=format&fit=crop" alt="{{ $item->product->name }}" class="w-12 h-12 rounded-xl object-cover">
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $item->product->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $item->quantity }} x Rp{{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                                <p class="text-sm font-bold">Rp{{ number_format($itemTotal, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-100 mt-4 pt-4 space-y-2 text-sm">
                        <div class="flex justify-between text-slate-500">
                            <span>Subtotal Komoditas</span>
                            <span class="font-semibold text-slate-800">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Ongkir Kebun</span>
                            <span class="font-semibold text-emerald-700">GRATIS</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 mt-4 pt-4 flex justify-between items-baseline">
                        <span class="font-bold text-slate-900">Total Pembayaran</span>
                        <span class="text-xl font-extrabold text-emerald-800">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" id="btn-submit-order" class="mt-5 w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3.5 rounded-xl text-sm transition shadow-md shadow-emerald-700/20 flex items-center justify-center gap-2">
                        <span>Konfirmasi & Buat Pesanan</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                    <p class="text-[11px] text-slate-400 text-center mt-3">
                        Dengan menekan tombol, Anda menyetujui pemesanan hasil komoditas perkebunan PT.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function highlightPaymentMethod(method) {
        const codEl = document.getElementById('label-method-cod');
        const transferEl = document.getElementById('label-method-transfer');
        if (method === 'cod') {
            codEl.classList.add('border-emerald-600', 'bg-emerald-50/30');
            transferEl.classList.remove('border-emerald-600', 'bg-emerald-50/30');
        } else {
            transferEl.classList.add('border-emerald-600', 'bg-emerald-50/30');
            codEl.classList.remove('border-emerald-600', 'bg-emerald-50/30');
        }
    }
    // Set initial highlight
    highlightPaymentMethod('cod');

    // Anti-spam double submission protection
    const checkoutForm = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('btn-submit-order');
    if (checkoutForm && submitBtn) {
        checkoutForm.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            submitBtn.innerHTML = '<span>Memproses Pesanan...</span>';
        });
    }
</script>
@endpush
@endsection
