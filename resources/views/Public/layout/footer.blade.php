<!-- E-Commerce Public Footer -->
<footer class="bg-brand-dark text-white pt-16 pb-12 border-t border-brand-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-brand-800/80">
            
            <!-- Brand Info -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <span class="w-10 h-10 rounded-2xl bg-brand-500 flex items-center justify-center text-earth-sand shadow-inner">
                        <i data-lucide="sprout" class="w-6 h-6"></i>
                    </span>
                    <div>
                        <span class="font-display font-bold text-xl text-earth-sand">E-UROO PERKEBUNAN</span>
                        <span class="text-[10px] tracking-widest text-brand-300 font-semibold uppercase block">PT Agro Nusantara</span>
                    </div>
                </a>
                <p class="text-brand-200/80 text-xs sm:text-sm leading-relaxed max-w-sm">
                    Platform e-commerce resmi penyedia komoditas pertanian dan perkebunan berkualitas tinggi langsung dari lahan PT. Kami menjamin panen segar harian, bebas bahan berbahaya, dengan harga adil dari produsen utama.
                </p>
                <div class="flex items-center space-x-3 pt-2">
                    <a href="#" class="w-8 h-8 rounded-full bg-brand-800 hover:bg-brand-600 flex items-center justify-center text-brand-200 hover:text-white transition-colors" aria-label="Facebook">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-brand-800 hover:bg-brand-600 flex items-center justify-center text-brand-200 hover:text-white transition-colors" aria-label="Instagram">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-brand-800 hover:bg-brand-600 flex items-center justify-center text-brand-200 hover:text-white transition-colors" aria-label="Twitter">
                        <i data-lucide="twitter" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Shop Quick Links -->
            <div>
                <h4 class="font-display font-bold text-sm text-earth-sand mb-4 uppercase tracking-wider">Kategori Panen</h4>
                <ul class="space-y-2.5 text-xs text-brand-200/80">
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">Semua Komoditas</a></li>
                    <li><a href="{{ route('products.index') }}#kategori" class="hover:text-white transition-colors">Hasil Kebun & Pertanian</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">Kopi Nusantara & Olahan</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">Beras & Palawija</a></li>
                    <li><a href="{{ route('cart') }}" class="hover:text-white transition-colors">Keranjang Belanja</a></li>
                </ul>
            </div>

            <!-- Customer Care -->
            <div>
                <h4 class="font-display font-bold text-sm text-earth-sand mb-4 uppercase tracking-wider">Layanan Pelanggan</h4>
                <ul class="space-y-2.5 text-xs text-brand-200/80">
                    @auth
                        <li><a href="{{ route('orders.index') }}" class="hover:text-white transition-colors">Status & Riwayat Pesanan</a></li>
                        <li><a href="{{ route('profile') }}" class="hover:text-white transition-colors">Alamat & Pengiriman</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk Akun</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Daftar Pelanggan</a></li>
                    @endauth
                    <li><a href="#keunggulan" class="hover:text-white transition-colors">Garansi Kesegaran 100%</a></li>
                    <li><a href="#petani" class="hover:text-white transition-colors">Tim Petani Kebun PT</a></li>
                    <li><a href="tel:081234567890" class="hover:text-white transition-colors">Bantuan: (0812) 3456-7890</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h4 class="font-display font-bold text-sm text-earth-sand mb-4 uppercase tracking-wider">Sahabat Kebun PT</h4>
                <p class="text-brand-200/80 text-xs mb-3">Dapatkan info jadwal panen raya & promo diskon khusus pelanggan setia.</p>
                <form class="space-y-2" onsubmit="event.preventDefault(); toast('Terima kasih telah bergabung!', 'success');">
                    <input type="email" placeholder="Alamat email Anda..." class="w-full bg-brand-900 border border-brand-700 text-white placeholder-brand-400 text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-brand-400">
                    <button type="submit" class="w-full bg-earth-terracotta hover:bg-earth-rust py-2.5 rounded-xl font-bold text-xs text-white transition-colors shadow">
                        Daftar Newsletter
                    </button>
                </form>
            </div>

        </div>

        <!-- Bottom Legal & Payment Icons -->
        <div class="pt-8 text-center text-xs text-brand-200/60 flex flex-col md:flex-row justify-between items-center gap-4">
            <p>&copy; 2026 PT E-UROO AGRO NUSANTARA. Seluruh hak cipta dilindungi.</p>
            <div class="flex items-center space-x-4 text-brand-300">
                <span class="text-[11px]">Metode Pembayaran Resmi:</span>
                <span class="inline-flex items-center gap-1 bg-brand-900/80 px-2 py-1 rounded border border-brand-700/60 text-[11px] font-bold text-earth-sand">
                    <i data-lucide="banknote" class="w-3.5 h-3.5 text-brand-300"></i> COD Bayar di Tempat
                </span>
                <span class="inline-flex items-center gap-1 bg-brand-900/80 px-2 py-1 rounded border border-brand-700/60 text-[11px] font-bold text-earth-sand">
                    <i data-lucide="qr-code" class="w-3.5 h-3.5 text-brand-300"></i> QRIS & Transfer
                </span>
            </div>
        </div>
    </div>
</footer>
