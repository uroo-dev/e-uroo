@extends('Admin.layout.app')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Admin NusantaraMart')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.orders.index') }}" class="p-2.5 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-emerald-700 hover:border-emerald-300 transition">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Pesanan #{{ $order->order_number }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Dipesan pada {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB oleh <span class="font-bold text-slate-700">{{ $order->user->name ?? 'Guest' }}</span></p>
        </div>
    </div>
    <div class="flex gap-2">
        <button onclick="window.print()" class="flex items-center gap-2 bg-white border border-slate-200 hover:border-emerald-300 text-slate-600 font-semibold text-xs px-4 py-2.5 rounded-xl transition shadow-sm">
            <i class="fa-solid fa-print"></i> Cetak Pesanan
        </button>
    </div>
</div>

@include('Admin.partials.alert')

<div class="grid lg:grid-cols-3 gap-5">
    <!-- Kolom Kiri: Rincian Produk & Log Status -->
    <div class="lg:col-span-2 space-y-5">
        <!-- Rincian Produk -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm">Produk Dipesan ({{ $order->items->count() }})</h3>
                <span class="text-xs text-slate-400">Komoditas Perkebunan PT</span>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($order->items as $item)
                    <div class="p-5 flex items-center gap-4">
                        @if($item->product && $item->product->main_image)
                            <img src="{{ asset('storage/' . $item->product->main_image) }}" alt="{{ $item->product_name }}" class="w-14 h-14 rounded-xl object-cover">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-box"></i>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-sm text-slate-800">{{ $item->product_name }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">SKU: {{ $item->product_sku }} | Qty: {{ $item->quantity }} unit</p>
                        </div>
                        <p class="font-bold text-sm text-slate-800">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
            <div class="px-5 py-4 bg-slate-50 border-t border-slate-100 space-y-2 text-sm">
                <div class="flex justify-between text-slate-500">
                    <span>Subtotal</span>
                    <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>Ongkos Kirim Kebun</span>
                    <span class="text-emerald-700 font-semibold">GRATIS</span>
                </div>
                <div class="flex justify-between font-extrabold text-slate-900 pt-2 border-t border-slate-200">
                    <span>Total Tagihan</span>
                    <span class="text-emerald-800 text-base">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Log Riwayat Status Pesanan -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <h3 class="font-bold text-slate-900 text-sm mb-5">Riwayat Status Pesanan</h3>
            <ol class="relative border-l-2 border-emerald-200 ml-2 space-y-5">
                @forelse($order->statusLogs as $log)
                    <li class="ml-5">
                        <span class="absolute -left-[9px] w-4 h-4 rounded-full bg-emerald-600 border-2 border-white"></span>
                        <p class="text-sm font-bold text-slate-800">{{ $log->note }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB - oleh {{ $log->changedBy->name ?? 'Sistem' }}
                        </p>
                    </li>
                @empty
                    <li class="ml-5 text-xs text-slate-400">Belum ada catatan log status.</li>
                @endforelse
            </ol>
        </div>
    </div>

    <!-- Kolom Kanan: Update Status & Detail Pelanggan -->
    <div class="space-y-5">
        <!-- Form Update Status -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <h3 class="font-bold text-slate-900 text-sm mb-3">Ubah Status Pesanan</h3>
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Status Utama</label>
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses (Processing)</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Batalkan Pesanan (Cancelled)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Status Pembayaran</label>
                    <select name="payment_status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Dibayar (Unpaid)</option>
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi (Pending)</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Gagal / Ditolak (Failed)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Catatan Pembaruan (Opsional)</label>
                    <textarea name="note" rows="2" placeholder="Contoh: Paket telah diserahkan ke kurir pengantar..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2.5 rounded-xl text-sm transition">
                    Simpan Perubahan Status
                </button>
            </form>
        </div>

        <!-- Info Penerima & Alamat -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <h3 class="font-bold text-slate-900 text-sm mb-3">Informasi Penerima</h3>
            <p class="font-bold text-sm text-slate-800">{{ $order->recipient_name }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Telepon: {{ $order->recipient_phone }}</p>
            <div class="mt-3 bg-slate-50 rounded-xl p-3 text-xs text-slate-600 leading-relaxed">
                {{ $order->notes }}
            </div>
        </div>

        <!-- Info Pembayaran / Bukti -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <h3 class="font-bold text-slate-900 text-sm mb-3">Informasi Pembayaran</h3>
            <p class="text-xs text-slate-500">Metode: <span class="font-bold text-slate-700">{{ $order->payment_method === 'cod' ? 'COD (Bayar di Tempat)' : 'Transfer Bank / QRIS' }}</span></p>

            @if($order->payment && $order->payment->proof_image)
                <div class="mt-3">
                    <p class="text-xs font-semibold text-slate-600 mb-1.5">Bukti Transfer Pelanggan:</p>
                    <a href="{{ asset('storage/' . $order->payment->proof_image) }}" target="_blank">
                        <img src="{{ asset('storage/' . $order->payment->proof_image) }}" alt="Bukti Transfer" class="w-full h-36 object-cover rounded-xl border border-slate-200 hover:opacity-90 transition">
                    </a>
                    <a href="{{ route('admin.payments.show', $order->payment->id) }}" class="mt-2 block text-center text-xs font-bold text-emerald-700 hover:underline">
                        Buka Panel Verifikasi Pembayaran
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
