<?php

namespace Database\Seeders;

use App\Models\Master\Geografis\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::insert([
            [
                'province_id' => 1,
                'name' => 'Krian',
                'code' => 'C001',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'province_id' => 2,
                'name' => 'Sidomulyo',
                'code' => 'C002',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
