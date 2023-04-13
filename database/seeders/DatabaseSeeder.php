<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\ATG\Database\Seeders\ATGDatabaseSeeder;
use Modules\Jitera\Database\Seeders\JiteraDatabaseSeeder;

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

            JiteraDatabaseSeeder::class,
            ATGDatabaseSeeder::class
        ]);
    }
}
