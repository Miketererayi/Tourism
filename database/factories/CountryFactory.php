<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    protected $model = Country::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $code = fake()->unique()->randomElement(Country::SUPPORTED_CODES);

        return [
            'name'       => fake()->country(),
            'code'       => $code,
            'domain'     => "co.{$code}",
            'currency'   => fake()->currencyCode(),
            'flag_emoji' => '🌍',
            'is_active'  => true,
        ];
    }
}
