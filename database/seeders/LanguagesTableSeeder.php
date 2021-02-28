<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('languages')->truncate();

        $data = [
            ['name' => 'Hindi'],
            ['name' => 'English'],
            ['name' => 'Gujrati']
        ];

        foreach ($data as $value) {
            Language::create($value);
        }
    }
}
