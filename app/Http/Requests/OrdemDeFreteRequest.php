<?php

namespace App\Http\Requests;

class OrdemDeFreteRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cidade_origem'     => 'required',
            'cidade_destino'    => 'required',
            'valor_frete'       => 'required|numeric',
            'peso'              => 'required|numeric',
            'measure_id'        => 'required',
            'adiantamento'      => 'required|numeric',
            'saldo'             => 'required|numeric',
            'data_carregamento' => 'required|date_format:d/m/Y',
            'previsao_descarga' => 'required|date_format:d/m/Y',
            'motorista_id'      => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'cidade_origem'     => 'cidade de origem',
            'cidade_destino'    => 'cidade de destino',
            'valor_frete'       => 'valor do frete',
            'measure_id'        => 'medida',
            'data_carregamento' => 'data do carregamento',
            'previsao_descarga' => 'previsão de descarga',
            'motorista_id'      => 'motorista',
        ];
    }
}
