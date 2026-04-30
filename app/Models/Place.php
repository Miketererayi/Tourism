<?php

namespace App\Models;

use Database\Factories\PlaceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\UseTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

#[UseTable('places')]
#[SoftDeletes]
#[Fillable([
    'country_id',
    'category_id',
    'title',
    'slug',
    'description',
    'address',
    'phone',
    'email',
    'website',
    'latitude',
    'longitude',
    'cover_image',
    'is_featured',
    'is_active',
    'published_at',
])]
class Place extends Model
{
    /** @use HasFactory<PlaceFactory> */
    use HasFactory;
    protected function casts(): array
    {
        return [
            'latitude'     => 'float',
            'longitude'    => 'float',
            'is_featured'  => 'boolean',
            'is_active'    => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /** @return BelongsTo<Country, $this> */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /** @return BelongsTo<Category, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** @return HasMany<PlaceImage, $this> */
    public function images(): HasMany
    {
        return $this->hasMany(PlaceImage::class)->orderBy('sort_order');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Scope: published and active places.
     *
     * @param Builder<Place> $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(fn (Builder $q) => $q
                ->whereNull('published_at')
                ->orWhere('published_at', '<=', Carbon::now())
            );
    }

    /**
     * Scope: featured places.
     *
     * @param Builder<Place> $query
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}
