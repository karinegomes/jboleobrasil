<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Embarque;
use App\Models\PeriodoCobranca;
use App\Http\Requests\PeriodoCobrancaRequest;

class PeriodoCobrancaController extends Controller
{
    public function index()
    {
        $periodos = PeriodoCobranca::all();

        return view('periodo_cobranca.index', compact('periodos'));
    }

    public function destroy($id)
    {
        $periodo = PeriodoCobranca::find($id);

        if(!$periodo) {
            return response()->json('O período não foi encontrado.', 404);
        }

        try {
            $periodo->delete();
        }
        catch(Exception $e) {
            return response()->json(config('constants.ERRO_PADRAO'), 500);
        }

        return response()->json('');
    }

    public function salvarPeriodo(PeriodoCobrancaRequest $request)
    {
        $filtro = $request->except(['_token']);
        $filtro['min_date'] = Carbon::createFromFormat('d/m/Y', $filtro['min_date'])->format('Y-m-d');
        $filtro['max_date'] = Carbon::createFromFormat('d/m/Y', $filtro['max_date'])->format('Y-m-d');


        $existe = PeriodoCobranca::where('min_date', '<=', $filtro['min_date'])
            ->where('max_date', '>=', $filtro['min_date'])
            ->orWhere('min_date', '<=', $filtro['max_date'])
            ->where('max_date', '>=', $filtro['max_date'])
            ->exists();

        if($existe) {
            return response()->json('O período já se encontra salvo.', 500);
        }

        try {
            PeriodoCobranca::create($filtro);
        }
        catch (Exception $e) {
            Log::alert($e->getMessage());

            return response()->json(config('constants.ERRO_PADRAO'), 500);
        }

        return response()->json('O período foi salvo com sucesso.');
    }

    public function intervalo($intervalo)
    {
        $clientes = Company::all();

        $min = Carbon::createFromFormat('Y-m', $intervalo)->startOfMonth()->format('Y-m-d');
        $max = Carbon::createFromFormat('Y-m', $intervalo)->endOfMonth()->format('Y-m-d');

        $periodoCobranca = PeriodoCobranca::where('min_date', '<=', $min)
            ->where('max_date', '>=', $max)
            ->first(['nome']);

        $nomePeriodo = '';

        if($periodoCobranca) {
            $nomePeriodo = $periodoCobranca->nome;
        }

        $clientesResultado = $clientes->filter(function($value) use ($min, $max) {
            $value->min_date = $min;
            $value->max_date = $max;

            $contratosVenda = $value->sells()->whereIn('status', ['ativo', 'encerrado'])->get();

            $contratosVenda = $contratosVenda->filter(function($value) use ($min, $max) {
                $embarques = $value->embarques()->whereBetween('data_pagamento', [$min, $max])->get()
                    ->filter(function($value) {
                    return $value->comissao_vendedor > 0;
                });

                return $embarques->count() > 0;
            });

            if($contratosVenda && $contratosVenda->count() > 0)
                return true;

            $contratosCompra = $value->purchases()->whereIn('status', ['ativo', 'encerrado'])->get();

            $contratosCompra = $contratosCompra->filter(function ($value) use ($min, $max) {
                $embarques = $value->embarques()->whereBetween('data_pagamento', [$min, $max])->get()
                    ->filter(function($value) {
                    return $value->comissao_comprador > 0;
                });

                return $embarques->count() > 0;
            });

            if($contratosCompra && $contratosCompra->count() > 0)
                return true;

            return false;
        });

        $clientesResultado = $clientesResultado->toArray();
        $clientesResultado = json_encode(array_values($clientesResultado));

        $filtro = [
            'min_date'  => Carbon::createFromFormat('Y-m-d', $min)->format('d/m/Y'),
            'max_date'  => Carbon::createFromFormat('Y-m-d', $max)->format('d/m/Y'),
            'vendedor'  => 'todos',
            'comprador' => 'todos'
        ];

        $intervalos = PeriodoCobranca::intervalos();

        $intervalosEmbarques = Embarque::intervaloDataPagamentoEmbarquesAtivos($min, $max, 'todos', 'todos');
        $intervalosEmbarques = json_encode($intervalosEmbarques);

        return view('pos_venda.index', compact('clientes', 'intervalosEmbarques', 'filtro', 'intervalos', 'nomePeriodo'));
    }
}
