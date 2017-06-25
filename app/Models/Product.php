<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['min_price', 'max_price'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function specs()
    {
        return $this->hasMany('App\Models\Spec');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function getMinPriceAttribute()
    {
        return $this->items()->min('price');
    }

    public function getMaxPriceAttribute()
    {
        return $this->items()->max('price');
    }

    public static function boot()
    {
        parent::boot();

        Product::creating(function($product) {
            foreach ($product->attributes as $key => $value) {
                $product->{$key} = empty($value) ? null : $value;
            }
        });

        Product::updating(function($product) {
            foreach ($product->attributes as $key => $value) {
                $product->{$key} = empty($value) ? null : $value;
            }
        });
    }

}
