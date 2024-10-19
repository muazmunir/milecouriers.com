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
            CountrySeeder::class,
            CurrencySeeder::class,
            SettingSeeder::class,
            TimezoneSeeder::class,
            UserSeeder::class,
            DeliveryTimeSeeder::class,
            PaymentMethodSeeder::class,
            ShippingModeSeeder::class,
            TypesOfPackingSeeder::class,
            ServiceModeSeeder::class,
        ]);
    }
}
