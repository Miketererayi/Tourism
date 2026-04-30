<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Default categories applied to every country.
     * sort_order is derived from the array index at seed time.
     *
     * @var array<int, array{name: string, slug: string, icon: string}>
     */
    private const array CATEGORIES = [
        ['name' => 'Restaurants',   'slug' => 'restaurants',   'icon' => '🍽️'],
        ['name' => 'Hotels',        'slug' => 'hotels',        'icon' => '🏨'],
        ['name' => 'Shopping',      'slug' => 'shopping',      'icon' => '🛍️'],
        ['name' => 'Health',        'slug' => 'health',        'icon' => '🏥'],
        ['name' => 'Education',     'slug' => 'education',     'icon' => '🎓'],
        ['name' => 'Entertainment', 'slug' => 'entertainment', 'icon' => '🎭'],
        ['name' => 'Services',      'slug' => 'services',      'icon' => '🔧'],
        ['name' => 'Real Estate',   'slug' => 'real-estate',   'icon' => '🏠'],
        ['name' => 'Transport',     'slug' => 'transport',     'icon' => '🚌'],
        ['name' => 'Finance',       'slug' => 'finance',       'icon' => '🏦'],
    ];

    public function run(): void
    {
        $countries = Country::where('is_active', true)->get();

        DB::transaction(function () use ($countries): void {
            foreach ($countries as $country) {
                foreach (self::CATEGORIES as $index => $data) {
                    Category::updateOrCreate(
                        [
                            'country_id' => $country->id,
                            'slug'       => $data['slug'],
                        ],
                        [
                            'name'       => $data['name'],
                            'icon'       => $data['icon'],
                            'sort_order' => $index,
                            'is_active'  => true,
                        ]
                    );
                }
            }
        });

        $total = $countries->count() * count(self::CATEGORIES);

        $this->command->info(
            sprintf(
                '✅ CategorySeeder: %d categories seeded across %d countries.',
                $total,
                $countries->count()
            )
        );
    }
}
