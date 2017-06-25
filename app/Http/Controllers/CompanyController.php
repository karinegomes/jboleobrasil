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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $companies = Company::all();

        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $groups = Group::all();
        $states = State::all();
        $cities = City::orderBy('name')->get()->groupBy('state_id')->toJson();

        $codigo = StringUtils::gerarCodigoCliente(Company::withTrashed()->max('id') + 1);

        return view('company.add', compact('groups', 'states', 'cities'))->with('codigo', $codigo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $company = Company::findOrFail($id);
        $doctypes = Doctype::all();

        $company->load('documents', 'documents.doctype');

        return view('company.read', compact('company', 'doctypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $company = Company::findOrFail($id);
        $groups = Group::all();
        $states = State::all();
        $cities = City::orderBy('name')->get()->groupBy('state_id')->toJson();

        return view('company.edit', compact('groups', 'states', 'cities', 'company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, $id) {
        try {
            $company = Company::findOrFail($id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (Company::destroy($id)) {
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
