<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_settings(): void
    {
        $response = $this->get('/admin/settings');
        $response->assertRedirect('/login');
    }

    public function test_regular_customer_cannot_access_admin_settings(): void
    {
        $customer = User::create([
            'name' => 'Pelanggan Biasa',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'pelanggan',
        ]);

        $response = $this->actingAs($customer)->get('/admin/settings');
        $response->assertForbidden();
    }

    public function test_admin_can_view_settings_page(): void
    {
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        Setting::set('site_name', 'Kebun Nusantara Test');

        $response = $this->actingAs($admin)->get('/admin/settings');
        $response->assertStatus(200);
        $response->assertSee('Kebun Nusantara Test');
        $response->assertSee('Pengaturan Website');
        $response->assertSee('Hero Section');
        $response->assertSee('Footer');
    }

    public function test_admin_can_update_website_settings(): void
    {
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/settings', [
            'site_name' => 'PT AGRO SEGAR BARU',
            'site_tagline' => 'Perkebunan Modern Mandiri',
            'site_phone' => '081299998888',
            'site_email' => 'halo@agrosegar.com',
            'announcement_text' => 'Diskon Pembukaan 20%!',
            'announcement_subtext' => 'Segar Setiap Hari',
            'hero_badge' => 'Panen Langsung Petani Mitra',
            'hero_title' => 'Komoditas Terbaik Langsung ke',
            'hero_title_highlight' => 'Dapur Rumah Anda',
            'hero_subtitle' => 'Pilihan kopi, beras, dan sayuran unggulan kualitas nomor satu.',
            'hero_cta_text' => 'Mulai Belanja',
            'hero_cta_link' => '#katalog',
            'footer_about' => 'Perusahaan perkebunan terintegrasi di Indonesia.',
            'footer_copyright' => '© 2026 PT AGRO SEGAR BARU.',
            'social_facebook' => 'https://facebook.com/agrosegar',
        ]);

        $response->assertRedirect('/admin/settings');
        $response->assertSessionHas('success');

        $this->assertEquals('PT AGRO SEGAR BARU', Setting::get('site_name'));
        $this->assertEquals('Dapur Rumah Anda', Setting::get('hero_title_highlight'));
        $this->assertEquals('© 2026 PT AGRO SEGAR BARU.', Setting::get('footer_copyright'));

        // Public page reflects the updated settings
        $publicResponse = $this->get('/');
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('PT AGRO SEGAR BARU');
        $publicResponse->assertSee('Dapur Rumah Anda');
        $publicResponse->assertSee('© 2026 PT AGRO SEGAR BARU.');
    }

    public function test_admin_can_upload_custom_logo_and_hero_image(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $logoFile = UploadedFile::fake()->image('custom_logo.png', 200, 200);
        $heroFile = UploadedFile::fake()->image('custom_hero.jpg', 1920, 1080);

        $response = $this->actingAs($admin)->post('/admin/settings', [
            'site_name' => 'Logo Test PT',
            'site_logo' => $logoFile,
            'hero_image' => $heroFile,
        ]);

        $response->assertRedirect('/admin/settings');

        $logoPath = Setting::get('site_logo');
        $heroPath = Setting::get('hero_image');

        $this->assertNotNull($logoPath);
        $this->assertNotNull($heroPath);

        Storage::disk('public')->assertExists($logoPath);
        Storage::disk('public')->assertExists($heroPath);
    }
}
