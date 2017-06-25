<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class MeasureRequest extends Request
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
      'name' => 'required|max:30',
      'abbreviation' => 'required|max:10',
    ];
  }

  public function messages(){
    return [
      'name.required' => 'É necessário inserir um nome para a unidade de medida.',
      'name.max' => 'O nome da unidade de medida não pode ultrapassar 30 caracteres.',
      'abbreviation.required' => 'É necessário inserir um nome para a unidade de medida.',
      'abbreviation.max' => 'O nome da unidade de medida não pode ultrapassar 10 caracteres.',
    ];
  }
}
