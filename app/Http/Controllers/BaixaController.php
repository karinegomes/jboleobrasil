<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Exception;
use Carbon\Carbon;
use App\Models\Baixa;
use App\Models\Embarque;
use Illuminate\Http\Request;
use App\Http\Requests\BaixaRequest;

class BaixaController extends Controller
{
    public function show($id)
    {
        $baixa = Baixa::findOrFail($id);

        return view('baixa.show', compact('baixa'));
    }

    public function create($idEmpresa, $idEmbarque)
    {
        $embarque = Embarque::find($idEmbarque);

        if(!$embarque) {
            return back()->withErrors('O embarque não foi encontrado.');
        }

        $valor = $embarque->getComissaoByCliente($idEmpresa);
        $valor = number_format($valor, 2, ',', '.'); // Valor formatado

        return view('baixa.add', compact('valor'));
    }

    public function store(BaixaRequest $request, $idEmpresa, $idEmbarque)
    {
        $embarque = Embarque::find($idEmbarque);

        if(!$embarque) {
            return back()->withErrors('O embarque não foi encontrado.');
        }

        $request['data_pagamento'] = Carbon::createFromFormat('d/m/Y', $request['data_pagamento'])->format('Y-m-d');
        $request['company_id']     = $idEmpresa;

        try {
            DB::transaction(function() use ($embarque, $request) {
                $embarque->baixa()->create($request->except(['_token', 'XDEBUG_SESSION_START']));

                $embarque->update([
                    'status' => 'pago'
                ]);
            });
        }
        catch (Exception $e) {
            Log::alert($e->getMessage());

            return back()->withInput()->withErrors(config('constants.ERRO_PADRAO'));
        }

        $dataPagamentoEmbarque = Carbon::createFromFormat('Y-m-d', $embarque->data_pagamento);
        $inicioMes             = $dataPagamentoEmbarque->startOfMonth()->format('d/m/Y');
        $finalMes              = $dataPagamentoEmbarque->endOfMonth()->format('d/m/Y');

        return redirect('pos-venda?search[min_date]=' . $inicioMes . '&search[max_date]=' . $finalMes . '&search[vendedor]=todos&search[comprador]=todos')
            ->with('success', 'Baixa realizada com sucesso.');
    }

    public function edit($idEmpresa, $idEmbarque)
    {
        $baixa = Baixa::where('embarque_id', $idEmbarque)->first();

        if(!$baixa) {
            return back()->withErrors('A baixa não foi encontrada.');
        }

        return view('baixa.edit', compact('baixa'));
    }

    public function update(BaixaRequest $request, $idEmpresa, $idEmbarque)
    {
        $baixa = Baixa::where('embarque_id', $idEmbarque)->first();

        if(!$baixa) {
            return back()->withErrors('A baixa não foi encontrada.');
        }

        $request['data_pagamento'] = Carbon::createFromFormat('d/m/Y', $request['data_pagamento'])->format('Y-m-d');

        try {
            $baixa->update($request->except(['_token']));
        }
        catch (Exception $e) {
            Log::alert($e->getMessage());

            return back()->withErrors(config('constants.ERRO_PADRAO'));
        }

        $dataPagamentoEmbarque = Carbon::createFromFormat('Y-m-d', $baixa->embarque->data_pagamento);
        $inicioMes             = $dataPagamentoEmbarque->startOfMonth()->format('d/m/Y');
        $finalMes              = $dataPagamentoEmbarque->endOfMonth()->format('d/m/Y');

        return redirect('pos-venda?search[min_date]=' . $inicioMes . '&search[max_date]=' . $finalMes . '&search[vendedor]=todos&search[comprador]=todos')
            ->with('success', 'Baixa atualizada com sucesso.');
    }

    public function destroy($id)
    {
        $baixa = Baixa::find($id);

        if(!$baixa) {
            return response()->json('A baixa não foi encontrada.', 404);
        }

        try {
            DB::transaction(function() use ($baixa) {
                $baixa->delete();
                $baixa->embarque->update([
                    'status' => 'nao_pago'
                ]);
            });
        }
        catch(Exception $e) {
            return response()->json(config('constants.ERRO_PADRAO'), 500);
        }

        $dataPagamentoEmbarque = Carbon::createFromFormat('Y-m-d', $baixa->embarque->data_pagamento);

        $inicioMes = $dataPagamentoEmbarque->startOfMonth()->format('d/m/Y');
        $finalMes  = $dataPagamentoEmbarque->endOfMonth()->format('d/m/Y');

        $redirectUrl = url('pos-venda?search[min_date]=' . $inicioMes . '&search[max_date]=' . $finalMes . '&search[vendedor]=todos&search[comprador]=todos');

        return response()->json([
            'redirectUrl' => $redirectUrl
        ]);
    }

    public function baixasPorEmpresaAjax($idEmpresa, Request $request)
    {
        $intervalo = $request['intervalo'];

        $min = Carbon::createFromFormat('Y-m', $intervalo)->startOfMonth()->format('Y-m-d');
        $max = Carbon::createFromFormat('Y-m', $intervalo)->endOfMonth()->format('Y-m-d');

        $baixas = Baixa::with([
            'embarque',
            'embarque.contrato',
            'embarque.contrato.seller',
            'embarque.contrato.client',
            'embarque.contrato.item.product' => function($query) {
            $query->select('id', 'name');
        }])
            ->whereBetween('data_pagamento', [$min, $max])
            ->where('company_id', $idEmpresa)
            ->orderBy('data_pagamento')
            ->get()->each(function($item) use ($idEmpresa) {
                $item->porcentagem_comissao = $item->embarque->getPorcentagemComissaoFormatadoByCliente($idEmpresa);
            });

        $total = 'R$ ' . number_format($baixas->sum('valor'), 2, ',', '.');

        return response()->json([
            'baixas' => $baixas,
            'total'  => $total
        ]);
    }
}
