<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/states.json');

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
            State::insert([
                'id' => $state['id'],
                'name' => $state['name'],
                'country_id' => $state['country_id'],
                'state_code' => $state['state_code'] ?? null,
                'latitude' => $state['latitude'] ?? null,
                'longitude' => $state['longitude'] ?? null,
            ]);
        }
    }
}
