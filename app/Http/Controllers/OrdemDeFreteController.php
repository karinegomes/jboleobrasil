<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdemDeFreteRequest;
use App\Models\Measure;
use App\Models\Motorista;
use App\Models\OrdemDeFrete;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdemDeFreteController extends Controller
{
    public function index()
    {
        return view('ordens_frete.index');
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

        return redirect(route('ordens-frete.index'))->with('success', 'A ordem de frete foi cadastrada com sucesso.');
    }

    public function edit(OrdemDeFrete $ordemFrete)
    {
        $motoristas = Motorista::select(['id', 'nome'])->get();
        $measures = Measure::select(['id', 'name'])->get();

        return view('ordens_frete.edit', compact('ordemFrete', 'motoristas', 'measures'));
    }

    public function update(OrdemDeFrete $ordemFrete, OrdemDeFreteRequest $request)
    {
        $data = $request->all();
        $data['data_carregamento'] = Carbon::createFromFormat('d/m/Y', $data['data_carregamento'])->format('Y-m-d');
        $data['previsao_descarga'] = Carbon::createFromFormat('d/m/Y', $data['previsao_descarga'])->format('Y-m-d');

        $ordemFrete->update($data);
        $ordemFrete->dadosBancarios()->update($request->get('dados_bancarios'));

        return redirect(route('ordens-frete.index'))->with('success', 'A ordem de frete foi atualizada com sucesso.');
    }

    public function tableData(Request $request)
    {
        $column = $request['order'][0]['column'];

        $ordensFrete = OrdemDeFrete::join('motoristas as m', 'ordens_de_frete.motorista_id', '=', 'm.id')
            ->join('ordens_de_frete_status as ofs', 'ordens_de_frete.status_id', '=', 'ofs.id')
            ->limit($request['length'])
            ->offset($request['start'])
            ->orderBy($request['columns'][$column]['data'], $request['order'][0]['dir'])
            ->select([
                'ordens_de_frete.id',
                'm.nome as motorista',
                'data_carregamento',
                'previsao_descarga',
                'valor_frete',
                'cidade_origem',
                'cidade_destino',
                'adiantamento',
                'saldo',
                'ofs.nome as status',
            ]);

        $search = $request['search']['value'];
        $count = OrdemDeFrete::count(['id']);

        if ($search) {
            $ordensFrete = $ordensFrete->where(function ($query) use ($search) {
                $query->where('m.nome', 'like', '%'.$search.'%')
                    ->orWhere('cidade_origem', 'like', '%'.$search.'%')
                    ->orWhere('cidade_destino', 'like', '%'.$search.'%')
                    ->orWhere('ofs.nome', 'like', '%'.$search.'%');
            });
        }

        $ordensFrete = $ordensFrete->get();

        return response()->json([
            'data'            => $ordensFrete,
            'draw'            => intval($request['draw']),
            'recordsTotal'    => intval($count),
            'recordsFiltered' => $search ? $ordensFrete->count() : intval($count),
        ]);
    }
}
