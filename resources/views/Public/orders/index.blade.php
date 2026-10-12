@extends('Public.layout.app')

@section('title', 'Riwayat Pesanan Saya - E-UROO')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 lg:py-10">
    <h1 class="text-2xl font-extrabold text-slate-900 mb-1 tracking-tight">Pesanan Saya</h1>
    <p class="text-sm text-slate-500 mb-6">Pantau riwayat pemesanan komoditas hasil perkebunan dan pertanian Anda.</p>

    @include('Admin.partials.alert')

    <!-- Status Filters -->
    <div class="flex gap-2 overflow-x-auto pb-2 mb-5">
        <a href="{{ route('orders.index') }}" class="shrink-0 px-4 py-2 rounded-xl text-sm font-semibold transition {{ !request('status') ? 'bg-emerald-700 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
            Semua
        </a>
        <a href="{{ route('orders.index', ['status' => 'pending']) }}" class="shrink-0 px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('status') === 'pending' ? 'bg-emerald-700 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
            Menunggu
        </a>
        <a href="{{ route('orders.index', ['status' => 'processing']) }}" class="shrink-0 px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('status') === 'processing' ? 'bg-emerald-700 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
            Diproses / Dikirim
        </a>
        <a href="{{ route('orders.index', ['status' => 'completed']) }}" class="shrink-0 px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('status') === 'completed' ? 'bg-emerald-700 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
            Selesai
        </a>
        <a href="{{ route('orders.index', ['status' => 'cancelled']) }}" class="shrink-0 px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('status') === 'cancelled' ? 'bg-emerald-700 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
            Dibatalkan
        </a>
    </div>

    <!-- Orders List -->
    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-slate-300 transition">
                <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-slate-100">
                    <div>
                        <p class="font-bold text-sm text-slate-900">
                            {{ $order->order_number }}
                            <span class="font-normal text-slate-400">- {{ $order->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                        </p>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Metode: {{ $order->payment_method === 'cod' ? 'COD (Bayar di Tempat)' : 'Transfer Bank / QRIS' }} | Total: Rp{{ number_format($order->grand_total, 0, ',', '.') }}
                        </p>
                    </div>
                    @php
                        $badgeClasses = match($order->status) {
                            'pending' => 'bg-amber-50 text-amber-700',
                            'processing' => 'bg-sky-50 text-sky-700',
                            'completed' => 'bg-emerald-50 text-emerald-700',
                            'cancelled' => 'bg-red-50 text-red-600',
                            default => 'bg-slate-100 text-slate-600',
                        };
                        $statusLabel = match($order->status) {
                            'pending' => 'Menunggu Pembayaran / Konfirmasi',
                            'processing' => 'Sedang Dikemas / Dikirim',
                            'completed' => 'Pesanan Selesai',
                            'cancelled' => 'Pesanan Dibatalkan',
                            default => ucfirst($order->status),
                        };
                    @endphp
                    <span class="text-xs font-bold px-3 py-1.5 rounded-full {{ $badgeClasses }}">
                        {{ $statusLabel }}
                    </span>
                </div>

                <!-- Preview Items -->
                <div class="flex items-center gap-3 py-4">
                    @foreach($order->items->take(3) as $idx => $item)
                        @if($item->product && $item->product->main_image)
                            <img src="{{ asset('storage/' . $item->product->main_image) }}" alt="{{ $item->product_name }}" class="w-14 h-14 rounded-xl object-cover {{ $idx > 0 ? '-ml-5 ring-2 ring-white' : '' }}">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs {{ $idx > 0 ? '-ml-5 ring-2 ring-white' : '' }}">
                                <i data-lucide="package" class="w-6 h-6"></i>
                            </div>
                        @endif
                    @endforeach
                    <div class="text-sm text-slate-700 ml-2">
                        <p class="font-semibold">{{ $order->items->first()->product_name ?? 'Produk Tani' }}</p>
                        @if($order->items->count() > 1)
                            <p class="text-xs text-slate-400">dan {{ $order->items->count() - 1 }} produk lainnya</p>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-100">
                    <div class="flex gap-2">
                        <a href="{{ route('orders.show', $order->order_number) }}" class="border border-emerald-700 text-emerald-700 hover:bg-emerald-50 font-semibold text-xs px-4 py-2 rounded-xl transition flex items-center gap-1.5">
                            <i data-lucide="receipt" class="w-3.5 h-3.5"></i> Lihat Struk Digital
                        </a>
                        @if($order->payment_method === 'transfer' && $order->payment_status === 'pending')
                            <a href="{{ route('payment.show', $order->order_number) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs px-4 py-2 rounded-xl transition flex items-center gap-1.5">
                                <i data-lucide="upload" class="w-3.5 h-3.5"></i> Upload Bukti Transfer
                            </a>
                        @endif
                    </div>
                    <span class="text-xs text-slate-400">Penerima: {{ $order->recipient_name }}</span>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 rounded-2xl py-16 px-6 text-center max-w-lg mx-auto">
                <span class="w-16 h-16 mx-auto rounded-2xl bg-slate-50 flex items-center justify-center">
                    <i data-lucide="receipt" class="w-8 h-8 text-slate-300"></i>
                </span>
                <h3 class="font-bold text-lg text-slate-900 mt-5">Belum Ada Pesanan</h3>
                <p class="text-sm text-slate-500 mt-2">Riwayat pemesanan komoditas panen Anda akan tercatat di sini.</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-sm px-6 py-3 rounded-xl transition inline-block">
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>
</div>
@endsection
