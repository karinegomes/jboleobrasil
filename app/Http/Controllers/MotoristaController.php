<?php

namespace App\Http\Controllers;

use App\Http\Requests\MotoristaRequest;
use App\Models\Doctype;
use App\Models\Motorista;
use App\Models\TipoDeCaminhao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MotoristaController extends Controller
{
    public function index()
    {
        return view('motoristas.index');
    }

    public function create()
    {
        $motorista = new Motorista();
        $tiposCaminhao = TipoDeCaminhao::all();

        return view('motoristas.edit', compact('motorista', 'tiposCaminhao'));
    }

    public function store(MotoristaRequest $request)
    {
        $motorista = Motorista::create($request->all());

        $motorista->dadosBancarios()->create($request->get('dados_bancarios'));

        return redirect(route('motoristas.index'))->with('success', 'O motorista foi cadastrado com sucesso.');
    }

    public function show(Motorista $motorista)
    {
        $doctypes = Doctype::all();

        $motorista->load('documents', 'documents.doctype');

        return view('motoristas.show', compact('motorista', 'doctypes'));
    }

    public function edit(Motorista $motorista)
    {
        $tiposCaminhao = TipoDeCaminhao::all();

        return view('motoristas.edit', compact('motorista', 'tiposCaminhao'));
    }

    public function update(MotoristaRequest $request, Motorista $motorista)
    {
        $motorista->update($request->all());
        $motorista->dadosBancarios()->update($request->get('dados_bancarios'));

        return redirect(route('motoristas.index'))->with('success', 'O motorista foi atualizado com sucesso.');
    }

    public function destroy(Motorista $motorista)
    {
        try {
            $motorista->delete();
        } catch (\Exception $e) {
            Log::debug($e);

            $erro = config('constants.ERRO_PADRAO');

            return redirect(route('motoristas.index'))->with('error', $erro.'<br><br>Erro: '.$e->getMessage());
        }

        return redirect(route('motoristas.index'))->with('success', 'O motorista foi removido com sucesso.');
    }

    public function tableData(Request $request)
    {
        $column = $request['order'][0]['column'];

        $motoristas = Motorista::join('tipos_de_caminhao as tc', 'motoristas.tipo_de_caminhao_id', '=', 'tc.id')
            ->limit($request['length'])
            ->offset($request['start'])
            ->orderBy($request['columns'][$column]['data'], $request['order'][0]['dir'])
            ->select([
                'motoristas.id',
                'motoristas.nome',
                'motoristas.cpf',
                'motoristas.telefone',
                'motoristas.celular',
                'motoristas.placa',
                'tc.nome as tipo_de_caminhao',
            ]);

        $search = $request['search']['value'];
        $count = Motorista::count(['id']);

        if ($search) {
            $motoristas = $motoristas->leftJoin('ordens_de_frete as of', 'motoristas.id', '=', 'of.motorista_id');

            $motoristas = $motoristas->where(function ($query) use ($search) {
                $query->where('motoristas.nome', 'like', '%'.$search.'%')
                    ->orWhere('motoristas.cpf', 'like', '%'.$search.'%')
                    ->orWhere('motoristas.telefone', 'like', '%'.$search.'%')
                    ->orWhere('motoristas.celular', 'like', '%'.$search.'%')
                    ->orWhere('motoristas.placa', 'like', '%'.$search.'%')
                    ->orWhere('tc.nome', 'like', '%'.$search.'%')
                    ->orWhere('of.cidade_origem', 'like', '%'.$search.'%')
                    ->orWhere('of.cidade_destino', 'like', '%'.$search.'%');
            });
        }


        $motoristas = $motoristas->get();

        return response()->json([
            'data'            => $motoristas,
            'draw'            => intval($request['draw']),
            'recordsTotal'    => intval($count),
            'recordsFiltered' => $search ? $motoristas->count() : intval($count),
        ]);
    }

    public function getDadosBancarios(Motorista $motorista)
    {
        $dadosBancarios = $motorista->dadosBancarios;

        return response()->json(compact('dadosBancarios'));
    }
}
