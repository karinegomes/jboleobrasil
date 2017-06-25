<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use Auth;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('user.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
      try {
        $user = $request->except('_token');

        if($request->hasFile('signature')){
          $file = $request->file('signature');
          $user['signature'] = base64_encode(file_get_contents($file->getRealPath()));
        }

        if(!Auth::user()->isAdmin()){
          unset($user['is_admin']);
        }

        User::register($user);

        return redirect('user/')->with('success', 'Usuário criado com sucesso!');
      } catch (\Exception $e) {
        return back();
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return view('user.read', ['user' => User::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = Auth::user();

      if($user->id === intval($id)){
        return view('user.edit', ['user' => $user]);
      } else {
        return back();
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
      try {
        $user = Auth::user();

        if($user->id !== intval($id)){
          throw new \Exception('Você não está autorizado a realizar essa ação.');
        }

        $data = $request->except('_token');
        if(empty($data['password'])){
          unset($data['password']);
        } else {
          $data['password'] = bcrypt($data['password']);
        }

        unset($data['is_admin']);

        if($request->hasFile('signature')){
          $file = $request->file('signature');
          $data['signature'] = base64_encode(file_get_contents($file->getRealPath()));
        }

        $user->update($data);

        return redirect('user/')->with('success', 'Dados alterados com sucesso!');
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
      //
    }
}
