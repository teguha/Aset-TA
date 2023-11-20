<?php

namespace App\Http\Requests\Master\Geografis;

use App\Http\Requests\FormRequest;

class DistrictRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        
        $rules = [
            'name' => 'required|string|max:255|unique:ref_city,name,' . $id,
            'code' => 'required|string|max:255|unique:ref_city,code,' . $id,
            'city_id' => 'required|numeric',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Kecamatan',
            'code' => 'Kode',
            'city_id' => 'Kota/Kabupaten'
        ];
    }
}