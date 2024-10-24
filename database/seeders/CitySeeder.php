<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/cities.json');

        // Check if the JSON file exists
        if (! File::exists($jsonPath)) {
            $this->command->error("The file {$jsonPath} does not exist.");

            return;
        }

        // Read the JSON file
        $json = File::get($jsonPath);
        $states = json_decode($json, true);

        // Loop through the states and insert them into the database
        foreach ($states as $state) {
            City::insert([
                'id' => $state['id'],
                'name' => $state['name'],
                'state_id' => $state['state_id'],
                'country_id' => $state['country_id'],
                'latitude' => $state['latitude'] ?? null,
                'longitude' => $state['longitude'] ?? null,
            ]);
        }
    }
}
