<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdemDeFrete extends Model
{
    use SoftDeletes;

    protected $table = 'ordens_de_frete';

    protected $fillable = [
        'cidade_origem',
        'cidade_destino',
        'valor_frete',
        'peso',
        'adiantamento',
        'saldo',
        'data_carregamento',
        'previsao_descarga',
        'motorista_id',
    ];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function dadosBancarios()
    {
        return $this->morphOne(DadosBancarios::class, 'entity');
    }
}
