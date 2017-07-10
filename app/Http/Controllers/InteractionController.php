<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Models\Appointment;
use App\Models\Interaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InteractionController extends Controller {
    public function index(Request $request) {

    }

    public function create() {
        //
    }

    public function store(Request $request) {

        try {
            $user = Auth::user();
            $company_id = $request->input('company_id');

            $interaction = new Interaction($request->input('interaction'));
            $interaction->user()->associate($user);
            $interaction->company_id = $company_id;

            $interaction->save();

            //if ($interaction->type === Interaction::REMARCADA) {
                $requestAppointment = $request->input('appointment');

                $appointment = [
                    'date' => \DateTime::createFromFormat('d/m/Y', $requestAppointment['date'])->format('Y-m-d'),
                    'time' => $requestAppointment['time']
                ];

                $apt = new Appointment($appointment);
                $apt->name = "Contato com {$interaction->company->name}";
                $apt->company_id = $company_id;
                $apt->interaction_id = $interaction->id;
                $apt->user()->associate($user);
                $apt->save();
            //}
        } catch (\Exception $e) {
            Log::debug($e);
            return back()->with('error', 'Erro ao cadastrar a anotação.');
        }

        return back();
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy(Interaction $interaction) {

        try {
            $appointment = Appointment::where('interaction_id', $interaction->id)->first();

            DB::transaction(function() use ($appointment, $interaction) {
                if($appointment) {
                    $appointment->update([
                        'interaction_id' => null
                    ]);
                }

                $interaction->delete(); // TODO cascade
            });
        }
        catch(\Exception $e) {
            $erro = Config::get('constants.ERRO_PADRAO');

            return back()->with('error', $erro);
        }

        $mensagem = 'A anotação foi removida com sucesso.';

        return back()->with('message', $mensagem);

    }
}
