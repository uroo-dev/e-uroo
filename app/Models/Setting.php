<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
    ];

    /**
     * Boot model events to automatically clear cache on changes.
     */
    protected static function booted(): void
    {
        static::saved(function (Setting $setting) {
            Cache::forget("setting.{$setting->key}");
            Cache::forget('settings.all');
        });

        static::deleted(function (Setting $setting) {
            Cache::forget("setting.{$setting->key}");
            Cache::forget('settings.all');
        });
    }

    /**
     * Get a setting value by key with optional fallback.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        try {
            $value = Cache::rememberForever("setting.{$key}", function () use ($key) {
                return static::where('key', $key)->value('value');
            });

            return $value !== null && $value !== '' ? $value : $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }

    /**
     * Set or update a setting value.
     */
    public static function set(string $key, ?string $value, string $group = 'general', string $type = 'text'): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
            ]
        );

        Cache::forget("setting.{$key}");
        Cache::forget('settings.all');

        return $setting;
    }

    /**
     * Retrieve all settings grouped by their group.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function getAllGrouped(): array
    {
        return static::all()->groupBy('group')->map(function ($items) {
            return $items->pluck('value', 'key')->all();
        })->all();
    }
}
