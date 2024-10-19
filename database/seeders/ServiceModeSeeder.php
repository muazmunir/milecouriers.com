<?php

namespace Database\Seeders;

use App\Models\ServiceMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceModes = [
            ['name' => 'Same Day'],
            ['name' => 'Next Day'],
            ['name' => 'After 2 Days'],
            ['name' => 'After 3 Days'],
            ['name' => 'After 4 Days'],
            ['name' => 'After 5 Days'],
            ['name' => 'After 6 Days'],
            ['name' => 'After 7 Days'],
            ['name' => 'After 8 Days'],
            ['name' => 'After 9 Days'],
            ['name' => 'After 10 Days'],
            ['name' => 'After 11 Days'],
            ['name' => 'After 12 Days'],
            ['name' => 'After 13 Days'],
            ['name' => 'After 14 Days'],
            ['name' => 'After 15 Days'],
            ['name' => 'After 16 Days'],
            ['name' => 'After 17 Days'],
            ['name' => 'After 18 Days'],
            ['name' => 'After 19 Days'],
            ['name' => 'After 20 Days'],
            ['name' => 'After 21 Days'],
            ['name' => 'After 22 Days'],
            ['name' => 'After 23 Days'],
            ['name' => 'After 24 Days'],
            ['name' => 'After 25 Days'],
            ['name' => 'After 26 Days'],
            ['name' => 'After 27 Days'],
            ['name' => 'After 28 Days'],
            ['name' => 'After 29 Days'],
            ['name' => 'After 30 Days'],
            ['name' => 'After 31 Days'],
        ];

        foreach ($serviceModes as $mode) {
            ServiceMode::create($mode);
        }
    }
}
