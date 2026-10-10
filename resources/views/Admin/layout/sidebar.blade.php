<!-- Admin Sidebar -->
<aside id="admin-sidebar" class="fixed lg:sticky top-0 left-0 h-screen z-50 lg:z-30 w-64 shrink-0 bg-emerald-950 text-white flex flex-col -translate-x-full lg:translate-x-0 transition-transform duration-200">
  <div class="h-16 flex items-center justify-between px-4 border-b border-emerald-900 shrink-0">
    <span class="flex items-center gap-2 font-extrabold tracking-tight">
      <span class="w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center shrink-0">
        <i class="fa-solid fa-leaf text-emerald-950 text-sm"></i>
      </span>
      <span class="side-label whitespace-nowrap">NusantaraMart<span class="text-emerald-400 text-xs font-bold ml-1 align-middle">ADMIN</span></span>
    </span>
    <button onclick="toggleAdminDrawer()" class="lg:hidden p-1.5 rounded-lg hover:bg-emerald-900 transition" aria-label="Tutup sidebar">
      <i class="fa-solid fa-xmark text-base"></i>
    </button>
  </div>
  <nav class="flex-1 overflow-y-auto p-3 space-y-0.5 text-sm">
    <p class="side-label text-[10px] font-bold uppercase tracking-wider text-emerald-100/40 px-3 pt-2 pb-2">Menu Utama</p>
    <button onclick="goAdmin('a-dashboard')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-500 text-emerald-950 font-bold transition" data-anav="a-dashboard">
      <i class="fa-solid fa-table-columns w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Dashboard</span>
    </button>

    <p class="side-label text-[10px] font-bold uppercase tracking-wider text-emerald-100/40 px-3 pt-4 pb-2">Katalog</p>
    <button onclick="goAdmin('a-products')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-products">
      <i class="fa-solid fa-box w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Produk</span>
    </button>
    <button onclick="goAdmin('a-categories')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-categories">
      <i class="fa-solid fa-layer-group w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Kategori</span>
    </button>
    <button onclick="goAdmin('a-inventory')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-inventory">
      <i class="fa-solid fa-warehouse w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Inventaris / Stok</span>
    </button>

    <p class="side-label text-[10px] font-bold uppercase tracking-wider text-emerald-100/40 px-3 pt-4 pb-2">Transaksi</p>
    <button onclick="goAdmin('a-orders')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-orders">
      <i class="fa-solid fa-bag-shopping w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Pesanan</span>
    </button>
    <button onclick="goAdmin('a-order-status')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-order-status">
      <i class="fa-solid fa-code-branch w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Status Pesanan</span>
    </button>
    <button onclick="goAdmin('a-payments')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-payments">
      <i class="fa-solid fa-circle-check w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Konfirmasi Pembayaran</span>
    </button>

    <p class="side-label text-[10px] font-bold uppercase tracking-wider text-emerald-100/40 px-3 pt-4 pb-2">Pelanggan & Promo</p>
    <button onclick="goAdmin('a-customers')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-customers">
      <i class="fa-solid fa-users w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Data Pelanggan</span>
    </button>
    <button onclick="goAdmin('a-vouchers')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-vouchers">
      <i class="fa-solid fa-ticket w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Voucher & Promo</span>
    </button>
    <button onclick="goAdmin('a-banners')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-banners">
      <i class="fa-solid fa-images w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Banner Beranda</span>
    </button>

    <p class="side-label text-[10px] font-bold uppercase tracking-wider text-emerald-100/40 px-3 pt-4 pb-2">Laporan & Sistem</p>
    <button onclick="goAdmin('a-reports')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-reports">
      <i class="fa-solid fa-chart-line w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Laporan Penjualan</span>
    </button>
    <button onclick="goAdmin('a-settings')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-settings">
      <i class="fa-solid fa-gear w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Pengaturan Toko</span>
    </button>
    <button onclick="goAdmin('a-profile')" class="anav w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition" data-anav="a-profile">
      <i class="fa-solid fa-user-gear w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Profil Admin</span>
    </button>
  </nav>
  <div class="p-3 border-t border-emerald-900 shrink-0">
    <button onclick="openStore()" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100/80 hover:bg-emerald-900 hover:text-white transition text-sm">
      <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center shrink-0"></i>
      <span class="side-label whitespace-nowrap">Lihat Toko Publik</span>
    </button>
  </div>
</aside>
