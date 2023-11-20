<?php

namespace App\Http\Requests\Setting\User;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rules\Password;

class SertifikasiUserRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'nama_sertif'        => 'required',
            'no_sertif'       => 'required',
            'tgl_sertif'      => 'required',
            'lembaga'      => 'required',

        ];
        return $rules;
    }
}
