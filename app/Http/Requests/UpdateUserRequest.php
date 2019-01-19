<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class UpdateUserRequest extends Request
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
        $userId = $this->route('user');
        $emailRule = 'bail|required|email|max:255|unique:users,email';

        if ($userId) {
            $emailRule .= ','.$userId;
        }

        return [
            'name' => 'required|max:255',
            'email' => $emailRule,
            'signature' => 'file|image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'É necessário inserir um nome para o usuário.',
            'name.max' => 'O nome do usuário não pode ultrapassar 255 caracteres.',
            'password.digits_between' => 'Digite uma senha contendo entre 6 e 15 caracteres.',
            'email.required' => 'É necessário inserir um e-mail para o usuário.',
            'email.email' => 'É necessário inserir um e-mail válido para o usuário.',
            'email.max' => 'O e-mail do usuário não pode ultrapassar 255 caracteres.',
            'email.unique' => 'E-mail já utilizado por outro usuário, por favor insira outro.',
            'file.file' => 'É necessário adicionar um arquivo válido para a assinatura.',
            'file.image' => 'É necessário adicionar uma imagem válido para a assinatura.',
        ];
    }
}
