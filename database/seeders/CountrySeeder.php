<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Countries to seed.
     * Each entry is keyed by its ISO 3166-1 alpha-2 code so updateOrCreate
     * can safely be re-run without creating duplicate rows.
     *
     * @var array<int, array<string, mixed>>
     */
    private const array COUNTRIES = [
        [
            'name'       => 'Zimbabwe',
            'code'       => 'zw',
            'domain'     => 'co.zw',
            'currency'   => 'USD',
            'flag_emoji' => '🇿🇼',
        ],
        [
            'name'       => 'South Africa',
            'code'       => 'za',
            'domain'     => 'co.za',
            'currency'   => 'ZAR',
            'flag_emoji' => '🇿🇦',
        ],
        [
            'name'       => 'Kenya',
            'code'       => 'ke',
            'domain'     => 'co.ke',
            'currency'   => 'KES',
            'flag_emoji' => '🇰🇪',
        ],
        [
            'name'       => 'Nigeria',
            'code'       => 'ng',
            'domain'     => 'co.ng',
            'currency'   => 'NGN',
            'flag_emoji' => '🇳🇬',
        ],
        [
            'name'       => 'Botswana',
            'code'       => 'bw',
            'domain'     => 'co.bw',
            'currency'   => 'BWP',
            'flag_emoji' => '🇧🇼',
        ],
        [
            'name'       => 'Zambia',
            'code'       => 'zm',
            'domain'     => 'co.zm',
            'currency'   => 'ZMW',
            'flag_emoji' => '🇿🇲',
        ],
    ];

    public function run(): void
    {
        DB::transaction(function (): void {
            foreach (self::COUNTRIES as $data) {
                Country::updateOrCreate(
                    ['code' => $data['code']],
                    [
                        'name'       => $data['name'],
                        'domain'     => $data['domain'],
                        'currency'   => $data['currency'],
                        'flag_emoji' => $data['flag_emoji'],
                        'is_active'  => true,
                    ]
                );
            }
        });

        $this->command->info('✅ CountrySeeder: ' . count(self::COUNTRIES) . ' countries seeded.');
    }
}
