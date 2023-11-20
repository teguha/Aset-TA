<?php

namespace Database\Seeders;

use App\Models\Master\Org\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $position = [
            [
                "location_id" => 8,
                "name" => "Kepala SPI",
                "code" => 1001,
                "level_id" => 1,
            ],
            [
                "location_id" => 15,
                "name" => "Kepala Seksi Audit Khusus",
                "code" => 1002,
                "level_id" => 2,
            ],
            [
                "location_id" => 15,
                "name" => "Staf Audit Khusus",
                "code" => 1003,
                "level_id" => 3,
            ],
            [
                "location_id" => 14,
                "name" => "Kepala Seksi Audit Operasional",
                "code" => 1004,
                "level_id" => 2,
            ],
            [
                "location_id" => 14,
                "name" => "Staf Audit Operasional",
                "code" => 1005,
                "level_id" => 3,
            ],
            [
                "location_id" => 9,
                "name" => "Manajer Sekretaris Perusahaan",
                "code" => 1008,
                "level_id" => 4,
            ],
            [
                "location_id" => 12,
                "name" => "Manajer Sumber Daya Manusia",
                "code" => 1009,
                "level_id" => 4,
            ],
        ];

        $this->generate($position);
    }

    public function generate($position)
    {
        ini_set("memory_limit", -1);

        foreach ($position as $val) {
            $position              = Position::firstOrNew(['code' => $val['code']]);
            $position->location_id = $val['location_id'] ?? NULL;
            $position->nonpkpt_id = $val['nonpkpt_id'] ?? NULL;
            $position->name        = $val['name'];
            $position->level_id        = $val['level_id'] ?? NULL;
            $position->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
