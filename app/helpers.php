<?php

use App\Helpers\CountryHelper;
use App\Models\Country;

if (! function_exists('current_country')) {
    /**
     * Return the Country resolved for the current request.
     *
     * Available in Blade templates, controllers, and service classes.
     * Delegates entirely to CountryHelper::current() so there is a single
     * source of truth for the runtime check.
     *
     * @throws \RuntimeException when called before DetectCountry middleware runs.
     */
    function current_country(): Country
    {
        return CountryHelper::current();
    }
}
