<?php

namespace Database\Seeders;

use App\Models\Master\Geografis\City;
use App\Models\Master\Geografis\District;
use File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File as FacadesFile;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/seeders/json/district.json');
        $json = FacadesFile::get($path);
        $data = json_decode($json);

        // $this->command->getOutput()->progressStart(count($data));
        $this->generate($data);
        // $this->command->getOutput()->progressFinish();
    }

    public function generate($data)
    {
        foreach ($data as $val) {
            $city = City::where('code', $val->city_id)->first();
            $kec = District::where('code', $val->id)
                ->first();
            if (!$kec) {
                $kec = new District;
                $kec->code = $val->id;
                $kec->city_id = $city->id;
                $kec->name = $val->name;
                $kec->created_by = $val->created_by;
                $kec->created_at = \Carbon\Carbon::now();
                $kec->save();
            }
            // $this->command->getOutput()->progressAdvance();
        }
    }
}
