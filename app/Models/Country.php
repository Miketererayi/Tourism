<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UseTable('countries')]
#[Fillable(['name', 'code', 'domain', 'currency', 'flag_emoji', 'is_active'])]
class Country extends Model
{
    use HasFactory;
    // PHP 8.3 typed class constants
    public const string CODE_ZIMBABWE  = 'zw';
    public const string CODE_SOUTH_AFRICA = 'za';
    public const string CODE_KENYA     = 'ke';
    public const string CODE_NIGERIA   = 'ng';
    public const string CODE_BOTSWANA  = 'bw';
    public const string CODE_ZAMBIA    = 'zm';

    public const array SUPPORTED_CODES = [
        self::CODE_ZIMBABWE,
        self::CODE_SOUTH_AFRICA,
        self::CODE_KENYA,
        self::CODE_NIGERIA,
        self::CODE_BOTSWANA,
        self::CODE_ZAMBIA,
    ];

    /**
     * Find a country by its domain TLD (e.g. "co.zw").
     */
    public static function findByDomain(string $domain): ?static
    {
        return static::where('domain', $domain)->first();
    }

    // -------------------------------------------------------------------------
    // Attribute casting
    // -------------------------------------------------------------------------

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /** @return HasMany<Category, $this> */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /** @return HasMany<Place, $this> */
    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }

    /** @return HasMany<Page, $this> */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    /** @return HasMany<Setting, $this> */
    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }
}
