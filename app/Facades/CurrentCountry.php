<?php

namespace App\Facades;

use App\Helpers\CountryHelper;
use App\Models\Country;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for CountryHelper.
 *
 * Usage:
 *   CurrentCountry::current()      → Country
 *   CurrentCountry::currentCode()  → 'zw'
 *   CurrentCountry::currentDomain() → 'co.zw'
 *
 * @method static Country current()
 * @method static string  currentCode()
 * @method static string  currentDomain()
 */
class CurrentCountry extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CountryHelper::class;
    }
}
