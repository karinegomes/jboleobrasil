<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;

use App\Models\Group;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('group.index', ['groups' => Group::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
      try {
        Group::create($request->except('_token'));

        return redirect('group/')->with('success', 'Grupo inserido com sucesso!');
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
      if(Group::destroy($id)){
        return 'Ok';
      } else {
        return abort(500);
      }
    }
}
