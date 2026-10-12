@extends('Admin.layout.app')
@section('title', 'Admin Category')
@section('content')
    <!-- ==================== Admin Categories Page ==================== -->
    <section data-admin-page="a-categories">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h1 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Kategori Produk</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    {{ $categories->count() }} kategori terdaftar di katalog toko
                </p>
            </div>
            <button onclick="openModal('modal-category')"
                class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md shadow-emerald-700/20">
                <i class="fa-solid fa-plus text-sm"></i> Tambah Kategori
            </button>
        </div>

        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse ($categories as $category)
                <div class="bg-white border border-slate-200 rounded-2xl p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    class="w-11 h-11 rounded-xl object-cover border border-slate-100">
                            @else
                                <span class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                                    <i class="fa-solid fa-tags text-emerald-700"></i>
                                </span>
                            @endif

                            @if ($category->is_active)
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700">Aktif</span>
                            @else
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-500">Tersembunyi</span>
                            @endif
                        </div>

                        <h3 class="font-bold text-slate-900 mt-3 text-base">{{ $category->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $category->description }}</p>
                        <p class="text-xs text-slate-400 mt-2">
                            {{ $category->products_count ?? 0 }} produk &bull; slug: <span class="font-mono text-slate-500">{{ $category->slug }}</span>
                        </p>
                    </div>

                    <div class="flex gap-2 mt-4 pt-3 border-t border-slate-100">
                        <button type="button"
                            onclick="openEditCategoryModal({{ json_encode($category) }}, '{{ $category->image ? asset('storage/' . $category->image) : '' }}')"
                            class="flex-1 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-xs py-2 rounded-xl transition text-center">
                            Ubah
                        </button>
                        <button type="button"
                            onclick="openDeleteCategoryModal('{{ route('admin.category.delete', $category) }}', '{{ addslashes($category->name) }}')"
                            class="flex-1 border border-red-200 text-red-600 hover:bg-red-50 font-semibold text-xs py-2 rounded-xl transition text-center">
                            Hapus
                        </button>
                    </div>
                </div>
            @empty
                <div class="sm:col-span-2 xl:col-span-3 bg-white border border-slate-200 rounded-2xl p-12 text-center">
                    <span class="w-14 h-14 mx-auto rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-4">
                        <i class="fa-solid fa-tags text-2xl"></i>
                    </span>
                    <h3 class="font-bold text-slate-900 text-base">Belum Ada Kategori</h3>
                    <p class="text-sm text-slate-500 mt-1">Belum ada kategori yang dibuat. Klik tombol di bawah untuk menambahkan kategori baru.</p>
                    <button onclick="openModal('modal-category')"
                        class="mt-4 inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition shadow-md shadow-emerald-700/20">
                        <i class="fa-solid fa-plus text-sm"></i> Tambah Kategori
                    </button>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Modal Tambah Category --}}
    <div id="modal-category" class="hidden fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60" onclick="closeModal('modal-category')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-lg text-slate-900">Tambah Kategori</h3>
                <button onclick="closeModal('modal-category')" class="p-1.5 rounded-xl hover:bg-slate-100 text-slate-400"
                    aria-label="Tutup"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama kategori</label>
                        <input type="text" name="name" required placeholder="Contoh: Peralatan Rumah"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi kategori</label>
                        <textarea name="description" rows="3" required placeholder="Tuliskan deskripsi kategori..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Gambar Kategori</label>
                        <div onclick="document.getElementById('category-image-input').click()"
                            class="relative border-2 border-dashed border-slate-200 hover:border-emerald-500 bg-slate-50/50 hover:bg-emerald-50/30 rounded-2xl p-4 text-center cursor-pointer transition">

                            <!-- Placeholder ketika belum pilih gambar -->
                            <div id="category-image-placeholder" class="py-2 flex flex-col items-center justify-center">
                                <span class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2">
                                    <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                </span>
                                <p class="text-xs font-semibold text-slate-700">Pilih atau unggah gambar</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Format PNG, JPG, WEBP (Maks. 2MB)</p>
                            </div>

                            <!-- Preview ketika gambar sudah dipilih -->
                            <div id="category-image-preview" class="hidden relative">
                                <img id="category-image-element" src="" alt="Preview Gambar"
                                    class="w-full h-36 object-cover rounded-xl border border-slate-200">
                                <button type="button" onclick="event.stopPropagation(); removeCategoryImage();"
                                    class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white w-7 h-7 rounded-lg flex items-center justify-center shadow-md transition text-xs"
                                    title="Hapus gambar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                        <input type="file" id="category-image-input" name="image" accept="image/png,image/jpeg,image/jpg,image/webp"
                            class="hidden" onchange="previewCategoryImage(this)">
                    </div>
                    <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" checked
                            class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        Tampilkan di menu publik
                    </label>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeModal('modal-category')"
                            class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Batal</button>
                        <button type="submit"
                            class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-700 hover:bg-emerald-800 transition">Simpan
                            Kategori</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Category --}}
    <div id="modal-edit-category" class="hidden fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60" onclick="closeModal('modal-edit-category')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-lg text-slate-900">Ubah Kategori</h3>
                <button onclick="closeModal('modal-edit-category')" class="p-1.5 rounded-xl hover:bg-slate-100 text-slate-400"
                    aria-label="Tutup"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <form id="form-edit-category" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama kategori</label>
                        <input type="text" id="edit-category-name" name="name" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi kategori</label>
                        <textarea id="edit-category-description" name="description" rows="3" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Gambar Kategori (Opsional)</label>
                        <div onclick="document.getElementById('edit-category-image-input').click()"
                            class="relative border-2 border-dashed border-slate-200 hover:border-emerald-500 bg-slate-50/50 hover:bg-emerald-50/30 rounded-2xl p-4 text-center cursor-pointer transition">

                            <!-- Placeholder ketika belum pilih gambar -->
                            <div id="edit-category-image-placeholder" class="py-2 flex flex-col items-center justify-center">
                                <span class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2">
                                    <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                </span>
                                <p class="text-xs font-semibold text-slate-700">Pilih atau unggah gambar baru</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Biarkan kosong jika tidak ingin mengubah</p>
                            </div>

                            <!-- Preview ketika gambar sudah dipilih / ada gambar lama -->
                            <div id="edit-category-image-preview" class="hidden relative">
                                <img id="edit-category-image-element" src="" alt="Preview Gambar"
                                    class="w-full h-36 object-cover rounded-xl border border-slate-200">
                                <button type="button" onclick="event.stopPropagation(); removeEditCategoryImage();"
                                    class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white w-7 h-7 rounded-lg flex items-center justify-center shadow-md transition text-xs"
                                    title="Hapus gambar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                        <input type="file" id="edit-category-image-input" name="image" accept="image/png,image/jpeg,image/jpg,image/webp"
                            class="hidden" onchange="previewEditCategoryImage(this)">
                    </div>
                    <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="edit-category-is-active" name="is_active" value="1"
                            class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        Tampilkan di menu publik
                    </label>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeModal('modal-edit-category')"
                            class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Batal</button>
                        <button type="submit"
                            class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-700 hover:bg-emerald-800 transition">Simpan
                            Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus Category --}}
    <div id="modal-delete-category" class="hidden fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60" onclick="closeModal('modal-delete-category')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-start gap-4">
                <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
                    <i data-lucide="trash-2" class="w-5 h-5 text-red-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-slate-900">Hapus Kategori?</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Kategori "<span id="delete-category-name" class="font-semibold text-slate-800"></span>" akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>
            <form id="form-delete-category" action="" method="POST" class="mt-6 flex justify-end gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal('modal-delete-category')"
                    class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Batal</button>
                <button type="submit"
                    class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition">Ya, Hapus</button>
            </form>
        </div>
    </div>

    <script>
        function previewCategoryImage(input) {
            const preview = document.getElementById('category-image-preview');
            const placeholder = document.getElementById('category-image-placeholder');
            const img = document.getElementById('category-image-element');

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

        function removeCategoryImage() {
            const input = document.getElementById('category-image-input');
            const preview = document.getElementById('category-image-preview');
            const placeholder = document.getElementById('category-image-placeholder');
            const img = document.getElementById('category-image-element');

            input.value = '';
            img.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }

        function openEditCategoryModal(category, imageUrl) {
            const form = document.getElementById('form-edit-category');
            form.action = `/admin/category/${category.id}`;

            document.getElementById('edit-category-name').value = category.name || '';
            document.getElementById('edit-category-description').value = category.description || '';
            document.getElementById('edit-category-is-active').checked = !!category.is_active;

            const preview = document.getElementById('edit-category-image-preview');
            const placeholder = document.getElementById('edit-category-image-placeholder');
            const img = document.getElementById('edit-category-image-element');

            if (imageUrl) {
                img.src = imageUrl;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                img.src = '';
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }

            openModal('modal-edit-category');
        }

        function previewEditCategoryImage(input) {
            const preview = document.getElementById('edit-category-image-preview');
            const placeholder = document.getElementById('edit-category-image-placeholder');
            const img = document.getElementById('edit-category-image-element');

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

        function removeEditCategoryImage() {
            const input = document.getElementById('edit-category-image-input');
            const preview = document.getElementById('edit-category-image-preview');
            const placeholder = document.getElementById('edit-category-image-placeholder');
            const img = document.getElementById('edit-category-image-element');

            input.value = '';
            img.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }

        function openDeleteCategoryModal(actionUrl, categoryName) {
            document.getElementById('form-delete-category').action = actionUrl;
            document.getElementById('delete-category-name').innerText = categoryName;
            openModal('modal-delete-category');
        }
    </script>
@endsection
