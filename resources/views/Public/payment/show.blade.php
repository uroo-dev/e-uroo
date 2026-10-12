@extends('Public.layout.app')

@section('title', 'Pembayaran QRIS & Transfer - ' . $order->order_number . ' - E-UROO')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 lg:py-10">
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('orders.show', $order->order_number) }}" class="hover:text-emerald-700">Struk Pesanan</a>
        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
        <span class="font-semibold text-slate-800">Pembayaran</span>
    </nav>

    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selesaikan Pembayaran</h1>
    <p class="text-sm text-slate-500 mt-1">Silakan lakukan transfer atau scan kode QRIS resmi di bawah, lalu unggah bukti transfer.</p>

    @include('Admin.partials.alert')

    <div class="grid md:grid-cols-5 gap-6 mt-6">
        <!-- Kolom Kiri: Informasi Transfer & QRIS -->
        <div class="md:col-span-3 space-y-5">
            <!-- Box QRIS & Rekening -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 text-center">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold mb-4">
                    <i data-lucide="qr-code" class="w-3.5 h-3.5"></i> QRIS & Rekening Resmi PT
                </span>
                
                <!-- Mockup QR Code -->
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl w-52 h-52 mx-auto flex flex-col items-center justify-center shadow-inner">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=PT_EUROO_PERKEBUNAN_{{ $order->order_number }}_{{ $order->grand_total }}" alt="QRIS E-UROO" class="w-44 h-44 rounded-lg">
                </div>
                <p class="text-xs font-semibold text-slate-600 mt-3">Scan menggunakan GoPay, OVO, Dana, BCA Mobile, atau Bank Apapun</p>

                <div class="border-t border-slate-100 mt-5 pt-5 text-left space-y-3">
                    <div class="bg-slate-50 rounded-xl p-3.5">
                        <p class="text-xs text-slate-500 font-medium">Bank Mandiri</p>
                        <div class="flex items-center justify-between mt-1">
                            <span class="font-bold text-slate-800 font-mono text-base">132-00-9876543-2</span>
                            <span class="text-xs text-slate-400">a.n PT Perkebunan E-Uroo</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3.5">
                        <p class="text-xs text-slate-500 font-medium">Bank BCA</p>
                        <div class="flex items-center justify-between mt-1">
                            <span class="font-bold text-slate-800 font-mono text-base">880-123-4567</span>
                            <span class="text-xs text-slate-400">a.n PT Perkebunan E-Uroo</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Upload Bukti -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6">
                <h2 class="font-bold text-slate-900 flex items-center gap-2 mb-4">
                    <i data-lucide="upload-cloud" class="w-5 h-5 text-emerald-700"></i> Unggah Bukti Pembayaran
                </h2>

                <form action="{{ route('payment.store', $order->order_number) }}" method="POST" enctype="multipart/form-data" id="payment-upload-form">
                    @csrf
                    <div>
                        <label class="block border-2 border-dashed border-slate-300 rounded-xl p-6 text-center cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/40 transition">
                            <i data-lucide="image-plus" class="w-8 h-8 text-slate-300 mx-auto"></i>
                            <p class="text-sm font-semibold text-slate-700 mt-2" id="upload-label">Klik untuk pilih foto struk / tangkapan layar transfer</p>
                            <p class="text-xs text-slate-400 mt-1">Format JPG, PNG, atau WEBP (Maksimal 3 MB)</p>
                            <input type="file" name="proof_image" accept="image/*" required class="hidden" id="proof-input" onchange="previewUpload(this)">
                        </label>
                        <div id="image-preview" class="hidden mt-3 text-center">
                            <img id="preview-img" src="" alt="Preview Bukti" class="max-h-48 rounded-xl mx-auto border border-slate-200 shadow-sm">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Pemilik Rekening Pengirim (Opsional)</label>
                        <input type="text" name="sender_name" placeholder="Contoh: Budi Santoso" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <button type="submit" id="btn-submit-payment" class="mt-5 w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3.5 rounded-xl text-sm transition shadow-md shadow-emerald-700/20 flex items-center justify-center gap-2">
                        <span>Kirim Bukti Pembayaran</span>
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Rincian Tagihan -->
        <div class="md:col-span-2">
            <div class="bg-white border border-slate-200 rounded-2xl p-5 md:sticky md:top-24 space-y-4">
                <h2 class="font-bold text-slate-900">Rincian Tagihan</h2>
                <div>
                    <p class="text-xs text-slate-400">Nomor Invoice</p>
                    <p class="text-sm font-bold text-slate-800">{{ $order->order_number }}</p>
                </div>
                <div class="border-t border-slate-100 pt-3 space-y-2 text-sm">
                    <div class="flex justify-between text-slate-500">
                        <span>Subtotal ({{ $order->items->count() }} komoditas)</span>
                        <span class="font-semibold text-slate-800">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Ongkos Kirim</span>
                        <span class="font-semibold text-emerald-700">GRATIS</span>
                    </div>
                </div>
                <div class="border-t border-slate-100 pt-3 flex justify-between items-baseline">
                    <span class="font-bold text-slate-900">Total Transfer</span>
                    <span class="text-xl font-extrabold text-emerald-800">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>

                <div class="bg-slate-50 rounded-xl p-3 text-xs text-slate-500 flex items-start gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                    <span>Verifikasi diproses langsung oleh Admin Perkebunan dalam waktu maksimal 1x24 jam.</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewUpload(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
                document.getElementById('upload-label').innerText = file.name;
            }
            reader.readAsDataURL(file);
        }
    }

    // Anti-spam protection
    const paymentForm = document.getElementById('payment-upload-form');
    const submitBtn = document.getElementById('btn-submit-payment');
    if (paymentForm && submitBtn) {
        paymentForm.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            submitBtn.innerHTML = '<span>Mengunggah Bukti Pembayaran...</span>';
        });
    }
</script>
@endpush
@endsection
