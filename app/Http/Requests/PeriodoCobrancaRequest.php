<?php

namespace App\Http\Requests;

class PeriodoCobrancaRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'min_date' => 'required|date_format:d/m/Y',
            'max_date' => 'required|date_format:d/m/Y',
            'nome'     => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'min_date' => 'data mínima',
            'max_date' => 'data máxima'
        ];
    }
}
