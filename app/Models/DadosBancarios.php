<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DadosBancarios extends Model
{
    protected $table = 'dados_bancarios';
    protected $fillable = ['nome_banco', 'favorecido', 'cpf_cnpj', 'agencia', 'conta', 'motorista_id'];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }
}
