<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the website settings management page.
     */
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key');

        return view('Admin.settings.index', compact('settings'));
    }

    /**
     * Update the website settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            // General
            'site_name' => 'nullable|string|max:100',
            'site_tagline' => 'nullable|string|max:150',
            'site_phone' => 'nullable|string|max:50',
            'site_email' => 'nullable|email|max:100',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'announcement_text' => 'nullable|string|max:255',
            'announcement_subtext' => 'nullable|string|max:255',

            // Hero Section
            'hero_badge' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_title_highlight' => 'nullable|string|max:100',
            'hero_subtitle' => 'nullable|string|max:1000',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'hero_cta_text' => 'nullable|string|max:50',
            'hero_cta_link' => 'nullable|string|max:255',
            'hero_secondary_text' => 'nullable|string|max:50',
            'hero_secondary_link' => 'nullable|string|max:255',

            // Footer Section
            'footer_about' => 'nullable|string|max:1000',
            'footer_copyright' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_whatsapp' => 'nullable|string|max:100',
            'footer_link_terms' => 'nullable|string|max:255',
            'footer_link_privacy' => 'nullable|string|max:255',
            'footer_link_faq' => 'nullable|string|max:255',
        ]);

        // Process File Upload: Site Logo
        if ($request->hasFile('site_logo')) {
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            Setting::set('site_logo', $logoPath, 'general', 'image');
        }

        // Process File Upload: Hero Image
        if ($request->hasFile('hero_image')) {
            $oldHero = Setting::get('hero_image');
            if ($oldHero && Storage::disk('public')->exists($oldHero)) {
                Storage::disk('public')->delete($oldHero);
            }
            $heroPath = $request->file('hero_image')->store('settings', 'public');
            Setting::set('hero_image', $heroPath, 'hero', 'image');
        }

        // Group mapping for text fields
        $groupMap = [
            'site_name' => 'general',
            'site_tagline' => 'general',
            'site_phone' => 'general',
            'site_email' => 'general',
            'announcement_text' => 'general',
            'announcement_subtext' => 'general',

            'hero_badge' => 'hero',
            'hero_title' => 'hero',
            'hero_title_highlight' => 'hero',
            'hero_subtitle' => 'hero',
            'hero_cta_text' => 'hero',
            'hero_cta_link' => 'hero',
            'hero_secondary_text' => 'hero',
            'hero_secondary_link' => 'hero',

            'footer_about' => 'footer',
            'footer_copyright' => 'footer',
            'social_facebook' => 'footer',
            'social_instagram' => 'footer',
            'social_twitter' => 'footer',
            'social_whatsapp' => 'footer',
            'footer_link_terms' => 'footer',
            'footer_link_privacy' => 'footer',
            'footer_link_faq' => 'footer',
        ];

        foreach ($groupMap as $key => $group) {
            if ($request->has($key)) {
                $type = in_array($key, ['hero_subtitle', 'footer_about']) ? 'textarea' : 'text';
                Setting::set($key, $request->input($key), $group, $type);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan tampilan website berhasil diperbarui!');
    }
}
