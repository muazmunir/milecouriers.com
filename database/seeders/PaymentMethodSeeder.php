<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            ['name' => 'Prepaid'],
            ['name' => 'Postpaid 15 day'],
            ['name' => 'Postpaid 30 day'],
            ['name' => 'Cash On Delivery'],
            ['name' => 'Online Transfer'],
            ['name' => 'Easypaisa'],
            ['name' => 'Jazzcash'],
            ['name' => 'Google Pay'],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
    }
}
