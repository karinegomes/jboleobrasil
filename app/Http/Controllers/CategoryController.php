<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;

use App\Models\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('category.index', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
      try {
        Category::create($request->except('_token'));

        return redirect('category/')->with('success', 'Categoria inserida com sucesso!');
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
      if(Category::destroy($id)){
        return 'Ok';
      } else {
        return abort(500);
      }
    }
}
