<?php

namespace App\Http\Requests\Master\Org;

use App\Http\Requests\FormRequest;

class RootRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'    => 'required|string|max:255|unique:ref_org_structs,name,'.$id.',id,level,root',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string',
        ];

        return $rules;
    }
}
