<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;

use App\Http\Requests;
use App\Models\Product;
use App\Models\Company;
use App\Models\Category;
use App\Models\Spec;
use App\Http\Controllers\Controller;
use App\Utils\StringUtils;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $products->load('category');

        return view('product.index', ['products' => $products]);
    }

    public function create()
    {
        $companies = Company::all();
        $categories = Category::all();

        return view('product.add', compact('companies', 'categories'));
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $productArr = $request->input('product');
            $specsArr = $request->input('specs');

            $specs = collect($specsArr)->map(function ($item) {
                return new Spec($item);
            })->all();

            DB::transaction(function () use($productArr, $specs) {
                $product = Product::create($productArr);

                $product->specs()->saveMany($specs);
            });

            return redirect('product/')->with('success', 'Produto inserido com sucesso!');
        }
        catch (Exception $e) {
            $erro = Config::get('constants.ERRO_PADRAO');

            return back()->with('error', $erro);
        }
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $variations = $product->items->map(function ($item) {
            return [
                'y' => $item->created_at->toDateString(),
                'a' => $item->price,
            ];
        })->toJson();

        return view('product.read', compact('product', 'variations'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();
        $categories = Category::all();
        $specs = $product->specs->toJson();

        return view('product.edit', compact('product', 'companies', 'categories', 'specs'));
    }

    public function update(StoreProductRequest $request, $id)
    {
        try {
            $productArr = $request->input('product');
            $specsArr = $request->input('specs');

            $product = Product::findOrFail($id);
            $collection = collect($specsArr);

            //pegar todas os ids que ainda tem no array
            $alteredKeys =
                $collection
                    ->pluck('id')
                    ->reject(function ($value) {
                        return empty($value);
                    })
                    ->all();
            //pego todas os ids salvos
            $specsIds = $product->specs->pluck('id');
            //pego os que não estão mais no array
            $removedSpecs = $specsIds->diff($alteredKeys)->all();
            //e apago eles

            DB::transaction(function() use($removedSpecs, $collection, $id, $product, $productArr) {
                Spec::destroy($removedSpecs);

                //agora vamos aos que estão no array
                $collection->each(function ($item) use ($id) {
                    if (empty($item['id'])) {
                        //é novo, só salvar
                        $spec = new Spec($item);
                        $spec->product_id = $id;
                        $spec->save();
                    } else {
                        //alterado, atualizar
                        $spec = Spec::find($item['id']);
                        $spec->update($item);
                    }
                });

                $product->update($productArr);
            });

            return redirect('product')->with('success', 'Produto atualizado com sucesso!');
        }
        catch (Exception $e) {
            $erro = Config::get('constants.ERRO_PADRAO');

            return back()->with('error', $erro);
        }
    }

    public function destroy($id)
    {
        if (Product::destroy($id)) {
            return 'Ok';
        } else {
            return abort(500);
        }
    }
}
