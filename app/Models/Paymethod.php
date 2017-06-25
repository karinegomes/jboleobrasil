<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paymethod extends Model
{
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    protected static function boot()
    {
        static::updating(function($payMethod) {
            foreach ($payMethod->attributes as $key => $value) {
                $payMethod->{$key} = empty($value) ? null : $value;
            }
        });
    }
}
