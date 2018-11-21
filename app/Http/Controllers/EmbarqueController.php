<?php

namespace App\Http\Controllers;

use DB;
use Log;
use PDF;
use File;
use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Company;
use App\Models\Product;
use App\Models\Desconto;
use App\Models\Embarque;
use App\Utils\StringUtils;
use Illuminate\Http\Request;
use App\Http\Requests\EmbarqueRequest;

class EmbarqueController extends Controller
{
    public function index()
    {
        /*$orders = Order::orderBy('sell_date')->orderBy('reference_code')->get();*/

        /*$orders = Order::limit(10)->get();

        $orders->load('item', 'seller', 'client');*/

        $vendedor = '(select name from companies where id = orders.seller_id)';
        $comprador = '(select name from companies where id = orders.client_id)';
        $produto = '(select (select name from products where id = items.product_id) from items where id = orders.item_id)';
        $quantidade = '(select format(amount, 2, "de_DE") from items where id = orders.item_id)';
        $preco = '(select concat("R$ ", format(price, 2, "de_DE")) from items where id = orders.item_id)';
        $status = 'CONCAT(UCASE(LEFT(orders.status, 1)), SUBSTRING(orders.status, 2))';
        $sellDate = 'date_format(orders.sell_date, "%d/%m/%Y")';

        $orders = Order::select([
                'orders.id',
                'orders.reference_code',
                DB::raw($sellDate.' as custom_sell_date'),
                DB::raw($vendedor.' as vendedor'),
                DB::raw($comprador.' as comprador'),
                DB::raw($produto.' as produto'),
                DB::raw($quantidade.' as quantidade'),
                DB::raw($preco.' as preco'),
                DB::raw($status.' as status'),
            ])->get();

        $clientes = Company::all(['id', 'nome_fantasia']);
        $produtos = Product::all(['id', 'name']);

        $status = [
            'ativo'     => 'Ativo',
            'liquidado' => 'Liquidado',
            'encerrado' => 'Encerrado',
            'cancelado' => 'Cancelado'
        ];

        return view('embarque.index', [
            'orders'   => $orders,
            'clientes' => $clientes,
            'produtos' => $produtos,
            'status'   => $status
        ]);
    }

    public function create($idContrato)
    {
        $contrato = Order::find($idContrato, ['id', 'item_id']);

        if(!$contrato) {
            return back()->withErrors(config('constants.ERRO_PADRAO'));
        }

        $embarque = $contrato->embarques()->last()->first(['entrega']);
        $entrega = 1;

        if($embarque) {
            $entrega = $embarque->entrega + 1;
        }

        $saldo = $contrato->saldoAtual();
        $condicaoPagamento = $contrato->maxCondicaoPagamento();
        $valorUnitario = number_format($contrato->item->price, 2, ',', '.');

        return view('embarque.adicionar', compact('entrega', 'idContrato', 'saldo', 'condicaoPagamento', 'valorUnitario'));
    }

    public function store($idContrato, EmbarqueRequest $request)
    {
        $contrato = Order::find($idContrato, ['id']);

        if(!$contrato) {
            return back()->withErrors(config('constants.ERRO_PADRAO'));
        }

        //$request['quantidade'] = str_replace('.', '', $request['quantidade']);

        $data = StringUtils::setNullWhenEmptyArray($request->except('_token', 'status', 'desconto'));
        $data['contrato_id'] = $contrato->id;
        $dataDesconto = $request['desconto'];

        try {
            DB::transaction(function() use ($data, $contrato, $request, $dataDesconto) {
                $embarque = Embarque::create($data);

                $contrato->update([
                    'status' => $request['status']
                ]);

                foreach ($dataDesconto as $_dataDesconto) {
                    if($_dataDesconto['valor'] != '') {
                        $_dataDesconto['embarque_id'] = $embarque->id;

                        Desconto::create($_dataDesconto);
                    }
                }
            });
        }
        catch(Exception $e) {
            return back()->withErrors(config('constants.ERRO_PADRAO'));
        }

        return redirect('contrato/' . $idContrato . '/resumo')->with('success', 'O embarque foi inserido com sucesso.');
    }

    public function show($idEmbarque)
    {
        $embarque = Embarque::find($idEmbarque);

        if(!$embarque) {
            return back()->withErrors(config('constants.ERRO_PADRAO'));
        }

        return view('embarque.show')->with('embarque', $embarque);
    }

