<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    protected $guarded = ['id'];

    public function doctype()
    {
        return $this->belongsTo('App\Models\Doctype');
    }

    public function entity()
    {
        return $this->morphTo();
    }
}
