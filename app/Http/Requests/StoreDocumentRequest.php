<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class StoreDocumentRequest extends Request
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
      'name' => 'required|max:100',
      'file' => 'required|file',
    ];
  }

  public function messages(){
    return [
      'name.required' => 'É necessário inserir um nome para o Documento.',
      'name.max' => 'O nome do documento não pode ultrapassar 100 caracteres.',
      'file.required' => 'É necessário adicionar um arquivo para o documento.',
    ];
  }
}
