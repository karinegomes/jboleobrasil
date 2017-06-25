<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\StringUtils;

class Interaction extends Model {

    use StringUtils;

    const REALIZADA = 'realizada';
    const REMARCADA = 'remarcada';

    protected $appends = ['user_name'];
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function company() {
        return $this->belongsTo('App\Models\Company');
    }

    public function getUserNameAttribute() {
        return $this->user->name;
    }

    public function getCreatedAtAttribute($value) {
        return $this->formatDateTime($value);
    }
}
