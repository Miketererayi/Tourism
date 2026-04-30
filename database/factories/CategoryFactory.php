<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $name = fake()->words(2, asText: true);

        return [
            'country_id' => Country::factory(),
            'name'       => ucwords($name),
            'slug'       => Str::slug($name),
            'icon'       => '📁',
            'sort_order' => fake()->numberBetween(0, 99),
            'is_active'  => true,
        ];
    }
}
