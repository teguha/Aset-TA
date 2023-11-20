<?php

namespace Database\Seeders\Dummy;

use App\Models\Master\Aspect\Aspect;
use App\Models\Master\Document\DocumentItem;
use Illuminate\Database\Seeder;

class DummyDocumentItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Rekapitulasi Kas Besar',
            'Laporan Suspend Account (Confins).',
            'Rekening Koran Bank Incoming.',
            'Kuitansi Kasir dan Tanda Terima (TT).',
            'Slip Setoran Bank.',
            'Laporan Pemeriksaan Fisik Uang Tunai Harian Kas Besar.',
            'Rekapitulasi Kas/Bank Incoming (Confins).',
            'Rekening Koran Bank Incoming Cabang',
            'Laporan Transaksi Harian Kas Kecil.',
            'Formulir Permohonan Pengeluaran Biaya dan Bukti Pengeluaran Kas Kecil.',
            'Laporan Pemeriksaan Fisik Uang Tunai Harian Kas Kecil.',
            'Rekening Koran Petty Cash.',
        ];

        $aspects = Aspect::get();
        foreach ($aspects as $aspect) {
            for ($i=rand(0, count($data)-1); $i < count($data); $i++) { 
                DocumentItem::firstOrCreate([
                    'aspect_id' => $aspect->id,
                    'name' => $data[$i],
                ], [
                    'description' => 'Data 3 bulan terakhir.'
                ]);
            }
        }
    }
}
