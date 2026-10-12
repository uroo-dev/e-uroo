@extends('Public.layout.app')

@section('title', 'E-UROO - Hasil Pertanian & Perkebunan Unggulan')

@section('content')
<!-- Hero Section -->
<div class="bg-emerald-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-12 lg:py-20 grid lg:grid-cols-2 gap-10 items-center">
        <div>
            <p class="inline-flex items-center gap-2 bg-emerald-800 text-emerald-200 text-xs font-semibold px-3 py-1.5 rounded-full mb-5">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Langsung dari Lahan Pertanian & Perkebunan PT
            </p>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight tracking-tight">
                Hasil Tani Berkualitas,<br>Segar & Terpercaya
            </h1>
            <p class="text-emerald-100/90 mt-4 max-w-md leading-relaxed">
                Menyediakan komoditas hasil perkebunan dan pertanian pilihan langsung dari sumbernya dengan jaminan kualitas terbaik dan harga terjangkau.
            </p>
            <div class="flex flex-wrap gap-3 mt-7">
                <a href="{{ route('products.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-6 py-3 rounded-xl text-sm transition shadow-lg shadow-orange-900/30 flex items-center gap-2">
                    Belanja Sekarang <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
                <a href="#kategori" class="bg-emerald-800 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition border border-emerald-700">
                    Lihat Kategori
                </a>
            </div>
        </div>
        <div class="relative hidden lg:block">
            <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=800&q=80&auto=format&fit=crop" onerror="this.onerror=null;this.src='https://picsum.photos/seed/pertanian/800/600'" alt="Kebun Pertanian" class="rounded-2xl shadow-2xl object-cover w-full aspect-[4/3]">
            <div class="absolute -bottom-5 -left-5 bg-white text-slate-800 rounded-2xl shadow-xl p-4 flex items-center gap-3">
                <span class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <i data-lucide="badge-check" class="w-5 h-5 text-emerald-600"></i>
                </span>
                <div>
                    <p class="font-bold text-sm">100% Panen Segar</p>
                    <p class="text-xs text-slate-500">Kualitas grade premium tersertifikasi</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Trust Strip -->
<div class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 py-5 grid grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
        <div class="flex items-center gap-3"><i data-lucide="truck" class="w-5 h-5 text-emerald-700"></i><div><p class="font-semibold text-slate-900">Pengiriman Cepat</p><p class="text-xs text-slate-500">Panen langsung dikirim</p></div></div>
        <div class="flex items-center gap-3"><i data-lucide="shield-check" class="w-5 h-5 text-emerald-700"></i><div><p class="font-semibold text-slate-900">Pembayaran Mudah</p><p class="text-xs text-slate-500">Transfer QRIS & COD</p></div></div>
        <div class="flex items-center gap-3"><i data-lucide="refresh-cw" class="w-5 h-5 text-emerald-700"></i><div><p class="font-semibold text-slate-900">Garansi Kualitas</p><p class="text-xs text-slate-500">Segar sampai tujuan</p></div></div>
        <div class="flex items-center gap-3"><i data-lucide="headphones" class="w-5 h-5 text-emerald-700"></i><div><p class="font-semibold text-slate-900">Pelayanan Prima</p><p class="text-xs text-slate-500">Konsultasi hasil kebun</p></div></div>
    </div>
</div>

<!-- Kategori Populer -->
<div id="kategori" class="max-w-7xl mx-auto px-4 py-12 lg:py-16">
    <div class="flex items-end justify-between mb-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Kategori Komoditas</h2>
            <p class="text-sm text-slate-500 mt-1">Pilihan hasil perkebunan dan pertanian pilihan</p>
        </div>
        <a href="{{ route('products.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
            Semua produk <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3 sm:gap-4">
        @forelse($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->id]) }}" class="group bg-white border border-slate-200 rounded-2xl p-4 text-center hover:border-emerald-300 hover:shadow-md transition">
                <span class="w-12 h-12 mx-auto rounded-xl bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition overflow-hidden">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover rounded-xl">
                    @else
                        <i data-lucide="sprout" class="w-6 h-6 text-emerald-700"></i>
                    @endif
                </span>
                <p class="text-sm font-semibold mt-3 text-slate-800 line-clamp-1">{{ $category->name }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ $category->products_count }} produk</p>
            </a>
        @empty
            <div class="col-span-full py-8 text-center text-slate-400 text-sm">
                Belum ada kategori yang terdaftar.
            </div>
        @endforelse
    </div>
</div>

<!-- Produk Unggulan -->
<div class="bg-white border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 py-12 lg:py-16">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Produk Unggulan Kebun</h2>
                <p class="text-sm text-slate-500 mt-1">Komoditas hasil panen segar siap kirim</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                Lihat semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            @forelse($featuredProducts as $product)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                    <div class="relative">
                        <a href="{{ route('products.show', $product->slug) }}">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=500&q=80&auto=format&fit=crop" alt="{{ $product->name }}" class="w-full aspect-square object-cover">
                            @endif
                        </a>
                        <span class="absolute top-3 left-3 bg-emerald-700 text-white text-[11px] font-bold px-2 py-1 rounded-lg">Panen Baru</span>
                    </div>
                    <div class="p-3.5 flex-1 flex flex-col justify-between">
                        <div>
                            <p class="text-[11px] text-slate-400 font-medium">{{ $product->category->name ?? 'Pertanian' }}</p>
                            <a href="{{ route('products.show', $product->slug) }}" class="block font-semibold text-sm text-slate-800 mt-0.5 line-clamp-1 hover:text-emerald-700">
                                {{ $product->name }}
                            </a>
                            <div class="mt-2 flex items-baseline gap-1.5">
                                <span class="font-extrabold text-emerald-800">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Stok: {{ $product->stock }}</p>
                        </div>
                        <form action="{{ route('cart.store') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-emerald-50 hover:bg-emerald-700 text-emerald-700 hover:text-white border border-emerald-200 font-semibold text-xs py-2.5 rounded-xl transition flex items-center justify-center gap-1.5">
                                <i data-lucide="shopping-cart" class="w-3.5 h-3.5"></i> Tambah Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-sm">
                    Belum ada produk hasil kebun yang tersedia.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
