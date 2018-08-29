<?php

namespace App\Http\Controllers;

use App\Http\Requests\MotoristaRequest;
use App\Models\Motorista;
use App\Models\TipoDeCaminhao;

class MotoristaController extends Controller
{
    public function index()
    {
        $motoristas = Motorista::all();

        return view('motoristas.index', compact('motoristas'));
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
}
