<?php

namespace App\Http\Controllers;

use PDF;
use File;
use Carbon\Carbon;
use App\Models\Baixa;
use App\Models\Company;
use App\Models\Embarque;
use Illuminate\Http\Request;
use App\Models\PeriodoCobranca;
use Illuminate\Support\Collection;

class PosVendaController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Company::all();

        $search = $request->input('search');
        $intervalosEmbarques = [];

        if(!empty($search)) {
            $search['min_date'] = Carbon::createFromFormat('d/m/Y', $search['min_date'])->format('Y-m-d');
            $search['max_date'] = Carbon::createFromFormat('d/m/Y', $search['max_date'])->format('Y-m-d');

            $intervalosEmbarques = Embarque::intervaloDataPagamentoEmbarquesAtivos(
                $search['min_date'],
                $search['max_date'],
                $search['comprador'],
                $search['vendedor']
            );
        }

        $filtro = $request->input('search');
        $intervalos = PeriodoCobranca::intervalos();
        $intervalosEmbarques = json_encode($intervalosEmbarques);
        $eControleComissao = true;

        return view('pos_venda.index',
            compact('clientes', 'intervalosEmbarques', 'filtro', 'intervalos', 'eControleComissao'));
    }

    public function imprimirRelatorio($idEmpresa, Request $request)
    {
        $periodo = $request->get('periodo');
        $minDate = Carbon::createFromFormat('Y-m', $periodo)->startOfMonth();
        $maxDate = Carbon::createFromFormat('Y-m', $periodo)->endOfMonth();

        $embarques = Embarque::whereHas('contrato', function($query) use ($idEmpresa, $request) {
            $query->where('client_id', $idEmpresa)
                ->orWhere('seller_id', $idEmpresa)
                ->whereIn('status', ['ativo', 'encerrado']);
        })->whereBetween('data_pagamento', [$minDate->format('Y-m-d'), $maxDate->format('Y-m-d')])->get()
            ->filter(function ($embarque) use ($idEmpresa) {
            $eVendedor = $embarque->contrato->seller_id == $idEmpresa;

            if($eVendedor) {
                if($embarque->comissao_vendedor > 0) {
                    return true;
                }
            }
            else {
                if($embarque->comissao_comprador > 0) {
                    return true;
                }
            }

            return false;
        })->sortBy('contrato.sell_date');

        $totalComissao = 0;

        foreach ($embarques as $embarque) {
            $totalComissao += $embarque->getComissaoByCliente($idEmpresa);
        }

        $totalComissao = 'R$ ' . number_format($totalComissao, 2, ',', '.');

        $minDate = $minDate->format('d/m/Y');
        $maxDate = $maxDate->format('d/m/Y');

        $now = Carbon::now()->format('d/m/Y H:i:s');

        File::deleteDirectory(storage_path('relatorios'));
        File::makeDirectory(storage_path('relatorios'));

        $fileName = "Relatorio_Comissao_" . Carbon::now()->format('dmYHi') . ".pdf";
        $path     = storage_path("relatorios/{$fileName}");
        $pdf      = PDF::loadView('layouts.relatorio_comissao', compact('minDate', 'maxDate', 'embarques', 'idEmpresa', 'totalComissao', 'now'));

        $pdf->setPaper('a4', 'landscape');
        $pdf->save($path);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$fileName.'"'
        ]);

        //return view('layouts.relatorio_comissao', compact('minDate', 'maxDate', 'embarques', 'idEmpresa', 'totalComissao', 'now));
    }

    public function controlePagamento($idEmpresa, $dataMin, $dataMax)
    {
        $nomeEmpresa = Company::find($idEmpresa, ['nome_fantasia'])->nome_fantasia;
        $embarques = Embarque::getEmbarquesAtivosByCliente($idEmpresa, $dataMin, $dataMax);

        return response()->json($embarques);

        //return view('pos_venda.controle_pagamento', compact('embarques', 'nomeEmpresa', 'dataMin', 'dataMax'));
    }

    public function controlePagamentoAjax(Request $request)
    {
        $idEmpresa = $request['idEmpresa'];
        $periodo   = $request['periodo'];

        $dataMin = Carbon::createFromFormat('Y-m', $periodo)->startOfMonth()->format('Y-m-d');
        $dataMax = Carbon::createFromFormat('Y-m', $periodo)->endOfMonth()->format('Y-m-d');

        $embarques = Embarque::getEmbarquesAtivosByClienteArray($idEmpresa, $dataMin, $dataMax);

        return response()->json($embarques);
    }

    public function resumoPagamentos($intervalo)
    {
        $min = Carbon::createFromFormat('Y-m', $intervalo)->startOfMonth()->format('Y-m-d');
        $max = Carbon::createFromFormat('Y-m', $intervalo)->endOfMonth()->format('Y-m-d');

        $periodoFormatado = config('constants.meses.' . Carbon::createFromFormat('Y-m', $intervalo)->format('n')) . ' - ' .
            Carbon::createFromFormat('Y-m', $intervalo)->format('Y');

        $clientes = Company::whereHas('baixas', function($query) use ($min, $max) {
            $query->whereBetween('data_pagamento', [$min, $max]);
        })->get();

        return view('pos_venda.resumo_pagamentos', compact('clientes', 'periodoFormatado', 'intervalo'));
    }
}