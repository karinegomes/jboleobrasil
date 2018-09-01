<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motorista extends Model
{
    use SoftDeletes;

    public $entityType = 'motorista';
    public $showRoute = 'motoristas.show';

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

    public function documents()
    {
        return $this->morphMany(Document::class, 'entity');
    }
}
