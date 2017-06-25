<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  public function freights(){
    return $this->hasMany('App\Models\Freight');
  }

  public function orders(){
    return $this->hasMany('App\Models\Order');
  }
}
