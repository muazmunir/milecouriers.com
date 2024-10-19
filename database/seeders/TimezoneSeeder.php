<?php

namespace Database\Seeders;

use App\Models\Timezone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimezoneSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timeZones = timezone_identifiers_list();

        $data = [];
        foreach ($timeZones as $timeZone) {
            $dateTimeZone = new \DateTimeZone($timeZone);
            $offset = $dateTimeZone->getOffset(new \DateTime());

            $data[] = [
                'name' => $timeZone,
                'code' => $this->getTimeZoneCode($offset),
            ];
        }

        Timezone::insert($data);
    }

    private function getTimeZoneCode($offset)
    {
        $offset = $offset / 3600; // Convert offset to hours

        if ($offset >= 0) {
            $offset = '+'.str_pad($offset, 2, '0', STR_PAD_LEFT);
        } else {
            $offset = '-'.str_pad(abs($offset), 2, '0', STR_PAD_LEFT);
        }

        return $offset;
    }
}
