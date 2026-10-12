@extends('Admin.layout.app')

@section('title', 'Verifikasi Pembayaran #' . ($payment->order->order_number ?? '') . ' - Admin NusantaraMart')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.payments.index') }}" class="p-2.5 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-emerald-700 hover:border-emerald-300 transition">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Verifikasi Pembayaran</h1>
            <p class="text-xs text-slate-500 mt-0.5">Invoice: <span class="font-bold text-slate-700">#{{ $payment->order->order_number ?? '-' }}</span></p>
        </div>
    </div>
</div>

@include('Admin.partials.alert')

<div class="grid lg:grid-cols-2 gap-6">
    <!-- Kolom Kiri: Bukti Transfer File Preview -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm">
        <h3 class="font-bold text-slate-900 text-sm mb-4 flex items-center gap-2">
            <i class="fa-solid fa-file-invoice text-emerald-700"></i> Bukti Transfer Pelanggan
        </h3>

        @if($payment->proof_image)
            <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" title="Klik untuk perbesar">
                    <img src="{{ asset('storage/' . $payment->proof_image) }}" alt="Bukti Transfer" class="w-full max-h-[460px] object-contain mx-auto">
                </a>
            </div>
            <p class="text-xs text-slate-400 text-center mt-2">Klik gambar di atas untuk melihat ukuran penuh</p>
        @else
            <div class="py-16 text-center border-2 border-dashed border-slate-200 rounded-xl">
                <i class="fa-solid fa-image text-slate-300 text-4xl mb-2"></i>
                <p class="text-sm text-slate-500 font-semibold">Pelanggan belum mengunggah foto bukti transfer</p>
            </div>
        @endif
    </div>

    <!-- Kolom Kanan: Detail & Form Verifikasi -->
    <div class="space-y-5">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm">
            <h3 class="font-bold text-slate-900 text-sm mb-4">Informasi Transaksi</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Nomor Invoice</span>
                    <span class="font-bold text-slate-800">{{ $payment->order->order_number ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Nama Pembeli</span>
                    <span class="font-semibold text-slate-800">{{ $payment->order->user->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Nomor Telepon</span>
                    <span class="text-slate-700">{{ $payment->order->recipient_phone ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Metode</span>
                    <span class="text-slate-700">{{ $payment->method }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Nominal Transfer</span>
                    <span class="font-extrabold text-emerald-800 text-base">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-slate-500">Status Saat Ini</span>
                    <span class="font-bold text-xs px-2.5 py-1 rounded-full {{ $payment->status === 'verified' ? 'bg-emerald-100 text-emerald-800' : ($payment->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                        {{ strtoupper($payment->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Form Aksi Verifikasi / Tolak -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm">
            <h3 class="font-bold text-slate-900 text-sm mb-3">Tindakan Verifikasi</h3>

            <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Keputusan</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-emerald-500 text-sm font-semibold text-slate-700">
                            <input type="radio" name="status" value="verified" checked class="text-emerald-600 focus:ring-emerald-500">
                            Setujui & Verifikasi
                        </label>
                        <label class="flex items-center gap-2 border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-red-500 text-sm font-semibold text-slate-700">
                            <input type="radio" name="status" value="rejected" class="text-red-600 focus:ring-red-500">
                            Tolak Bukti
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Alasan Penolakan (Jika Ditolak)</label>
                    <textarea name="rejection_reason" rows="2" placeholder="Contoh: Nominal transfer kurang, atau foto tidak terbaca jelas..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ $payment->rejection_reason }}</textarea>
                </div>

                <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 rounded-xl text-sm transition">
                    Simpan Keputusan Verifikasi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
