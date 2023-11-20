<?php

namespace Database\Seeders;

use App\Models\Master\Org\OrgStruct;
use Illuminate\Database\Seeder;

class OrgStructSeeder extends Seeder
{
    public function run()
    {
        $structs = [
            // type => 1:presdir, 2:direktur, 3:ia department, 4:it department
            // Level Root
            [
                'level'         => 'root',
                'name'          => config('base.company.name'),
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'email'         => config('base.company.email'),
                'website'       => config('base.company.website'),
                'code'          => 1001,
                'code_manual'   => NULL,
                'type'          => 0,
                'city_id'       => 183,
            ],
            // Level BOD
            [
                'level'         => 'bod',
                'name'          => 'Direksi',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 1001,
                'code'          => 1011,
                'code_manual'   => '01',
                'type'          => 1,
            ],
            // Level Departemen
            [
                'level'         => 'department',
                'name'          => 'Bidang Penunjang Medik dan Non Medik',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 1011,
                'code'          => 2001,
                'code_manual'   => '0601',
                'type'          => 3,
            ],
            [
                'level'         => 'department',
                'name'          => 'Bidang Pelayanan Medik dan Keparawatan',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 1011,
                'code'          => 2002,
                'code_manual'   => '0602',
                'type'          => 0,
            ],
            [
                'level'         => 'department',
                'name'          => 'Bagian Tata Usaha',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 1011,
                'code'          => 2003,
                'code_manual'   => '0603',
                'type'          => 0,
            ],
            [
                'level'         => 'department',
                'name'          => 'Bidang Pengembangan Sumber Daya Manusia dan Kemuhamasan',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 1011,
                'code'          => 2004,
                'code_manual'   => '0801',
                'type'          => 3,
            ],
            // subdepartment
            [
                'level'         => 'subdepartment',
                'name'          => 'Seksi Penunjang Medik dan Non Medik',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 2001,
                'code'          => 3001,
                'code_manual'   => '060101',
                'type'          => 0,
            ],
            [
                'level'         => 'subdepartment',
                'name'          => 'Seksi Sarana dan Prasarana Logistik',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 2001,
                'code'          => 3002,
                'code_manual'   => '060102',
                'type'          => 0,
            ],
            [
                'level'         => 'subdepartment',
                'name'          => 'Seksi Pelayanan Medik',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 2002,
                'code'          => 3003,
                'code_manual'   => '060103',
                'type'          => 0,
            ],
            [
                'level'         => 'subdepartment',
                'name'          => 'Seksi Pelayanan Keperawatan',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 2002,
                'code'          => 3004,
                'code_manual'   => '060104',
                'type'          => 0,
            ],
            [
                'level'         => 'subdepartment',
                'name'          => 'Sub Bagian Program Perencanaan dan Pelaporan',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 2003,
                'code'          => 3005,
                'code_manual'   => '060105',
                'type'          => 0,
            ],
            [
                'level'         => 'subdepartment',
                'name'          => 'Sub Bagian Keuangan',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 2003,
                'code'          => 3006,
                'code_manual'   => '060106',
                'type'          => 0,
            ],
            [
                'level'         => 'subdepartment',
                'name'          => 'Sub Bagian Umum dan Kepegawaian',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 2003,
                'code'          => 3007,
                'code_manual'   => '060107',
                'type'          => 0,
            ],
        ];

        $this->generate($structs);
    }

    public function generate($structs)
    {
        ini_set("memory_limit", -1);

        foreach ($structs as $val) {
            $struct = OrgStruct::firstOrNew(['code' => $val['code']]);
            $struct->level   = $val['level'];
            $struct->name    = $val['name'];
            $struct->type    = $val['type'] ?? 0;
            $struct->phone   = $val['phone'] ?? null;
            $struct->address = $val['address'] ?? null;
            $struct->email   = $val['email'] ?? null;
            $struct->website = $val['website'] ?? null;
            $struct->city_id = $val['city_id'] ?? null;
            $struct->code_manual = $val['code_manual'] ?? null;
            if (!empty($val['parent_code'])) {
                if ($parent = OrgStruct::where('code', $val['parent_code'])->first()) {
                    $struct->parent_id = $parent->id;
                }
            }
            $struct->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
