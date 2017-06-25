<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncotermRequest;

use App\Models\Incoterm;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class IncotermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('incoterm.index', ['incoterms' => Incoterm::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncotermRequest $request)
    {
      try {
        Incoterm::create($request->except('_token'));

        return redirect('incoterm/')->with('success', 'Incoterm inserido com sucesso!');
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
      if(Incoterm::destroy($id)){
        return 'Ok';
      } else {
        return abort(500);
      }
    }
}
