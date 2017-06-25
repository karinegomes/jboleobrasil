<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;

use App\Models\Telephone;
use App\Utils\StringUtils;
use Auth;
use App\Http\Requests;
use App\Models\Client;
use App\Models\Carrier;
use App\Models\Group;
use App\Models\City;
use App\Models\State;
use App\Models\Company;
use App\Http\Controllers\Controller;

class ClientController extends Controller {

    public function create(\Illuminate\Http\Request $request) {
        $company_id = $request->input('company_id');
        $carriers = Carrier::all();

        if (empty($company_id)) {
            $companies = Company::all();

            return view('client.add', ['companies' => $companies, 'carriers' => $carriers]);
        } else {
            $company = Company::find($company_id);

            return view('client.add', ['company' => $company, 'carriers' => $carriers]);
        }
    }

    public function store(StoreClientRequest $request) {

        try {
            $data = $request->except('_token', 'telefone_adicional_ddd', 'tipo_telefone', 'telefone_adicional', 'operadora_ramal_adicional');
            $data = StringUtils::setNullWhenEmptyArray($data);

            $client = new Client($data);

            $client->user()->associate(Auth::user());
            $client->save();

            $this->inserirTelefones($request, $client->id);

            return redirect('agenda/' . $client->company_id)->with('success', 'Contato inserido com sucesso!');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id) {
        $client = Client::findOrFail($id);

        return view('client.read', ['client' => $client]);
    }

    public function edit($id) {
        $client = Client::findOrFail($id);
        $carriers = Carrier::all();

        return view('client.edit', compact('client', 'carriers'));
    }

    public function update(StoreClientRequest $request, Client $client) {

        $data = StringUtils::setNullWhenEmptyArray($request->all());

        if(!$request['main'])
            $data['main'] = '0';

        try {
            $client->update([
                'name' => $data['name'],
                'position' => $data['position'],
                'email' => $data['email'],
                'ddd' => $data['ddd'],
                'number' => $data['number'],
                'extension' => $data['extension'],
                'mobile_ddd' => $data['mobile_ddd'],
                'mobile_number' => $data['mobile_number'],
                'carrier_id' => $data['carrier_id'],
                'main' => $data['main']
            ]);

            if($request['id_telefone_removido']) {
                for($i = 0; $i < count($data['id_telefone_removido']); $i++) {
                    if($data['id_telefone_removido'][$i] != '')
                        Telephone::find($data['id_telefone_removido'][$i])->delete();
                }
            }

            if($request['id_telefone']) {
                for($i = 0; $i < count($data['id_telefone']); $i++) {
                    $update = [
                        'ddd' => $data['telefone_adicional_ddd_salvo'][$i],
                        'number' => $data['telefone_adicional_salvo'][$i],
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    if($request['operadora_ramal_adicional_salvo'][$i] != '') {
                        if($data['tipo_salvo'][$i] == 'telefone')
                            $update['extension'] = $data['operadora_ramal_adicional_salvo'][$i];
                        else
                            $update['carrier_id'] =
                                StringUtils::setNullWhenEmpty($data['operadora_ramal_adicional_salvo'][$i]);
                    }

                    Telephone::find($data['id_telefone'][$i])->update($update);
                }
            }

            if($request['telefone_adicional_ddd'])
                $this->inserirTelefones($data, $client->id);

            return redirect('agenda/' . $client->company_id)->with('success', 'Contato atualizado com sucesso!');
        } catch (\Exception $e) {
            //return back()->withInput();
            echo $e->getMessage();
        }
    }

    public function destroy(Client $client) {

        try {
            $client->delete();
        }
        catch(\Exception $e) {
            $error = 'Um erro ocorreu ao tentar realizar a operação.';

            return back()->with('error', $error);
        }

        $message = 'O contato foi removido com sucesso.';

        return back()->with('message', $message);

    }

    public function inserirTelefones($request, $clientId) {

        $ddds = $request['telefone_adicional_ddd'];

        for($i = 0; $i < count($ddds); $i++) {
            $telephone = [
                'ddd' => $ddds[$i],
                'number' => $request['telefone_adicional'][$i],
                'type' => $request['tipo_telefone'][$i],
                'client_id' => $clientId
            ];

            if($request['operadora_ramal_adicional'][$i] != '') {
                if($request['tipo_telefone'][$i] == 'telefone') {
                    $telephone['extension'] = $request['operadora_ramal_adicional'][$i];
                }
                else if($request['tipo_telefone'][$i] == 'celular') {
                    $telephone['carrier_id'] = $request['operadora_ramal_adicional'][$i];
                }
            }

            Telephone::create($telephone);
        }

    }
}
