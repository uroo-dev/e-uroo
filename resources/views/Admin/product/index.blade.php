@extends('Admin.layout.app')
@section('title', 'Admin Produk')
@section('content')
    <!-- ==================== Admin Products Page ==================== -->
    <section data-admin-page="a-products">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h1 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Produk</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    {{ $products->count() }} produk terdaftar di katalog toko
                </p>
            </div>
            <button onclick="openModal('modal-product')"
                class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md shadow-emerald-700/20">
                <i class="fa-solid fa-plus text-sm"></i> Tambah Produk
            </button>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div id="bulk-bar" class="hidden bg-emerald-50 border-b border-emerald-100 px-5 py-3 flex flex-wrap items-center gap-3">
                <p class="text-sm font-bold text-emerald-800"><span id="bulk-count">0</span> produk dipilih</p>
                <button onclick="toast('Produk pilihan diarsipkan','success')" class="text-xs font-bold text-slate-600 border border-slate-200 bg-white rounded-xl px-3 py-1.5 hover:bg-slate-50 transition">Arsipkan</button>
                <button onclick="openModal('modal-delete-product')" class="text-xs font-bold text-red-600 border border-red-200 bg-white rounded-xl px-3 py-1.5 hover:bg-slate-50 transition">Hapus</button>
            </div>
            <div class="p-4 sm:p-5 flex flex-wrap items-center gap-3 border-b border-slate-100">
                <div class="relative flex-1 min-w-[200px] max-w-sm">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" id="product-search" onkeyup="filterProducts()" placeholder="Cari nama produk atau SKU..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <select id="filter-category" onchange="filterProducts()" class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <select id="filter-status" onchange="filterProducts()" class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Semua status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[820px]" id="product-table">
                    <thead>
                        <tr class="bg-slate-50 text-left text-xs text-slate-500 font-semibold">
                            <th class="px-5 py-3 w-10"><input type="checkbox" onchange="toggleSelectAll(this,'prod-check')" class="w-4 h-4 rounded border-slate-300 text-emerald-600"></th>
                            <th class="px-5 py-3">Produk</th>
                            <th class="px-5 py-3">SKU</th>
                            <th class="px-5 py-3">Kategori</th>
                            <th class="px-5 py-3">Harga</th>
                            <th class="px-5 py-3">Stok</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($products as $product)
                            <tr class="product-row hover:bg-slate-50 transition" data-category="{{ $product->category->name ?? '' }}" data-status="{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}">
                                <td class="px-5 py-3.5"><input type="checkbox" class="prod-check w-4 h-4 rounded border-slate-300 text-emerald-600" onchange="updateBulkBar()"></td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if($product->main_image)
                                            <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-xl object-cover border border-slate-100">
                                        @else
                                            <span class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-box text-emerald-600 text-base"></i>
                                            </span>
                                        @endif
                                        <div>
                                            <span class="font-semibold text-slate-800 product-name block">{{ $product->name }}</span>
                                            <span class="text-[11px] text-slate-400 font-mono">{{ $product->weight }} gr</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-slate-500 font-mono text-xs product-sku">{{ $product->sku }}</td>
                                <td class="px-5 py-3.5 text-slate-600">{{ $product->category->name ?? '-' }}</td>
                                <td class="px-5 py-3.5 font-semibold text-slate-800">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-5 py-3.5">
                                    @if($product->stock <= 5)
                                        <span class="font-bold text-red-600">{{ $product->stock }}</span>
                                        <span class="block text-[10px] text-red-500">Stok menipis</span>
                                    @else
                                        <span class="text-slate-600">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($product->is_active)
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700">Aktif</span>
                                    @else
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-500">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex justify-end gap-1">
                                        <button type="button"
                                            onclick="openEditProductModal({{ json_encode($product) }}, '{{ $product->main_image ? asset('storage/' . $product->main_image) : '' }}')"
                                            class="p-2 rounded-xl text-slate-400 hover:text-emerald-700 hover:bg-emerald-50 transition" aria-label="Edit" title="Ubah Produk">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </button>
                                        <button type="button"
                                            onclick="openDeleteProductModal('{{ route('admin.product.delete', $product) }}', '{{ addslashes($product->name) }}')"
                                            class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition" aria-label="Hapus" title="Hapus Produk">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center">
                                    <span class="w-12 h-12 mx-auto rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-3">
                                        <i class="fa-solid fa-box-open text-xl"></i>
                                    </span>
                                    <h3 class="font-bold text-slate-800 text-sm">Belum Ada Produk</h3>
                                    <p class="text-xs text-slate-400 mt-1">Belum ada produk yang ditambahkan ke katalog toko.</p>
                                    <button onclick="openModal('modal-product')"
                                        class="mt-4 inline-flex items-center gap-1.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow-md shadow-emerald-700/20">
                                        <i class="fa-solid fa-plus text-xs"></i> Tambah Produk Pertama
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-t border-slate-100">
                <p class="text-xs text-slate-400">Total: {{ $products->count() }} produk</p>
            </div>
        </div>
    </section>

    {{-- Modal Tambah Produk --}}
    <div id="modal-product" class="hidden fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60" onclick="closeModal('modal-product')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-lg text-slate-900">Tambah Produk Baru</h3>
                <button onclick="closeModal('modal-product')" class="p-1.5 rounded-xl hover:bg-slate-100 text-slate-400" aria-label="Tutup">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Produk</label>
                            <input type="text" name="name" required placeholder="Contoh: Kopi Gayo Arabika 250gr"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">SKU (Kode Produk)</label>
                            <input type="text" name="sku" required placeholder="Contoh: KOP-001"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori</label>
                            <select name="category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Harga (Rp)</label>
                            <input type="number" name="price" min="0" required placeholder="Contoh: 85000"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Stok</label>
                            <input type="number" name="stock" min="0" required placeholder="Contoh: 100"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Berat (gram)</label>
                            <input type="number" name="weight" min="0" required placeholder="Contoh: 250"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Produk</label>
                        <textarea name="description" rows="3" placeholder="Tuliskan deskripsi lengkap produk..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Utama Produk</label>
                        <div onclick="document.getElementById('product-image-input').click()"
                            class="relative border-2 border-dashed border-slate-200 hover:border-emerald-500 bg-slate-50/50 hover:bg-emerald-50/30 rounded-2xl p-4 text-center cursor-pointer transition">

                            <!-- Placeholder ketika belum pilih gambar -->
                            <div id="product-image-placeholder" class="py-3 flex flex-col items-center justify-center">
                                <span class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2">
                                    <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                </span>
                                <p class="text-xs font-semibold text-slate-700">Pilih atau unggah foto utama produk</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Format PNG, JPG, WEBP (Maks. 2MB)</p>
                            </div>

                            <!-- Preview ketika gambar sudah dipilih -->
                            <div id="product-image-preview" class="hidden relative">
                                <img id="product-image-element" src="" alt="Preview Gambar" class="w-full h-40 object-cover rounded-xl border border-slate-200">
                                <button type="button" onclick="event.stopPropagation(); removeProductImage();"
                                    class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white w-7 h-7 rounded-lg flex items-center justify-center shadow-md transition text-xs" title="Hapus gambar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                        <input type="file" id="product-image-input" name="main_image" accept="image/png,image/jpeg,image/jpg,image/webp" class="hidden" onchange="previewProductImage(this)">
                    </div>

                    <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" checked
                            class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        Tampilkan & aktifkan di katalog toko
                    </label>

                    <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" onclick="closeModal('modal-product')"
                            class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-700 hover:bg-emerald-800 transition shadow-md shadow-emerald-700/20">
                            Simpan Produk
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Produk --}}
    <div id="modal-edit-product" class="hidden fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60" onclick="closeModal('modal-edit-product')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-lg text-slate-900">Ubah Produk</h3>
                <button onclick="closeModal('modal-edit-product')" class="p-1.5 rounded-xl hover:bg-slate-100 text-slate-400" aria-label="Tutup">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form id="form-edit-product" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Produk</label>
                            <input type="text" id="edit-product-name" name="name" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">SKU (Kode Produk)</label>
                            <input type="text" id="edit-product-sku" name="sku" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori</label>
                            <select id="edit-product-category" name="category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Harga (Rp)</label>
                            <input type="number" id="edit-product-price" name="price" min="0" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Stok</label>
                            <input type="number" id="edit-product-stock" name="stock" min="0" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Berat (gram)</label>
                            <input type="number" id="edit-product-weight" name="weight" min="0" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Produk</label>
                        <textarea id="edit-product-description" name="description" rows="3"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Utama Produk (Opsional)</label>
                        <div onclick="document.getElementById('edit-product-image-input').click()"
                            class="relative border-2 border-dashed border-slate-200 hover:border-emerald-500 bg-slate-50/50 hover:bg-emerald-50/30 rounded-2xl p-4 text-center cursor-pointer transition">

                            <!-- Placeholder ketika belum pilih gambar baru -->
                            <div id="edit-product-image-placeholder" class="py-3 flex flex-col items-center justify-center">
                                <span class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2">
                                    <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                </span>
                                <p class="text-xs font-semibold text-slate-700">Pilih atau unggah foto utama baru</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Biarkan kosong jika tidak ingin mengubah</p>
                            </div>

                            <!-- Preview ketika gambar sudah dipilih / ada gambar lama -->
                            <div id="edit-product-image-preview" class="hidden relative">
                                <img id="edit-product-image-element" src="" alt="Preview Gambar" class="w-full h-40 object-cover rounded-xl border border-slate-200">
                                <button type="button" onclick="event.stopPropagation(); removeEditProductImage();"
                                    class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white w-7 h-7 rounded-lg flex items-center justify-center shadow-md transition text-xs" title="Hapus gambar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                        <input type="file" id="edit-product-image-input" name="main_image" accept="image/png,image/jpeg,image/jpg,image/webp" class="hidden" onchange="previewEditProductImage(this)">
                    </div>

                    <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="edit-product-is-active" name="is_active" value="1"
                            class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        Tampilkan & aktifkan di katalog toko
                    </label>

                    <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" onclick="closeModal('modal-edit-product')"
                            class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-700 hover:bg-emerald-800 transition shadow-md shadow-emerald-700/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus Produk --}}
    <div id="modal-delete-product" class="hidden fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60" onclick="closeModal('modal-delete-product')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-start gap-4">
                <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
                    <i data-lucide="trash-2" class="w-5 h-5 text-red-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-slate-900">Hapus Produk?</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Produk "<span id="delete-product-name" class="font-semibold text-slate-800"></span>" akan dihapus dari katalog toko. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>
            <form id="form-delete-product" action="" method="POST" class="mt-6 flex justify-end gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal('modal-delete-product')" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition">Ya, Hapus</button>
            </form>
        </div>
    </div>

    <script>
        function previewProductImage(input) {
            const preview = document.getElementById('product-image-preview');
            const placeholder = document.getElementById('product-image-placeholder');
            const img = document.getElementById('product-image-element');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeProductImage() {
            const input = document.getElementById('product-image-input');
            const preview = document.getElementById('product-image-preview');
            const placeholder = document.getElementById('product-image-placeholder');
            const img = document.getElementById('product-image-element');

            input.value = '';
            img.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }

        function openEditProductModal(product, imageUrl) {
            const form = document.getElementById('form-edit-product');
            form.action = `/admin/product/${product.id}`;

            document.getElementById('edit-product-name').value = product.name || '';
            document.getElementById('edit-product-sku').value = product.sku || '';
            document.getElementById('edit-product-category').value = product.category_id || '';
            document.getElementById('edit-product-price').value = parseInt(product.price) || '';
            document.getElementById('edit-product-stock').value = product.stock || 0;
            document.getElementById('edit-product-weight').value = parseInt(product.weight) || 0;
            document.getElementById('edit-product-description').value = product.description || '';
            document.getElementById('edit-product-is-active').checked = !!product.is_active;

            const preview = document.getElementById('edit-product-image-preview');
            const placeholder = document.getElementById('edit-product-image-placeholder');
            const img = document.getElementById('edit-product-image-element');

            if (imageUrl) {
                img.src = imageUrl;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                img.src = '';
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }

            openModal('modal-edit-product');
        }

        function previewEditProductImage(input) {
            const preview = document.getElementById('edit-product-image-preview');
            const placeholder = document.getElementById('edit-product-image-placeholder');
            const img = document.getElementById('edit-product-image-element');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeEditProductImage() {
            const input = document.getElementById('edit-product-image-input');
            const preview = document.getElementById('edit-product-image-preview');
            const placeholder = document.getElementById('edit-product-image-placeholder');
            const img = document.getElementById('edit-product-image-element');

            input.value = '';
            img.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }

        function openDeleteProductModal(actionUrl, productName) {
            document.getElementById('form-delete-product').action = actionUrl;
            document.getElementById('delete-product-name').innerText = productName;
            openModal('modal-delete-product');
        }

        function toggleSelectAll(master, itemClass) {
            const items = document.querySelectorAll('.' + itemClass);
            items.forEach(cb => cb.checked = master.checked);
            updateBulkBar();
        }

        function updateBulkBar() {
            const checked = document.querySelectorAll('.prod-check:checked');
            const bulkBar = document.getElementById('bulk-bar');
            const bulkCount = document.getElementById('bulk-count');
            if (bulkBar && bulkCount) {
                bulkCount.innerText = checked.length;
                if (checked.length > 0) {
                    bulkBar.classList.remove('hidden');
                } else {
                    bulkBar.classList.add('hidden');
                }
            }
        }

        function filterProducts() {
            const search = document.getElementById('product-search').value.toLowerCase();
            const category = document.getElementById('filter-category').value;
            const status = document.getElementById('filter-status').value;
            const rows = document.querySelectorAll('.product-row');

            rows.forEach(row => {
                const name = row.querySelector('.product-name').innerText.toLowerCase();
                const sku = row.querySelector('.product-sku').innerText.toLowerCase();
                const rowCategory = row.getAttribute('data-category');
                const rowStatus = row.getAttribute('data-status');

                const matchesSearch = !search || name.includes(search) || sku.includes(search);
                const matchesCategory = !category || rowCategory === category;
                const matchesStatus = !status || rowStatus === status;

                if (matchesSearch && matchesCategory && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endsection
