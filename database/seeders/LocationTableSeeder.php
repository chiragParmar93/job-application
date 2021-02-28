<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use DB;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('locations')->truncate();

        $data = [
            ['name' => 'Ahmedabad'],
            ['name' => 'Surat'],
            ['name' => 'Vadodara']
        ];

        foreach ($data as $value) {
            Location::create($value);
        }

    }
}
