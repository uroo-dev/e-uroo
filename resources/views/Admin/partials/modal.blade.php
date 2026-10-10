  <div id="modal-delete" class="hidden fixed inset-0 z-[80] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60" onclick="closeModal('modal-delete')"></div>
    <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
      <div class="flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
          <i data-lucide="trash-2" class="w-5 h-5 text-red-600"></i>
        </div>
        <div>
          <h3 class="font-bold text-lg text-slate-900">Hapus produk ini?</h3>
          <p class="text-sm text-slate-500 mt-1">Produk "Kopi Gayo Arabika 250gr" akan dihapus permanen dari katalog toko. Tindakan ini tidak dapat dibatalkan.</p>
        </div>
      </div>
      <div class="flex justify-end gap-3 mt-6">
        <button onclick="closeModal('modal-delete')" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Batal</button>
        <button onclick="closeModal('modal-delete'); toast('Produk berhasil dihapus','error')" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition">Ya, Hapus</button>
      </div>
    </div>
  </div>

  <div id="modal-confirm-payment" class="hidden fixed inset-0 z-[80] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60" onclick="closeModal('modal-confirm-payment')"></div>
    <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
      <div class="flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
          <i data-lucide="badge-check" class="w-5 h-5 text-emerald-600"></i>
        </div>
        <div>
          <h3 class="font-bold text-lg text-slate-900">Konfirmasi pembayaran?</h3>
          <p class="text-sm text-slate-500 mt-1">Bukti transfer dari Rina Sulastri (Rp318.000) sudah sesuai. Pesanan akan diteruskan ke proses pengemasan.</p>
        </div>
      </div>
      <div class="flex justify-end gap-3 mt-6">
        <button onclick="closeModal('modal-confirm-payment')" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Periksa Lagi</button>
        <button onclick="closeModal('modal-confirm-payment'); toast('Pembayaran terverifikasi','success')" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-700 hover:bg-emerald-800 transition">Verifikasi Sekarang</button>
      </div>
    </div>
  </div>

<div id="modal-category" class="hidden fixed inset-0 z-[80] flex items-center justify-center p-4">
          <div class="absolute inset-0 bg-slate-900/60" onclick="closeModal('modal-category')"></div>
          <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-5">
              <h3 class="font-bold text-lg text-slate-900">Tambah Kategori</h3>
              <button onclick="closeModal('modal-category')" class="p-1.5 rounded-xl hover:bg-slate-100 text-slate-400" aria-label="Tutup"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama kategori</label>
                <input type="text" placeholder="Contoh: Peralatan Rumah" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Slug URL</label>
                <input type="text" placeholder="peralatan-rumah" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-emerald-500">
              </div>
              <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer"><input type="checkbox" checked class="w-4 h-4 rounded border-slate-300 text-emerald-600"> Tampilkan di menu publik</label>
              <div class="flex justify-end gap-3 pt-2">
                <button onclick="closeModal('modal-category')" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Batal</button>
                <button onclick="closeModal('modal-category'); toast('Kategori baru ditambahkan','success')" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-700 hover:bg-emerald-800 transition">Simpan Kategori</button>
              </div>
            </div>
          </div>
        </div>
