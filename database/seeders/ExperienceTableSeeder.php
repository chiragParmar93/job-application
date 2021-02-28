<?php

namespace Database\Seeders;

use App\Models\Experience;
use DB;
use Illuminate\Database\Seeder;

class ExperienceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('experiences')->truncate();

        $data = [
            ['name' => 'PHP'],
            ['name' => 'Mysql'],
            ['name' => 'Laravel'],
            ['name' => 'React'],
        ];

        foreach ($data as $value) {
            Experience::create($value);
        }

    }
}
