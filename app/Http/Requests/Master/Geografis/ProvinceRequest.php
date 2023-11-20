<?php

namespace App\Http\Requests\Master\Geografis;

use App\Http\Requests\FormRequest;

class ProvinceRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        
        $rules = [
            'name' => 'required|string|max:255|unique:ref_province,name,' . $id,
            'code' => 'required|string|max:255|unique:ref_province,code,'. $id
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Provinsi',
            'code' => 'Kode'
        ];
    }
}