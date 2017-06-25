<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['expiry'];
    protected $appends = ['product_name'];

    public function order()
    {
        return $this->hasOne('App\Models\Order');
    }

    public function package()
    {
        return $this->belongsTo('App\Models\Package');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function measure()
    {
        return $this->belongsTo('App\Models\Measure');
    }

    public function setExpiryAttribute($value)
    {
        $this->attributes['expiry'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function getProductNameAttribute()
    {
        return $this->product->name;
    }

    public function linhaPrecoContrato(Order $order)
    {
        $valor = number_format($this->price, 2, ',', '.');

        $texto = $valor . ' por ' . $this->measure->abbreviation;

        foreach($order->taxes as $tax) {
            $texto .= ', com ' . $tax->type . ' ' . $tax->value . '% incluso no preço';
        }

        return $texto;
    }
}
