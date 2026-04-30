<?php

namespace App\Helpers;

use App\Models\Country;
use RuntimeException;

/**
 * Provides convenient access to the Country that was resolved for the current
 * request by DetectCountry middleware.
 *
 * The three methods are intentionally static so they can be called from
 * anywhere — service classes, Blade views, or the global helper function —
 * without needing a facade or dependency injection.
 */
final class CountryHelper
{
    /**
     * Return the Country instance bound to the service container.
     *
     * @throws RuntimeException when called before DetectCountry has run.
     */
    public static function current(): Country
    {
        if (! app()->bound(Country::class)) {
            throw new RuntimeException(
                'No Country has been bound to the service container. ' .
                'Ensure the DetectCountry middleware has run before calling ' .
                CountryHelper::class . '::current().'
            );
        }

        return app(Country::class);
    }

    /**
     * Return the 2-letter ISO country code (e.g. "zw").
     */
    public static function currentCode(): string
    {
        return static::current()->code;
    }

    /**
     * Return the TLD domain string (e.g. "co.zw").
     */
    public static function currentDomain(): string
    {
        return static::current()->domain;
    }
}