    public function edit($idEmbarque)
    {
        $embarque = Embarque::find($idEmbarque);

        if(!$embarque) {
            return back()->withErrors(config('constants.ERRO_PADRAO'));
        }

        $status = $embarque->contrato->status;
        $quantidade = $embarque->saldo + $embarque->quantidade;
        $saldo = $embarque->saldo;
        $condicaoPagamento = $embarque->contrato->maxCondicaoPagamento();
        $valorUnitario = number_format($embarque->contrato->item->price, 2, ',', '.');

        return view('embarque.edit', compact('embarque', 'status', 'saldo', 'quantidade', 'condicaoPagamento',
            'valorUnitario'));
    }

    public function update($id, EmbarqueRequest $request)
    {
        $input = $request->all();
        $embarque = Embarque::find($id);

        if(!$embarque) {
            return back()->withErrors(config('constants.ERRO_PADRAO'));
        }

        $input['data_embarque'] = Carbon::createFromFormat('d/m/Y', $input['data_embarque'])->format('Y-m-d');
        $input['data_pagamento'] = Carbon::createFromFormat('d/m/Y', $input['data_pagamento'])->format('Y-m-d');

        $data = StringUtils::setNullWhenEmptyArray($input);
        $dataDesconto = $input['desconto'];

        try {
            $embarque->update($data);

            $embarque->contrato->update([
                'status' => $input['status']
            ]);

            $embarque->descontos()->delete();

            foreach ($dataDesconto as $_dataDesconto) {
                if($_dataDesconto['valor'] != '') {
                    $_dataDesconto['embarque_id'] = $embarque->id;

                    Desconto::create($_dataDesconto);
                }
            }
        }
        catch (Exception $e) {
            Log::debug($e);

            return back()->withErrors(config('constants.ERRO_PADRAO'));
        }

        return redirect('contrato/' . $embarque->contrato_id . '/resumo')
            ->with('success', 'O embarque foi atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $embarque = Embarque::find($id);

        if(!$embarque) {
            return response()->json(config('constants.ERRO_PADRAO'), 404);
        }

        try {
            $embarque->delete();
        }
        catch(Exception $e) {
            return response()->json(config('constants.ERRO_PADRAO'), 500);
        }

        return response()->json('O embarque foi removido com sucesso.');
    }

    public function imprimirRelatorio(Request $request)
    {
        $contratos = Order::orderBy('sell_date', 'asc')->orderBy('reference_code', 'asc')->get();

        if($request['contrato'] != 'todos') {
            $contratos = $contratos->where('id', intval($request['contrato']));
        }

        if($request['vendedor'] != 'todos') {
            $contratos = $contratos->where('seller_id', intval($request['vendedor']));
        }

        if($request['comprador'] != 'todos') {
            $contratos = $contratos->where('client_id', intval($request['comprador']));
        }

        if($request['produto'] != 'todos') {
            $contratos = $contratos->where('item.product_id', intval($request['produto']));
        }

        if($request['status'] != 'todos') {
            $contratos = $contratos->where('status', $request['status']);
        }

        $data = array();

        foreach ($contratos as $contrato) {
            $saldo = $contrato->item->amount;
            $observacao = '';

            if($contrato->embarques()->count() > 0) {
                $saldo = $contrato->embarques->last()->saldo;
                $observacao = $contrato->embarques->last()->observacao;
            }

            $quantidadeEmbarcada = $contrato->item->amount - $saldo;

            $_data = [
                'reference_code' => $contrato->reference_code,
                'sell_date' => $contrato->sell_date->format('d/m/Y'),
                'vendedor' => $contrato->seller->nome_fantasia,
                'comprador' => $contrato->client->nome_fantasia,
                'produto' => $contrato->item->product_name,
                'quantidade' => number_format($contrato->item->amount, 0, ',', '.'),
                'quantidade_embarcada' => number_format($quantidadeEmbarcada, 0, ',', '.'),
                'saldo' => number_format($saldo, 0, ',', '.'),
                'preco' => 'R$ ' . number_format($contrato->item->price, 2, ',', '.'),
                'observacao' => $observacao
            ];

            array_push($data, (object) $_data);
        }

        File::deleteDirectory(storage_path('relatorios'));
        File::makeDirectory(storage_path('relatorios'));

        $now      = Carbon::now()->format('d/m/Y - H:i');
        $fileName = "Relatorio_" . Carbon::now()->format('dmYHi') . ".pdf";
        $path     = storage_path("relatorios/{$fileName}");
        $pdf      = PDF::loadView('layouts.relatorio_contrato', compact('now', 'data'));

        $pdf->setPaper('a4', 'landscape');
        $pdf->save($path);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$fileName.'"'
        ]);
    }
}
