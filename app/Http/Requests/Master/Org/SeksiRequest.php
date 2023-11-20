<?php

namespace App\Http\Requests\Master\Org;

use App\Http\Requests\FormRequest;

class SeksiRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'parent_id' => 'required|exists:ref_org_structs,id',
            'code_manual'  => 'required|unique:ref_org_structs,code_manual,'.$id.',id',
            'name'      => 'required|string|max:255|unique:ref_org_structs,name,'.$id.',id,parent_id,'.$this->parent_id.',level,seksi',
        ];

        return $rules;
    }
}
