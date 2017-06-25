<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freight extends Model{

  protected $guarded = ['id'];

  public function invoice(){
    return $this->belongsTo('App\Models\Invoice');
  }

  public function transporter(){
    return $this->belongsTo('App\Models\Company');
  }

  public function incoterm(){
    return $this->belongsTo('App\Models\Incoterm');
  }

  public function orders(){
    return $this->hasOne('App\Models\Order');
  }
}
