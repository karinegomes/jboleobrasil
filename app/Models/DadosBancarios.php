<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DadosBancarios extends Model
{
    protected $table = 'dados_bancarios';
    protected $fillable = ['nome_banco', 'favorecido', 'cpf_cnpj', 'tipo_conta', 'agencia', 'conta'];

    public function entity()
    {
        return $this->morphTo();
    }
}
