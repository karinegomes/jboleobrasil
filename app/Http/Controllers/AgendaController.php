<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Models\Company;
use App\Http\Controllers\Controller;

class AgendaController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $clients = Company::whereHas('clients', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get()->sortByDesc('last_note')->values();

        return view('agenda.index', ['clients' => $clients->toJson()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $company = Company::with(['interactions' => function ($query) {
            $query->orderBy('created_at', 'desc');
            $query->where('user_id', Auth::user()->id);
        }, 'appointments' => function ($query) {
            $query->orderBy('date', 'asc');
            $query->whereDate('date', '>=', date('Y-m-d'));
            $query->where('user_id', Auth::user()->id);
        }, 'clients' => function ($query) {
            $query->where('user_id', Auth::user()->id);
        }])->find($id);

        return view('agenda.read', ['company' => $company]);

    }
}
