<!-- Top Announcement Bar -->
<div class="bg-brand-900 text-brand-100 text-xs py-2 px-4 border-b border-brand-800">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <span class="flex items-center space-x-1.5 font-medium">
                <i data-lucide="truck" class="w-3.5 h-3.5 text-brand-300"></i>
                <span>{{ setting('announcement_text', 'Gratis Ongkir Pembelian di Atas Rp150.000!') }}</span>
            </span>
            <span class="hidden md:inline-block text-brand-700">|</span>
            <span class="hidden md:flex items-center space-x-1.5">
                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-brand-300"></i>
                <span>{{ setting('announcement_subtext', '100% Panen Kebun PT Tersertifikasi Organik') }}</span>
            </span>
        </div>
        <div class="flex items-center space-x-4 text-xs">
            @php $phone = setting('site_phone', '(0812) 3456-7890'); @endphp
            <a href="tel:{{ preg_replace('/[^0-9]/', '', $phone) }}" class="hover:text-white transition-colors flex items-center space-x-1">
                <i data-lucide="phone" class="w-3.5 h-3.5 text-brand-300"></i>
                <span class="hidden sm:inline">Layanan Kebun: {{ $phone }}</span>
            </a>
            <span class="text-brand-700">|</span>
            <span class="text-brand-300 font-semibold">COD & QRIS Tersedia</span>
        </div>
    </div>
</div>

<!-- Main Navigation Header (Glassmorphic) -->
<header class="sticky top-0 z-40 w-full transition-all duration-300 nav-glass border-b border-brand-800/80 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-4">

            <!-- Mobile Menu Toggle -->
            <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-xl text-brand-200 hover:text-white hover:bg-brand-800/60 transition" aria-label="Buka menu">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>

            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group shrink-0">
                @if(setting('site_logo'))
                    <span class="w-11 h-11 rounded-2xl bg-white/10 p-1 flex items-center justify-center overflow-hidden shrink-0 shadow-inner group-hover:scale-105 transition-transform">
                        <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="{{ setting('site_name', 'E-UROO') }}" class="w-full h-full object-contain">
                    </span>
                @else
                    <span class="w-11 h-11 rounded-2xl bg-brand-500 flex items-center justify-center text-earth-sand shadow-inner group-hover:scale-105 transition-transform shrink-0">
                        <i data-lucide="sprout" class="w-6 h-6"></i>
                    </span>
                @endif
                <div>
                    <span class="font-display font-bold text-xl sm:text-2xl tracking-tight text-earth-sand block leading-none">{{ setting('site_name', 'E-UROO') }}</span>
                    <span class="text-[10px] tracking-widest text-brand-300 font-semibold uppercase block mt-1">{{ setting('site_tagline', 'Perkebunan PT') }}</span>
                </div>
            </a>

            <!-- Search Bar -->
            <form action="{{ route('products.index') }}" method="GET" class="flex-1 max-w-md hidden md:flex items-center bg-white rounded-full p-1 shadow-inner border border-brand-200/50">
                <div class="flex-1 flex items-center pl-3.5 pr-2">
                    <i data-lucide="search" class="w-4 h-4 text-brand-600 mr-2 shrink-0"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari hasil panen, kopi, beras, buah..."
                        class="w-full bg-transparent text-brand-dark placeholder-gray-400 text-xs sm:text-sm focus:outline-none py-1.5">
                </div>
                <button type="submit" class="bg-earth-terracotta hover:bg-earth-rust text-white px-4 py-2 rounded-full font-bold text-xs transition shadow-sm flex items-center space-x-1 shrink-0">
                    <span>Cari</span>
                </button>
            </form>

            <!-- Desktop Nav Links -->
            <nav class="hidden lg:flex items-center space-x-1 text-sm font-semibold">
                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl hover:text-brand-200 hover:bg-brand-800/50 transition {{ request()->routeIs('home') ? 'text-brand-300 bg-brand-800/80' : 'text-brand-100' }}">Beranda</a>
                <a href="{{ route('products.index') }}" class="px-3.5 py-2 rounded-xl hover:text-brand-200 hover:bg-brand-800/50 transition {{ request()->routeIs('products*') ? 'text-brand-300 bg-brand-800/80' : 'text-brand-100' }}">Semua Produk</a>
                @auth
                    <a href="{{ route('orders.index') }}" class="px-3.5 py-2 rounded-xl hover:text-brand-200 hover:bg-brand-800/50 transition {{ request()->routeIs('orders*') ? 'text-brand-300 bg-brand-800/80' : 'text-brand-100' }}">Pesanan Saya</a>
                    <a href="{{ route('profile') }}" class="px-3.5 py-2 rounded-xl hover:text-brand-200 hover:bg-brand-800/50 transition {{ request()->routeIs('profile*') ? 'text-brand-300 bg-brand-800/80' : 'text-brand-100' }}">Profil & Alamat</a>
                @endauth
            </nav>

            <!-- Right Actions (Cart & Auth) -->
            <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
                <!-- Cart Button -->
                <a href="{{ route('cart') }}" class="flex items-center space-x-2 bg-brand-500 hover:bg-brand-600 text-white px-3.5 py-2 rounded-full font-bold text-xs transition shadow-md active:scale-95 relative" aria-label="Keranjang Belanja">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Keranjang</span>
                    @php 
                        $cartCount = auth()->check() ? (auth()->user()->cart?->items()->sum('quantity') ?? 0) : 0; 
                    @endphp
                    @if($cartCount > 0)
                        <span class="bg-earth-terracotta text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center font-bold">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="hidden sm:flex items-center space-x-1.5 bg-earth-sand text-brand-dark hover:bg-white text-xs font-bold px-3 py-2 rounded-full transition shadow-sm">
                            <i data-lucide="layout-dashboard" class="w-3.5 h-3.5 text-brand-700"></i>
                            <span>Admin</span>
                        </a>
                    @else
                        <a href="{{ route('profile') }}" class="hidden sm:flex items-center space-x-1.5 text-xs font-semibold text-brand-100 hover:text-white px-2 py-1 rounded-lg">
                            <i data-lucide="user" class="w-3.5 h-3.5 text-brand-300"></i>
                            <span class="max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-2 rounded-xl text-brand-200 hover:text-white hover:bg-brand-800/60 transition" title="Keluar">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center space-x-1.5 text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-brand-500/40 px-3.5 py-2 rounded-full transition">
                        <i data-lucide="user" class="w-3.5 h-3.5 text-brand-300"></i>
                        <span>Masuk</span>
                    </a>
                @endauth
            </div>

        </div>
    </div>
