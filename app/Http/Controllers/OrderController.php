<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Comissao;
use App\Utils\StringUtils;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
use Auth;
use App\Http\Requests;
use App\Models\Order;
use App\Models\Company;
use App\Models\Product;
use App\Models\Package;
use App\Models\Detailtype;
use App\Models\Incoterm;
use App\Models\Tax;
use App\Models\Item;
use App\Models\Detail;
use App\Models\Paymethod;
use App\Models\Freight;
use App\Models\Measure;

class OrderController extends Controller
{

	use StringUtils;

	public function index()
	{
		//Traz também os contratos invalidados
		//$orders = Order::withTrashed()->get();
        $orders = Order::all();
		$orders->load('item', 'seller', 'client');
		$userId = auth()->user()->id;

		return view('order.index', compact('orders', 'userId'));
	}

	public function create(Request $request)
	{
		$companies = Company::all();
		$products = Product::all();
		$packages = Package::all();
		$incoterms = Incoterm::all();
		$measures = Measure::all();
		$tax_types = Tax::$types;
		$detail_types = [
			new Detailtype('entrega', 'Entrega'),
			new Detailtype('retirada', 'Retirada'),
			new Detailtype('embarque', 'Embarque')
		];

		$reference_code = Order::getReferenceCode();
		$reference_order = $request->input('reference_order');

		if(!empty($reference_order)){
			$order = Order::withTrashed()->findOrFail($reference_order);
			$taxes = $order->taxes->toJson();

			return view('order.copy', compact(
			'order', 'companies', 'products', 'packages',
			'reference_code', 'detail_types', 'incoterms',
			'tax_types', 'taxes', 'measures'));
		}

		return view('order.add', compact(
		'companies', 'products', 'packages',
		'reference_code', 'detail_types', 'incoterms',
		'tax_types', 'measures'));
	}

	public function store(OrderRequest $request)
	{
		try {
			$itemData = $request->input('item');
			//$itemData['amount'] = $this->formatCurrency($itemData['amount']);
			$itemData['price'] = $this->formatCurrency($itemData['price']);

            DB::transaction(function() use ($itemData, $request) {
                $item = Item::create($itemData);
                $freight = Freight::create($request->input('freight'));
                $detail = Detail::create($request->input('detail'));

                $order = new Order($request->input('order'));
                $order->freight()->associate($freight);
                $order->item()->associate($item);
                $order->detail()->associate($detail);
                //$order->paymethods()->associate($paymethod);
                $order->user()->associate(Auth::user());
                $order->reference_code = Order::getReferenceCode();
                $order->save();

                foreach ($request->input('paymethod') as $requestPaymethod) {
                    $paymethod = new Paymethod($requestPaymethod);

                    $paymethod->order()->associate($order);
                    $paymethod->save();
                }

                foreach ($request->input('comissao') as $comissaoRequest) {
                    if($comissaoRequest['valor'] != '') {
                        $comissaoRequest['valor'] = str_replace(',', '.', $comissaoRequest['valor']);
                        $comissaoRequest['contrato_id'] = $order->id;

                        Comissao::create($comissaoRequest);
                    }
                }

                if(!empty($order->reference_order)){
                    $reference = Order::where('reference_code', $order->reference_order);
                    $reference->delete();
                }

                $taxes = collect($request->input('taxes'))
                    ->map(function($item){ return new Tax($item); })
                    ->all();

                $order->taxes()->saveMany($taxes);
            });
		}
        catch (\Exception $e) {
            $erro = config('constants.ERRO_PADRAO');

            return back()->withInput($request->all())->withErrors($erro);
		}

        return redirect('order')->with('success', 'O contrato foi criado com sucesso.');
	}

