<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeasureRequest;

use App\Models\Measure;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('measure.index', ['measures' => Measure::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeasureRequest $request)
    {
      try {
        Measure::create($request->except('_token'));

        return redirect('measure/')->with('success', 'Medida inserida com sucesso!');
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
      if(Measure::destroy($id)){
        return 'Ok';
      } else {
        return abort(500);
      }
    }
}
