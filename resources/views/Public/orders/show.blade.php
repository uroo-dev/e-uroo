@extends('Public.layout.app')

@section('title', 'Struk Digital - ' . $order->order_number . ' - E-UROO')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 lg:py-10">
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('orders.index') }}" class="hover:text-emerald-700">Pesanan Saya</a>
        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
        <span class="font-semibold text-slate-800">Struk Digital {{ $order->order_number }}</span>
    </nav>

    @include('Admin.partials.alert')

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Struk Digital Pesanan</h1>
            <p class="text-sm text-slate-500 mt-0.5">Nomor Referensi: <span class="font-bold text-slate-700">{{ $order->order_number }}</span></p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                <i data-lucide="printer" class="w-4 h-4"></i> Cetak Struk
            </button>
            @if($order->payment_method === 'transfer' && $order->payment_status === 'pending')
                <a href="{{ route('payment.show', $order->order_number) }}" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 shadow-md">
                    <i data-lucide="upload" class="w-4 h-4"></i> Upload Bukti
                </a>
            @endif
        </div>
    </div>

    <!-- Digital Receipt Card -->
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden p-6 sm:p-8">
        <!-- Header Struk -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-slate-200">
            <div class="flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-xl bg-emerald-700 flex items-center justify-center text-white">
                    <i data-lucide="leaf" class="w-6 h-6"></i>
                </span>
                <div>
                    <h2 class="font-extrabold text-slate-900 text-lg tracking-tight">E-UROO PERKEBUNAN</h2>
                    <p class="text-xs text-slate-500">PT Hasil Pertanian & Perkebunan Indonesia</p>
                </div>
            </div>
            <div class="text-right">
                @php
                    $statusBadge = match($order->status) {
                        'pending' => 'bg-amber-100 text-amber-800',
                        'processing' => 'bg-sky-100 text-sky-800',
                        'completed' => 'bg-emerald-100 text-emerald-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        default => 'bg-slate-100 text-slate-800',
                    };
                @endphp
                <span class="text-xs font-extrabold px-3 py-1.5 rounded-full {{ $statusBadge }}">
                    STATUS: {{ strtoupper($order->status) }}
                </span>
                <p class="text-xs text-slate-400 mt-1.5">Tanggal: {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Info Penerima & Pembayaran -->
        <div class="grid sm:grid-cols-2 gap-6 py-6 border-b border-slate-200 text-sm">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Informasi Penerima</p>
                <p class="font-bold text-slate-800">{{ $order->recipient_name }}</p>
                <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $order->notes }}</p>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Metode & Status Pembayaran</p>
                <p class="font-bold text-slate-800">
                    {{ $order->payment_method === 'cod' ? 'COD (Bayar di Tempat)' : 'Transfer Bank / QRIS' }}
                </p>
                <p class="text-xs mt-1">
                    Status Bayar:
                    @if($order->payment_status === 'paid')
                        <span class="font-bold text-emerald-700">LUNAS (Terverifikasi)</span>
                    @elseif($order->payment_status === 'pending')
                        <span class="font-bold text-amber-600">MENUNGGU PEMBAYARAN</span>
                    @elseif($order->payment_status === 'failed')
                        <span class="font-bold text-red-600">GAGAL / DITOLAK</span>
                    @else
                        <span class="font-bold text-slate-600">BELUM DIBAYAR</span>
                    @endif
                </p>
                @if($order->paid_at)
                    <p class="text-[11px] text-slate-400 mt-0.5">Waktu Lunas: {{ $order->paid_at->translatedFormat('d M Y, H:i') }} WIB</p>
                @endif
            </div>
        </div>

        <!-- Rincian Item Komoditas -->
        <div class="py-6 border-b border-slate-200">
            <h3 class="font-bold text-slate-900 text-sm mb-4">Rincian Komoditas Panen</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex-1 pr-4">
                            <p class="font-semibold text-slate-800">{{ $item->product_name }}</p>
                            <p class="text-xs text-slate-400">{{ $item->quantity }} unit x Rp{{ number_format($item->product_price, 0, ',', '.') }} (SKU: {{ $item->product_sku }})</p>
                        </div>
                        <p class="font-bold text-slate-900">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Perhitungan Total -->
        <div class="pt-6 space-y-2 text-sm">
            <div class="flex justify-between text-slate-600">
                <span>Subtotal</span>
                <span class="font-semibold text-slate-800">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-slate-600">
                <span>Ongkos Kirim Kebun</span>
                <span class="font-semibold text-emerald-700">GRATIS</span>
            </div>
            <div class="flex justify-between text-base font-extrabold text-slate-900 pt-3 border-t border-slate-200">
                <span>Total Tagihan</span>
                <span class="text-emerald-800 text-xl">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Riwayat Log Perjalanan Status -->
        @if($order->statusLogs->isNotEmpty())
            <div class="mt-8 pt-6 border-t border-slate-200">
                <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-4">Riwayat Status Pesanan</h4>
                <ol class="relative border-l-2 border-emerald-200 ml-3 space-y-4 text-xs">
                    @foreach($order->statusLogs as $log)
                        <li class="pl-4 relative">
                            <span class="absolute -left-[9px] top-0.5 w-3 h-3 rounded-full bg-emerald-600 ring-2 ring-white"></span>
                            <p class="font-bold text-slate-800">{{ $log->note ?? 'Status: ' . $log->status }}</p>
                            <p class="text-slate-400 text-[10px]">{{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        @endif
    </div>
</div>
@endsection