</header>

<!-- Mobile Menu Drawer -->
<div id="mobile-menu" class="hidden fixed inset-0 z-50 lg:hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="toggleMobileMenu()"></div>
    <div class="absolute left-0 top-0 bottom-0 w-80 max-w-[85%] bg-brand-dark text-white shadow-2xl flex flex-col border-r border-brand-800">
        <div class="flex items-center justify-between px-5 h-20 bg-brand-900 border-b border-brand-800">
            <span class="flex items-center space-x-2 font-display font-bold text-lg text-earth-sand">
                @if(setting('site_logo'))
                    <span class="w-8 h-8 rounded-xl bg-white/10 p-0.5 flex items-center justify-center overflow-hidden shrink-0">
                        <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="{{ setting('site_name', 'E-UROO') }}" class="w-full h-full object-contain">
                    </span>
                @else
                    <span class="w-8 h-8 rounded-xl bg-brand-500 flex items-center justify-center text-white"><i data-lucide="sprout" class="w-4 h-4"></i></span>
                @endif
                <span>{{ setting('site_name', 'E-UROO PERKEBUNAN') }}</span>
            </span>
            <button onclick="toggleMobileMenu()" class="p-2 rounded-xl text-brand-300 hover:text-white hover:bg-brand-800 transition" aria-label="Tutup menu">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Mobile Search -->
        <div class="p-4 border-b border-brand-800">
            <form action="{{ route('products.index') }}" method="GET" class="flex items-center bg-white rounded-xl overflow-hidden p-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari hasil panen..."
                    class="w-full bg-transparent text-brand-dark placeholder-gray-400 text-xs px-2.5 py-1.5 focus:outline-none">
                <button type="submit" class="bg-earth-terracotta text-white p-2 rounded-lg">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                </button>
            </form>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 space-y-1.5 text-sm font-semibold text-brand-100">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl hover:bg-brand-800 hover:text-white transition">
                <i data-lucide="home" class="w-4 h-4 text-brand-400"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl hover:bg-brand-800 hover:text-white transition">
                <i data-lucide="shopping-bag" class="w-4 h-4 text-brand-400"></i>
                <span>Semua Produk</span>
            </a>
            <a href="{{ route('cart') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl hover:bg-brand-800 hover:text-white transition">
                <i data-lucide="shopping-cart" class="w-4 h-4 text-brand-400"></i>
                <span>Keranjang Belanja</span>
            </a>
            @auth
                <a href="{{ route('orders.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl hover:bg-brand-800 hover:text-white transition">
                    <i data-lucide="receipt" class="w-4 h-4 text-brand-400"></i>
                    <span>Pesanan Saya</span>
                </a>
                <a href="{{ route('profile') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl hover:bg-brand-800 hover:text-white transition">
                    <i data-lucide="user" class="w-4 h-4 text-brand-400"></i>
                    <span>Profil & Alamat</span>
                </a>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl bg-brand-800 text-earth-sand hover:bg-brand-700 transition mt-2">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-brand-300"></i>
                        <span>Panel Admin</span>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl bg-brand-800 text-earth-sand hover:bg-brand-700 transition mt-2">
                    <i data-lucide="log-in" class="w-4 h-4 text-brand-300"></i>
                    <span>Masuk / Daftar</span>
                </a>
            @endauth
        </nav>
    </div>
</div>
