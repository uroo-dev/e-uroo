@extends('Public.layout.app')

@section('title', 'Profil & Alamat Pengiriman - E-UROO')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 lg:py-10">
    <h1 class="text-2xl font-extrabold text-slate-900 mb-6 tracking-tight">Profil & Pengaturan Akun</h1>

    @include('Admin.partials.alert')

    <div class="grid lg:grid-cols-4 gap-6">
        <!-- Sidebar Menu Akun -->
        <aside class="lg:col-span-1">
            <div class="bg-white border border-slate-200 rounded-2xl p-4">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold text-sm text-slate-900 truncate">{{ $user->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                    </div>
                </div>
                <nav class="mt-3 space-y-1 text-sm font-medium">
                    <button type="button" onclick="switchProfileTab('ptab-alamat')" id="tab-btn-alamat" class="ptab w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-50 text-emerald-800 font-semibold text-left">
                        <i data-lucide="map-pin" class="w-4 h-4"></i> Alamat Pengiriman
                    </button>
                    <button type="button" onclick="switchProfileTab('ptab-data')" id="tab-btn-data" class="ptab w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 text-left transition">
                        <i data-lucide="user" class="w-4 h-4"></i> Data Diri & Akun
                    </button>
                    <a href="{{ route('orders.index') }}" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 text-left transition">
                        <i data-lucide="package" class="w-4 h-4"></i> Riwayat Pesanan
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Konten Panel -->
        <div class="lg:col-span-3 space-y-6">

            <!-- Tab 1: Alamat Pengiriman (Wajib Diisi untuk Checkout) -->
            <div id="ptab-alamat" class="ptab-panel bg-white border border-slate-200 rounded-2xl p-5 sm:p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="font-bold text-slate-900 text-lg">Alamat Pengiriman</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Wajib dilengkapi sebelum Anda dapat melakukan checkout pesanan hasil panen.</p>
                    </div>
                    <button type="button" onclick="document.getElementById('modal-add-address').classList.remove('hidden')" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-3.5 py-2 rounded-xl flex items-center gap-1.5 transition">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Alamat
                    </button>
                </div>

                @if($user->addresses->isEmpty())
                    <div class="border-2 border-dashed border-amber-300 bg-amber-50/50 rounded-2xl p-6 text-center">
                        <i data-lucide="map-pin-off" class="w-10 h-10 text-amber-500 mx-auto mb-2"></i>
                        <h3 class="font-bold text-slate-800 text-sm">Belum Ada Alamat Pengiriman</h3>
                        <p class="text-xs text-slate-600 mt-1 max-w-md mx-auto">
                            Sebelum melakukan pemesanan (COD atau Transfer), Anda wajib memasukkan alamat pengiriman yang valid.
                        </p>
                        <button type="button" onclick="document.getElementById('modal-add-address').classList.remove('hidden')" class="mt-4 px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold transition">
                            Tambah Alamat Sekarang
                        </button>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($user->addresses as $addr)
                            <div class="border {{ $addr->is_default ? 'border-2 border-emerald-700 bg-emerald-50/30' : 'border-slate-200 bg-white' }} rounded-xl p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <p class="font-bold text-sm text-slate-900">{{ $addr->recipient_name }}</p>
                                        <span class="text-xs text-slate-500">({{ $addr->phone }})</span>
                                        @if($addr->is_default)
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">UTAMA</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <form action="{{ route('profile.address.destroy', $addr->id) }}" method="POST" onsubmit="return confirm('Hapus alamat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                                <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                                    {{ $addr->full_address }}, {{ $addr->district }}, {{ $addr->city }}, {{ $addr->province }} {{ $addr->postal_code }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Tab 2: Data Diri -->
            <div id="ptab-data" class="ptab-panel hidden bg-white border border-slate-200 rounded-2xl p-5 sm:p-6">
                <h2 class="font-bold text-slate-900 text-lg mb-5">Data Diri & Akun</h2>
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                            <input type="email" value="{{ $user->email }}" disabled class="w-full bg-slate-100 text-slate-500 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor Telepon (WhatsApp)</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-5 mt-5">
                        <h3 class="font-bold text-sm text-slate-900 mb-3">Ubah Kata Sandi (Opsional)</h3>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Kata Sandi Baru</label>
                                <input type="password" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah Alamat -->
<div id="modal-add-address" class="hidden fixed inset-0 z-[80] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60" onclick="document.getElementById('modal-add-address').classList.add('hidden')"></div>
    <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg text-slate-900">Tambah Alamat Pengiriman</h3>
            <button type="button" onclick="document.getElementById('modal-add-address').classList.add('hidden')" class="p-1 rounded-lg text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('profile.address.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Penerima</label>
                <input type="text" name="recipient_name" value="{{ old('recipient_name', $user->name) }}" required placeholder="Contoh: Rina Sulastri" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor Telepon</label>
                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" required placeholder="Contoh: 081234567890" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Provinsi</label>
                    <input type="text" name="province" required placeholder="Jawa Barat" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kota / Kabupaten</label>
                    <input type="text" name="city" required placeholder="Kota Bandung" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kecamatan</label>
                    <input type="text" name="district" required placeholder="Coblong" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kode Pos</label>
                    <input type="text" name="postal_code" required placeholder="40132" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap (Jalan, RT/RW, No. Rumah)</label>
                <textarea name="full_address" rows="3" required placeholder="Jl. Raya Perkebunan No. 10..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>
            <label class="flex items-center gap-2 cursor-pointer text-sm text-slate-600">
                <input type="checkbox" name="is_default" value="1" class="w-4 h-4 rounded text-emerald-600">
                Jadikan sebagai alamat utama
            </label>
            <div class="flex justify-end gap-2 pt-3">
                <button type="button" onclick="document.getElementById('modal-add-address').classList.add('hidden')" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold">Batal</button>
                <button type="submit" class="px-5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-sm font-bold">Simpan Alamat</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function switchProfileTab(tabId) {
        document.querySelectorAll('.ptab-panel').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.ptab').forEach(el => {
            el.classList.remove('bg-emerald-50', 'text-emerald-800', 'font-semibold');
            el.classList.add('text-slate-600');
        });
        const target = document.getElementById(tabId);
        if (target) target.classList.remove('hidden');

        const btn = tabId === 'ptab-alamat' ? document.getElementById('tab-btn-alamat') : document.getElementById('tab-btn-data');
        if (btn) {
            btn.classList.add('bg-emerald-50', 'text-emerald-800', 'font-semibold');
            btn.classList.remove('text-slate-600');
        }
    }
</script>
@endpush
@endsection
