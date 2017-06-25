<?php

namespace App\Models;

use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class PeriodoCobranca extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['min_date', 'max_date'];

    public function intervalo()
    {
        $start = new DateTime($this->min_date->format('Y-m-d'));
        $end   = new DateTime($this->max_date->format('Y-m-d'));

        $start->modify('first day of this month');
        $end->modify('first day of next month');

        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);
        $meses    = [];

        foreach ($period as $dt) {
            $meses[$dt->format('Y-m')] = config('constants.meses.' . $dt->format("n")) . ' - ' . $dt->format("Y");
        }

        return $meses;
    }

    public static function intervalos()
    {
        $periodos = PeriodoCobranca::all()->sortBy('min_date');
        $intervalos = array();

        foreach ($periodos as $periodo) {
            $intervalos = array_merge($intervalos, $periodo->intervalo());
        }

        return $intervalos;
    }
}
