<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageRequest;

use App\Models\Package;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('package.index', ['packages' => Package::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
    {
      try {
        Package::create($request->except('_token'));

        return redirect('package/')->with('success', 'Embalagem inserida com sucesso!');
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
      if(Package::destroy($id)){
        return 'Ok';
      } else {
        return abort(500);
      }
    }
}
