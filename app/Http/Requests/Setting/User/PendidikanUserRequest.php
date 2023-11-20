<?php

namespace App\Http\Requests\Setting\User;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rules\Password;

class PendidikanUserRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'jenjang_pendidikan'        => 'required',
            'thn_lulus'       => 'required',
            'institute'      => 'required',
        ];
        return $rules;
    }
}
