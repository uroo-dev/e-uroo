<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusLog;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with agricultural & plantation e-commerce dummy data.
     */
    public function run(): void
    {
        // 1. Akun Admin
        $admin = User::updateOrCreate(
            ['email' => 'uroo@gmail.com'],
            [
                'name' => 'Admin Perkebunan PT',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '0882006533693',
            ]
        );

        // 2. Akun Pelanggan (Customer) Demo
        $customer1 = User::updateOrCreate(
            ['email' => 'rina.sulastri@gmail.com'],
            [
                'name' => 'Rina Sulastri',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'phone' => '081234567890',
            ]
        );

        $customer2 = User::updateOrCreate(
            ['email' => 'budi.santoso@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'phone' => '085712345678',
            ]
        );

        // 3. Alamat Pengiriman
        $addrRina1 = Address::updateOrCreate(
            ['user_id' => $customer1->id, 'recipient_name' => 'Rina Sulastri'],
            [
                'phone' => '081234567890',
                'province' => 'Jawa Barat',
                'city' => 'Kota Bandung',
                'district' => 'Coblong',
                'postal_code' => '40132',
                'full_address' => 'Jl. Kenanga Raya No. 12, RT 03/RW 05, Kel. Sekeloa',
                'is_default' => true,
            ]
        );

        $addrRina2 = Address::updateOrCreate(
            ['user_id' => $customer1->id, 'recipient_name' => 'Rina Sulastri (Kantor)'],
            [
                'phone' => '081234567890',
                'province' => 'Jawa Barat',
                'city' => 'Kota Bandung',
                'district' => 'Sumur Bandung',
                'postal_code' => '40111',
                'full_address' => 'Gedung Agro Plaza Lt. 4, Jl. Asia Afrika No. 45',
                'is_default' => false,
            ]
        );

        $addrBudi = Address::updateOrCreate(
            ['user_id' => $customer2->id, 'recipient_name' => 'Budi Santoso'],
            [
                'phone' => '085712345678',
                'province' => 'DKI Jakarta',
                'city' => 'Kota Jakarta Selatan',
                'district' => 'Kebayoran Baru',
                'postal_code' => '12160',
                'full_address' => 'Jl. Senopati No. 88, RT 01/RW 02',
                'is_default' => true,
            ]
        );

        // 4. Kategori Komoditas Perkebunan & Pertanian
        $categoriesData = [
            [
                'name' => 'Kopi Perkebunan',
                'slug' => 'kopi-perkebunan',
                'description' => 'Biji kopi arabika dan robusta petik merah pilihan langsung dari dataran tinggi kebun PT.',
                'is_active' => true,
            ],
            [
                'name' => 'Teh & Herbal',
                'slug' => 'teh-dan-herbal',
                'description' => 'Pucuk daun teh hijau, teh hitam, dan tanaman obat herbal organik hasil budidaya kebun.',
                'is_active' => true,
            ],
            [
                'name' => 'Buah Segar Panen',
                'slug' => 'buah-segar-panen',
                'description' => 'Buah-buahan segar hasil panen perkebunan seperti alpukat mentega, pisang cavendish, dan jeruk nipis.',
                'is_active' => true,
            ],
            [
                'name' => 'Sayuran Organik',
                'slug' => 'sayuran-organik',
                'description' => 'Sayuran hidroponik dan sayuran hijau segar bebas pestisida kimia dari greenhouse PT.',
                'is_active' => true,
            ],
            [
                'name' => 'Rempah Nusantara',
                'slug' => 'rempah-nusantara',
                'description' => 'Cengkeh, pala, kapulaga, jahe merah, dan lada hitam kualitas ekspor.',
                'is_active' => true,
            ],
            [
                'name' => 'Madu & Olahan Tani',
                'slug' => 'madu-dan-olahan-tani',
                'description' => 'Madu murni lebah perkebunan nektar bunga kopi dan olahan hasil tani murni.',
                'is_active' => true,
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::updateOrCreate(['slug' => $c['slug']], $c);
        }

        // 5. Produk Komoditas Panen
        $productsData = [
            [
                'category_slug' => 'kopi-perkebunan',
                'name' => 'Kopi Gayo Arabika Petik Merah 250g',
                'slug' => 'kopi-gayo-arabika-petik-merah-250g',
                'sku' => 'KOP-GYO-250',
                'description' => "Biji kopi Arabika single origin dipanen dari perkebunan dataran tinggi 1.400 mdpl.\nProses: Full Wash\nNotes: Caramel, Fruity, Medium Acidity\nKemasan: Pouch aluminium foil dengan valve satu arah.",
                'price' => 85000,
                'stock' => 120,
                'weight' => 0.25,
                'is_active' => true,
            ],
            [
                'category_slug' => 'kopi-perkebunan',
                'name' => 'Kopi Robusta Lampung Grade 1 500g',
                'slug' => 'kopi-robusta-lampung-grade-1-500g',
                'sku' => 'KOP-RBS-500',
                'description' => 'Kopi Robusta murni dengan cita rasa bold, crema tebal, aroma cokelat kuat, cocok untuk kopi susu kekinian dan espresso base.',
                'price' => 65000,
                'stock' => 80,
                'weight' => 0.50,
                'is_active' => true,
            ],
            [
                'category_slug' => 'teh-dan-herbal',
                'name' => 'Teh Hitam Pucuk Premium 100g',
                'slug' => 'teh-hitam-pucuk-premium-100g',
                'sku' => 'TEH-HTM-100',
                'description' => 'Dipetik hanya bagian pucuk daun teh terbaik di pagi hari. Memberikan aroma wangi segar dan warna air seduhan merah keemasan alami.',
                'price' => 45000,
                'stock' => 95,
                'weight' => 0.10,
                'is_active' => true,
            ],
            [
                'category_slug' => 'teh-dan-herbal',
                'name' => 'Teh Hijau Organik Pilihan 150g',
                'slug' => 'teh-hijau-organik-pilihan-150g',
                'sku' => 'TEH-HJU-150',
                'description' => 'Kaya antioksidan alami polifenol dan EGCG. Daun teh disangrai dengan standar pengolahan modern tanpa bahan tambahan.',
                'price' => 52000,
                'stock' => 70,
                'weight' => 0.15,
                'is_active' => true,
            ],
            [
                'category_slug' => 'buah-segar-panen',
                'name' => 'Alpukat Mentega Super (1 Kg)',
                'slug' => 'alpukat-mentega-super-1-kg',
                'sku' => 'BUH-ALP-1KG',
                'description' => 'Alpukat berdaging tebal, gurih creamy bebas serat pahit. Isi 3-4 buah per kilogram, dipetik tua pohon siap matang sempurna.',
                'price' => 38000,
                'stock' => 60,
                'weight' => 1.00,
                'is_active' => true,
            ],
            [
                'category_slug' => 'buah-segar-panen',
                'name' => 'Pisang Cavendish Mulur Mas (Sisir / 1.5 Kg)',
                'slug' => 'pisang-cavendish-mulur-mas-1-5-kg',
                'sku' => 'BUH-PSG-15KG',
                'description' => 'Kulit bersih mulus warna kuning cerah merata, rasa manis segar lembut. Dipanen higienis dari perkebunan pisang modern.',
                'price' => 32000,
                'stock' => 50,
                'weight' => 1.50,
                'is_active' => true,
            ],
            [
                'category_slug' => 'sayuran-organik',
                'name' => 'Selada Romaine Hidroponik (250g)',
                'slug' => 'selada-romaine-hidroponik-250g',
                'sku' => 'SAY-ROM-250',
                'description' => 'Renyah, manis alami, bebas residu pestisida kimia. Dipanen segar langsung bersama akar busa hidroponik.',
                'price' => 18000,
                'stock' => 45,
                'weight' => 0.25,
                'is_active' => true,
            ],
            [
                'category_slug' => 'rempah-nusantara',
                'name' => 'Jahe Merah Segar Pilihan (1 Kg)',
                'slug' => 'jahe-merah-segar-pilihan-1-kg',
                'sku' => 'RMP-JHE-1KG',
                'description' => 'Rimpang jahe merah segar usia panen 10 bulan dengan kadar minyak atsiri dan rasa pedas hangat yang tinggi untuk stamina.',
                'price' => 42000,
                'stock' => 110,
                'weight' => 1.00,
                'is_active' => true,
            ],
            [
                'category_slug' => 'madu-dan-olahan-tani',
                'name' => 'Madu Murni Nektar Bunga Kopi 350ml',
                'slug' => 'madu-murni-nektar-bunga-kopi-350ml',
                'sku' => 'MDU-KPI-350',
                'description' => 'Madu mentah (raw honey) 100% murni tanpa campuran gula atau pemanasan buatan. Dihasilkan saat musim berbunga pohon kopi di perkebunan.',
                'price' => 95000,
                'stock' => 35,
                'weight' => 0.50,
                'is_active' => true,
            ],
        ];

        $createdProducts = [];
        foreach ($productsData as $p) {
            $cat = $categories[$p['category_slug']];
            unset($p['category_slug']);
            $p['category_id'] = $cat->id;

            $createdProducts[$p['sku']] = Product::updateOrCreate(['sku' => $p['sku']], $p);
        }

        // 6. Keranjang Belanja Pelanggan Rina (Cart)
        $cartRina = Cart::firstOrCreate(['user_id' => $customer1->id]);
        CartItem::updateOrCreate(
            ['cart_id' => $cartRina->id, 'product_id' => $createdProducts['KOP-GYO-250']->id],
            ['quantity' => 2]
        );
        CartItem::updateOrCreate(
            ['cart_id' => $cartRina->id, 'product_id' => $createdProducts['MDU-KPI-350']->id],
            ['quantity' => 1]
        );

        // 7. Pesanan Dummy 1: COD - Selesai (Completed)
        $orderCod = Order::updateOrCreate(
            ['order_number' => 'INV-20261010-COD01'],
            [
                'user_id' => $customer1->id,
                'status' => 'completed',
                'subtotal' => 170000,
                'discount_amount' => 0,
                'grand_total' => 170000,
                'payment_method' => 'cod',
                'payment_status' => 'paid',
                'recipient_name' => $addrRina1->recipient_name.' ('.$addrRina1->phone.')',
                'recipient_phone' => $addrRina1->phone,
                'notes' => 'Alamat: '.$addrRina1->full_address.', '.$addrRina1->city.'. Catatan: Titip di pos satpam',
                'paid_at' => now()->subDays(2),
                'completed_at' => now()->subDays(2),
                'created_at' => now()->subDays(3),
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $orderCod->id, 'product_sku' => 'KOP-GYO-250'],
            [
                'product_id' => $createdProducts['KOP-GYO-250']->id,
                'product_name' => $createdProducts['KOP-GYO-250']->name,
                'product_price' => 85000,
                'quantity' => 2,
                'subtotal' => 170000,
            ]
        );

        Payment::updateOrCreate(
            ['order_id' => $orderCod->id],
            [
                'method' => 'COD (Bayar di Tempat)',
                'amount' => 170000,
                'status' => 'verified',
                'verified_by' => $admin->id,
                'verified_at' => now()->subDays(2),
            ]
        );

        OrderStatusLog::firstOrCreate(
            ['order_id' => $orderCod->id, 'status' => 'completed'],
            [
                'note' => 'Pesanan COD telah diterima oleh pembeli dan pembayaran tunai telah disetorkan.',
                'changed_by' => $admin->id,
                'created_at' => now()->subDays(2),
            ]
        );

        // 8. Pesanan Dummy 2: Transfer QRIS - Menunggu Verifikasi (Pending)
        $orderTransferPending = Order::updateOrCreate(
            ['order_number' => 'INV-20261012-TRF02'],
            [
                'user_id' => $customer2->id,
                'status' => 'pending',
                'subtotal' => 127000,
                'discount_amount' => 0,
                'grand_total' => 127000,
                'payment_method' => 'transfer',
                'payment_status' => 'pending',
                'recipient_name' => $addrBudi->recipient_name.' ('.$addrBudi->phone.')',
                'recipient_phone' => $addrBudi->phone,
                'notes' => 'Alamat: '.$addrBudi->full_address.', '.$addrBudi->city.'. Catatan: Kirim pagi hari',
                'created_at' => now()->subHours(3),
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $orderTransferPending->id, 'product_sku' => 'BUH-ALP-1KG'],
            [
                'product_id' => $createdProducts['BUH-ALP-1KG']->id,
                'product_name' => $createdProducts['BUH-ALP-1KG']->name,
                'product_price' => 38000,
                'quantity' => 1,
                'subtotal' => 38000,
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $orderTransferPending->id, 'product_sku' => 'MDU-KPI-350'],
            [
                'product_id' => $createdProducts['MDU-KPI-350']->id,
                'product_name' => $createdProducts['MDU-KPI-350']->name,
                'product_price' => 95000,
                'quantity' => 1,
                'subtotal' => 95000,
            ]
        );

        Payment::updateOrCreate(
            ['order_id' => $orderTransferPending->id],
            [
                'method' => 'Transfer Bank / QRIS',
                'amount' => 127000,
                'status' => 'pending',
            ]
        );

        OrderStatusLog::firstOrCreate(
            ['order_id' => $orderTransferPending->id, 'status' => 'pending'],
            [
                'note' => 'Pesanan dibuat. Menunggu verifikasi bukti transfer pembayaran.',
                'changed_by' => $customer2->id,
                'created_at' => now()->subHours(3),
            ]
        );

        // 9. Pesanan Dummy 3: Transfer QRIS - Diproses (Processing)
        $orderTransferProcessing = Order::updateOrCreate(
            ['order_number' => 'INV-20261011-TRF03'],
            [
                'user_id' => $customer1->id,
                'status' => 'processing',
                'subtotal' => 84000,
                'discount_amount' => 0,
                'grand_total' => 84000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'recipient_name' => $addrRina1->recipient_name.' ('.$addrRina1->phone.')',
                'recipient_phone' => $addrRina1->phone,
                'notes' => 'Alamat: '.$addrRina1->full_address,
                'paid_at' => now()->subDay(),
                'created_at' => now()->subDay(),
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $orderTransferProcessing->id, 'product_sku' => 'RMP-JHE-1KG'],
            [
                'product_id' => $createdProducts['RMP-JHE-1KG']->id,
                'product_name' => $createdProducts['RMP-JHE-1KG']->name,
                'product_price' => 42000,
                'quantity' => 2,
                'subtotal' => 84000,
            ]
        );

        Payment::updateOrCreate(
            ['order_id' => $orderTransferProcessing->id],
            [
                'method' => 'Transfer Bank / QRIS',
                'amount' => 84000,
                'status' => 'verified',
                'verified_by' => $admin->id,
                'verified_at' => now()->subDay(),
            ]
        );

        OrderStatusLog::firstOrCreate(
            ['order_id' => $orderTransferProcessing->id, 'status' => 'processing'],
            [
                'note' => 'Pembayaran telah diverifikasi oleh Admin. Komoditas sedang dikemas dari gudang kebun.',
                'changed_by' => $admin->id,
                'created_at' => now()->subDay(),
            ]
        );
    }
}
