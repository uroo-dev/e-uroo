@extends('Public.layout.app')

@section('title', $product->name . ' - E-UROO')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 lg:py-10">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-emerald-700">Beranda</a>
        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
        <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="hover:text-emerald-700">{{ $product->category->name ?? 'Pertanian' }}</a>
        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
        <span class="font-semibold text-slate-800 truncate">{{ $product->name }}</span>
    </nav>

    <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
        <!-- Galeri Produk -->
        <div>
            @php
                $mainImg = $product->main_image ? asset('storage/' . $product->main_image) : 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&q=80&auto=format&fit=crop';
            @endphp
            <img id="gallery-main" src="{{ $mainImg }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover rounded-2xl border border-slate-200 bg-white">

            @if($product->images->isNotEmpty())
                <div class="grid grid-cols-4 gap-3 mt-3">
                    <button type="button" onclick="document.getElementById('gallery-main').src='{{ $mainImg }}'" class="ring-2 ring-emerald-600 rounded-xl overflow-hidden">
                        <img src="{{ $mainImg }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover">
                    </button>
                    @foreach($product->images as $img)
                        <button type="button" onclick="document.getElementById('gallery-main').src='{{ asset('storage/' . $img->image) }}'" class="rounded-xl overflow-hidden border border-slate-200 hover:border-emerald-400 transition">
                            <img src="{{ asset('storage/' . $img->image) }}" alt="Preview" class="w-full aspect-square object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Info Produk -->
        <div>
            <p class="text-sm font-semibold text-emerald-700">{{ $product->category->name ?? 'Hasil Pertanian & Perkebunan PT' }}</p>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 mt-1.5 tracking-tight">{{ $product->name }}</h1>
            <p class="text-xs text-slate-400 mt-1">Kode SKU: {{ $product->sku }} | Berat: {{ $product->weight }} kg</p>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 mt-5">
                <div class="flex items-baseline gap-3">
                    <span class="text-3xl font-extrabold text-emerald-800">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                </div>

                <!-- Form Tambah ke Keranjang / Checkout Langsung -->
                <form action="{{ route('cart.store') }}" method="POST" class="mt-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="flex flex-wrap items-end gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Beli</label>
                            <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden w-36">
                                <button type="button" onclick="let el=document.getElementById('qty-input'); if(parseInt(el.value)>1) el.value=parseInt(el.value)-1;" class="px-3.5 py-2.5 text-slate-500 hover:bg-slate-50 transition" aria-label="Kurangi"><i data-lucide="minus" class="w-4 h-4"></i></button>
                                <input id="qty-input" type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-full text-center text-sm font-bold text-slate-800 focus:outline-none">
                                <button type="button" onclick="let el=document.getElementById('qty-input'); if(parseInt(el.value)<{{ $product->stock }}) el.value=parseInt(el.value)+1;" class="px-3.5 py-2.5 text-slate-500 hover:bg-slate-50 transition" aria-label="Tambah"><i data-lucide="plus" class="w-4 h-4"></i></button>
                            </div>
                        </div>
                        <p class="text-sm text-slate-500 pb-2">Stok tersedia: <span class="font-bold text-emerald-700">{{ $product->stock }} unit</span></p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 mt-6">
                        @if($product->stock > 0)
                            <button type="submit" class="flex-1 bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3.5 rounded-xl text-sm transition shadow-md shadow-emerald-700/20 flex items-center justify-center gap-2">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i> Tambah ke Keranjang
                            </button>
                        @else
                            <button type="button" disabled class="flex-1 bg-slate-300 text-slate-500 font-bold py-3.5 rounded-xl text-sm cursor-not-allowed flex items-center justify-center gap-2">
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Jaminan Layanan Kebun -->
            <div class="grid sm:grid-cols-3 gap-3 mt-5">
                <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-start gap-3">
                    <i data-lucide="package-check" class="w-5 h-5 text-emerald-700 shrink-0 mt-0.5"></i>
                    <div><p class="text-xs font-bold text-slate-800">Panen Segar</p><p class="text-xs text-slate-500 mt-0.5">Langsung dari lahan</p></div>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-start gap-3">
                    <i data-lucide="truck" class="w-5 h-5 text-emerald-700 shrink-0 mt-0.5"></i>
                    <div><p class="text-xs font-bold text-slate-800">Bisa COD</p><p class="text-xs text-slate-500 mt-0.5">Bayar di tempat</p></div>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-start gap-3">
                    <i data-lucide="shield-check" class="w-5 h-5 text-emerald-700 shrink-0 mt-0.5"></i>
                    <div><p class="text-xs font-bold text-slate-800">Jaminan Mutu</p><p class="text-xs text-slate-500 mt-0.5">Kualitas terjaga</p></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi Produk -->
    <div class="mt-10 lg:mt-14 bg-white border border-slate-200 rounded-2xl p-6">
        <h3 class="font-bold text-slate-900 text-lg mb-4">Deskripsi Komoditas</h3>
        <div class="text-sm text-slate-600 leading-relaxed space-y-3">
            {!! nl2br(e($product->description)) !!}
        </div>
    </div>

    <!-- Produk Terkait -->
    @if($relatedProducts->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Produk Terkait Lainnya</h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($relatedProducts as $related)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-3.5 flex flex-col justify-between">
                        <a href="{{ route('products.show', $related->slug) }}">
                            @if($related->main_image)
                                <img src="{{ asset('storage/' . $related->main_image) }}" alt="{{ $related->name }}" class="w-full aspect-square object-cover rounded-xl mb-3">
                            @else
                                <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=500&q=80&auto=format&fit=crop" alt="{{ $related->name }}" class="w-full aspect-square object-cover rounded-xl mb-3">
                            @endif
                            <p class="font-semibold text-sm text-slate-800 line-clamp-1 hover:text-emerald-700">{{ $related->name }}</p>
                            <p class="font-extrabold text-emerald-800 text-sm mt-1">Rp{{ number_format($related->price, 0, ',', '.') }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
