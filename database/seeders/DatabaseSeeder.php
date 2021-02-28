<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminUserTableSeeder::class,
            LocationTableSeeder::class,
            ExperienceTableSeeder::class,
            LanguagesTableSeeder::class,
        ]);
    }
}
