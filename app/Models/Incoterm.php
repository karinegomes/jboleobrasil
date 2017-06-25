<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incoterm extends Model
{
  use SoftDeletes;

  public $timestamps = false;
  protected $guarded = ['id'];

  public function freights(){
    return $this->hasMany('App\Models\Freight');
  }
}
