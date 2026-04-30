<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Generates 5 demo Place records per country per category using PlaceFactory.
 *
 * This seeder is intentionally excluded from DatabaseSeeder so it only runs
 * when explicitly requested:
 *
 *   php artisan db:seed --class=DemoPlaceSeeder
 */
class DemoPlaceSeeder extends Seeder
{
    /** Number of demo places created per country-category combination. */
    private const int PLACES_PER_CATEGORY = 5;

    public function run(): void
    {
        $countries = Country::with('categories')->where('is_active', true)->get();

        DB::transaction(function () use ($countries): void {
            foreach ($countries as $country) {
                foreach ($country->categories as $category) {
                    Place::factory()
                        ->count(self::PLACES_PER_CATEGORY)
                        ->for($country)
                        ->for($category)
                        ->create();
                }
            }
        });

        $total = $countries->sum(
            fn (Country $c) => $c->categories->count() * self::PLACES_PER_CATEGORY
        );

        $this->command->info(
            sprintf(
                '✅ DemoPlaceSeeder: %d demo places seeded across %d countries.',
                $total,
                $countries->count()
            )
        );
    }
}
