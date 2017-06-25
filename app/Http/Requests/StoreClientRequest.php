<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class StoreClientRequest extends Request {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        $validacaoEmail = 'max:255|email';

        if($this->number == '' && $this->mobile_number == '') {
            $validacaoEmail .= '|required';
        }

        return [
            'name' => 'required|max:255',
            'ddd' => 'numeric|digits:2',
            'number' => 'between:8,10',
            'mobile_ddd' => 'numeric|digits:2',
            'mobile_number' => 'between:8,10',
            'email' => $validacaoEmail,
            array('telefone_adicional_ddd' => 'numeric|digits:2|required'),
            array('telefone_adicional' => 'between:8,10|required'),
            array('telefone_adicional_ddd_salvo' => 'numeric|digits:2|required'),
            array('telefone_adicional_salvo' => 'between:8,10|required')
        ];
    }

    public function messages() {
        return [
            'name.required' => 'É necessário inserir um nome para o contato.',
            'name.max' => 'O nome do contato não pode ultrapassar 255 caracteres.',
            'ddd.numeric' => 'O DDD do contato deve conter apenas números.',
            'ddd.digits' => 'O DDD do contato não pode ultrapassar 2 caracteres.',
            'number.digits' => 'O telefone do contato deve conter entre 8 e 10 caracteres.',
            'mobile_ddd.numeric' => 'O DDD do celular deve conter apenas números.',
            'mobile_ddd.digits' => 'O DDD do celular não pode ultrapassar 2 caracteres.',
            'mobile_number.numeric' => 'O celular do contato deve conter apenas números.',
            'mobile_number.digits' => 'O celular do contato deve conter entre 8 e 10 caracteres.',
            'email.required' => 'Por favor, digite uma forma de contato (telefone ou e-mail).',
            'email.max' => 'O e-mail do contato não pode ultrapassar 255 caracteres.',
            'email.email' => 'Digite um e-mail válido para o contato.',
            'telefone_adicional_ddd[].numeric' => 'O DDD do contato deve conter apenas números.',
            'telefone_adicional_ddd[].digits' => 'O DDD do contato não pode ultrapassar 2 caracteres.',
            'telefone_adicional_ddd[].required' => 'É necessário inserir um DDD para o contato.',
            'telefone_adicional[].between' => 'O telefone do contato deve conter entre 8 e 10 caracteres.',
            'telefone_adicional[].required' => 'É necessário inserir um número de telefone para o contato.'
        ];
    }
}
