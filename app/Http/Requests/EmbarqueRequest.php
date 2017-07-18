<?php

namespace App\Http\Requests;

class EmbarqueRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'nota_fiscal'    => 'required',
            'quantidade'     => 'numeric|required',
            'data_embarque'  => 'date_format:d/m/Y',
            'data_pagamento' => 'date_format:d/m/Y'
        ];

        for($i = 0; $i < count($this['desconto']); $i++) {
            if($this['desconto'][$i]['tipo'] == 'peso') {
                $rules['desconto.' . $i . '.valor'] = 'numeric|max:' . $this['quantidade'];
            }
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'data_embarque'  => 'data do embarque',
            'data_pagamento' => 'data prevista para pagamento'
        ];

        for($i = 0; $i < count($this['desconto']); $i++) {
            if($this['desconto'][$i]['tipo'] == 'peso') {
                $attributes['desconto.' . $i . '.valor'] = 'desconto';
            }
        }

        return $attributes;
    }

    public function all()
    {
        $all = array_replace_recursive($this->input(), $this->allFiles());

        $all['quantidade'] = str_replace('.', '', $all['quantidade']);
        $all['quantidade'] = str_replace(',', '.', $all['quantidade']);

        for($i = 0; $i < count($all['desconto']); $i++) {
            $all['desconto'][$i]['valor'] = str_replace(',', '.', str_replace('.', '', $all['desconto'][$i]['valor']));
        }

        return $all;
    }
}
