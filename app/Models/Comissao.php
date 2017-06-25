<?php

namespace App\Models;

use App\Utils\StringUtils;
use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
    protected $guarded = ['id'];
    protected $table = 'comissao';
    protected $appends = ['valor_formatado'];

    public function getValorFormatadoAttribute()
    {
        if($this->unidade == 'fixo') {
            $valor = 'R$ ' . number_format($this->valor, 2, ',', '.');
        }
        else {
            $valor = $valor = StringUtils::formatarNumeroBrasileiro($this->valor) . '%';
        }

        return $valor;
    }
}
