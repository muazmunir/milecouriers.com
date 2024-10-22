<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/countries.json');
        
        // Check if the JSON file exists
        if (!File::exists($jsonPath)) {
            $this->command->error("The file {$jsonPath} does not exist.");
            return;
        }

        // Read the JSON file
        $json = File::get($jsonPath);
        $countries = json_decode($json, true);

        // Loop through the countries and insert them into the database
        foreach ($countries as $country) {
            // dd($country);
            DB::table('countries')->insert([
                'id' => $country['id'],
                'name' => $country['name'],
                'iso3' => $country['iso3'],
                'numeric_code' => $country['numeric_code'],
                'iso2' => $country['iso2'],
                'phone_code' => $country['phone_code'], // Ensure this matches your JSON field
                'capital' => $country['capital'],
                'currency' => $country['currency'],
                'currency_name' => $country['currency_name'],
                'currency_symbol' => $country['currency_symbol'],
                'tld' => $country['tld'],
                'native' => $country['native'],
                'region_id' => $country['region_id'] ?? null, // Handle region_id if present
                'subregion_id' => $country['subregion_id'] ?? null, // Handle subregion_id if present
                'nationality' => $country['nationality'],
                'timezones' => json_encode($country['timezones']), // Convert array to JSON
                'translations' => json_encode($country['translations']), // Convert array to JSON
                'latitude' => $country['latitude'],
                'longitude' => $country['longitude'],
                'emoji' => $country['emoji'] ?? null,
                'emojiU' => $country['emojiU'] ?? null,
            ]);
        }

        // $this->command->info('Countries table seeded successfully.');
    }
}
