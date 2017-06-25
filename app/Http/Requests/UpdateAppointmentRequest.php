<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class UpdateAppointmentRequest extends Request {

    public function authorize() {
        return Auth::check();
    }

    public function rules() {

        return [
            'date' => 'required|date_format:d/m/Y',
            'time' => 'required|date_format:H:i',
            'status_id' => 'required|exists:status,id'
        ];

    }

    public function messages() {

        return [
            'date.required' => 'É necessário informar a data do compromisso.',
            'date.date_format' => 'A data é inválida.',
            'time.required' => 'É necessário informar o horário do compromisso.',
            'time.date_format' => 'O horário é inválido.',
            'status_id.required' => 'É necessário informar a situação do compromisso.',
            'status_id.exists' => 'A situação é inválida.'
        ];

    }

}
