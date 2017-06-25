<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model{

  public $timestamps = false;
  protected $guarded = ['id'];

  public static $types = ['IRPJ','CSLL','PIS/PASEP','Confins','INSS','IPI','ICMS','ISS'];

  public function order(){
    return $this->belongsTo('App\Models\Order');
  }
}
