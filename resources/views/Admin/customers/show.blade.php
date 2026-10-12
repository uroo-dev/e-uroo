@extends('Admin.layout.app')

@section('title', 'Detail Pelanggan ' . $customer->name . ' - Admin NusantaraMart')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.customers.index') }}" class="p-2.5 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-emerald-700 hover:border-emerald-300 transition">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">{{ $customer->name }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Email: {{ $customer->email }} | Telepon: {{ $customer->phone ?? '-' }}</p>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Riwayat Alamat Tersimpan -->
    <div class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <h3 class="font-bold text-slate-900 text-sm mb-3">Daftar Alamat Pengiriman</h3>
            <div class="space-y-3">
                @forelse($customer->addresses as $addr)
                    <div class="border rounded-xl p-3.5 {{ $addr->is_default ? 'border-emerald-600 bg-emerald-50/20' : 'border-slate-200' }}">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-xs text-slate-800">{{ $addr->recipient_name }}</span>
                            @if($addr->is_default)
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">Utama</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $addr->phone }}</p>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $addr->full_address }}, {{ $addr->district }}, {{ $addr->city }}, {{ $addr->province }} {{ $addr->postal_code }}</p>
                    </div>
                @empty
                    <p class="text-xs text-slate-400">Pelanggan belum menambahkan alamat.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Riwayat Transaksi Pesanan -->
    <div class="lg:col-span-2">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <h3 class="font-bold text-slate-900 text-sm mb-4">Riwayat Pesanan Pelanggan ({{ $customer->orders->count() }})</h3>
            <div class="divide-y divide-slate-100">
                @forelse($customer->orders as $order)
                    <div class="py-3.5 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-sm text-slate-800">{{ $order->order_number }}</p>
                            <p class="text-xs text-slate-400">{{ $order->created_at->format('d M Y, H:i') }} WIB | Total: Rp{{ number_format($order->grand_total, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $order->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-xs font-bold text-emerald-700 hover:underline">
                                Buka Pesanan
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-6 text-center">Belum ada riwayat pesanan dari pelanggan ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
