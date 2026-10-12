<!-- Public Footer -->
<footer class="bg-emerald-950 text-emerald-100/80">
    <div class="max-w-7xl mx-auto px-4 py-12 lg:py-16">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="col-span-2 lg:col-span-1">
                <span class="flex items-center gap-2 text-white font-extrabold text-lg">
                    <span class="w-9 h-9 rounded-xl bg-emerald-500 flex items-center justify-center">
                        <i data-lucide="leaf" class="w-5 h-5 text-emerald-950"></i>
                    </span>
                    E-UROO
                </span>
                <p class="text-sm mt-4 leading-relaxed max-w-xs">Marketplace produk UMKM lokal Indonesia. Belanja berkualitas sambil mendukung pengrajin dan petani Nusantara.</p>
            </div>
            <div>
                <h3 class="text-white font-bold text-sm mb-4">Belanja</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#" class="hover:text-white transition">Semua Produk</a></li>
                    <li><a href="#" class="hover:text-white transition">Kategori</a></li>
                    <li><a href="{{ route('cart') }}" class="hover:text-white transition">Keranjang Belanja</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-bold text-sm mb-4">Akun</h3>
                <ul class="space-y-2.5 text-sm">
                    @auth
                        <li><a href="#" class="hover:text-white transition">Profil Saya</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Daftar</a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <h3 class="text-white font-bold text-sm mb-4">Bantuan</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-white transition">Hubungi Kami</a></li>
                    <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-emerald-900 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-emerald-100/50">© 2026 E-UROO. Platform E-Commerce UMKM Lokal.</p>
        </div>
    </div>
</footer>
