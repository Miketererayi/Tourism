<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * PageView intentionally has no created_at / updated_at columns.
 * All writes go through the visited_at timestamp instead.
 */
#[UseTable('page_views')]
#[Fillable(['country_code', 'url', 'ip_hash', 'user_agent', 'visited_at'])]
class PageView extends Model
{
    /** Disable Laravel's automatic timestamps entirely. */
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /** @param Builder<PageView> $query */
    public function scopeForCountry(Builder $query, string $countryCode): Builder
    {
        return $query->where('country_code', $countryCode);
    }
}
