<?php

namespace App\Imports\Master;

use App\Models\Master\Ict\IctObject;
use App\Models\Master\Ict\IctType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class IctObjectImport implements ToCollection, WithStartRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // Validasi Template
        $row = $collection->first();
        if (empty($row[1]) || strtoupper($row[1]) != strtoupper('Nama Objek Audit TI')) {
            throw new \Exception("MESSAGE--File tidak tidak sesuai dengan template terbaru. Silahkan download template kembali!", 1);
        }

        // Maping Data
        foreach ($collection as $rw => $row) {
            if ($rw == 0) continue;

            $name     = trim($row[1] ?? '');
            $typeName = trim($row[2] ?? '');

            if (!empty($name) && !empty($typeName)) {
                // Check ictType
                $ictType = IctType::firstOrCreate(['name' => $typeName]);

                // Simpan Objek
                IctObject::firstOrCreate([
                    'name' => $name,
                    'ict_type_id' => $ictType->id,
                ]);
            }
        }

        return $collection;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 1;
    }
}
