<?php

namespace App\Http\Requests;

class OrderRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'order.sell_date'       => 'required',
            'order.seller_id'       => 'required',
            'order.client_id'       => 'required',
            'item.product_id'       => 'required',
            'item.measure_id'       => 'required',
            'item.amount'           => 'required',
            'item.price'            => 'required',
            'item.package_id'       => 'required',
            'freight.incoterm_id'   => 'required',
            'detail.type'           => 'required',
            'detail.description'    => 'required'
        ];

        /*for($i = 0; $i < count($this['comissao']); $i++) {
            $rules['comissao.' . $i . '.valor'] = 'numeric';
        }*/

        for($i = 0; $i < count($this['paymethod']); $i++) {
            $rules['paymethod.' . $i . '.days'] = 'required|numeric';
            $rules['paymethod.' . $i . '.name'] = 'required';
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'order.sell_date'       => 'Data do Contrato',
            'order.seller_id'       => 'Vendedor',
            'order.client_id'       => 'Comprador',
            'item.product_id'       => 'Produto',
            'item.measure_id'       => 'Medida',
            'item.amount'           => 'Quantidade',
            'item.price'            => 'Preço',
            'item.package_id'       => 'Embalagem',
            'freight.incoterm_id'   => 'Modalidade',
            'detail.type'           => 'Detalhes',
            'detail.description'    => 'Descrição dos detalhes'
        ];

        for($i = 0; $i < count($this['comissao']); $i++) {
            $attributes['comissao.' . $i . '.valor'] = 'Valor da comissão';
        }

        for($i = 0; $i < count($this['paymethod']); $i++) {
            $attributes['paymethod.' . $i . '.days'] = 'Dias para Condição de Pagamento';
            $attributes['paymethod.' . $i . '.name'] = 'Detalhamento da Condição de Pagamento';
        }

        return $attributes;
    }
}
