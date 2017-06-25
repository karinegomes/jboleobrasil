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
            'agrosd'         => 'numeric',
            'silas'          => 'numeric',
            'dayane'         => 'numeric'
        ];
    }

    public function attributes()
    {
        return [
            'data_pagamento' => 'data do pagamento',
            'agrosd' => 'AgroSD',
            'silas' => 'Silas',
            'dayane' => 'Dayane'
        ];
    }

    public function all()
    {
        $all = array_replace_recursive($this->input(), $this->allFiles());

        $all['valor']  = str_replace(',', '.', str_replace('.', '', $all['valor']));
        $all['agrosd'] = str_replace(',', '.', str_replace('.', '', $all['agrosd']));
        $all['silas']  = str_replace(',', '.', str_replace('.', '', $all['silas']));
        $all['dayane'] = str_replace(',', '.', str_replace('.', '', $all['dayane']));

        return $all;
    }
}
