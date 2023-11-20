<?php

namespace Database\Seeders\Dummy;

use App\Models\Master\Aspect\Aspect;
use App\Models\Master\Ict\IctObject;
use App\Models\Master\Org\OrgStruct;
use Illuminate\Database\Seeder;

class DummyAspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Administrasi',
            'Operasional',
            'Legal',
            'Keuangan',
            'Fungsional',
        ];

        $objects = OrgStruct::whereIn('level', ['division', 'branch', 'group'])->orderBy('level')->get();
        foreach ($data as $name) {
            foreach ($objects as $object) {
                Aspect::firstOrCreate([
                    'category' => 'operation',
                    'object_id' => $object->id,
                    'name' => $name
                ]);
                Aspect::firstOrCreate([
                    'category' => 'special',
                    'object_id' => $object->id,
                    'name' => $name
                ]);
            }
        }

        $objects = IctObject::has('ictType')->get();
        foreach ($data as $name) {
            foreach ($objects as $object) {
                Aspect::firstOrCreate([
                    'category' => 'ict',
                    'ict_object_id' => $object->id,
                    'name' => $name
                ]);
            }
        }
    }
}
