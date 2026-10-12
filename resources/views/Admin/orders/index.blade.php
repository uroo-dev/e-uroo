@extends('Admin.layout.app')

@section('title', 'Daftar Pesanan - Admin NusantaraMart')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Pesanan</h1>
        <p class="text-sm text-slate-500 mt-0.5">Kelola seluruh transaksi pesanan komoditas hasil perkebunan</p>
    </div>
</div>

@include('Admin.partials.alert')

<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    <div class="p-4 sm:p-5 flex flex-wrap items-center justify-between gap-3 border-b border-slate-100">
        <!-- Search -->
        <form method="GET" action="{{ route('admin.orders.index') }}" class="relative flex-1 min-w-[200px] max-w-sm">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. invoice atau nama..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>

        <!-- Status Filter Chips -->
        <div class="flex gap-2 overflow-x-auto text-xs font-bold">
            <a href="{{ route('admin.orders.index') }}" class="shrink-0 px-3.5 py-2 rounded-xl transition {{ !request('status') ? 'bg-emerald-700 text-white' : 'bg-slate-50 border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
                Semua ({{ $statusCounts['all'] }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="shrink-0 px-3.5 py-2 rounded-xl transition {{ request('status') === 'pending' ? 'bg-emerald-700 text-white' : 'bg-slate-50 border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
                Menunggu ({{ $statusCounts['pending'] }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="shrink-0 px-3.5 py-2 rounded-xl transition {{ request('status') === 'processing' ? 'bg-emerald-700 text-white' : 'bg-slate-50 border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
                Diproses ({{ $statusCounts['processing'] }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="shrink-0 px-3.5 py-2 rounded-xl transition {{ request('status') === 'completed' ? 'bg-emerald-700 text-white' : 'bg-slate-50 border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
                Selesai ({{ $statusCounts['completed'] }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="shrink-0 px-3.5 py-2 rounded-xl transition {{ request('status') === 'cancelled' ? 'bg-emerald-700 text-white' : 'bg-slate-50 border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
                Dibatalkan ({{ $statusCounts['cancelled'] }})
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[860px]">
            <thead>
                <tr class="bg-slate-50 text-left text-xs text-slate-500 font-semibold border-b border-slate-100">
                    <th class="px-5 py-3">Invoice</th>
                    <th class="px-5 py-3">Pelanggan</th>
                    <th class="px-5 py-3">Komoditas</th>
                    <th class="px-5 py-3">Total Tagihan</th>
                    <th class="px-5 py-3">Metode Bayar</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-5 py-3.5 font-bold text-slate-800">
                            {{ $order->order_number }}
                            <p class="text-[11px] font-normal text-slate-400">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="font-semibold text-slate-800">{{ $order->user->name ?? 'Guest' }}</p>
                            <p class="text-xs text-slate-400">{{ $order->recipient_phone }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600 text-xs">
                            {{ $order->items->count() }} jenis komoditas
                        </td>
                        <td class="px-5 py-3.5 font-bold text-slate-800">
                            Rp{{ number_format($order->grand_total, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3.5 text-xs text-slate-600">
                            {{ $order->payment_method === 'cod' ? 'COD (Bayar di Tempat)' : 'Transfer Bank / QRIS' }}
                        </td>
                        <td class="px-5 py-3.5">
                            @php
                                $badgeColor = match($order->status) {
                                    'pending' => 'bg-amber-50 text-amber-700',
                                    'processing' => 'bg-sky-50 text-sky-700',
                                    'completed' => 'bg-emerald-50 text-emerald-700',
                                    'cancelled' => 'bg-red-50 text-red-600',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            @endphp
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $badgeColor }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-xs font-bold text-emerald-700 hover:underline inline-flex items-center gap-1">
                                Kelola <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400 text-sm">
                            Tidak ada pesanan yang sesuai dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-5 py-4 border-t border-slate-100">
        {{ $orders->links() }}
    </div>
</div>
@endsection
