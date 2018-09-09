<?php

namespace App\Http\Requests;

class OrdemDeFreteEmailRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'e-mail',
        ];
    }
}
