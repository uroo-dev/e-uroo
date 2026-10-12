<!-- Promo Bar -->
<div class="bg-orange-500 text-white text-xs sm:text-sm">
    <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-center gap-2 text-center">
        <i data-lucide="truck" class="w-4 h-4 shrink-0"></i>
        <p class="font-medium">Gratis ongkir ke seluruh Indonesia untuk pembelian di atas Rp150.000</p>
    </div>
</div>

<!-- Public Navbar -->
<header class="bg-emerald-900 text-white sticky top-0 z-40 shadow-md">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-3 h-16">
            <button onclick="toggleMobileMenu()" class="lg:hidden p-2 -ml-2 rounded-xl hover:bg-emerald-800 transition" aria-label="Buka menu">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>

            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                <span class="w-9 h-9 rounded-xl bg-emerald-500 flex items-center justify-center">
                    <i data-lucide="leaf" class="w-5 h-5 text-emerald-950"></i>
                </span>
                <span class="font-extrabold text-lg tracking-tight hidden sm:block">E-<span class="text-emerald-400">UROO</span></span>
            </a>

            <nav class="hidden lg:flex items-center gap-1 ml-4 text-sm font-medium">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl hover:bg-emerald-800 transition {{ request()->routeIs('home') ? 'bg-emerald-800 text-emerald-300 font-bold' : '' }}">Beranda</a>
                <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-xl hover:bg-emerald-800 transition {{ request()->routeIs('products*') ? 'bg-emerald-800 text-emerald-300 font-bold' : '' }}">Semua Produk</a>
                @auth
                    <a href="{{ route('orders.index') }}" class="px-3 py-2 rounded-xl hover:bg-emerald-800 transition {{ request()->routeIs('orders*') ? 'bg-emerald-800 text-emerald-300 font-bold' : '' }}">Pesanan Saya</a>
                    <a href="{{ route('profile') }}" class="px-3 py-2 rounded-xl hover:bg-emerald-800 transition {{ request()->routeIs('profile*') ? 'bg-emerald-800 text-emerald-300 font-bold' : '' }}">Profil & Alamat</a>
                @endauth
            </nav>

            <form action="{{ route('products.index') }}" method="GET" class="flex-1 relative hidden md:block max-w-md ml-auto lg:ml-6">
                <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari hasil komoditas kebun & panen..."
                    class="w-full bg-white text-slate-800 rounded-xl pl-10 pr-4 py-2.5 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400">
            </form>

            <div class="flex items-center gap-1 ml-auto md:ml-3">
                <a href="{{ route('cart') }}" class="relative p-2.5 rounded-xl hover:bg-emerald-800 transition" aria-label="Keranjang">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                </a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="hidden sm:flex items-center gap-2 ml-2 bg-emerald-500 hover:bg-emerald-400 text-emerald-950 text-sm font-bold px-4 py-2.5 rounded-xl transition">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Panel Admin
                        </a>
                    @else
                        <a href="{{ route('profile') }}" class="text-sm font-semibold text-emerald-100 hover:text-white ml-2 hidden sm:inline flex items-center gap-1.5">
                            <i data-lucide="user" class="w-4 h-4"></i> {{ auth()->user()->name }}
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-2.5 rounded-xl hover:bg-emerald-800 transition text-sm text-emerald-200 hover:text-white" title="Keluar">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:flex items-center gap-2 ml-2 pl-3 border-l border-emerald-700 text-sm font-medium hover:text-emerald-300 transition">
                        <i data-lucide="user" class="w-5 h-5"></i>
                        <span class="hidden lg:block">Masuk</span>
                    </a>
                @endauth
            </div>

        </div>
    </div>
</header>

<!-- Mobile Menu Drawer -->
<div id="mobile-menu" class="hidden fixed inset-0 z-50 lg:hidden">
    <div class="absolute inset-0 bg-slate-900/60" onclick="toggleMobileMenu()"></div>
    <div class="absolute left-0 top-0 bottom-0 w-80 max-w-[85%] bg-white shadow-2xl flex flex-col">
        <div class="flex items-center justify-between px-4 h-16 bg-emerald-900 text-white">
            <span class="flex items-center gap-2 font-extrabold">
                <span class="w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center"><i data-lucide="leaf" class="w-4 h-4 text-emerald-950"></i></span>
                E-UROO
            </span>
            <button onclick="toggleMobileMenu()" class="p-2 rounded-xl hover:bg-emerald-800 transition" aria-label="Tutup menu"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <nav class="flex-1 overflow-y-auto p-3 space-y-1 text-sm font-medium text-slate-700">
            <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-emerald-50 hover:text-emerald-800 transition"><i data-lucide="home" class="w-4 h-4 text-slate-400"></i>Beranda</a>
            <a href="{{ route('cart') }}" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-emerald-50 hover:text-emerald-800 transition"><i data-lucide="shopping-cart" class="w-4 h-4 text-slate-400"></i>Keranjang</a>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-900 text-white hover:bg-emerald-800 transition mt-2"><i data-lucide="layout-dashboard" class="w-4 h-4 text-emerald-400"></i>Panel Admin</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-emerald-50 hover:text-emerald-800 transition"><i data-lucide="log-in" class="w-4 h-4 text-slate-400"></i>Masuk / Daftar</a>
            @endauth
        </nav>
    </div>
</div>
