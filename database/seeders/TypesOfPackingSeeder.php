<?php

namespace Database\Seeders;

use App\Models\TypesOfPacking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypesOfPackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packingTypes = [
            ['name' => 'Small Box'],               // Small packing option
            ['name' => 'Medium Box'],              // A step up for slightly larger items
            ['name' => 'Large Box'],               // Standard larger packing
            ['name' => 'Extra Large Box'],         // For oversized items
            ['name' => 'Bulk Package'],            // For items shipped in bulk
            ['name' => 'Palletized Freight'],      // For shipping on pallets
            ['name' => 'Custom Size Package'],     // For items requiring custom packaging
            ['name' => 'ZARF (Zero Area Return Freight)'], // Specific packing type
            ['name' => 'Sample Package'],           // For samples or trial items
            ['name' => 'Gift Package'],             // For items intended as gifts
            ['name' => 'Eco-Friendly Packaging'],   // For environmentally conscious options
            ['name' => 'Fragile Package'],          // For delicate items requiring special care
        ];

        foreach ($packingTypes as $type) {
            TypesOfPacking::create($type);
        }
    }
}
