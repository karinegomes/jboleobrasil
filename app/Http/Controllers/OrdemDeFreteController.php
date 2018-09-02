<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdemDeFreteRequest;
use App\Models\Measure;
use App\Models\Motorista;
use App\Models\OrdemDeFrete;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class OrdemDeFreteController extends Controller
{
    public function index()
    {
        return 'test';
    }

    public function create()
    {
        $ordemFrete = new OrdemDeFrete();
        $motoristas = Motorista::select(['id', 'nome'])->get();
        $measures = Measure::select(['id', 'name'])->get();

        return view('ordens_frete.edit', compact('ordemFrete', 'motoristas', 'measures'));
    }

    public function store(OrdemDeFreteRequest $request)
    {
        $data = $request->all();
        $data['data_carregamento'] = Carbon::createFromFormat('d/m/Y', $data['data_carregamento'])->format('Y-m-d');
        $data['previsao_descarga'] = Carbon::createFromFormat('d/m/Y', $data['previsao_descarga'])->format('Y-m-d');
        $ordemFrete = OrdemDeFrete::create($data);

        $ordemFrete->dadosBancarios()->create($request->get('dados_bancarios'));

        return redirect(route('ordens-frete.index'))->with('success', 'A ordem de frete foi cadastrado com sucesso.');
    }
}
