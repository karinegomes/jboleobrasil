<?php

namespace App\Http\Requests;

class BaixaRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'data_pagamento' => 'required|date_format:d/m/Y',
            'valor'          => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'data_pagamento' => 'data do pagamento',
        ];
    }

    public function all()
    {
        $all = array_replace_recursive($this->input(), $this->allFiles());

        $all['valor']  = str_replace(',', '.', str_replace('.', '', $all['valor']));

        return $all;
    }
}
