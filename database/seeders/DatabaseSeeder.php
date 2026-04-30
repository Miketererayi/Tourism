<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Runs in dependency order:
     *   1. CountrySeeder  — base reference data
     *   2. CategorySeeder — requires countries to exist
     *
     * Demo data is intentionally excluded. To seed demo places run:
     *   php artisan db:seed --class=DemoPlaceSeeder
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            CategorySeeder::class,
        ]);
    }
}
