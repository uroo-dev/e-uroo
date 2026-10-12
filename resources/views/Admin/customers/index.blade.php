@extends('Admin.layout.app')

@section('title', 'Data Pelanggan - Admin NusantaraMart')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Data Pelanggan</h1>
        <p class="text-sm text-slate-500 mt-0.5">Daftar pelanggan terdaftar yang bertransaksi hasil panen</p>
    </div>
</div>

@include('Admin.partials.alert')

<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    <div class="p-4 sm:p-5 flex flex-wrap items-center justify-between gap-3 border-b border-slate-100">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="relative flex-1 min-w-[200px] max-w-sm">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, telepon..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[760px]">
            <thead>
                <tr class="bg-slate-50 text-left text-xs text-slate-500 font-semibold border-b border-slate-100">
                    <th class="px-5 py-3">Pelanggan</th>
                    <th class="px-5 py-3">Kontak</th>
                    <th class="px-5 py-3">Jumlah Transaksi</th>
                    <th class="px-5 py-3">Total Belanja</th>
                    <th class="px-5 py-3">Terdaftar Sejak</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($customers as $cust)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-sm">
                                    {{ strtoupper(substr($cust->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $cust->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $cust->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-xs text-slate-600">
                            {{ $cust->phone ?? '-' }}
                        </td>
                        <td class="px-5 py-3.5 font-bold text-slate-800 text-xs">
                            {{ $cust->orders_count }} pesanan
                        </td>
                        <td class="px-5 py-3.5 font-extrabold text-emerald-800">
                            Rp{{ number_format($cust->orders_sum_grand_total ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3.5 text-xs text-slate-400">
                            {{ $cust->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <a href="{{ route('admin.customers.show', $cust->id) }}" class="text-xs font-bold text-emerald-700 hover:underline">
                                Detail Pelanggan
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400 text-sm">
                            Tidak ada data pelanggan yang terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-5 py-4 border-t border-slate-100">
        {{ $customers->links() }}
    </div>
</div>
@endsection
