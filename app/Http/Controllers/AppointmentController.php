<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Company;
use App\Models\Interaction;
use App\Models\Status;
use App\Utils\StringUtils;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;

use App\Models\Appointment;
use App\Http\Requests\AppointmentFilterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller {

    public function index() {

        $appointments = Auth::user()->appointments()->whereMonth('date', '=', date('m'))->orderBy('date')
            ->orderBy('time')->get();

        $clientes = Company::all();
        $dataInicial = StringUtils::firstDayMonth();
        $dataFinal = StringUtils::lastDayMonth();

        return view('appointment.index', ['appointments' => $appointments])->with('dataInicial', $dataInicial)
            ->with('dataFinal', $dataFinal)->with('clientes', $clientes);
    }

    public function show(Appointment $appointment) {

        $status = Status::all();

        return view('appointment.show')->with('appointment', $appointment)->with('status', $status);

    }

    public function store(Request $request) {
        try {
            Appointment::create($request->except('_token'));

            return redirect('Appointment/');
        } catch (\Exception $e) {
            return back();
        }
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment) {

        try {
            $update = [
                'date' => DateTime::createFromFormat('d/m/Y', $request['date'])->format('Y-m-d'),
                'time' => $request['time'],
                'status_id' => $request['status_id']
            ];

            $status = Status::find($update['status_id']);

            if($request['date'] != $appointment->date || $update['time'] != $appointment->time ||
                ($update['status_id'] != $appointment->status_id &&
                    $appointment->status->constant_name == Status::REALIZADO &&
                    in_array($status->constant_name, [Status::NAO_REALIZADO, Status::PENDENTE]))) {

                $update['viewed_at'] = null;

            }

            DB::transaction(function() use($appointment, $update, $request) {
                $appointment->update($update);

                if($appointment->interaction) {
                    $appointment->interaction()->update([
                        'description' => $request['anotacao']
                    ]);
                }
                else {
                    $interaction = Interaction::create([
                        'description' => $request['anotacao'],
                        'user_id' => $appointment->user_id,
                        'company_id' => $appointment->company_id
                    ]);

                    $appointment->update([
                        'interaction_id' => $interaction->id
                    ]);
                }
            });
        }
        catch(Exception $e) {
            //return $e->getMessage();
            return back()->with('error', Config::get('constants.ERRO_PADRAO'));
        }

        return back()->with('success', 'O compromisso foi atualizado com sucesso.');

    }

    public function destroy(Appointment $appointment) {

        try {
            $appointment->delete();
        }
        catch(\Exception $e) {
            $error = Config::get('constants.ERRO_PADRAO');

            return back()->with('error', $error);
        }

        $message = 'O compromisso foi removido com sucesso.';

        return back()->with('message', $message);

    }

    public function filter(AppointmentFilterRequest $request) {

        $dataInicial = DateTime::createFromFormat('d/m/Y', $request['data_inicial'])->format('Y-m-d');
        $dataFinal = DateTime::createFromFormat('d/m/Y', $request['data_final'])->format('Y-m-d');

        $appointments = Auth::user()->appointments()
            ->whereDate('date', '>=', $dataInicial)
            ->whereDate('date', '<=', $dataFinal)
            ->orderBy('date');

        $cliente = null;

        if($request['cliente'] != 'todos') {
            $appointments = $appointments->where('company_id', $request['cliente'])->get();
            $cliente = Company::find($request['cliente']);
        }
        else {
            $appointments = $appointments->get();
        }

        $clientes = Company::all();

        return view('appointment.index')
            ->with('appointments', $appointments)
            ->with('dataInicial', $request['data_inicial'])
            ->with('dataFinal', $request['data_final'])
            ->with('clientes', $clientes)
            ->with('cliente', $cliente);

    }

    public function viewNotification(Request $request) {

        $compromisso = Appointment::find($request['compromisso_id']);

        $compromisso->update([
            'viewed_at' => $request['viewed_at']
        ]);

    }

}