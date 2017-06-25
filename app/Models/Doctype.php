<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctype extends Model
{
  use SoftDeletes;

  protected $guarded = ['id'];

  public function documents(){
    return $this->hasMany('App\Models\Document');
  }
}
