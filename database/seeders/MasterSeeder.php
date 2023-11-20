<?php

namespace Database\Seeders;

use App\Models\Master\Coa\COA;
use App\Models\Master\Vendor\TypeVendor;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coas = [
            [
                'kode_akun' => '01.01',
                'nama_akun' => 'TANAH',
                'tipe_akun' => 'KIB A',
                'deskripsi' => null,
                'status'    => 2,
            ],
            [
                'kode_akun' => '01.01.01',
                'nama_akun' => 'PERKAMPUNGAN',
                'tipe_akun' => 'KIB A',
                'deskripsi' => null,
                'status'    => 2,
            ],
            [
                'kode_akun' => '01.01.01.01',
                'nama_akun' => 'kAMPUNG',
                'tipe_akun' => 'KIB A',
                'deskripsi' => null,
                'status'    => 2,
            ],
        ];

        foreach ($coas as $val) {
            $coa = new COA();
            $coa->kode_akun = $val['kode_akun'];
            $coa->nama_akun = $val['nama_akun'];
            $coa->tipe_akun = $val['tipe_akun'];
            $coa->deskripsi = $val['deskripsi'];
            $coa->status    = $val['status'];
            $coa->save();
        }
    }
}