	public function show($tipo, $code)
	{
		$filename = "contrato_{$code}_{$tipo}.pdf";
		$path = storage_path("contracts/{$filename}");

        Storage::delete("contracts/{$filename}");

        $order = Order::findByReference(str_replace('-', '/', $code));

        if(!$order) {
            $erro = config('constants.ERRO_PADRAO');

            return redirect('order')->withErrors($erro);
        }

        //$order->finalize(); // seta o contrato como finalizado para não ser mais alterado

        $now = Carbon::now();
        $dia = $now->format('d');
        $mes = config('constants.meses.' . $now->format('n'));
        $ano = $now->format('Y');
        $date = $dia . ' de ' . $mes . ' de ' . $ano;

        //$date = strftime('%d de %B de %Y', strtotime('today'));
        $pdf = PDF::loadView('layouts.contract', compact('order', 'date', 'tipo'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->save($path);

		return response()->file($path, [
			'Content-Type' => 'application/pdf',
			'Content-Disposition' => 'inline; filename="'.$filename.'"'
		]);

        //return view('layouts.contract', compact('order', 'date', 'tipo'));
	}

	public function edit($id)
	{
		$order = Order::findOrFail($id);
		$taxes = $order->taxes->toJson();
		$companies = Company::all();
		$products = Product::all();
		$packages = Package::all();
		$incoterms = Incoterm::all();
		$measures = Measure::all();
		$tax_types = Tax::$types;
		$detail_types = [
			new Detailtype('entrega', 'Entrega'),
			new Detailtype('retirada', 'Retirada'),
			new Detailtype('embarque', 'Embarque')
		];

		$reference_code = Order::getReferenceCode();

		return view('order.edit', compact(
		'order', 'companies', 'products', 'packages',
		'reference_code', 'detail_types', 'incoterms',
		'tax_types', 'taxes', 'measures'));
	}

	public function update(OrderRequest $request, $id)
	{
        $itemData = $request->input('item');
        //$itemData['amount'] = $this->formatCurrency($itemData['amount']);
        $itemData['price'] = $this->formatCurrency($itemData['price']);

		$order = Order::find($id);
        $erro = config('constants.ERRO_PADRAO');

		if(!$order) {
			return back()->withErrors($erro);
		}

		try {
		    DB::transaction(function() use ($order, $request, $itemData) {
                $order->freight()->update($request->input('freight'));
                $order->item()->update($itemData);
                $order->detail()->update($request->input('detail'));
                //$order->paymethod()->update($request->input('paymethod'));
                $order->user()->associate(Auth::user());
                $order->update($request->input('order'));

                $order->taxes()->delete();
                $taxes = collect($request->input('taxes'))
                    ->map(function($item){
                        return new Tax($item);
                    })->all();

                $order->taxes()->saveMany($taxes);
                $order->comissoes()->delete();
                $order->paymethods()->delete();

                foreach ($request->input('paymethod') as $paymethodRequest) {
                    $paymethodRequest['order_id'] = $order->id;

                    Paymethod::create($paymethodRequest);
                }

                foreach ($request->input('comissao') as $comissaoRequest) {
                    if($comissaoRequest['valor'] != '') {
                        $comissaoRequest['valor'] = str_replace(',', '.', $comissaoRequest['valor']);
                        $comissaoRequest['contrato_id'] = $order->id;

                        Comissao::create($comissaoRequest);
                    }
                }
            });
		}
		catch (\Exception $e) {
			//return $e->getMessage();
			return back()->withInput($request->except('_token'))->withErrors($erro);
		}

        return redirect('order')->with('success', 'O contrato foi alterado com sucesso.');
	}

	public function destroy($id)
	{
		if(Order::destroy($id)){
			return 'Ok';
		} else {
			return abort(500);
		}
	}

	public function resumo($id)
    {
        $contrato = Order::with(['item', 'embarques'])->find($id);

        if(!$contrato) {
            return back()->withErrors('O contrato é inválido.');
        }

        $embarques = $contrato->recuperarEmbarquesJSON();

        return view('order.resumo', compact('contrato', 'embarques'));
    }

    public function cancelarPedidoAjax($id)
    {
        $contrato = Order::find($id);

        if(!$contrato) {
            return response()->json('O contrato não foi encontrado.', 404);
        }

        if($contrato->status == 'cancelado') {
            return response()->json('O pedido já foi cancelado.', 401);
        }

        try {
            $contrato->update([
                'status' => 'cancelado'
            ]);
        }
        catch(Exception $e) {
            return response()->json(config('constants.ERRO_PADRAO'), 500);
        }

        return response()->json('O pedido foi cancelado com sucesso.');
    }
}
