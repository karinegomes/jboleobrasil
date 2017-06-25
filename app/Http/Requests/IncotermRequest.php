<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class IncotermRequest extends Request
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
      'name' => 'required|max:50',
      'abbreviation' => 'required|max:5',
    ];
  }

  public function messages(){
    return [
      'name.required' => 'É necessário inserir um nome para o Incoterm.',
      'name.max' => 'O nome do Incoterm não pode ultrapassar 50 caracteres.',
      'abbreviation.required' => 'É necessário inserir uma abreviação para o Incoterm.',
      'abbreviation.max' => 'A abreviação do Incoterm não pode ultrapassar 5 caracteres.',
    ];
  }
}
