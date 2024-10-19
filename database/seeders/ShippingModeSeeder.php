<?php

namespace Database\Seeders;

use App\Models\ShippingMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippingModes = [
            ['name' => 'Domestic Air Freight'],
            ['name' => 'Domestic Road Freight'],
            ['name' => 'Rail Freight'],
            ['name' => 'Courier Services'],
            ['name' => 'Ocean Freight'],
            ['name' => 'Express Delivery Services'],
            ['name' => 'Freight Forwarding Services'],
            ['name' => 'Cold Chain Logistics'],
            ['name' => 'E-commerce Delivery Services'],
            ['name' => 'Cross-Border Shipping'],
        ];

        foreach ($shippingModes as $mode) {
            ShippingMode::create($mode);
        }
    }
}
