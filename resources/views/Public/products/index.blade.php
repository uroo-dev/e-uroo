@extends('Public.layout.app')

@section('title', 'Katalog Hasil Pertanian & Perkebunan - E-UROO')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 lg:py-10">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-emerald-700">Beranda</a>
        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
        <span class="font-semibold text-slate-800">Semua Produk Pertanian</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
        <!-- Filter Sidebar (Desktop) -->
        <aside class="hidden lg:block w-64 shrink-0">
            <form method="GET" action="{{ route('products.index') }}" class="bg-white border border-slate-200 rounded-2xl p-5 sticky top-24 space-y-6">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <div>
                    <h3 class="font-bold text-sm text-slate-900 mb-3">Kategori Komoditas</h3>
                    <div class="space-y-2 text-sm text-slate-600">
                        <label class="flex items-center gap-2.5 cursor-pointer hover:text-emerald-700">
                            <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                            Semua Kategori
                        </label>
                        @foreach($categories as $category)
                            <label class="flex items-center gap-2.5 cursor-pointer hover:text-emerald-700">
                                <input type="radio" name="category" value="{{ $category->id }}" {{ request('category') == $category->id ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                                {{ $category->name }} ({{ $category->products_count }})
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-5">
                    <h3 class="font-bold text-sm text-slate-900 mb-3">Rentang Harga (Rp)</h3>
                    <div class="flex items-center gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <span class="text-slate-400 text-sm">-</span>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Maks" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-5">
                    <h3 class="font-bold text-sm text-slate-900 mb-3">Urutkan</h3>
                    <select name="sort" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                    </select>
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-sm py-2.5 rounded-xl transition">
                        Terapkan
                    </button>
                    <a href="{{ route('products.index') }}" class="px-3 py-2.5 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 text-sm font-semibold transition text-center">
                        Reset
                    </a>
                </div>
            </form>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 min-w-0">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <p class="text-sm text-slate-500">
                    Menampilkan <span class="font-bold text-slate-800">{{ $products->total() }}</span> produk pertanian
                </p>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @forelse($products as $product)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                        <div class="relative">
                            <a href="{{ route('products.show', $product->slug) }}">
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover">
                                @else
                                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=500&q=80&auto=format&fit=crop" alt="{{ $product->name }}" class="w-full aspect-square object-cover">
                                @endif
                            </a>
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
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200">
                        <i data-lucide="package-search" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
                        <h3 class="font-bold text-slate-700">Tidak ada produk yang ditemukan</h3>
                        <p class="text-xs text-slate-400 mt-1">Silakan coba kata kunci atau filter kategori yang lain.</p>
                        <a href="{{ route('products.index') }}" class="inline-block mt-4 px-4 py-2 bg-emerald-700 text-white rounded-xl text-xs font-semibold">
                            Reset Filter
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
