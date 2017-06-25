<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telephone extends Model {

    protected $guarded = ['id'];

    public function client() {
        return $this->belongsTo('App\Models\Client');
    }

    public function carrier() {
        return $this->belongsTo('App\Models\Carrier');
    }

}
