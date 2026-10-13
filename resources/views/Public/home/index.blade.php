@extends('Public.layout.app')

@section('title', 'E-UROO - Panen Segar Perkebunan PT Langsung ke Meja Anda')

@section('content')
@php
    $heroImage = setting('hero_image')
        ? asset('storage/' . setting('hero_image'))
        : asset('template/assets/image/hero.jpeg');
@endphp
<!-- HERO SECTION - Natural, Clean, High-Converting Agricultural Store Banner -->
<section id="hero" class="relative min-h-[85vh] py-20 flex items-center bg-cover bg-center overflow-hidden" style="background-image: url('{{ $heroImage }}');">

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <!-- Left Hero Copy & Search Bar -->
            <div class="lg:col-span-8 space-y-6" data-aos="fade-right">

                <!-- Trust Tag -->
                <div class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-white/55 border border-brand-300 text-brand-900 text-xs sm:text-sm font-bold tracking-wide shadow-sm backdrop-blur-md">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-brand-600"></i>
                    <span>{{ setting('hero_badge', 'Langsung dari Lahan Perkebunan PT • Bebas Pestisida Berbahaya') }}</span>
                </div>

                <!-- Big Headline -->
                <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight leading-[1.08] text-brand-900">
                    {{ setting('hero_title', 'Panen Segar Perkebunan Langsung ke') }}
                    <span class="text-brand-600 block mt-1">{{ setting('hero_title_highlight', 'Meja Anda') }}</span>
                </h1>

                <!-- Subheadline -->
                <div class="max-w-2xl bg-white/35 backdrop-blur-sm p-4 rounded-2xl border border-white/90 shadow-sm">
                    <p class="text-brand-950 text-base sm:text-lg leading-relaxed font-semibold">
                        {{ setting('hero_subtitle', 'Dipetik harian langsung dari kebun & perkebunan kami. Nikmati aneka komoditas unggulan: Kopi Spesialti, Kelapa Sawit olahan, Beras Merah Organik, Sayuran Higienis, dan Buah Segar Nusantara.') }}
                    </p>
                </div>

                <!-- Hero E-Commerce Quick Search -->
                <div class="pt-2 max-w-xl">
                    <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 bg-white p-2 rounded-2xl shadow-xl border border-brand-200">
                        <div class="flex-1 flex items-center px-3 space-x-2">
                            <i data-lucide="search" class="w-5 h-5 text-brand-600 shrink-0"></i>
                            <input type="text" name="search" placeholder="Cari hasil panen, beras, kopi, sayur segar..." class="w-full bg-transparent text-brand-dark placeholder-gray-500 text-sm focus:outline-none py-2 font-medium">
                        </div>
                        <button type="submit" class="bg-earth-terracotta hover:bg-earth-rust text-white px-6 py-3 rounded-xl font-bold text-sm transition-all shadow-md flex items-center justify-center space-x-1 shrink-0">
                            <span>Cari Hasil Panen</span>
                        </button>
                    </form>
                </div>

                <!-- Action Buttons & Quick Stats -->
                <div class="flex flex-wrap items-center gap-4 sm:gap-6 pt-2">
                    <a href="{{ setting('hero_cta_link', '#products') }}" class="px-8 py-4 rounded-full bg-brand-700 hover:bg-brand-800 text-white font-bold text-base transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        <span>{{ setting('hero_cta_text', 'Belanja Hasil Panen') }}</span>
                    </a>
                    <a href="{{ setting('hero_secondary_link', '#subscription') }}" class="px-8 py-4 rounded-full bg-white hover:bg-brand-50 text-brand-900 border-2 border-brand-700 font-bold text-base shadow-md transition-all flex items-center space-x-2">
                        <i data-lucide="box" class="w-5 h-5 text-brand-600"></i>
                        <span>{{ setting('hero_secondary_text', 'Paket Panen Mingguan') }}</span>
                    </a>
                </div>

                <!-- Quick Badges -->
                <div class="pt-4 flex flex-wrap items-center gap-3 sm:gap-4 text-xs font-bold text-brand-900">
                    <span class="flex items-center space-x-2 bg-white/55 backdrop-blur-md px-3.5 py-2 rounded-full border border-brand-200 shadow-sm">
                        <i data-lucide="clock" class="w-4 h-4 text-brand-600"></i>
                        <span>Dipetik Segar Hari Ini</span>
                    </span>
                    <span class="flex items-center space-x-2 bg-white/55 backdrop-blur-md px-3.5 py-2 rounded-full border border-brand-200 shadow-sm">
                        <i data-lucide="truck" class="w-4 h-4 text-brand-600"></i>
                        <span>Pengiriman Cepat Cold Chain</span>
                    </span>
                    <span class="flex items-center space-x-2 bg-white/55 backdrop-blur-md px-3.5 py-2 rounded-full border border-brand-200 shadow-sm">
                        <i data-lucide="rotate-ccw" class="w-4 h-4 text-brand-600"></i>
                        <span>Garansi 100% Kesegaran Mutu</span>
                    </span>
                </div>

            </div>

        </div>
    </div>

    <!-- Bottom Organic Paper-Torn Divider (Wavy Transition) -->
    <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-none z-20">
        <svg class="relative block w-full h-12 sm:h-20 text-earth-cream" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 C150,90 350,-40 500,60 C650,160 900,10 1200,40 L1200,120 L0,120 Z" fill="currentColor"></path>
        </svg>
    </div>
