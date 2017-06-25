<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Excel;
use App\Models\Order;
use App\Models\Filter;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $search = $request->input('search');

      if(!empty($search)){
        $filter = Filter::firstOrCreate($search);
        $filter_id = $filter->id;

        $orders = Filter::findOrders($filter_id);
      } else {
        $filter_id = 0;

        $orders = Order::where('user_id', Auth::user()->id)->get();
      }

      return view('finance.index', compact('orders', 'filter_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $commission = Excel::create("Relatório_".date('Y-d-m'), function($excel) use($id){
        $excel->sheet('Folha 01', function($sheet) use($id){
          if($id === 0){
            $orders = Order::where('user_id', Auth::user()->id)->get();
          } else {
            $orders = Filter::findOrders($id);
          }

          $sheet->loadView('layouts.comission', ['orders' => $orders]);
        });
      });

      return $commission->download('xlsx');
    }
}
