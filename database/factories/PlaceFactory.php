<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Country;
use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Place>
 */
class PlaceFactory extends Factory
{
    protected $model = Place::class;

    /**
     * Define the model's default state.
     *
     * When a Country and/or Category are passed via ->for() in the seeder,
     * those bindings override the defaults defined here.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->company();

        return [
            // Relationships — resolved via ->for() in the seeder, but we
            // provide safe fallbacks here for standalone factory usage.
            'country_id'  => Country::factory(),
            'category_id' => Category::factory(),

            // Content
            'title'       => $title,
            'slug'        => Str::slug($title) . '-' . fake()->unique()->randomNumber(5),
            'description' => fake()->paragraphs(3, asText: true),
            'address'     => fake()->address(),
            'phone'       => fake()->e164PhoneNumber(),
            'email'       => fake()->companyEmail(),
            'website'     => fake()->url(),

            // Geography — constrained to the African continent
            'latitude'    => fake()->latitude(min: -35, max: 15),
            'longitude'   => fake()->longitude(min: 10, max: 52),

            // Status — 1-in-5 chance of being featured
            'is_featured' => fake()->boolean(chanceOfGettingTrue: 20),
            'is_active'   => true,

            // Published at a random point within the last 6 months
            'published_at' => fake()->dateTimeBetween(startDate: '-6 months', endDate: 'now'),
        ];
    }

    // -------------------------------------------------------------------------
    // Named states
    // -------------------------------------------------------------------------

    /** Force the place to be featured. */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /** Force the place to be inactive / unpublished. */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active'   => false,
            'published_at' => null,
        ]);
    }
}