</section>

<!-- PRODUCT CATEGORIES GRID SECTION -->
<section id="categories" class="py-16 bg-earth-cream relative z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12" data-aos="fade-up">
            <div>
                <span class="text-earth-terracotta font-bold text-xs uppercase tracking-widest">Pilihan Hasil Panen Segar</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-brand-900 mt-1">Jelajahi Kategori Komoditas</h2>
            </div>
            <a href="{{ route('products.index') }}" class="mt-4 md:mt-0 font-bold text-sm text-brand-600 hover:text-brand-800 flex items-center space-x-1">
                <span>Lihat Semua Kategori</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <!-- Categories Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
            @forelse($categories as $index => $category)
                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="group bg-white p-5 rounded-3xl shadow-sm hover:shadow-organic border border-brand-100 text-center transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="{{ (($index % 5) + 1) * 75 }}">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-2xl overflow-hidden bg-brand-50 p-1 flex items-center justify-center">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition-transform">
                        @else
                            <div class="w-full h-full rounded-xl bg-brand-100/60 flex items-center justify-center text-brand-700">
                                <i data-lucide="sprout" class="w-8 h-8"></i>
                            </div>
                        @endif
                    </div>
                    <h3 class="font-display font-bold text-brand-900 text-base group-hover:text-brand-600 transition-colors line-clamp-1">{{ $category->name }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $category->products_count }} Komoditas</p>
                </a>
            @empty
                <div class="col-span-full py-12 text-center text-gray-400 text-sm bg-white rounded-3xl border border-brand-100">
                    Belum ada kategori hasil perkebunan aktif.
                </div>
            @endforelse
        </div>

    </div>
</section>

<!-- FEATURED PRODUCTS GRID -->
<section id="products" class="py-16 bg-brand-50 relative z-20 border-t border-brand-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12" data-aos="fade-up">
            <div>
                <span class="text-earth-terracotta font-bold text-xs uppercase tracking-widest">Panen Unggulan Terbaik</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-brand-900 mt-1">Produk Unggulan Perkebunan</h2>
            </div>
            <a href="{{ route('products.index') }}" class="mt-4 md:mt-0 font-bold text-sm text-brand-600 hover:text-brand-800 flex items-center space-x-1">
                <span>Lihat Katalog Lengkap</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredProducts as $index => $product)
                <div class="bg-white rounded-3xl p-4 border border-brand-100 shadow-sm hover:shadow-organic transition-all duration-300 flex flex-col justify-between group" data-aos="fade-up" data-aos-delay="{{ (($index % 4) + 1) * 100 }}">
                    <div>
                        <!-- Image Container -->
                        <div class="relative overflow-hidden rounded-2xl h-52 mb-4 bg-gray-100">
                            <span class="absolute top-3 left-3 bg-brand-700 text-white text-[10px] font-bold px-2.5 py-1 rounded-full z-10 shadow-sm">PANEN SEGAR</span>

                            <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=500" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @endif
                            </a>
                        </div>

                        <!-- Product Info -->
                        <div class="flex items-center space-x-1 text-amber-500 text-xs mb-1">
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <span class="text-gray-400 text-[11px] ml-1">({{ rand(25, 95) }})</span>
                        </div>

                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            <h3 class="font-display font-bold text-lg text-brand-900 group-hover:text-brand-600 transition-colors line-clamp-1">{{ $product->name }}</h3>
                        </a>
                        <p class="text-xs text-gray-500 mb-3">{{ $product->category->name ?? 'Perkebunan PT' }} • Stok {{ $product->stock }}</p>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div>
                            <div class="font-display font-bold text-xl text-earth-terracotta">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>

                        <form action="{{ route('cart.store') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white p-3 rounded-2xl transition-all shadow-md active:scale-95 flex items-center space-x-1" title="Tambah ke Keranjang">
                                <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                <span class="text-xs font-bold px-1">Tambah</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-gray-400 text-sm bg-white rounded-3xl border border-brand-100">
                    Belum ada produk panen unggulan yang tersedia saat ini.
                </div>
            @endforelse
        </div>

    </div>
