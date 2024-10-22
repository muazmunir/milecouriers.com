<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            DeliveryTimeSeeder::class,
            PaymentMethodSeeder::class,
            ShippingModeSeeder::class,
            TypesOfPackingSeeder::class,
            ServiceModeSeeder::class,
            RegionSeeder::class,
            SubRegionSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class
        ]);
    }
}
