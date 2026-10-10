      <!-- Admin Header -->
      <header class="h-16 bg-white border-b border-slate-200 sticky top-0 z-20 flex items-center gap-3 px-4 lg:px-6">
        <button onclick="toggleAdminDrawer()" class="lg:hidden p-2 rounded-xl hover:bg-slate-100 text-slate-600 transition" aria-label="Buka sidebar"><i data-lucide="menu" class="w-5 h-5"></i></button>
        <button onclick="toggleAdminCollapse()" class="hidden lg:block p-2 rounded-xl hover:bg-slate-100 text-slate-600 transition" aria-label="Ciutkan sidebar"><i data-lucide="panel-left-close" class="w-5 h-5"></i></button>
        <div class="relative flex-1 max-w-sm">
          <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
          <input type="text" placeholder="Cari pesanan, produk, pelanggan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <div class="ml-auto flex items-center gap-2">
          <div class="relative">
            <button onclick="toggleNotifDropdown()" class="relative p-2.5 rounded-xl hover:bg-slate-100 text-slate-600 transition" aria-label="Notifikasi">
              <i data-lucide="bell" class="w-5 h-5"></i>
              <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-orange-500 rounded-full border-2 border-white"></span>
            </button>
            <div id="notif-dropdown" class="hidden absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 p-2">
              <p class="text-xs font-bold text-slate-400 px-3 py-2">Notifikasi baru</p>
              <button onclick="goAdmin('a-payments'); toggleNotifDropdown()" class="w-full flex items-start gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 text-left transition">
                <span class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center shrink-0"><i data-lucide="banknote" class="w-4 h-4 text-amber-600"></i></span>
                <span><span class="block text-sm font-semibold text-slate-800">Bukti pembayaran baru</span><span class="block text-xs text-slate-400 mt-0.5">Rina Sulastri mengunggah bukti transfer - 5 mnt lalu</span></span>
              </button>
              <button onclick="goAdmin('a-inventory'); toggleNotifDropdown()" class="w-full flex items-start gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 text-left transition">
                <span class="w-8 h-8 rounded-xl bg-red-50 flex items-center justify-center shrink-0"><i data-lucide="alert-triangle" class="w-4 h-4 text-red-500"></i></span>
                <span><span class="block text-sm font-semibold text-slate-800">Stok menipis</span><span class="block text-xs text-slate-400 mt-0.5">Keripik Singkong Balado tersisa 4 pcs - 1 jam lalu</span></span>
              </button>
              <button onclick="goAdmin('a-orders'); toggleNotifDropdown()" class="w-full flex items-start gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 text-left transition">
                <span class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0"><i data-lucide="shopping-bag" class="w-4 h-4 text-emerald-600"></i></span>
                <span><span class="block text-sm font-semibold text-slate-800">Pesanan baru #INV-2843</span><span class="block text-xs text-slate-400 mt-0.5">3 produk senilai Rp412.000 - 2 jam lalu</span></span>
              </button>
            </div>
          </div>
          <button onclick="goAdmin('a-profile')" class="flex items-center gap-2.5 pl-2 border-l border-slate-200 hover:opacity-80 transition">
            <img src="https://picsum.photos/seed/admin-dimas/80/80" alt="Foto admin Dimas" class="w-9 h-9 rounded-xl object-cover">
            <span class="hidden md:block text-left"><span class="block text-sm font-bold text-slate-800 leading-tight">Dimas Aditya</span><span class="block text-xs text-slate-400">Administrator</span></span>
          </button>
        </div>
      </header>
