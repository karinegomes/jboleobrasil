<?php

namespace App\Models;

use App\Utils\DateUtils;
use Illuminate\Database\Eloquent\Model;

class Baixa extends Model
{
    protected $dates = ['data_pagamento'];
    protected $guarded = ['id'];
    protected $appends = ['valor_formatado'];

    public function embarque()
    {
        return $this->belongsTo('App\Models\Embarque');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

    public static function intervalos()
    {
        $baixas   = Baixa::orderBy('data_pagamento', 'ASC')->get();

        if($baixas->count() == 0)
            return null;

        $primeiro = $baixas->first();
        $ultimo   = $baixas->last();

        $intervalo = DateUtils::intervalo($primeiro->data_pagamento, $ultimo->data_pagamento);

        return $intervalo;
    }

    public function getValorFormatadoAttribute()
    {
        return 'R$ ' . number_format((float) $this->valor, 2, ',', '.');
    }

    public static function boot()
    {
        static::creating(function (Baixa $baixa) {
            foreach ($baixa->attributes as $key => $value) {
                $baixa->{$key} = empty($value) ? null : $value;
            }
        });

        static::updating(function (Baixa $baixa) {
            foreach ($baixa->attributes as $key => $value) {
                $baixa->{$key} = empty($value) ? null : $value;
            }
        });

        parent::boot();
    }
}
