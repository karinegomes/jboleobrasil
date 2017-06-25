<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class StoreProductRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $productId = $this->route('product');

        $rules = [
            'product.name' => 'required|max:255',
            'product.codigo' => 'required|max:45|unique:products,codigo,' . $productId
        ];

        if($this->has('specs')) {
            foreach($this['specs'] as $key => $spec) {
                $rules['specs.' . $key . '.name'] = 'required';
                $rules['specs.' . $key . '.value'] = 'required';
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'product.name.required' => 'É necessário inserir um nome para o produto.',
            'product.name.max' => 'O nome do produto não pode ultrapassar 255 caracteres.',
            'product.codigo.required' => 'É necessário inserir um código para o produto.',
            'product.codigo.max' => 'O código do produto não pode ultrapassar 45 caracteres.',
            'product.codigo.unique' => 'O código do produto já está sendo utilizado.'
        ];

        if($this->has('specs')) {
            foreach($this['specs'] as $key => $spec) {
                $messages['specs.' . $key . '.name.required'] = 'É necessário inserir um nome para a especificação.';
                $messages['specs.' . $key . '.value.required'] = 'É necessário inserir um valor para a especificação.';
            }
        }

        return $messages;
    }
}
