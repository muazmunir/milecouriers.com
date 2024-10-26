<?php

namespace Database\Seeders;

use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\User;
use App\Models\DeliveryStatus;
use App\Models\DeliveryTime;
use App\Models\PaymentMethod;
use App\Models\ServiceMode;
use App\Models\ShippingMode;
use App\Models\TypesOfPacking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch necessary data
        $deliveryTimes = DeliveryTime::all()->pluck('id');
        $paymentMethods = PaymentMethod::all()->pluck('id');
        $shippingModes = ShippingMode::all()->pluck('id');
        $serviceModes = ServiceMode::all()->pluck('id');
        $deliveryStatuses = DeliveryStatus::all()->pluck('id');
        $typesOfPacking = TypesOfPacking::all()->pluck('id');
        
        // Ensure we have at least one driver
        $driver = User::where('type', 2)->inRandomOrder()->first();
        if (!$driver) {
            $driver = User::factory()->create(['type' => 2]); // Create a driver if none exists
        }

        // Generate shipments
        foreach (range(1, 50) as $i) {
            $shipment = Shipment::create([
                'shipment_number' => 'SHIP-' . strtoupper(uniqid()),
                'sender_id' => User::inRandomOrder()->first()->id,
                'recipient_id' => User::inRandomOrder()->first()->id,
                'origin_address' => 'Origin Address ' . $i,
                'destination_address' => 'Destination Address ' . $i,
                'status_id' => $deliveryStatuses->random(),
                'delivery_time_id' => $deliveryTimes->random(),
                'payment_method_id' => $paymentMethods->random(),
                'shipping_mode_id' => $shippingModes->random(),
                'service_mode_id' => $serviceModes->random(),
                'driver_id' => $driver->id, // Use the driver we ensured exists
                'shipment_date' => now(),
            ]);

            // Add associated items to the shipment
            foreach (range(1, rand(1, 3)) as $j) {
                ShipmentItem::create([
                    'shipment_id' => $shipment->id,
                    'description' => 'Item Description ' . $j,
                    'type_of_packaging_id' => $typesOfPacking->random(),
                    'weight' => rand(1, 100),
                    'length' => rand(1, 50),
                    'width' => rand(1, 50),
                    'height' => rand(1, 50),
                    'declared_value' => rand(100, 1000),
                ]);
            }
        }
    }
}
