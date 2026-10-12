@extends('Admin.layout.app')
@section('title', 'Admin Produk')
@section('content')
    <!-- ==================== Admin Products Page ==================== -->
    <section data-admin-page="a-products">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h1 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Produk</h1>
                <p class="text-sm text-slate-500 mt-0.5">Kelola produk aktif di katalog toko</p>
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
                <button onclick="openModal('modal-delete')" class="text-xs font-bold text-red-600 border border-red-200 bg-white rounded-xl px-3 py-1.5 hover:bg-red-50 transition">Hapus</button>
            </div>
            <div class="p-4 sm:p-5 flex flex-wrap items-center gap-3 border-b border-slate-100">
                <div class="relative flex-1 min-w-[200px] max-w-sm">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" placeholder="Cari nama produk atau SKU..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <select onchange="toast('Filter kategori diterapkan','success')" class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option>Semua kategori</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @else
                        <option>Kopi & Minuman</option>
                        <option>Camilan</option>
                        <option>Fashion</option>
                        <option>Perawatan</option>
                    @endif
                </select>
                <select onchange="toast('Filter status diterapkan','success')" class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option>Semua status</option>
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                    <option>Stok habis</option>
                </select>
                <button onclick="toast('Data diurutkan berdasarkan nama','success')" class="ml-auto flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium text-slate-600 hover:border-emerald-300 transition">
                    <i data-lucide="arrow-up-down" class="w-4 h-4"></i> Urutkan
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[820px]">
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
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5"><input type="checkbox" class="prod-check w-4 h-4 rounded border-slate-300 text-emerald-600" onchange="updateBulkBar()"></td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=80&q=80&auto=format&fit=crop" onerror="this.onerror=null;this.src='https://picsum.photos/seed/kopi-gayo/80/80'" alt="Kopi Gayo" class="w-10 h-10 rounded-xl object-cover">
                                    <span class="font-semibold text-slate-800">Kopi Gayo Arabika 250gr</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 font-mono text-xs">KOP-001</td>
                            <td class="px-5 py-3.5 text-slate-600">Kopi & Minuman</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">Rp85.000</td>
                            <td class="px-5 py-3.5 text-slate-600">87</td>
                            <td class="px-5 py-3.5"><span class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700">Aktif</span></td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 rounded-xl text-slate-400 hover:text-emerald-700 hover:bg-emerald-50 transition" aria-label="Edit"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                    <button onclick="openModal('modal-delete')" class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition" aria-label="Hapus"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5"><input type="checkbox" class="prod-check w-4 h-4 rounded border-slate-300 text-emerald-600" onchange="updateBulkBar()"></td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="https://picsum.photos/seed/keripik-singkong/80/80" alt="Keripik Singkong" class="w-10 h-10 rounded-xl object-cover">
                                    <span class="font-semibold text-slate-800">Keripik Singkong Balado 200gr</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 font-mono text-xs">CAM-014</td>
                            <td class="px-5 py-3.5 text-slate-600">Camilan</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">Rp25.000</td>
                            <td class="px-5 py-3.5"><span class="font-bold text-red-600">4</span></td>
                            <td class="px-5 py-3.5"><span class="text-xs font-bold px-2.5 py-1 rounded-full bg-red-50 text-red-600">Stok habis segera</span></td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 rounded-xl text-slate-400 hover:text-emerald-700 hover:bg-emerald-50 transition" aria-label="Edit"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                    <button onclick="openModal('modal-delete')" class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition" aria-label="Hapus"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5"><input type="checkbox" class="prod-check w-4 h-4 rounded border-slate-300 text-emerald-600" onchange="updateBulkBar()"></td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=80&q=80&auto=format&fit=crop" onerror="this.onerror=null;this.src='https://picsum.photos/seed/tas-anyaman/80/80'" alt="Tas Anyaman" class="w-10 h-10 rounded-xl object-cover">
                                    <span class="font-semibold text-slate-800">Tas Anyaman Rotan Kalimantan</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 font-mono text-xs">KRA-022</td>
                            <td class="px-5 py-3.5 text-slate-600">Kerajinan</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">Rp189.000</td>
                            <td class="px-5 py-3.5 text-slate-600">23</td>
                            <td class="px-5 py-3.5"><span class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700">Aktif</span></td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 rounded-xl text-slate-400 hover:text-emerald-700 hover:bg-emerald-50 transition" aria-label="Edit"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                    <button onclick="openModal('modal-delete')" class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition" aria-label="Hapus"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5"><input type="checkbox" class="prod-check w-4 h-4 rounded border-slate-300 text-emerald-600" onchange="updateBulkBar()"></td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=80&q=80&auto=format&fit=crop" onerror="this.onerror=null;this.src='https://picsum.photos/seed/serum-wajah/80/80'" alt="Serum Wajah" class="w-10 h-10 rounded-xl object-cover">
                                    <span class="font-semibold text-slate-800">Serum Wajah Pencerah 30ml</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 font-mono text-xs">PWT-007</td>
                            <td class="px-5 py-3.5 text-slate-600">Perawatan</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">Rp125.000</td>
                            <td class="px-5 py-3.5 text-slate-600">0</td>
                            <td class="px-5 py-3.5"><span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-500">Nonaktif</span></td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 rounded-xl text-slate-400 hover:text-emerald-700 hover:bg-emerald-50 transition" aria-label="Edit"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                    <button onclick="openModal('modal-delete')" class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition" aria-label="Hapus"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-t border-slate-100">
                <p class="text-xs text-slate-400">Menampilkan 1-4 produk</p>
                <div class="flex items-center gap-1.5">
                    <button class="w-8 h-8 rounded-xl border border-slate-200 text-slate-400 flex items-center justify-center hover:border-emerald-300 transition" aria-label="Sebelumnya"><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
                    <button class="w-8 h-8 rounded-xl bg-emerald-700 text-white text-xs font-bold flex items-center justify-center">1</button>
                    <button onclick="toast('Halaman 2 dimuat','success')" class="w-8 h-8 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 flex items-center justify-center hover:border-emerald-300 transition">2</button>
                    <button onclick="toast('Halaman berikutnya dimuat','success')" class="w-8 h-8 rounded-xl border border-slate-200 text-slate-600 flex items-center justify-center hover:border-emerald-300 transition" aria-label="Berikutnya"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
                </div>
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
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
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
                                <p class="text-[11px] text-slate-400 mt-0.5">Format PNG, JPG (Maks. 2MB)</p>
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
                        <input type="file" id="product-image-input" name="main_image" accept="image/png,image/jpeg,image/jpg" class="hidden" onchange="previewProductImage(this)">
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

    {{-- Modal Hapus --}}
    <div id="modal-delete" class="hidden fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60" onclick="closeModal('modal-delete')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-start gap-4">
                <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
                    <i data-lucide="trash-2" class="w-5 h-5 text-red-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-slate-900">Hapus produk ini?</h3>
                    <p class="text-sm text-slate-500 mt-1">Produk ini akan dihapus dari katalog toko. Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button onclick="closeModal('modal-delete')" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Batal</button>
                <button onclick="closeModal('modal-delete'); toast('Produk berhasil dihapus','error')" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition">Ya, Hapus</button>
            </div>
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
    </script>
@endsection
