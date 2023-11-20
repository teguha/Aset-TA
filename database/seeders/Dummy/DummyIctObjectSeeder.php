<?php

namespace Database\Seeders\Dummy;

use App\Models\Master\Ict\IctType;
use Illuminate\Database\Seeder;

class DummyIctObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Core System' => [
                'Core System (CONFINS)',
                'Core System (EGL)',
                'Core System Aplikasi Human Capital Information System (HRIS',
            ],
            'Support System' => [
                'Support System (Website)',
                'Support System (Mail Server)',
                'Support System (KPM - Kredit Pasti Mudah)',
                'General Computer Control I - System Development & Acquisition dan Disaster Recovery Plan',
                'General Computer Control II – End User Computing Management',
            ]
        ];

        foreach ($data as $key => $values) {
            $type = IctType::firstOrCreate(['name' => $key]);
            foreach ($values as $val) {
                $type->ictObject()->firstOrCreate(['name' => $val]);
            }
        }
    }
}
