<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class UpdateCompanyRequest extends Request {
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
        $company = $this->route('company');

        return [
            'company.codigo' => 'required|max:4|unique:companies,codigo,' . $company->id,
            'company.name' => 'required|max:100',
            'company.nome_fantasia' => 'required|max:100',
            'company.registry' => 'bail|max:25|cnpj|unique:companies,companies.registry,' . $company->id,
            'company.cpf' => 'max:14|cpf',
            'company.nome_contato' => 'max:100',
            'company.telefone' => 'max:45',
            'company.caixa_postal' => 'max:45',
            'address.zip_code' => 'numeric',
        ];
    }

    public function messages() {
        return [
            'company.codigo.required' => 'É necessário inserir um código para o cliente.',
            'company.codigo.max' => 'O código do cliente não pode ultrapassar 4 dígitos.',
            'company.codigo.unique' => 'O código informado já está sendo utilizado.',
            'company.name.required' => 'É necessário inserir um nome para o cliente.',
            'company.name.max' => 'O nome do cliente não pode ultrapassar 100 caracteres.',
            'company.nome_fantasia.required' => 'É necessário inserir um nome fantasia para o cliente.',
            'company.nome_fantasia.max' => 'O nome fantasia do cliente não pode ultrapassar 100 caracteres.',
            'company.registry.required_without' => 'É necessário inserir um documento para o cliente (CNPJ ou CPF).',
            'company.registry.max' => 'O CNPJ do cliente não pode ultrapassar 25 caracteres.',
            'company.registry.cnpj' => 'CNPJ inválido.',
            'company.registry.unique' => 'CNPJ já utilizado, por favor insira outro.',
            'address.city_id.required' => 'É necessário selecionar uma cidade o cliente.',
            'address.zip_code.numeric' => 'Apenas números são permitidos no campo de CEP.',
            'company.nome_contato.max' => 'O nome do contato não pode ultrapassar 100 caracteres.',
            'company.telefone.max' => 'O telefone não pode ultrapassar 45 caracteres.',
            'company.caixa_postal.max' => 'A caixa postal não pode ultrapassar 45 caracteres.',
        ];
    }
}
