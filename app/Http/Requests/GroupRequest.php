<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class GroupRequest extends Request
{
  /**
  * Determine if the user is authorized to make this request.
  *
  * @return bool
  */
  public function authorize(){
    return Auth::check();
  }

  /**
  * Get the validation rules that apply to the request.
  *
  * @return array
  */
  public function rules(){
    return [
      'name' => 'required|max:150',
    ];
  }

  public function messages(){
    return [
      'name.required' => 'É necessário inserir um nome para o tipo de cliente.',
      'name.max' => 'O nome do tipo de cliente não pode ultrapassar 150 caracteres.',
    ];
  }
}
