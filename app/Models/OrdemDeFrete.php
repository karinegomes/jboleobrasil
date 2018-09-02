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
        'measure_id',
        'adiantamento',
        'saldo',
        'data_carregamento',
        'previsao_descarga',
        'motorista_id',
        'status_id',
    ];

    protected $dates = ['data_carregamento', 'previsao_descarga'];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function dadosBancarios()
    {
        return $this->morphOne(DadosBancarios::class, 'entity');
    }

    public function measure()
    {
        return $this->belongsTo(Measure::class);
    }

    public function status()
    {
        return $this->belongsTo(OrdemDeFreteStatus::class, 'status_id');
    }

    public function getValorAdiantamentoAttribute()
    {
        return $this->valor_frete * ($this->adiantamento / 100);
    }

    public function getValorSaldoAttribute()
    {
        return $this->valor_frete * ($this->saldo / 100);
    }
}
