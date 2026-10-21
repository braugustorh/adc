<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class PrivacyNotice extends Model
{
    use HasFactory;

    public const CACHE_KEY_ACTIVE = 'adc_active_privacy_notice';

    public const SCOPE_RAZON_SOCIAL = 'razon_social';
    public const SCOPE_SEDE = 'sede';
    public const SCOPE_GENERAL = 'general';

    protected $fillable = [
        'title',
        'version',
        'scope_type',
        'provider_name',
        'general_company_name',
        'general_address',
        'has_initial_notice',
        'initial_notice_content',
        'simplified_content',
        'has_extended_notice',
        'extended_content',
        'checkbox_label',
        'is_active',
        'created_by',
        'published_at',
    ];

    protected $casts = [
        'has_initial_notice' => 'boolean',
        'has_extended_notice' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (PrivacyNotice $notice) {
            if ($notice->is_active) {
                if (!$notice->published_at) {
                    $notice->published_at = now();
                }

                // Desactivar cualquier otro aviso activo para que solo exista uno vigente a la vez
                static::where('id', '!=', $notice->id ?? 0)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }
        });

        static::saved(function () {
            static::clearActiveCache();
        });

        static::deleted(function () {
            static::clearActiveCache();
        });
    }

    public static function clearActiveCache(): void
    {
        Cache::forget(self::CACHE_KEY_ACTIVE);
    }

    public static function getActive(): ?self
    {
        $active = static::where('is_active', true)
            ->latest('id')
            ->first();

        if (!$active) {
            static::clearActiveCache();
            return null;
        }

        return $active;
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function acceptances(): HasMany
    {
        return $this->hasMany(PrivacyNoticeAcceptance::class, 'privacy_notice_id');
    }

    public static function getScopeOptions(): array
    {
        return [
            self::SCOPE_RAZON_SOCIAL => 'Personalizado por Razón Social del Colaborador',
            self::SCOPE_SEDE => 'Personalizado por Sede del Colaborador',
            self::SCOPE_GENERAL => 'General (El mismo para todos)',
        ];
    }
}
