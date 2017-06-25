<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

use App\Http\Requests;

class AddressController extends Controller {

    public function buscarCEP(Request $request) {

        $cep          = $request['cep'];
        $enderecoJson = Address::buscarCEP($cep);
        $endereco     = json_decode($enderecoJson, true);

        if(empty($endereco)) {
            return response('O CEP informado não foi encontrado.', 404);
        }

        return response($enderecoJson);

    }

}
