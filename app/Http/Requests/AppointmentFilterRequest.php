<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class AppointmentFilterRequest extends Request {

    public function authorize(){
        return true;
    }


    public function rules(){
        return [
            'cliente' => 'required',
            'data_inicial' => 'required',
            'data_final' => 'required'
        ];
    }

    public function messages(){
        return [
            'cliente.required' => 'É necessário selecionar um cliente.',
            'data_inicial.required' => 'É necessário informar a data inicial.',
            'data_final.required' => 'É necessário informar a data final.'
        ];
    }
}
