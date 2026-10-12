<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General & Brand
            ['key' => 'site_name', 'value' => 'E-UROO PERKEBUNAN', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_tagline', 'value' => 'PT Agro Nusantara', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_phone', 'value' => '(0812) 3456-7890', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_email', 'value' => 'kontak@e-uroo.id', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_logo', 'value' => null, 'group' => 'general', 'type' => 'image'],
            ['key' => 'announcement_text', 'value' => 'Gratis Ongkir Pembelian di Atas Rp150.000!', 'group' => 'general', 'type' => 'text'],
            ['key' => 'announcement_subtext', 'value' => '100% Panen Kebun PT Tersertifikasi Organik', 'group' => 'general', 'type' => 'text'],

            // Hero Section
            ['key' => 'hero_badge', 'value' => 'Langsung dari Lahan Perkebunan PT • Bebas Pestisida Berbahaya', 'group' => 'hero', 'type' => 'text'],
            ['key' => 'hero_title', 'value' => 'Panen Segar Perkebunan Langsung ke', 'group' => 'hero', 'type' => 'text'],
            ['key' => 'hero_title_highlight', 'value' => 'Meja Anda', 'group' => 'hero', 'type' => 'text'],
            ['key' => 'hero_subtitle', 'value' => 'Dipetik harian langsung dari kebun & perkebunan kami. Nikmati aneka komoditas unggulan: Kopi Spesialti, Kelapa Sawit olahan, Beras Merah Organik, Sayuran Higienis, dan Buah Segar Nusantara.', 'group' => 'hero', 'type' => 'textarea'],
            ['key' => 'hero_image', 'value' => null, 'group' => 'hero', 'type' => 'image'],
            ['key' => 'hero_cta_text', 'value' => 'Belanja Hasil Panen', 'group' => 'hero', 'type' => 'text'],
            ['key' => 'hero_cta_link', 'value' => '#products', 'group' => 'hero', 'type' => 'text'],
            ['key' => 'hero_secondary_text', 'value' => 'Paket Panen Mingguan', 'group' => 'hero', 'type' => 'text'],
            ['key' => 'hero_secondary_link', 'value' => '#subscription', 'group' => 'hero', 'type' => 'text'],

            // Footer Section
            ['key' => 'footer_about', 'value' => 'Platform e-commerce resmi penyedia komoditas pertanian dan perkebunan berkualitas tinggi langsung dari lahan PT. Kami menjamin panen segar harian, bebas bahan berbahaya, dengan harga adil dari produsen utama.', 'group' => 'footer', 'type' => 'textarea'],
            ['key' => 'footer_copyright', 'value' => '© 2026 PT E-UROO AGRO NUSANTARA. Seluruh hak cipta dilindungi.', 'group' => 'footer', 'type' => 'text'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com', 'group' => 'footer', 'type' => 'text'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com', 'group' => 'footer', 'type' => 'text'],
            ['key' => 'social_twitter', 'value' => 'https://x.com', 'group' => 'footer', 'type' => 'text'],
            ['key' => 'social_whatsapp', 'value' => 'https://wa.me/6281234567890', 'group' => 'footer', 'type' => 'text'],
            ['key' => 'footer_link_terms', 'value' => '#', 'group' => 'footer', 'type' => 'text'],
            ['key' => 'footer_link_privacy', 'value' => '#', 'group' => 'footer', 'type' => 'text'],
            ['key' => 'footer_link_faq', 'value' => '#', 'group' => 'footer', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
