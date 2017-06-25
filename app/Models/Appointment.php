<?php

namespace App\Models;

use App\Utils\StringUtils;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model {

    use StringUtils;

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $appends = ['data'];
    /*public $appends = ['anotacao'];*/

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function company() {
        return $this->belongsTo('App\Models\Company');
    }

    public function interaction() {
        return $this->belongsTo('App\Models\Interaction');
    }

    public function status() {
        return $this->belongsTo('App\Models\Status');
    }

    public function getDateAttribute($value) {
        return $this->formatDate($value);
    }

    public function getTimeAttribute($value) {
        return $this->formatTime($value);
    }

    public function getDataAttribute()
    {
        return $this->attributes['date'].' '.$this->attributes['time'];
    }

    /*public function getAnotacaoAttribute() {

        $maiorData = Auth::user()->interactions()->where('company_id', $this->company_id)->max('created_at');

        $anotacao = Auth::user()->interactions()
            ->where('company_id', $this->company_id)
            ->where('created_at', $maiorData)
            ->pluck('description');

        return $anotacao[0];

    }*/
}
