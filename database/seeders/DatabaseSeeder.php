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
        // Geo
        $this->call(ProvinceTableSeeder::class);
        $this->call(CityTableSeeder::class);

        $this->call(OrgStructSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(MasterSeeder::class);

    }
}