</section>

<!-- HARVEST BOX SUBSCRIPTION BANNER -->
<section id="subscription" class="py-20 bg-brand-900 text-white relative overflow-hidden">
    <!-- Organic Wavy Divider Top -->
    <div class="absolute top-0 left-0 right-0 w-full overflow-hidden leading-none z-10 transform rotate-180">
        <svg class="relative block w-full h-8 sm:h-12 text-brand-50" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 C150,90 350,-40 500,60 C650,160 900,10 1200,40 L1200,120 L0,120 Z" fill="currentColor"></path>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <div class="lg:col-span-7 space-y-6" data-aos="fade-right">
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-brand-800 text-brand-200 text-xs font-bold uppercase tracking-wider border border-brand-700">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-brand-400"></i>
                    <span>Paket Panen Rutin PT Perkebunan</span>
                </span>

                <h2 class="font-display text-3xl sm:text-5xl font-bold tracking-tight text-earth-sand leading-tight">
                    Langganan Paket Panen Segar Mingguan Bebas Ribet
                </h2>

                <p class="text-brand-100/90 text-sm sm:text-base leading-relaxed">
                    Dapatkan kurasi hasil kebun terbaik setiap minggu: kombinasi sayuran segar, buah tropis matang di pohon, kopi Nusantara, dan beras organik langsung ke alamat Anda dengan opsi pembayaran fleksibel (COD atau QRIS).
                </p>

                <div class="space-y-3 pt-2">
                    <div class="flex items-center space-x-3 text-xs sm:text-sm text-brand-100">
                        <i data-lucide="check" class="w-5 h-5 text-brand-400 shrink-0"></i>
                        <span>100% Dipetik Pada Hari Pengiriman Berpendingin</span>
                    </div>
                    <div class="flex items-center space-x-3 text-xs sm:text-sm text-brand-100">
                        <i data-lucide="check" class="w-5 h-5 text-brand-400 shrink-0"></i>
                        <span>Bebas Menyesuaikan Komposisi Komoditas Panen Tiap Minggu</span>
                    </div>
                    <div class="flex items-center space-x-3 text-xs sm:text-sm text-brand-100">
                        <i data-lucide="check" class="w-5 h-5 text-brand-400 shrink-0"></i>
                        <span>Gratis Ongkir Khusus Pelanggan Paket Berlangganan</span>
                    </div>
                </div>

                <div class="pt-4 flex items-center space-x-4">
                    <a href="{{ route('products.index') }}" class="px-8 py-4 rounded-full bg-earth-terracotta hover:bg-earth-rust text-white font-bold text-sm transition-all shadow-lg flex items-center space-x-2">
                        <span>Pesan Hasil Panen Sekarang</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5 relative" data-aos="zoom-in">
                <div class="relative rounded-3xl overflow-hidden border-4 border-brand-500/30 shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=800" alt="Kotak Panen Segar PT" class="w-full h-80 object-cover">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- MEET OUR PLANTERS & AGRONOMISTS -->
