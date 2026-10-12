@extends('Admin.layout.app')

@section('title', 'Admin Dashboard - E-UROO')

@section('content')
<section class="apage">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Admin</h1>
            <p class="text-sm text-slate-500 mt-0.5">Ringkasan performa penjualan komoditas pertanian & perkebunan PT</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 bg-white border border-slate-200 hover:border-emerald-300 text-slate-600 font-semibold text-sm px-4 py-2.5 rounded-xl transition shadow-sm">
            <i class="fa-solid fa-arrows-rotate"></i> Muat Ulang Data
        </a>
    </div>

    @include('Admin.partials.alert')

    <!-- Metrics Cards -->
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
        <!-- Revenue -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <i class="fa-solid fa-wallet text-base"></i>
                </span>
                <span class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> Real
                </span>
            </div>
            <p class="text-xl lg:text-2xl font-extrabold text-slate-900 mt-3">
                Rp{{ number_format($totalRevenue, 0, ',', '.') }}
            </p>
            <p class="text-xs text-slate-500 mt-1 font-medium">Total omset pendapatan</p>
        </div>

        <!-- Orders -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <i class="fa-solid fa-bag-shopping text-base"></i>
                </span>
                <span class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                    Bulan ini
                </span>
            </div>
            <p class="text-xl lg:text-2xl font-extrabold text-slate-900 mt-3">
                {{ number_format($totalOrdersMonth) }}
            </p>
            <p class="text-xs text-slate-500 mt-1 font-medium">Pesanan bulan {{ now()->translatedFormat('F') }}</p>
        </div>

        <!-- Active Products -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                    <i class="fa-solid fa-box text-base"></i>
                </span>
                <span class="text-xs font-bold text-slate-500">
                    Aktif
                </span>
            </div>
            <p class="text-xl lg:text-2xl font-extrabold text-slate-900 mt-3">
                {{ number_format($totalProducts) }}
            </p>
            <p class="text-xs text-slate-500 mt-1 font-medium">Komoditas produk aktif</p>
        </div>

        <!-- Registered Customers -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <i class="fa-solid fa-users text-base"></i>
                </span>
                <span class="text-xs font-bold text-emerald-600">
                    Customer
                </span>
            </div>
            <p class="text-xl lg:text-2xl font-extrabold text-slate-900 mt-3">
                {{ number_format($totalCustomers) }}
            </p>
            <p class="text-xs text-slate-500 mt-1 font-medium">Pelanggan terdaftar</p>
        </div>
    </div>

    <!-- Kategori & Info -->
    <div class="grid xl:grid-cols-3 gap-4 mt-6">
        <div class="xl:col-span-2 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-slate-900">Komoditas Perkebunan Berdasarkan Kategori</h2>
                <a href="{{ route('admin.category') }}" class="text-xs font-bold text-emerald-700 hover:underline">Kelola Kategori</a>
            </div>
            <div class="grid sm:grid-cols-2 gap-3">
                @forelse($topCategories as $cat)
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">
                                <i class="fa-solid fa-leaf"></i>
                            </span>
                            <div>
                                <p class="font-bold text-sm text-slate-800">{{ $cat->name }}</p>
                                <p class="text-xs text-slate-400">{{ $cat->products_count }} produk terdaftar</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 col-span-2">Belum ada kategori komoditas.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <h2 class="font-bold text-slate-900 mb-2">Aksi Cepat</h2>
            <div class="space-y-2 mt-4 text-xs font-semibold">
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="flex items-center justify-between p-3 rounded-xl bg-amber-50 text-amber-800 hover:bg-amber-100 transition">
                    <span><i class="fa-solid fa-clock mr-1.5"></i> Periksa Pesanan Menunggu</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" class="flex items-center justify-between p-3 rounded-xl bg-emerald-50 text-emerald-800 hover:bg-emerald-100 transition">
                    <span><i class="fa-solid fa-circle-check mr-1.5"></i> Verifikasi Bukti Pembayaran</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="{{ route('admin.product') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 text-slate-800 hover:bg-slate-100 transition">
                    <span><i class="fa-solid fa-plus mr-1.5"></i> Tambah Produk Panen Baru</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Pesanan Terbaru -->
    <div class="bg-white border border-slate-200 rounded-2xl mt-6 overflow-hidden shadow-sm">
        <div class="flex items-center justify-between p-5 pb-4 border-b border-slate-100">
            <div>
                <h2 class="font-bold text-slate-900">Pesanan Terbaru Masuk</h2>
                <p class="text-xs text-slate-400 mt-0.5">5 pesanan terakhir yang dipesan pelanggan</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[640px]">
                <thead>
                    <tr class="bg-slate-50 text-left text-xs text-slate-500 font-semibold">
                        <th class="px-5 py-3">Invoice</th>
                        <th class="px-5 py-3">Pelanggan</th>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3">Total</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders as $ro)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5 font-bold text-slate-800">{{ $ro->order_number }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $ro->user->name ?? 'Guest' }}</td>
                            <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $ro->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">Rp{{ number_format($ro->grand_total, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5">
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $ro->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : ($ro->status === 'processing' ? 'bg-sky-50 text-sky-700' : 'bg-amber-50 text-amber-700') }}">
                                    {{ ucfirst($ro->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <a href="{{ route('admin.orders.show', $ro->id) }}" class="text-xs font-bold text-emerald-700 hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-sm">Belum ada pesanan terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
