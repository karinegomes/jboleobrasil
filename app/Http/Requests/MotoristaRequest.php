<?php

namespace App\Http\Requests;

class MotoristaRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required',
        ];
    }
}
