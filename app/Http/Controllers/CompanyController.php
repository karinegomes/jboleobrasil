<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

use App\Http\Requests;
use App\Models\Company;
use App\Models\Address;
use App\Models\Embarque;
use App\Models\Group;
use App\Models\Doctype;
use App\Models\State;
use App\Models\City;
use App\Http\Controllers\Controller;
use App\Utils\StringUtils;
use Carbon\Carbon;

class CompanyController extends Controller {

    public function index() {
        $companies = Company::all();

        return view('company.index', compact('companies'));
    }

    public function create() {

        $groups = Group::all();
        $states = State::all();
        $cities = City::orderBy('name')->get()->groupBy('state_id')->toJson();

        $codigo = StringUtils::gerarCodigoCliente(Company::withTrashed()->max('id') + 1);

        return view('company.add', compact('groups', 'states', 'cities'))->with('codigo', $codigo);
    }

    public function store(StoreCompanyRequest $request) {

        try {
            $addressArr = $request->input('address');
            $companyArr = $request->input('company');

            $address = Address::create($addressArr);
            $company = new Company($companyArr);

            $address->company()->save($company);

            return redirect('company')->with('success', 'Cliente inserido com sucesso!');
        } catch (\Exception $e) {
            return back();
        }
    }

    public function show(Company $company) {
        $doctypes = Doctype::all();

        $company->load('documents', 'documents.doctype');

        return view('company.read', compact('company', 'doctypes'));
    }

    public function edit(Company $company) {
        $groups = Group::all();
        $states = State::all();
        $cities = City::orderBy('name')->get()->groupBy('state_id')->toJson();

        return view('company.edit', compact('groups', 'states', 'cities', 'company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company) {
        try {
            $address = $company->address;

            $addressArr = $request->input('address');
            $companyArr = $request->input('company');

            $company->update($companyArr);
            $address->update($addressArr);

            return redirect('company/')->with('success', 'Cliente atualizado com sucesso!');
        } catch (\Exception $e) {
            return back();
        }
    }

    public function destroy(Company $company) {
        if ($company->delete()) {
            return 'Ok';
        } else {
            return abort(500);
        }
    }

    public function getClientesComissaoPeriodo($periodo)
    {
        $clientes = Company::getClientesComissaoPeriodo($periodo);
        $clientes = $clientes->values();
        $info     = Embarque::getInformacoesByPeriodo($periodo);

        return response()->json(compact('clientes', 'info'));
    }
}
