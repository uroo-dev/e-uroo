@extends('Admin.layout.app')

@section('title', 'Konfirmasi Pembayaran - Admin NusantaraMart')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Konfirmasi Pembayaran</h1>
        <p class="text-sm text-slate-500 mt-0.5">Verifikasi bukti transfer pelanggan untuk pesanan non-COD</p>
    </div>
</div>

@include('Admin.partials.alert')

<!-- Ringkasan Status -->
<div class="grid sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <span class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
            <i class="fa-solid fa-clock"></i>
        </span>
        <p class="text-2xl font-extrabold text-slate-900 mt-3">{{ $statusCounts['pending'] }}</p>
        <p class="text-xs text-slate-400 font-semibold mt-0.5">Menunggu Verifikasi</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <i class="fa-solid fa-circle-check"></i>
        </span>
        <p class="text-2xl font-extrabold text-slate-900 mt-3">{{ $statusCounts['verified'] }}</p>
        <p class="text-xs text-slate-400 font-semibold mt-0.5">Telah Diverifikasi</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <span class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
            <i class="fa-solid fa-circle-xmark"></i>
        </span>
        <p class="text-2xl font-extrabold text-slate-900 mt-3">{{ $statusCounts['rejected'] }}</p>
        <p class="text-xs text-slate-400 font-semibold mt-0.5">Bukti Ditolak</p>
    </div>
</div>

<!-- Table Card -->
<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    <div class="p-4 sm:p-5 flex flex-wrap items-center justify-between gap-3 border-b border-slate-100">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="relative flex-1 min-w-[200px] max-w-sm">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice atau pembeli..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>

        <div class="flex gap-2 overflow-x-auto text-xs font-bold">
            <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" class="shrink-0 px-3.5 py-2 rounded-xl transition {{ request('status', 'pending') === 'pending' ? 'bg-emerald-700 text-white' : 'bg-slate-50 border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
                Menunggu ({{ $statusCounts['pending'] }})
            </a>
            <a href="{{ route('admin.payments.index', ['status' => 'verified']) }}" class="shrink-0 px-3.5 py-2 rounded-xl transition {{ request('status') === 'verified' ? 'bg-emerald-700 text-white' : 'bg-slate-50 border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
                Terverifikasi ({{ $statusCounts['verified'] }})
            </a>
            <a href="{{ route('admin.payments.index', ['status' => 'rejected']) }}" class="shrink-0 px-3.5 py-2 rounded-xl transition {{ request('status') === 'rejected' ? 'bg-emerald-700 text-white' : 'bg-slate-50 border border-slate-200 text-slate-600 hover:border-emerald-300' }}">
                Ditolak ({{ $statusCounts['rejected'] }})
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[860px]">
            <thead>
                <tr class="bg-slate-50 text-left text-xs text-slate-500 font-semibold border-b border-slate-100">
                    <th class="px-5 py-3">Invoice</th>
                    <th class="px-5 py-3">Pembeli</th>
                    <th class="px-5 py-3">Metode</th>
                    <th class="px-5 py-3">Nominal</th>
                    <th class="px-5 py-3">Bukti</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payments as $payment)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-5 py-3.5 font-bold text-slate-800">
                            {{ $payment->order->order_number ?? '-' }}
                            <p class="text-[11px] font-normal text-slate-400">{{ $payment->created_at->format('d/m/Y H:i') }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="font-semibold text-slate-800">{{ $payment->order->user->name ?? 'Guest' }}</p>
                            <p class="text-xs text-slate-400">{{ $payment->order->recipient_phone ?? '-' }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-xs text-slate-600">
                            {{ $payment->method }}
                        </td>
                        <td class="px-5 py-3.5 font-bold text-slate-800">
                            Rp{{ number_format($payment->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3.5">
                            @if($payment->proof_image)
                                <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="text-xs font-bold text-emerald-700 hover:underline inline-flex items-center gap-1">
                                    <i class="fa-solid fa-image"></i> Lihat Bukti
                                </a>
                            @else
                                <span class="text-xs text-slate-400">Belum diunggah</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            @php
                                $pBadge = match($payment->status) {
                                    'pending' => 'bg-amber-50 text-amber-700',
                                    'verified' => 'bg-emerald-50 text-emerald-700',
                                    'rejected' => 'bg-red-50 text-red-600',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            @endphp
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $pBadge }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <a href="{{ route('admin.payments.show', $payment->id) }}" class="text-xs font-bold text-emerald-700 hover:underline">
                                Verifikasi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400 text-sm">
                            Tidak ada data pembayaran pada status ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-5 py-4 border-t border-slate-100">
        {{ $payments->links() }}
    </div>
</div>
@endsection
