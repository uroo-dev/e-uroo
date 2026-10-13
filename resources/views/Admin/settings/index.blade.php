@extends('Admin.layout.app')

@section('title', 'Pengaturan Website & Tampilan')

@section('content')
<section class="max-w-6xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Pengaturan Website & Tampilan</h1>
            <p class="text-sm text-slate-500 mt-1">
                Sesuaikan nama website, logo, banner hero section, kata-kata di footer, kontak, dan tautan sosial media.
            </p>
        </div>
        <div>
            <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-sm font-semibold transition">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> Pratinjau Website
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between gap-3 text-sm font-medium">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm font-medium">
            <p class="font-bold mb-1">Terjadi kesalahan validasi:</p>
            <ul class="list-disc list-inside space-y-0.5 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Tab Controls -->
        <div class="flex items-center gap-2 border-b border-slate-200 pb-2 overflow-x-auto">
            <button type="button" onclick="switchTab('tab-general')" id="btn-tab-general"
                class="tab-btn px-4 py-2.5 rounded-xl text-sm font-bold transition flex items-center gap-2 bg-emerald-700 text-white shadow-sm">
                <i class="fa-solid fa-globe text-sm"></i> Identitas & Brand
            </button>
            <button type="button" onclick="switchTab('tab-hero')" id="btn-tab-hero"
                class="tab-btn px-4 py-2.5 rounded-xl text-sm font-bold transition flex items-center gap-2 bg-white text-slate-600 hover:bg-slate-100 border border-slate-200">
                <i class="fa-solid fa-image text-sm"></i> Hero Section
            </button>
            <button type="button" onclick="switchTab('tab-footer')" id="btn-tab-footer"
                class="tab-btn px-4 py-2.5 rounded-xl text-sm font-bold transition flex items-center gap-2 bg-white text-slate-600 hover:bg-slate-100 border border-slate-200">
                <i class="fa-solid fa-shoe-prints text-sm"></i> Footer & Medsos
            </button>
        </div>

        <!-- ==================== TAB 1: IDENTITAS & BRAND ==================== -->
        <div id="tab-general" class="tab-pane bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Identitas Toko & Logo</h2>
                <p class="text-xs text-slate-500 mt-0.5">Atur nama merek, logo gambar, nomor kontak, dan pengumuman di bilah atas.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Web -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Website / Toko <span class="text-red-500">*</span></label>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'E-UROO PERKEBUNAN') }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Tagline -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tagline / Nama Perusahaan PT</label>
                    <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? 'PT Agro Nusantara') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Telepon / CS</label>
                    <input type="text" name="site_phone" value="{{ old('site_phone', $settings['site_phone'] ?? '(0812) 3456-7890') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Layanan</label>
                    <input type="email" name="site_email" value="{{ old('site_email', $settings['site_email'] ?? 'kontak@e-uroo.id') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Pengumuman Teks -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pengumuman Top Bar (Kiri)</label>
                    <input type="text" name="announcement_text" value="{{ old('announcement_text', $settings['announcement_text'] ?? 'Gratis Ongkir Pembelian di Atas Rp150.000!') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Pengumuman Sub-teks -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jaminan Top Bar (Tengah)</label>
                    <input type="text" name="announcement_subtext" value="{{ old('announcement_subtext', $settings['announcement_subtext'] ?? '100% Panen Kebun PT Tersertifikasi Organik') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="border-t border-slate-100 pt-6">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Logo Website (Opsional)</label>
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <div class="w-24 h-24 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden shrink-0">
                        @if (!empty($settings['site_logo']))
                            <img id="preview-logo" src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" class="w-full h-full object-contain p-2">
                        @else
                            <img id="preview-logo" src="" alt="Preview Logo" class="hidden w-full h-full object-contain p-2">
                            <span id="placeholder-logo" class="text-slate-400 text-xs font-semibold text-center p-2">Belum ada logo kustom</span>
                        @endif
                    </div>
                    <div class="flex-1 w-full space-y-2">
                        <input type="file" name="site_logo" id="input-logo" accept="image/*" onchange="previewImage(this, 'preview-logo', 'placeholder-logo')"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        <p class="text-[11px] text-slate-400">Format: PNG, JPG, WEBP, atau SVG transparan. Maks 2MB. Jika kosong, logo default icon tunas akan dipakai.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== TAB 2: HERO SECTION ==================== -->
        <div id="tab-hero" class="tab-pane hidden bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Hero Section (Banner Utama Halaman Depan)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kustomisasi judul besar, subjudul, tombol CTA, serta background gambar pada hero section.</p>
            </div>

            <div class="space-y-4">
                <!-- Badge Tagline -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tagline Badge Kecil di Atas Judul</label>
                    <input type="text" name="hero_badge" value="{{ old('hero_badge', $settings['hero_badge'] ?? 'Langsung dari Lahan Perkebunan PT • Bebas Pestisida Berbahaya') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Judul Hero Utama -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Hero (Baris Pertama)</label>
                        <input type="text" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? 'Panen Segar Perkebunan Langsung ke') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <!-- Judul Highlight -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Teks Hijau Terang (Highlight)</label>
                        <input type="text" name="hero_title_highlight" value="{{ old('hero_title_highlight', $settings['hero_title_highlight'] ?? 'Meja Anda') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <!-- Subtitle / Deskripsi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi / Subjudul Hero</label>
                    <textarea name="hero_subtitle" rows="3"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? 'Dipetik harian langsung dari kebun & perkebunan kami. Nikmati aneka komoditas unggulan: Kopi Spesialti, Kelapa Sawit olahan, Beras Merah Organik, Sayuran Higienis, dan Buah Segar Nusantara.') }}</textarea>
                </div>

                <!-- CTA Buttons -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 border-t border-slate-100 pt-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tombol 1 Teks</label>
                        <input type="text" name="hero_cta_text" value="{{ old('hero_cta_text', $settings['hero_cta_text'] ?? 'Belanja Hasil Panen') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tombol 1 Link / Target</label>
                        <input type="text" name="hero_cta_link" value="{{ old('hero_cta_link', $settings['hero_cta_link'] ?? '#products') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tombol 2 Teks</label>
                        <input type="text" name="hero_secondary_text" value="{{ old('hero_secondary_text', $settings['hero_secondary_text'] ?? 'Paket Panen Mingguan') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tombol 2 Link / Target</label>
                        <input type="text" name="hero_secondary_link" value="{{ old('hero_secondary_link', $settings['hero_secondary_link'] ?? '#subscription') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <!-- Background Image Upload -->
                <div class="border-t border-slate-100 pt-6">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Gambar Latar Hero (Background Image)</label>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <div class="w-48 h-28 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden shrink-0 relative">
                            @if (!empty($settings['hero_image']))
                                <img id="preview-hero" src="{{ asset('storage/' . $settings['hero_image']) }}" alt="Hero Background" class="w-full h-full object-cover">
                            @else
                                <img id="preview-hero" src="{{ asset('template/assets/image/hero.jpeg') }}" alt="Hero Background Default" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1 w-full space-y-2">
                            <input type="file" name="hero_image" id="input-hero" accept="image/*" onchange="previewImage(this, 'preview-hero', null)"
                                class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                            <p class="text-[11px] text-slate-400">Resolusi yang disarankan: 1920x1080 piksel (JPG/WEBP). Maks 5MB. Jika tidak diunggah, gambar default kebun akan dipakai.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== TAB 3: FOOTER & MEDSOS ==================== -->
        <div id="tab-footer" class="tab-pane hidden bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Footer, Tautan & Media Sosial</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola kata-kata penjelasan di footer, hak cipta, link media sosial, dan tautan informasi.</p>
            </div>

            <div class="space-y-5">
                <!-- Kata-kata Footer -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi / Kata-kata Singkat di Footer</label>
                    <textarea name="footer_about" rows="3"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('footer_about', $settings['footer_about'] ?? 'Platform e-commerce resmi penyedia komoditas pertanian dan perkebunan berkualitas tinggi langsung dari lahan PT. Kami menjamin panen segar harian, bebas bahan berbahaya, dengan harga adil dari produsen utama.') }}</textarea>
                </div>

                <!-- Copyright -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Hak Cipta / Copyright</label>
                    <input type="text" name="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '© 2026 PT E-UROO AGRO NUSANTARA. Seluruh hak cipta dilindungi.') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Media Sosial -->
                <div class="border-t border-slate-100 pt-5">
                    <h3 class="text-sm font-bold text-slate-900 mb-4">Tautan Media Sosial</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-brands fa-facebook text-blue-600"></i> Facebook URL
                            </label>
                            <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? 'https://facebook.com') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-brands fa-instagram text-pink-600"></i> Instagram URL
                            </label>
                            <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? 'https://instagram.com') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-brands fa-x-twitter text-slate-900"></i> Twitter / X URL
                            </label>
                            <input type="url" name="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? 'https://x.com') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-brands fa-whatsapp text-emerald-600"></i> WhatsApp / Link Kontak
                            </label>
                            <input type="text" name="social_whatsapp" value="{{ old('social_whatsapp', $settings['social_whatsapp'] ?? 'https://wa.me/6281234567890') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <!-- Tautan Footer Lainnya -->
                <div class="border-t border-slate-100 pt-5">
                    <h3 class="text-sm font-bold text-slate-900 mb-4">Link Informasi & Dokumen</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Link Syarat & Ketentuan</label>
                            <input type="text" name="footer_link_terms" value="{{ old('footer_link_terms', $settings['footer_link_terms'] ?? '#') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Link Kebijakan Privasi</label>
                            <input type="text" name="footer_link_privacy" value="{{ old('footer_link_privacy', $settings['footer_link_privacy'] ?? '#') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Link FAQ / Bantuan</label>
                            <input type="text" name="footer_link_faq" value="{{ old('footer_link_faq', $settings['footer_link_faq'] ?? '#') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Save Button -->
        <div class="sticky bottom-4 z-20 bg-white/95 backdrop-blur-md border border-slate-200 shadow-xl rounded-2xl p-4 flex items-center justify-between">
            <span class="text-xs text-slate-500 hidden sm:inline">Perubahan akan langsung diterapkan ke seluruh halaman publik.</span>
            <div class="flex items-center gap-3 ml-auto">
                <button type="reset" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-semibold transition">
                    Reset
                </button>
                <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition shadow-md shadow-emerald-700/20 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Semua Pengaturan
                </button>
            </div>
        </div>
    </form>
</section>

@push('scripts')
<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-pane').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-emerald-700', 'text-white', 'shadow-sm');
            btn.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-200');
        });

        const activePane = document.getElementById(tabId);
        if (activePane) activePane.classList.remove('hidden');

        const activeBtn = document.getElementById('btn-' + tabId);
        if (activeBtn) {
            activeBtn.classList.remove('bg-white', 'text-slate-600', 'border', 'border-slate-200');
            activeBtn.classList.add('bg-emerald-700', 'text-white', 'shadow-sm');
        }
    }

    function previewImage(input, previewId, placeholderId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(previewId);
                img.src = e.target.result;
                img.classList.remove('hidden');
                if (placeholderId) {
                    const placeholder = document.getElementById(placeholderId);
                    if (placeholder) placeholder.classList.add('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
