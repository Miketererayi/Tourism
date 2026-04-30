<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearSitemapCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the country-specific sitemap caches';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $countries = Country::where('is_active', true)->get();
        $count = 0;

        foreach ($countries as $country) {
            Cache::forget("sitemap_{$country->code}");
            $count++;
        }

        $this->info("Sitemap cache cleared for {$count} countries.");

        return self::SUCCESS;
    }
}
