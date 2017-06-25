<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocTypeRequest;

use App\Models\Doctype;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DoctypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('doctype.index', ['types' => Doctype::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocTypeRequest $request)
    {
      try {
        Doctype::create($request->except('_token'));

        return redirect('doctype/')->with('success', 'Tipo de documento inserido com sucesso!');
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
      if(Doctype::destroy($id)){
        return 'Ok';
      } else {
        return abort(500);
      }
    }
}
