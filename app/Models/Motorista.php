<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    protected $table = 'motoristas';

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'celular',
        'placa',
        'endereco',
        'observacoes',
        'tipo_de_caminhao_id',
    ];

    public function tipoDeCaminhao()
    {
        return $this->belongsTo(TipoDeCaminhao::class, 'tipo_de_caminhao_id');
    }

    public function dadosBancarios()
    {
        return $this->morphOne(DadosBancarios::class, 'entity');
    }
}
