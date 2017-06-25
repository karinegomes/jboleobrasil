<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarrierRequest;

use App\Models\Carrier;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CarrierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('carrier.index', ['carriers' => Carrier::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarrierRequest $request)
    {
      try {
        Carrier::create($request->except('_token'));

        return redirect('carrier/')->with('success', 'Operadora inserida com sucesso!');
      } catch (\Exception $e) {
        return back();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if(Carrier::destroy($id)){
        return 'Ok';
      } else {
        return abort(500);
      }
    }
}
