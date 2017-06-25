<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model{
  protected $guarded = ['id'];

  public static function findOrders($id){
    $filter = static::find($id);

    $orders = Order::query();

    if(!empty($filter->min_date)){
      $orders->whereDate('sell_date', '>=', $filter->min_date);
    }

    if(!empty($filter->max_date)){
      $orders->whereDate('sell_date', '<=', $filter->max_date);
    }

    if(!empty($filter->reference_code)){
      $orders->whereDate('reference_code', $filter->reference_code);
    }

    if(!empty($filter->client_id)){
      $orders->whereDate('client_id', $filter->client_id);
    }

    if(!empty($filter->status)){
      $orders->whereDate('status', $filter->status);
    }

    return $orders->get();
  }
}