<section id="farmers" class="py-20 bg-earth-cream relative z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
            <span class="text-earth-terracotta font-bold text-xs uppercase tracking-widest">Dedikasi Pertanian Nusantara</span>
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-brand-900 mt-1">Kenali Tim Petani & Agronomis Kebun PT</h2>
            <p class="text-gray-600 text-sm mt-2">Setiap komoditas dirawat dengan penuh dedikasi oleh tenaga ahli pertanian dan komunitas petani mitra PT.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Planter Card 1 -->
            <div class="bg-white p-5 rounded-3xl border border-brand-100 shadow-sm text-center group" data-aos="fade-up" data-aos-delay="100">
                <div class="overflow-hidden rounded-2xl mb-4 h-60">
                    <img src="https://images.unsplash.com/photo-1595974482597-4b8da8879bc5?auto=format&fit=crop&q=80&w=500" alt="Pak David Miller" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-earth-terracotta bg-earth-sand/50 px-3 py-1 rounded-full">Kebun Kopi Dataran Tinggi</span>
                <h3 class="font-display font-bold text-xl text-brand-900 mt-2">David Suryanto</h3>
                <p class="text-gray-500 text-xs mt-1">Kepala Kebun Kopi • 15 Thn Pengalaman</p>
            </div>

            <!-- Planter Card 2 -->
            <div class="bg-white p-5 rounded-3xl border border-brand-100 shadow-sm text-center group" data-aos="fade-up" data-aos-delay="200">
                <div class="overflow-hidden rounded-2xl mb-4 h-60">
                    <img src="https://images.unsplash.com/photo-1592417817098-8f3d6eb16432?auto=format&fit=crop&q=80&w=500" alt="Ibu Elena Rostova" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-earth-terracotta bg-earth-sand/50 px-3 py-1 rounded-full">Lahan Hortikultura</span>
                <h3 class="font-display font-bold text-xl text-brand-900 mt-2">Ir. Elena Rostova</h3>
                <p class="text-gray-500 text-xs mt-1">Agronomis Tanah & Panen Organik</p>
            </div>

            <!-- Planter Card 3 -->
            <div class="bg-white p-5 rounded-3xl border border-brand-100 shadow-sm text-center group" data-aos="fade-up" data-aos-delay="300">
                <div class="overflow-hidden rounded-2xl mb-4 h-60">
                    <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&q=80&w=500" alt="Pak Robert Chen" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-earth-terracotta bg-earth-sand/50 px-3 py-1 rounded-full">Estate Kelapa Sawit & Palawija</span>
                <h3 class="font-display font-bold text-xl text-brand-900 mt-2">Robert Chen</h3>
                <p class="text-gray-500 text-xs mt-1">Master Roaster & Pengawas Pascapanen</p>
            </div>

            <!-- Planter Card 4 -->
            <div class="bg-white p-5 rounded-3xl border border-brand-100 shadow-sm text-center group" data-aos="fade-up" data-aos-delay="400">
                <div class="overflow-hidden rounded-2xl mb-4 h-60">
                    <img src="https://images.unsplash.com/photo-1589923188900-85dae523342b?auto=format&fit=crop&q=80&w=500" alt="Pak Arthur Pendelton" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-earth-terracotta bg-earth-sand/50 px-3 py-1 rounded-full">Lahan Padi & Beras Organik</span>
                <h3 class="font-display font-bold text-xl text-brand-900 mt-2">Arthur Gunawan</h3>
                <p class="text-gray-500 text-xs mt-1">Pakar Budidaya Padi Organik</p>
            </div>

        </div>
    </div>
</section>

<!-- VALUE PROPOSITION / STORE BENEFITS -->
<section id="keunggulan" class="py-12 bg-brand-100/60 border-y border-brand-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="flex items-center space-x-4 bg-white p-6 rounded-2xl border border-brand-200/50 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-brand-500 text-white flex items-center justify-center shrink-0">
                    <i data-lucide="truck" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-brand-900 text-sm">Pengiriman Ekspres Suhu Terjaga</h4>
                    <p class="text-xs text-gray-600 mt-0.5">Dikemas rapi dalam kemasan berpendingin higienis.</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 bg-white p-6 rounded-2xl border border-brand-200/50 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-brand-500 text-white flex items-center justify-center shrink-0">
                    <i data-lucide="award" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-brand-900 text-sm">100% Panen Alami Tersertifikasi</h4>
                    <p class="text-xs text-gray-600 mt-0.5">Bebas bahan pengawet & residu kimia berbahaya.</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 bg-white p-6 rounded-2xl border border-brand-200/50 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-brand-500 text-white flex items-center justify-center shrink-0">
                    <i data-lucide="refresh-cw" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-brand-900 text-sm">Garansi Mutu & Pembayaran Fleksibel</h4>
                    <p class="text-xs text-gray-600 mt-0.5">Mendukung COD di tempat & transfer QRIS resmi.</p>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
