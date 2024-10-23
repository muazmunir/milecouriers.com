<?php

namespace Database\Seeders;

use App\Models\DeliveryStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Pending'],
            ['name' => 'Processing'],
            ['name' => 'Shipped'],
            ['name' => 'Out for Delivery'],
            ['name' => 'Delivered'],
            ['name' => 'Returned'],
            ['name' => 'Cancelled'],
            ['name' => 'Failed'],
        ];

        foreach ($statuses as $status) {
            DeliveryStatus::create($status);
        }
    }
}
