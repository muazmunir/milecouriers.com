<?php

namespace Database\Seeders;

use App\Models\DeliveryTime;
use Illuminate\Database\Seeder;

class DeliveryTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveryTimes = [
            ['delivery_time' => 'Same Day Delivery'],
            ['delivery_time' => 'Next Day Delivery'],
            ['delivery_time' => '24 Hours'],
            ['delivery_time' => '48 Hours'],
            ['delivery_time' => '2 - 3 Days'],
            ['delivery_time' => '3 - 5 Days'],
            ['delivery_time' => '5 - 7 Days'],
            ['delivery_time' => '7 - 10 Days'],
            ['delivery_time' => '10 - 14 Days'],
            ['delivery_time' => '2 Weeks'],
            ['delivery_time' => '3 Weeks'],
            ['delivery_time' => 'Over 3 Weeks'],
        ];

        // Insert delivery times into the database
        foreach ($deliveryTimes as $time) {
            DeliveryTime::create($time);
        }
    }
}
