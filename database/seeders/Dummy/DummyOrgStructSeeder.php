<?php

namespace Database\Seeders\Dummy;

use App\Models\Master\Org\OrgStruct;
use App\Models\Master\Org\Position;
use Illuminate\Database\Seeder;

class DummyOrgStructSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $structs = [
            // Bod
            'bod' => [
                ['name' => 'Direktur Pemasaran'],
                ['name' => 'Direktur Umum'],
                ['name' => 'Direktur Kepatuhan'],
            ],
            // Division
            'division' => [
                ['name' => 'Divisi Manajemen Risiko dan Kepatuhan', 'parent' => 'Direktur Kepatuhan'],
                ['name' => 'Divisi Trisuri', 'parent' => 'Direktur Kepatuhan'],
                ['name' => 'Divisi Teknologi Informasi', 'parent' => 'Direktur Umum'],
                ['name' => 'Divisi Sumber Daya Manusia dan Umum', 'parent' => 'Direktur Umum'],
                ['name' => 'Divisi Perencanaan dan Pengembangan', 'parent' => 'Direktur Pemasaran'],
                ['name' => 'Divisi Perkreditan', 'parent' => 'Direktur Pemasaran'],
            ],
            // Branch
            // 'branch' => [
            //     [
            //         'name'=>'Cabang Utama',
            //         'phone'=>'(0274) 561614',
            //         'address'=>'Jl. Tentara Pelajar No. 7 Yogyakarta',
            //     ],[
            //         'name'=>'Cabang Sleman',
            //         'phone'=>'(0274) 868866',
            //         'address'=>'Jl. Magelang km 11 Tridadi, Sleman',
            //     ],[
            //         'name'=>'Cabang Bantul',
            //         'phone'=>'(0274) 367011',
            //         'address'=>'Jl. Jendral Sudirman No. 2A Bantul',
            //     ],[
            //         'name'=>'Cabang Wates',
            //         'phone'=>'(0274) 773352',
            //         'address'=>'Jl. Stasiun No.1 Wates',
            //     ],[
            //         'name'=>'Cabang Wonosari',
            //         'phone'=>'(0274) 391801',
            //         'address'=>'Jl. Brigjend Katamso 4, Wonosari',
            //     ],[
            //         'name'=>'Cabang Senopati',
            //         'phone'=>'(0274) 562395',
            //         'address'=>'Jl. Panembahan Senopati No.5-7, Yogyakarta',
            //     ],[
            //         'name'=>'Kantor Cabang Syariah',
            //         'phone'=>'(0274) 550740',
            //         'address'=>'Jl. Magelang Km.5,6 Kutu Tegal, Sinduadi, Mlati',
            //     ],
            // ],
        ];

        if ($presdir = OrgStruct::presdir()->first()) {
            foreach ($structs as $level => $values) {
                foreach ($values as $val) {
                    if (!empty($val['parent']) && OrgStruct::where('name', $val['parent'])->exists()) {
                        $parent = OrgStruct::where('name', $val['parent'])->first();
                    } else {
                        $parent = $presdir;
                    }

                    $parent->child()
                        ->firstOrCreate([
                            'level' => $level,
                            'name' => $val['name'],
                        ], [
                            'code' => (new OrgStruct)->getNewCode($level),
                            'phone' => $val['phone'] ?? $presdir->phone,
                            'address' => $val['address'] ?? $presdir->address,
                        ]);
                }
            }

            // Group
            $group = OrgStruct::firstOrCreate([
                'level' => 'group',
                'name' => 'Corporate Social Responsibility (CSR)'
            ], [
                'code' => (new OrgStruct)->getNewCode($level),
                'phone' => $presdir->phone,
                'address' => $presdir->address,
            ]);
            $group->childOfGroup()->sync(OrgStruct::division()->where('type', 0)->limit(3)->pluck('id')->toArray());
        }
    }
}
