<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model{
  public $timestamps = false;
  protected $guarded = ['id'];

  public function order(){
    return $this->hasOne('App\Models\Order');
  }
}
