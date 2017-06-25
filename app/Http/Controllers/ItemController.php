<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Item;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $orders = Order::all();

    return view('item.index', ['orders' => $orders]);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $order_id
  * @return \Illuminate\Http\Response
  */
  public function edit($order_id)
  {
    $order = Order::find($order_id);

      // TODO: Passar carriers

    return view('item.edit', ['order' => $order]);
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {

  }
}
